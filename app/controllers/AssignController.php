<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Database\QueryException;

    /**
     * @file   AssignController.php
     * @brief  This class manages the subjects and classes assigned to teachers
     * @author Sumit Chhetri
     * @date   6/20/14
     * @bug    No known bugs
     */
    class AssignController extends BaseController {

        /**
         * @var Teacher
         */
        private $teacher;

        /**
         * @var Subject
         */
        private $subject;

        /**
         * @var ClassDetail
         */
        private $classDetail;

        /**
         * @var Mark
         */
        private $mark;

        /**
         * @param Teacher     $teacher
         * @param Subject     $subject
         * @param ClassDetail $classDetail
         */
        public function __construct(Teacher $teacher, Subject $subject, ClassDetail $classDetail, Mark $mark)
        {
            $this->teacher     = $teacher;
            $this->subject     = $subject;
            $this->classDetail = $classDetail;
            $this->beforeFilter('class.subject.isEmpty', ['only' => ['create']]);
            $this->mark = $mark;
        }

        /**
         * @brief Shows the view containing the assigned subject and class of a teacher
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function index($id)
        {
            try {
                $teacher = $this->teacher->findOrFail($id);
                $batches = $this->getBatches($teacher);
                if ( Input::has('batch') ) {
                    $subjectsWithClass = $teacher->subjects()->whereBatch(Input::get('batch'))->get(['title', 'subject_name', 'subject_id', 'class_detail_id']);

                    return View::make('assign_subjects.index', compact(['teacher', 'batches', 'subjectsWithClass']));
                }

                return View::make('assign_subjects.index', compact('teacher', 'batches'));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('teachers.index')->with('error', 'Teacher not found.');
            }
        }

        /**
         * @brief Shows the form for assigning a new subject and class for a teacher
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function create($id)
        {
            try {
                $teacher = $this->teacher->findOrFail($id);
                list($subjects, $classes) = $this->getListsOfSubjectsAndClasses();

                return View::make('assign_subjects.create', compact(['teacher', 'subjects', 'classes']));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('teachers.index')->with('error', 'Teacher not found.');
            }
        }

        /**
         * @brief Stores the relationship of teacher with his assigned subject and class in database
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store($id)
        {
            if ( $this->isValid() ) {
                $teacher = $this->teacher->find($id);
                try {
                    $teacher->subjects()->attach(Input::get('subject_id'), ['class_detail_id' => Input::get('class_detail_id')]);
                    $this->mark->where('subject_id', '=', Input::get('subject_id'))->where('class_detail_id', '=', Input::get('class_detail_id'))->update(['teacher_id' => $id]);

                    return Redirect::route('teachers.subjects.index', $teacher->id)->with('success', 'Subject successfully assigned.');

                } catch (QueryException $exception) {
                    return $this->redirectBackWithAssignedTeacherName($id);
                }
            }

            return $this->redirectBackWithAssignedTeacherName($id);

        }

        /**
         * @brief Deletes the relation of the teacher with his assigned subject and class
         * @param $teacherId
         * @param $subjectId
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy($teacherId, $subjectId)
        {
            $class_detail_id = Input::get('cdi');
            DB::table('subject_teacher')->where('teacher_id', '=', $teacherId)->where('subject_id', '=', $subjectId)->where('class_detail_id', '=', $class_detail_id)->delete();

            return Redirect::route('teachers.subjects.index', $teacherId)->with('success', 'Subject successfully dissociated');
        }

        /**
         * @brief Get all the batches a teacher taught in
         * @param $teacher
         * @return mixed
         */
        private function getBatches($teacher)
        {
            $batches = [];
            if ( ! $teacher->subjects->isEmpty() ) {
                foreach ($teacher->subjects()->orderBy('batch', 'desc')->groupBy('batch')->get(['batch']) as $subject) {
                    array_push($batches, $subject->batch);
                }

                return $batches;
            }

            return $batches;
        }

        /**
         * @brief Get lists of subject and class assigned to teacher
         * @return array
         */
        private function getListsOfSubjectsAndClasses()
        {
            $subjects         = $this->subject->orderBy('subject_name', 'asc')->lists('subject_name', 'id');
            $classes          = $this->classDetail->orderBy('title', 'asc')->get();
            $classesWithBatch = $classes->lists('title_with_batch', 'id');

            return array($subjects, $classesWithBatch);
        }

        /**
         * @brief Checks if the provided subject and class is already assigned
         * @return bool
         */
        private function isValid()
        {
            $rules = [
                'subject_id'      => 'required|unique:subject_teacher,subject_id,null,null,class_detail_id,' . Input::get('class_detail_id'),
                'class_detail_id' => 'required'
            ];

            $validator = Validator::make(Input::all(), $rules);
            if ( $validator->fails() ) {
                return false;
            }

            return true;
        }

        /**
         * @brief Gets the name of the teacher to whom the subject is already assigned and redirects to the create form
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        private function redirectBackWithAssignedTeacherName($id)
        {
            $assignedTeacherId = DB::table('subject_teacher')->where('subject_id', '=', Input::get('subject_id'))->where('class_detail_id', '=', Input::get('class_detail_id'))->first(['teacher_id']);
            $assignedTeacher   = $this->teacher->find($assignedTeacherId->teacher_id);

            return Redirect::route('teachers.subjects.create', $id)->withInput()->with('error', 'This subject in this class is already assigned to ' . ucfirst($assignedTeacher->first_name) . ' ' . ucfirst($assignedTeacher->last_name));
        }

    }