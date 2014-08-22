<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   MarkController.php
     * @brief  This class manages marks
     *
     * Contains functions which allow user to add, view, update and delete marks
     * @author Sumit Chhetri
     * @date   8/20/14
     * @bug    No known bugs
     */
    class MarkController extends BaseController {

        /**
         * @var Student
         */
        private $student;

        /**
         * @var Mark
         */
        private $mark;

        /**
         * @var Teacher
         */
        private $teacher;

        /**
         * @var ClassDetail
         */
        private $classDetail;

        /**
         * @var bool
         */
        private $registered = true;

        /**
         * @var Subject
         */
        private $subject;

        /**
         * @param Student     $student
         * @param Mark        $mark
         * @param ClassDetail $classDetail
         * @param Subject     $subject
         */
        public function __construct(Student $student, Mark $mark, ClassDetail $classDetail, Subject $subject)
        {
            $this->student     = $student;
            $this->mark        = $mark;
            $this->teacher     = Session::get('teacher');
            $this->classDetail = $classDetail;
            $this->subject     = $subject;
        }

        /**
         * @brief Displays the view for adding/updating marks
         * @param $cdId
         * @param $sbjId
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function index($cdId, $sbjId)
        {
            try {
                $class_detail = $this->classDetail->findOrFail($cdId);
                $subject      = $this->subject->findOrFail($sbjId);
                if ( DB::table('subject_teacher')->where('teacher_id', '=', $this->teacher->id)->where('class_detail_id', '=', $cdId)->where('subject_id', '=', $sbjId)->count() == 0 ) {
                    return Redirect::route('teacher.dashboard')->with('error', 'Permission denied.');
                }
                $studentsWithMarks = $this->getStudentsWithMarks($cdId, $sbjId, $class_detail);
                $count             = $this->mark->where('class_detail_id', '=', $cdId)->where('subject_id', '=', $sbjId)->count();
                if ( $subject->type == "Practical" ) {
                    return View::make('marks.index_practical', compact('studentsWithMarks', 'class_detail', 'subject', 'count'))->with('registered', $this->registered);
                }

                return View::make('marks.index_nonpractical', compact('studentsWithMarks', 'class_detail', 'subject', 'count'))->with('registered', $this->registered);
            } catch (ModelNotFoundException $e) {
                return Redirect::route('teacher.dashboard')->with('error', 'Class/Subject not found.');
            }
        }

        /**
         * @brief Stores the marks in database
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            $marks = Input::get('mark');
            $this->mark->insert($marks);

            return Redirect::back()->with('success', 'Marks successfully added.');
        }

        /**
         * @brief Updates the marks
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update()
        {
            $marks = Input::get('mark');
            foreach ($marks as $key => $value) {
                if ( ! isset($value['id']) ) {
                    $this->mark->create($value);
                } else {
                    $mark = $this->mark->find($value['id']);
                    $mark->update($value);
                }
            }

            return Redirect::back()->with('success', 'Marks successfully updated.');
        }

        /**
         * @brief Export an Excel file of the marks
         * @param $cdId
         * @param $sbjId
         * @return \Illuminate\Http\RedirectResponse
         */
        public function export($cdId, $sbjId)
        {
            try {
                $class_detail = $this->classDetail->findOrFail($cdId);
                $subject      = $this->subject->findOrFail($sbjId);
                if ( DB::table('subject_teacher')->where('teacher_id', '=', $this->teacher->id)->where('class_detail_id', '=', $cdId)->where('subject_id', '=', $sbjId)->count() == 0 ) {
                    return Redirect::route('teacher.dashboard')->with('error', 'Permission denied.');
                }
                $studentsWithMarks = $this->getStudentsWithMarks($cdId, $sbjId, $class_detail);
                $this->downloadExcelFile($class_detail, $subject, $studentsWithMarks);

            } catch (ModelNotFoundException $e) {
                return Redirect::route('teacher.dashboard')->with('error', 'Class/Subject not found.');
            }
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
                    return $query->where('teacher_id', '=', $this->teacher->id)
                        ->where('class_detail_id', '=', $cdId)
                        ->where('subject_id', '=', $sbjId);
                }])
                ->where('faculty_id', '=', $class_detail->faculty_id)
                ->where('shift_id', '=', $class_detail->shift_id)
                ->where('batch', '=', $class_detail->batch)
                ->orderBy('roll_no')
                ->get();
        }

        /**
         * @brief Downloads the excel file
         * @param $class_detail
         * @param $subject
         * @param $studentsWithMarks
         */
        private function downloadExcelFile($class_detail, $subject, $studentsWithMarks)
        {
            Excel::create($class_detail->title . " " . $class_detail->batch . "-" . Str::upper($subject->subject_name) . " Marks", function ($excel) use ($studentsWithMarks, $subject) {
                $excel->setCreator(Session::get('first_name') . " " . Session::get('last_name'))->setCompany('NCIT');

                $excel->sheet(Str::limit(Str::upper($subject->subject_name),28,"..."), function ($sheet) use ($studentsWithMarks, $subject) {
                    $sheet->setStyle(array(
                        'font' => array(
                            'name' => 'Calibri',
                            'size' => 12,
                        )
                    ));
                    if ( $subject->type == "Practical" ) {
                        $sheet->loadView('marks.export.practical')->with('studentsWithMarks', $studentsWithMarks);
                    } else {
                        $sheet->loadView('marks.export.nonpractical')->with('studentsWithMarks', $studentsWithMarks);
                    }

                });

            })->download('xlsx');;
        }
    }