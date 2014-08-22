<?php

    /**
     * @file   DashboardController.php
     * @brief  This class opens the dashboard of admin/teacher.
     *
     * @author Sumit Chhetri
     * @date   8/11/14
     * @bug    No known bugs
     */
    class DashBoardController extends BaseController {

        /**
         * @var bool
         */
        private $registered = true;

        /**
         * @var Notice
         */
        private $notice;

        /**
         * @param Notice $notice
         */
        public function __construct(Notice $notice)
        {
            $this->notice = $notice;
            $this->beforeFilter('check_regAct', ['only' => ['teacherDashboard', 'teachersSubjects']]);
        }

        /**
         * @brief Displays the admin dashboard
         * @return \Illuminate\View\View
         */
        public function adminDashboard()
        {
            return View::make('layout.admin.dashboard');
        }

        /**
         * @brief Displays the teacher dashboard
         * @return \Illuminate\View\View
         */
        public function teacherDashboard()
        {
            $teacher = Session::get('teacher');
            $this->setTeachersNameInSession($teacher->first_name, $teacher->last_name);
            $batches = $this->getBatches($teacher);
            $notices = $teacher->notices()->orderBy('updated_at', 'desc')->limit(3)->get();

            return View::make('layout.teacher.dashboard', compact('batches', 'notices'))->with('registered', $this->registered);

        }

        /**
         * @brief Set the teacher's first and last name in session and in the login information
         * @param $first_name
         * @param $last_name
         */
        private function setTeachersNameInSession($first_name, $last_name)
        {
            if ( Session::get('first_name') == null || Session::get('last_name') == null ) {
                Session::put('first_name', $first_name);
                Session::put('last_name', $last_name);
                $user             = Sentry::getUser();
                $user->first_name = $first_name;
                $user->last_name  = $last_name;
                $user->save();
            }
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
         * @brief Displays the subjects taught by a teacher
         * @param $batch
         * @return \Illuminate\View\View
         */
        public function teachersSubjects($batch)
        {
            $teacher           = Session::get('teacher');
            $subjectsWithClass = $teacher->subjects()->whereBatch($batch)->get(['title', 'subject_name']);
            $batches           = $this->getBatches($teacher);

            return View::make('layout.teacher.subjects', compact('subjectsWithClass', 'batches'))->with('registered', $this->registered);
        }
    }