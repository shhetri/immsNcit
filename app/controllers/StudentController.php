<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   StudentController.php
     * @brief  This class manages students
     *
     * Contains functions which allow user to add, view, update and delete students
     * @author Sumit Chhetri
     * @date   6/25/14
     * @bug    No known bugs
     */
    class StudentController extends BaseController {

        /**
         * @var Faculty
         */
        private $faculty;

        /**
         * @var Shift
         */
        private $shift;

        /**
         * @var Student
         */
        private $student;

        /**
         * @param Faculty $faculty
         * @param Shift   $shift
         * @param Student $student
         */
        function __construct(Faculty $faculty, Shift $shift, Student $student)
        {
            $this->faculty = $faculty;
            $this->shift   = $shift;
            $this->student = $student;
            $this->beforeFilter('ajax', ['only' => ['getListsOfFacultyShiftAndBatch', 'getStudents']]);
        }


        public function index()
        {
            return View::make('students.index');
        }

        public function create()
        {
            list($faculties, $shifts, $batches) = $this->getListsOfFacultyShiftBatch();
            if ( Input::get('file') == true ) {
                return View::make('students.create')->withFaculties($faculties)->withShifts($shifts)->withBatches($batches)->withFile(true);
            }

            return View::make('students.create')->withFaculties($faculties)->withShifts($shifts)->withBatches($batches);
        }

        public function store()
        {
            $input = Input::all();
            if(Input::has('hasFile')){
                if($this->student->isValidFile($input)){
                    return "success";
                }
            }
            else{
                if($this->student->isValid($input)){
                    $this->student->fill($input);
                    if($this->student->save()){
                        return Redirect::route('students.index')->with('success','Student successfully added.');
                    }
                }
            }
            return Redirect::back()->withInput()->withErrors($this->student->errors);
        }

        public function show($id)
        {
            try {
                $student = $this->student->findOrFail($id);

                return View::make('students.show', compact('student'));
            } catch (ModelNotFoundException $exception) {
                return Redirect::route('students.index')->with('error', 'Student not found.');
            }
        }

        public function edit($id)
        {
            //
        }

        public function update($id)
        {
            //
        }

        public function destroy($id)
        {
            //
        }

        /**
         * @brief Get the list of faculties, shifts and batches
         * @return array
         */
        private function getListsOfFacultyShiftBatch()
        {
            $allFaculties = $this->faculty->get();
            $faculties    = $allFaculties->lists('faculty_with_description', 'id');
            $shifts       = $this->shift->orderBy('id', 'asc')->lists('shift', 'id');
            $batches      = [];
            for ($year = 2001; $year <= date('Y'); $year ++) {
                $batches[$year] = $year;
            }

            return array($faculties, $shifts, $batches);
        }

        /**
         * @brief Get the list of faculties, shifts and batches for angularjs ajax call
         * @return array
         */
        public function getListsOfFacultyShiftAndBatch()
        {
            $allFaculties = $this->faculty->get(['id', 'faculty_name', 'faculty_description']);
            $allShifts    = $this->shift->orderBy('id', 'asc')->get(['id', 'shift']);
            $allBatches   = [];
            $batches      = [];
            for ($year = 2001; $year <= date('Y'); $year ++) {
                $batches['id']    = $year;
                $batches['batch'] = strval($year);
                array_push($allBatches, $batches);
            }

            return array('faculty' => $allFaculties->toArray(), 'shift' => $allShifts->toArray(), 'batch' => $allBatches);
        }

        public function getStudents($faculty_id, $shift_id, $batch)
        {
            return $this->student->with(
                [
                    'faculty' => function ($query) {
                            $query->select(['id', 'faculty_name']);
                        },
                    'shift'   => function ($query) {
                            $query->select(['id', 'shift']);
                        }
                ])
                ->where('faculty_id', '=', $faculty_id)
                ->where('shift_id', '=', $shift_id)
                ->where('batch', '=', $batch)
                ->get(['id', 'first_name', 'last_name', 'roll_no', 'faculty_id', 'shift_id', 'batch']);
        }

    }