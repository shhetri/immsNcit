<?php
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * @file   NoticeController.php
     * @brief  This class manages notices
     *
     * Contains functions which allow user to add, view, update and delete notices
     * @author Sumit Chhetri
     * @date   8/21/14
     * @bug    No known bugs
     */
    class NoticeController extends BaseController {

        /**
         * @var Notice
         */
        private $notice;

        /**
         * @var mixed
         */
        private $teacher;

        /**
         * @var bool
         */
        private $registered = true;

        /**
         * @param Notice $notice
         */
        public function __construct(Notice $notice)
        {
            $this->notice  = $notice;
            $this->teacher = Session::get('teacher');
        }

        /**
         * @brief Displays all the notices of logged in teacher
         */
        public function index()
        {
            $notices = $this->teacher->notices()->orderBy('updated_at', 'desc')->paginate(10);

            return View::make('notices.index', compact('notices'))->with('registered', $this->registered);
        }

        /**
         * @brief Displays a form to add a notice
         */
        public function create()
        {
            return View::make('notices.create')->with('registered', $this->registered);

        }

        /**
         * @brief Stores the notice in database
         */
        public function store()
        {
            $input               = Input::all();
            $input['teacher_id'] = $this->teacher->id;
            if ( $this->notice->isValid($input) ) {
                $this->notice->fill($input);
                if ( $this->notice->create($input) ) {
                    return Redirect::route('notices.index')->with('success', 'Notice succesfully added.');
                }

                return Redirect::back()->withInput()->with('error', 'Notice could not be added. Please try again.');
            }

            return Redirect::back()->withInput()->withErrors($this->notice->errors);
        }

        /**
         * @brief Displays the form to edit a notice
         * @param $id
         */
        public function edit($id)
        {
            try {
                $notice = $this->notice->findOrFail($id);

                return View::make('notices.edit', compact('notice'))->with('registered', $this->registered);
            } catch (ModelNotFoundException $e) {
                return Redirect::route('notices.index')->with('error', 'Notice could not found.');
            }
        }

        /**
         * @brief Updates the notice
         * @param $id
         */
        public function update($id)
        {
            $input = Input::all();
            if ( $this->notice->isValid($input) ) {
                if ( $this->notice->find($id)->update($input) ) {
                    return Redirect::route('notices.index')->with('success', 'Notice successfully updated.');
                }

                return Redirect::route('notices.index')->with('error', 'Notice not updated. Please try again.');
            }

            return Redirect::back()->withInput()->withErrors($this->notice->errors);
        }

        /**
         * @brief Delete the notice
         * @param $id
         */
        public function destroy($id)
        {
            $notice = $this->notice->find($id);
            if ( $notice->delete() ) {
                return Redirect::route('notices.index')->with('success', 'Notice successfully deleted.');
            }

            return Redirect::route('notices.index')->with('error', 'Notice could not be deleted. Please try again.');
        }

    }