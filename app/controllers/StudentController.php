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

        /**
         * @brief Shows the view containg all the students
         * @return \Illuminate\View\View
         */
        public function index()
        {
            return View::make('students.index');
        }

        /**
         * @brief Shows the form to add new students
         * @return mixed
         */
        public function create()
        {
            list($faculties, $shifts, $batches) = $this->getListsOfFacultyShiftBatch();
            if ( Input::get('file') == true ) {
                return View::make('students.create')->withFaculties($faculties)->withShifts($shifts)->withBatches($batches)->withFile(true);
            }

            return View::make('students.create')->withFaculties($faculties)->withShifts($shifts)->withBatches($batches);
        }

        /**
         * @brief Saves a new student in database
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            $input = Input::all();
            if ( Input::get('hasFile') == 1 ) {
                if ( $this->student->isValidFile($input) ) {
                    return $this->storeByFile($input);
                }
            } else {
                if ( $this->student->isValid($input) ) {
                    $this->student->fill($input);
                    if ( $this->student->save() ) {
                        return Redirect::route('students.index')->with('success', 'Student successfully added.');
                    }
                }
            }

            return Redirect::back()->withInput()->withErrors($this->student->errors);
        }

        /**
         * @brief Saves many students in database using an Excel file
         * @param $input
         * @return \Illuminate\Http\RedirectResponse
         */
        private function storeByFile($input)
        {
            $file  = Input::file('file');
            $sheet = Excel::load($file->getRealPath())->get();
            if ( $sheet->count() > 1 )
                return Redirect::back()->withInput()->with('error', 'File should contain only one sheet.');

            $rowCollection = $sheet->first();
            $first_row     = $rowCollection->first();
            if ( $this->isFileEmpty($first_row) )
                return Redirect::back()->withInput()->with('error', 'The file doesn\'t contain any student\'s record.');

            if ( ! $this->isCorrectHeaders($first_row) )
                return Redirect::back()->withInput()->with('error', 'Either the file doesn\'t contain correct headers or the fields of first student\'s record isn\'t filled.');

            $this->deleteStudents($input);
            foreach ($rowCollection as $row) {
                $input['first_name'] = $row->first_name;
                $input['last_name']  = $row->last_name;
                $input['roll_no']    = $row->roll_no;
                if ( $this->student->isValid($input) ) {
                    $this->student->create($input);
                } else {
                    Session::flash('roll_no',$input['roll_no']);
                    return Redirect::back()->withInput()->withErrors($this->student->errors)->with('error', 'All student\'s record couldn\'t be saved because of some errors in file.');
                }
            }

            return Redirect::route('students.index')->with('success', 'Students successfully added.');

        }

        /**
         * @brief Checks if the selected Execl file is empty
         * @param $first_row
         * @return bool
         */
        private function isFileEmpty($first_row)
        {
            if ( ! $first_row ) {
                return true;
            }

            return false;
        }

        /**
         * @brief Checks if the selected Excel file has correct headers
         * @param $first_row
         * @return bool
         */
        private function isCorrectHeaders($first_row)
        {
            if ( ! ($first_row->first_name && $first_row->last_name && $first_row->roll_no) ) {
                return false;
            }

            return true;
        }

        /**
         * @brief Deletes all the students (selected faculty, shift and batch) from database before adding through Excel file
         * @param $input
         */
        private function deleteStudents($input)
        {
            $this->student->where('faculty_id', '=', $input['faculty_id'])
                ->where('shift_id', '=', $input['shift_id'])
                ->where('batch', '=', $input['batch'])
                ->delete();
        }

        /**
         * @brief Shows the view containg information of a single student
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function show($id)
        {
            try {
                $student = $this->student->findOrFail($id);

                return View::make('students.show', compact('student'));
            } catch (ModelNotFoundException $exception) {
                return Redirect::route('students.index')->with('error', 'Student not found.');
            }
        }

        /**
         * @brief Shows the form for editing student
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function edit($id)
        {
            try {
                $student = $this->student->findOrFail($id);
                list($faculties, $shifts, $batches) = $this->getListsOfFacultyShiftBatch();

                return View::make('students.edit', compact('student'))->withFaculties($faculties)->withShifts($shifts)->withBatches($batches);
            } catch (ModelNotFoundException $exception) {
                return Redirect::route('students.index')->with('error', 'Student not found.');
            }
        }

        /**
         * @brief Updates the information of a student
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update($id)
        {
            $input = Input::all();
            if ( $this->student->isValid($input, $id) ) {
                if ( $this->student->find($id)->update($input) ) {
                    return Redirect::route('students.show', $id)->with('success', 'Student successfully updated.');
                }

                return Redirect::route('students.show', $id)->with('error', 'Student not updated. Please try again.');
            }

            return Redirect::route('students.edit', $id)->withInput()->withErrors($this->student->errors);
        }

        /**
         * @brief Deletes a student
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy($id)
        {
            $student = $this->student->find($id);
            if ( $student->delete() ) {
                return Redirect::route('students.index')->with('success', 'Student successfully deleted.');
            }

            return Redirect::route('students.show', $id)->with('error', 'Student could not be deleted. Please try again.');
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

        /**
         * @brief Gets the students of a particular faculty, shift and batch when ajax call is made by client
         * @param $faculty_id
         * @param $shift_id
         * @param $batch
         * @return mixed
         */
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
                ->orderBy('first_name', 'asc')->get(['id', 'first_name', 'last_name', 'roll_no', 'faculty_id', 'shift_id', 'batch']);
        }

    }