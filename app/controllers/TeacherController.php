<?php

    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   TeacherController.php
     * @brief  This class manages teachers
     *
     * Contains functions which allow user to add, view, update and delete teachers
     * @author Sumit Chhetri
     * @date   6/9/14
     * @bug    No known bugs
     */
    class TeacherController extends BaseController {

        /**
         * @var Teacher
         */
        private $teacher;

        /**
         * @param Teacher $teacher
         */
        public function __construct(Teacher $teacher)
        {
            $this->teacher = $teacher;
            $this->beforeFilter('ajax', ['only' => 'getAllTeachers']);
        }

        /**
         * @brief Shows the view containing all the teachers
         * @return \Illuminate\View\View
         */
        public function index()
        {
            return View::make('teachers.index');
        }

        /**
         * @brief Shows the form to add a new teacher
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return View::make('teachers.create');
        }

        /**
         * @brief Inserts new teacher
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            $input = Input::all();
            if ( $this->teacher->isValid($input) ) {
                $this->teacher->fill($input);
                if ( $this->teacher->save() ) {
                    return Redirect::route('teachers.index')->with('success', 'Teacher successfully added.');
                }

                return Redirect::route('teachers.create')->withInput()->with(
                    'error',
                    'Teacher could not be added. Please try again.'
                );
            }

            return Redirect::route('teachers.create')->withInput()->withErrors($this->teacher->errors);
        }

        /**
         * @brief Shows a specific teacher information
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function show($id)
        {
            try {
                $teacher = $this->teacher->findOrFail($id);

                return View::make('teachers.show', compact('teacher'));
            } catch (Exception $e) {
                return Redirect::route('teachers.index')->with('error', 'Teacher not found.');
            }
        }

        /**
         * @brief Shows the form to edit a teacher
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function edit($id)
        {
            try {
                $teacher = $this->teacher->findOrFail($id);

                return View::make('teachers.edit', compact('teacher'));
            } catch (Exception $e) {
                return Redirect::route('teachers.index')->with('error', 'Teacher not found.');
            }
        }

        /**
         * @brief Updates the information of a teacher
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update($id)
        {
            $input = Input::all();
            if ( $this->teacher->isValid($input, $id) ) {
                if ( $this->teacher->find($id)->update($input) ) {
                    return Redirect::route('teachers.show', $id)->with('success', 'Teacher successfully updated.');
                }

                return Redirect::route('teachers.show', $id)->with('error', 'Teacher not updated. Please try again.');
            }

            return Redirect::route('teachers.edit', $id)->withInput()->withErrors($this->teacher->errors);
        }

        /**
         * @brief Deletes a teacher
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy($id)
        {
            $teacher = $this->teacher->find($id);
            if ( $teacher->delete() ) {
                return Redirect::route('teachers.index')->with('success', 'Teacher successfully deleted.');
            }

            return Redirect::route('teachers.show', $id)->with('error', 'Teacher could not be deleted. Please try again.');
        }

        /**
         * @brief Get teachers when ajax call made by client
         * @return \Illuminate\Pagination\Paginator
         */
        public function getAllTeachers()
        {
            return $this->teacher->orderBy('first_name', 'asc')->paginate(10, ['id', 'first_name', 'last_name', 'status']);
        }
    }