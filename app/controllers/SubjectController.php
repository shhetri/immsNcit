<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   SubjectController.php
     * @brief  This class manages subjects
     *
     * Contains functions which allow user to add, view, update and delete subjects
     * @author Sumit Chhetri
     * @date   6/10/14
     * @bug    No known bugs
     */
    class SubjectController extends BaseController {

        /**
         * @var Subject
         */
        private $subject;

        /**
         * @param Subject $subject
         */
        public function __construct(Subject $subject)
        {
            $this->subject = $subject;
            $this->beforeFilter('ajax', ['only' => 'getAllSubjects']);
        }

        /**
         * @brief Displays the view containing all the subjects.
         * @return \Illuminate\View\View
         */
        public function index()
        {
            return View::make('subjects.index');
        }

        /**
         * @brief Displays form to add a new subject
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return View::make('subjects.create');
        }

        /**
         * @brief Inserts new subject
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            $input = Input::all();
            if ( $this->subject->isValid($input) ) {
                $this->subject->fill($input);
                if ( $this->subject->save() ) {
                    return Redirect::route('subjects.index')->with('success', 'Subject successfully added.');
                }

                return Redirect::route('subjects.create')->withInput()->with('error', 'Subject could not be added. Please try again.');
            }

            return Redirect::route('subjects.create')->withInput()->withErrors($this->subject->errors);
        }

        /**
         * @brief Displays a particular subject
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function show($id)
        {
            try {
                $subject = $this->subject->findOrFail($id);

                return View::make('subjects.show', compact('subject'));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('subjects.index')->with('error', 'Subject not found.');
            }
        }

        /**
         * @brief Shows form to edit a subject
         * @param $id
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function edit($id)
        {
            try {
                $subject = $this->subject->findOrFail($id);

                return View::make('subjects.edit', compact('subject'));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('subjects.index')->with('error', 'Subject not found.');
            }
        }

        /**
         * @brief Updates a particular subject
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update($id)
        {
            $input = Input::all();
            if ( $this->subject->isValid($input, $id) ) {
                if ( $this->subject->find($id)->update($input) ) {
                    return Redirect::route('subjects.show', $id)->with('success', 'Subject successfully edited.');
                }

                return Redirect::route('subjects.edit', $id)->withInput()->with('error', 'Subject could not be edited. Please try again.');
            }

            return Redirect::route('subjects.edit', $id)->withInput()->withErrors($this->subject->errors);
        }

        /**
         * @brief Deletes a particular subject
         * @param $id
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy($id)
        {
            if ( $this->subject->find($id)->delete() ) {
                return Redirect::route('subjects.index')->with('success', 'Subject successfully deleted.');
            }

            return Redirect::route('subjects.show', $id)->with('error', 'Subject could not be deleted. Please try again.');
        }

        /**
         * @brief Get all subjects on ajax call
         * @return \Illuminate\Pagination\Paginator
         */
        public function getAllSubjects()
        {
            return $this->subject->orderBy('subject_name')->paginate(10,['id','subject_name','course_code']);
        }
    }