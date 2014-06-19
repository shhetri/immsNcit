<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   ClassDetailController.php
     * @brief  This class manages class details
     *
     * Contains functions which allow user to add, view, update and delete class details
     * @author Sumit Chhetri
     * @date   6/14/14
     * @bug    No known bugs
     */
    class ClassDetailController extends BaseController {

        /**
         * @var ClassDetail
         */
        private $classDetail;

        /**
         * @var Faculty
         */
        private $faculty;

        /**
         * @var Semester
         */
        private $semester;

        /**
         * @var Shift
         */
        private $shift;

        /**
         * @param ClassDetail $classDetail
         * @param Faculty     $faculty
         * @param Semester    $semester
         * @param Shift       $shift
         */
        function __construct(ClassDetail $classDetail, Faculty $faculty, Semester $semester, Shift $shift)
        {
            $this->classDetail = $classDetail;
            $this->faculty     = $faculty;
            $this->semester    = $semester;
            $this->shift       = $shift;
        }

        /**
         * @brief Shows the view containing all the classes
         * @return \Illuminate\View\View
         */
        public function index()
        {
            return View::make('classDetails.index');
        }

        /**
         * @brief Shows the form for adding a class
         * @return mixed
         */
        public function create()
        {
            list($faculties, $semesters, $shifts, $batches) = $this->getListsOfFacultySemesterShiftAndBatch();

            return View::make('classDetails.create')->withFaculties($faculties)->withSemesters($semesters)->withShifts($shifts)->withBatches($batches);
        }

        /**
         * @brief Inserts a new class
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            $input          = Input::all();
            $inputWithTitle = $this->composeTitle($input);
            if ( $this->classDetail->isValid($inputWithTitle) ) {
                $this->classDetail->fill($inputWithTitle);
                if ( $this->classDetail->save() ) {
                    return Redirect::route('classes.index')->with('success', 'Class successfully added.');
                }

                return Redirect::route('classes.create')->with('error', 'Class could not be added. Please try again.');
            }

            return Redirect::route('classes.create')->withInput()->with('error', 'Class already exists.');
        }

        /**
         * @brief Displays a particular class
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function show($id)
        {
            try {
                $classDetail = $this->classDetail->findOrFail($id);

                return View::make('classDetails.show', compact('classDetail'));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('classes.index')->with('error', 'Class not found.');
            }
        }

        /**
         * @brief Shows a form to edit a class
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function edit($id)
        {
            try {
                $classDetails = $this->classDetail->findOrFail($id);
                list($faculties, $semesters, $shifts, $batches) = $this->getListsOfFacultySemesterShiftAndBatch();

                return View::make('classDetails.edit')->withClassDetails($classDetails)->withFaculties($faculties)->withSemesters($semesters)->withShifts($shifts)->withBatches($batches);
            } catch (ModelNotFoundException $e) {
                return Redirect::route('classes.index')->with('error', 'Class not found.');
            }
        }

        /**
         * @brief Updates a particular class
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update($id)
        {
            $input          = Input::all();
            $inputWithTitle = $this->composeTitle($input);
            if ( $this->classDetail->isValid($inputWithTitle, $id) ) {
                if ( $this->classDetail->find($id)->update($inputWithTitle) ) {
                    return Redirect::route('classes.show', $id)->with('success', 'Class successfully edited.');
                }

                return Redirect::route('classes.edit', $id)->with('error', 'Class could not be edited. Please try again.');
            }

            return Redirect::route('classes.edit', $id)->withInput()->with('error', 'Class already exists.');

        }

        /**
         * @brief Deletes a particular class
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy($id)
        {
            $classDetail = $this->classDetail->find($id);
            if ( $classDetail->delete() ) {
                return Redirect::route('classes.index')->with('success', 'Class successfully deleted.');
            }

            return Redirect::route('classes.show', $id)->with('error', 'Class could not be deleted. Please try again.');
        }

        /**
         * @brief Get the list of faculties, semesters, shifts and batches
         * @return array
         */
        private function getListsOfFacultySemesterShiftAndBatch()
        {
            $allFaculties = $this->faculty->get();
            $faculties    = $allFaculties->lists('faculty_with_description', 'id');
            $semesters    = $this->semester->orderBy('id', 'asc')->lists('semester_name', 'id');
            $shifts       = $this->shift->orderBy('id', 'asc')->lists('shift', 'id');
            $batches      = [];
            for ($year = 2001; $year <= date('Y'); $year ++) {
                $batches[$year] = $year;
            }

            return array($faculties, $semesters, $shifts, $batches);
        }

        /**
         * @brief Compose the title of the class using faculty, semester and shift
         * @param $input
         */
        private function composeTitle($input)
        {
            $faculty        = $this->faculty->find($input['faculty_id']);
            $faculty_name   = $faculty->faculty_name;
            $semester       = $this->semester->find($input['semester_id']);
            $semester_name  = $semester->semester_name;
            $shift          = $this->shift->find($input['shift_id']);
            $shift_time     = $shift->shift;
            $title          = $faculty_name . ' ' . $semester_name . ' Semester' . ' ' . $shift_time;
            $input['title'] = $title;

            return $input;

        }

        /**
         * @brief Get all the class details on ajax call
         * @return \Illuminate\Pagination\Paginator
         */
        public function getAllClasses()
        {
            return $this->classDetail->with(['faculty', 'semester', 'shift'])->orderBy('batch', 'desc')->paginate(10);
        }
    }