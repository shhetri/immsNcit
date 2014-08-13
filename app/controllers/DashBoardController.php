<?php
/**
 * @file DashboardController.php
 * @brief This class opens the dashboard of admin/teacher.
 *
 * @author Sumit Chhetri
 * @date 8/11/14
 * @bug No known bugs
 */

class DashBoardController extends BaseController{

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
        return View::make('layout.teacher.dashboard');
    }
	
}