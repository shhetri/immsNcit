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
        }

        /**
         * @brief Displays the view containing all the subjects.
         * @return \Illuminate\View\View
         */
        public function index()
        {
            $allSubjects = $this->subject->orderBy('subject_name')->paginate(10);

            return View::make('subjects.index', compact('allSubjects'));
        }

        /**
         * @brief Displays form to add a new subject
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return View::make('subjects.create');
        }

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

        public function show($id)
        {
            try {
                $subject = $this->subject->findOrFail($id);

                return View::make('subjects.show', compact('subject'));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('subjects.index')->with('error', 'Subject not found.');
            }
        }

        public function edit($id)
        {
            try {
                $subject = $this->subject->findOrFail($id);

                return View::make('subjects.edit', compact('subject'));
            } catch (ModelNotFoundException $e) {
                return Redirect::route('subjects.index')->with('error', 'Subject not found.');
            }
        }

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

        public function destroy($id)
        {
            if ( $this->subject->find($id)->delete() ) {
                return Redirect::route('subjects.index')->with('success', 'Subject successfully deleted.');
            }

            return Redirect::route('subjects.show', $id)->with('error', 'Subject could not be deleted. Please try again.');
        }

    }