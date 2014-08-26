<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   ViewController.php
     * @brief  Contains functions which allow students to view marks, teacher's details and notices
     * @author Sumit Chhetri
     * @date   8/23/14
     * @bug    No known bugs
     */
    class ViewController extends BaseController {

        private $notice;

        /**
         * @var Subject
         */
        private $subject;

        /**
         * @var ClassDetail
         */
        private $classDetail;

        private $student;

        public function __construct(Notice $notice, Subject $subject, ClassDetail $classDetail, Student $student)
        {
            $this->notice      = $notice;
            $this->subject     = $subject;
            $this->classDetail = $classDetail;
            $this->student     = $student;
            $this->beforeFilter('ajax', ['only' => ['getMarks']]);
        }

        public function index()
        {
            $notices = $this->notice->with(['teachers' => function ($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                }])->orderBy('updated_at', 'desc')->limit(3)->get();
            list($subjects, $classes) = $this->getListsOfSubjectsAndClasses();

            return View::make('student_views.home', compact('notices', 'subjects', 'classes'));
        }

        public function notices()
        {
            $notices = $this->notice->with(['teachers' => function ($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                }])->orderBy('updated_at', 'desc')->paginate(10);

            return View::make('student_views.notices', compact('notices'));
        }

        public function marks()
        {
            try {
                $input         = Input::all();
                $subject       = $this->subject->findOrFail($input['subject_id']);
                $classDetail   = $this->classDetail->findOrFail($input['class_detail_id']);
                $teacherDetail = $subject->teachers()->where('class_detail_id', '=', $input['class_detail_id'])->first(['first_name', 'last_name']);
                if ( ! $teacherDetail ) {
                    return Redirect::route('view.home')->withInput()->with('error', $subject->subject_name . ' is not taught in ' . $classDetail->title . ' : ' . $classDetail->batch);
                }
                list($subjects, $classes) = $this->getListsOfSubjectsAndClasses();
                if ( $subject->type == 'Practical' ) {
                    return View::make('student_views.practical_marks', compact('subject', 'classDetail', 'teacherDetail'))->with('subjects', $subjects)->with('classes', $classes);
                }

                return View::make('student_views.nonpractical_marks', compact('subject', 'classDetail', 'teacherDetail'))->with('subjects', $subjects)->with('classes', $classes);
            } catch (ModelNotFoundException $e) {
                return Redirect::route('view.home')->with('error', 'Class/Subject not found');
            }

        }

        public function getMarks($cdId, $sbjId)
        {
            $class_detail      = $this->classDetail->find($cdId);
            $studentsWithMarks = $this->getStudentsWithMarks($cdId, $sbjId, $class_detail);

            return $studentsWithMarks;

        }

        /**
         * @brief Get lists of subject and class
         * @return array
         */
        private function getListsOfSubjectsAndClasses()
        {
            $subjects         = $this->subject->orderBy('subject_name', 'asc')->lists('subject_name', 'id');
            $classes          = $this->classDetail->orderBy('batch', 'desc')->get();
            $classesWithBatch = $classes->lists('title_with_batch', 'id');

            return array($subjects, $classesWithBatch);
        }

        /**
         * @brief Gets the list of students and their marks of a particular class and subject
         * @param $cdId
         * @param $sbjId
         * @param $class_detail
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        private function getStudentsWithMarks($cdId, $sbjId, $class_detail)
        {
            return $this->student->with(['marks' => function ($query) use ($cdId, $sbjId) {
                    $query->where('class_detail_id', '=', $cdId)
                        ->where('subject_id', '=', $sbjId)
                        ->select(['student_id', 'unit_test', 'assessment', 'tutorial', 'attendance', 'practical']);
                }])
                ->where('faculty_id', '=', $class_detail->faculty_id)
                ->where('shift_id', '=', $class_detail->shift_id)
                ->where('batch', '=', $class_detail->batch)
                ->get();
        }
    }