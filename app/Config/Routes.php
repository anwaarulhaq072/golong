<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/user_creation', 'Home::send_user_creation_email');
$routes->get('/admin/alerts' , 'Admin::adminAlerts') ;
$routes->get('/admin/withdrawal' , 'Admin::withdrawal_requests') ;
$routes->get('/admin/deposit' , 'Admin::deposit_requests') ;



//Login Api
$routes->post('/verify', 'Api\Home::verify');
$routes->post('/otpVerify', 'Api\Home::otpVerify');
$routes->get('/logout' , 'Api\Home::logout') ;

//User side Api
$routes->get('/profile', 'Api\Home::profile');
$routes->post('/update_profile', 'Api\home::updateProfile');
$routes->get('/user_dashboard', 'Api\User::dashboard');
$routes->get('/chartDetails', 'Api\User::chartDetails');
$routes->get('/deposit', 'Api\User::deposit');
$routes->post('/submit_deposit', 'Api\User::submit_deposit');
$routes->get('/withdrawal', 'Api/User::withdrawal');
$routes->post('/submit_withdrawal', 'Api/User::submit_withdrawal');
$routes->get('/overview', 'Api/User::overview');
$routes->post('/report_genrate', 'Api/User::report_genrate');
$routes->get('/notification', 'Api/user::notifications');

//admin side API
$routes->get('/admin_dashboard', 'Api\admin::dashboard');
$routes->get('/admin_notification', 'Api\admin::notifications');
$routes->get('/admin_deposit', 'Api\admin::deposit_requests');
$routes->get('/admin_withdrawal', 'Api\admin::withdrawal_requests');
$routes->post('/add_user', 'Api\home::saveSignupData');
$routes->get('/bulkupdate', 'Api\admin::bulkUpdate');
$routes->post('/submit_bulkupdate', 'Api\admin::addBulkUpdate');
$routes->get('/customer_detail' , 'Api\admin::customerdetails');
$routes->get('/customer_dashboard' , 'Api\admin::userDashboard');
$routes->post('/customer_edit_profile' , 'Api\admin::editProfile');
$routes->post('/customer_update_investment' , 'Api\admin::addInvestment');
$routes->post('/customer_add_payouts' , 'Api\admin::addPayouts');
$routes->post('/customer_edit_payouts' , 'Api\admin::editPayout');
$routes->get('/customer_delete_payouts' , 'Api\admin::deletePayouts');
$routes->post('/customer_add_profit_loss' , 'Api\admin::addProfitLoss');
$routes->post('/customer_edit_profit_loss' , 'Api\admin::editProfitLoss');
$routes->get('/customer_delete_profit_Loss' , 'Api\admin::deleteProfit');
$routes->post('/admin_submit_notification' , 'Api\admin::submitnotification');
$routes->get('/admin_update_notification' , 'Api\admin::updatenotification');
$routes->post('/admin_edit_notification' , 'Api\admin::updatenotificationData');
$routes->get('/admin_delete_notification' , 'Api\admin::deleteNotification');
$routes->get('/admin_accepted_deposit' , 'Api\admin::accept_deposit_requests');
$routes->post('/admin_rejected_deposit' , 'Api\admin::reject_deposit_requests');
$routes->get('/admin_completed_deposit' , 'Api\admin::complete_deposit_requests');
$routes->get('/admin_accepted_withdrawal' , 'Api\admin::accept_withdrawal_requests');
$routes->post('/admin_rejected_withdrawal' , 'Api\admin::reject_withdrawal_requests');
$routes->get('/admin_completed_withdrawal' , 'Api\admin::complete_withdrawal_requests');
$routes->get('/user_profile_data' , 'Api\admin::user_profile_data');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
