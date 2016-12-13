<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Front-end Page Controllers

Route::get('/', 'HomeController@index');
Route::get('/signup', 'HomeController@signup');
Route::get('/Sign Up', 'HomeController@signup');

Route::get('/registerandnominate', 'HomeController@register_nominate');
Route::get('/Register And Nominate Business', 'HomeController@register_nominate');
Route::get('/register_from_nominate/', 'HomeController@register_from_nominate');

Route::get('/businesses', 'HomeController@business_list');
Route::get('/business/{id?}', 'HomeController@business');
Route::get('/businessratings/{id?}', 'HomeController@business_rating');
Route::get('/coupon/{id?}', 'HomeController@coupon');
Route::get('/navigateToBusiness/{id?}', 'HomeController@navicatoToBusiness');

Route::get('/page/{name?}', 'HomeController@page');
Route::get('/Page/{name?}', 'HomeController@page');

Route::get('/nominate/{name?}', 'HomeController@nominate');

Route::get('/login', 'HomeController@login');

Route::any('/setlocation', 'HomeController@location');

Route::get('/activate/{id?}', 'HomeController@activate');

Route::get('/forgot-password', 'HomeController@forgotPassword');


// Only logged in users can see
Route::group(['middleware' => 'auth'], function(){

	Route::any('/changepassword', 'HomeController@change_password');

	Route::any('/myaccount', 'HomeController@my_account');

	Route::any('/mycoupons', 'HomeController@my_coupon');
});

// Processing requests from email link
Route::group(['middleware' => 'auth:0'], function(){
	Route::get('/confirm_complaint/{id}', 'HomeController@confirmComplaint');
});

// Ajax Controllers

Route::get('/ajax/getlocations', 'AjaxController@getlocations');
Route::post('/ajax/addtomycoupon', 'AjaxController@addToMyCoupon');
Route::post('/ajax/removemycoupon', 'AjaxController@removeFromMyCoupon');
Route::post('/ajax/updatemyaccount', 'AjaxController@updateMyAccount');
Route::post('/ajax/addreview', 'AjaxController@addReview');
Route::post('/ajax/filterbusiness', 'AjaxController@filterBusiness');
Route::post('/ajax/setlocation', 'AjaxController@changeLocation');
Route::post('/ajax/nominatebusiness', 'AjaxController@nominateBusiness');
Route::post('/ajax/registerwithpromo', 'AjaxController@registerWithPromocode');
Route::post('/ajax/registerwithnomination', 'AjaxController@registerWithNomination');
Route::post('/ajax/registerfromnomination', 'AjaxController@registerFromNomination');

Route::get('/ajax/gettotal', 'AjaxController@getTotal');

Route::get('/ajax/findbusiness/{radius}/{name?}', 'AjaxController@findBusiness');

Route::get('/ajax/visitbusinesswebsite/{id}', 'AjaxController@visitBusinessWebsite');


// Auth Controller
Route::post('/auth/login', 'AuthController@login');
Route::any('/auth/logout', 'AuthController@logout');
Route::post('/auth/setLocationNonmember', 'AuthController@setLocationNonmember');
Route::post('/auth/changepassword', 'AuthController@changePassword');
Route::post('/auth/verifyusername', 'AuthController@verifyUsername');
Route::post('/auth/verifyanswer', 'AuthController@verifyAnswer');

Route::get('/franchise/getreport/{name}', 'FranchisorReportController@downloadPdf');

// Franchisor Controller
Route::group(['middleware' => 'auth:1'], function(){
	Route::get('/franchise_dashboard', 'FranchisorController@home');
	Route::get('/franchise_promo', 'FranchisorPromoController@promo');
	Route::get('/franchise_businesses', 'FranchisorBusinessController@business');
	Route::get('/franchise_report', 'FranchisorReportController@report');
	Route::get('/franchise_business_selection_list', 'FranchisorBusinessController@businessSelectionList');
	
	Route::get('/franchise_add_business', 'FranchisorBusinessController@showCreateBusiness');
	Route::get('/franchise_edit_business/{id}', 'FranchisorBusinessController@showEditBusiness');
	Route::get('/franchise_contract/{id?}', 'FranchisorBusinessController@editContract');
	Route::get('/franchise_business_complaints/{id?}', 'FranchisorBusinessController@businessComplaints');
	Route::get('/franchise_business_ratings/{id?}', 'FranchisorBusinessController@businessRatings');
	Route::get('/franchise_business_images/{id?}', 'FranchisorBusinessController@businessImages');
	Route::get('/franchise_business_coupons/{id?}', 'FranchisorBusinessController@businessCoupons');
	Route::get('/franchise_business_report/{id?}', 'FranchisorReportController@businessReport');
	Route::get('/franchise_roi_calculator', 'FranchisorController@roiCalculator');
	Route::get('/franchise_roi_calculator_help', 'FranchisorController@roiCalculatorHelp');
	Route::get('/franchise_signedup_users/{pid?}', 'FranchisorPromoController@signupUsers');
	Route::get('/franchise_active_users/{pid}', 'FranchisorPromoController@activeUsers');

	Route::get('/fvajax/dashboard/setApproval/{code}', 'FranchisorController@setApproval');
	Route::get('/fajax/dashboard/setapproval/{id}', 'FranchisorController@toggleNominationApproval');
	Route::get('/fajax/dashboard/delete/{id}', 'FranchisorController@deleteNomination');

	Route::post('/fajax/savebusiness/{id}', 'FranchiseAjaxController@saveBusiness');
	Route::get('/fajax/removebusiness/{id}', 'FranchiseAjaxController@removeBusiness');

	Route::post('/fajax/savecontract/{id}', 'FranchiseAjaxController@saveContract');
	Route::get('/fajax/emailcontract/{id}', 'FranchiseAjaxController@sendContractEmail');

	Route::get('/fajax/getcomplaint/{id}', 'FranchiseAjaxController@getComplaint');
	Route::post('/fajax/savecomplaint/{id}', 'FranchiseAjaxController@saveComplaint');
    Route::delete('/fajax/deletecomplaint/{id}', 'FranchiseAjaxController@deleteComplaint');

	Route::get('/fajax/getrating/{id}', 'FranchiseAjaxController@getRating');
	Route::post('/fajax/saverating/{id}', 'FranchiseAjaxController@saveRating');
	Route::get('/fajax/deleterating/{id}', 'FranchiseAjaxController@deleteRating');
	Route::get('/fajax/activaterating/{id}', 'FranchiseAjaxController@activateRating');

	Route::post('/fajax/business/uploadgalleryimage/{id}', 'FranchiseAjaxController@uploadBusinessGalleryImage');
	Route::get('/fajax/business/deletegalleryimage/{bid}/{gid}', 'FranchiseAjaxController@deleteBusinessGalleryImage');
	Route::get('/fajax/gallery/setcategory/{cat?}', 'FranchisorGalleryController@setImageFilter');

	Route::post('/fajax/savecoupon/{id}', 'FranchiseAjaxController@saveCoupon');
	Route::get('/fajax/getcoupon/{id}', 'FranchiseAjaxController@getCoupon');
	Route::get('/fajax/deletecoupon/{id}', 'FranchiseAjaxController@deleteCoupon');
	Route::get('/fajax/activatecoupon/{id}', 'FranchiseAjaxController@activateCoupon');

	Route::post('/fajax/businessreport/{id}', 'FranchiseAjaxController@businessReport');
	Route::post('/fajax/franchisereport', 'FranchiseAjaxController@franchiseReport');
	Route::post('/fajax/franchisereportpdf', 'FranchisorReportController@pdfReport');

	Route::post('/fajax/savepromo/{id}', 'FranchiseAjaxController@savePromo');
	Route::post('/fajax/addpromo', 'FranchiseAjaxController@addPromo');
	Route::get('/fajax/promo/toggleneedactivation/{id}', 'FranchiseAjaxController@togglePromoNeedActivation');
	Route::get('/fajax/promo/toggleactivation/{id}', 'FranchiseAjaxController@togglePromoActivation');
	Route::get('/fajax/promo/delete/{id}', 'FranchiseAjaxController@deletePromo');
	Route::get('/fajax/sendactivationemail/{id}', 'FranchiseAjaxController@sendActivationEmail');

	Route::get('/fajax/setsortcolumn/{scope}/{column}', 'FranchiseAjaxController@setSortColumn');
	Route::post('/fajax/setfilter/{scope}', 'FranchiseAjaxController@setFilter');



	Route::any('/fupload', ['middleware' => 'auth', 'uses' =>'FranchiseAjaxController@upload']);


	Route::get('/business-criteria', 'FranchisorController@businessCriteria');
	Route::get('/business-criteria/{id}', 'FranchisorController@businessCriteria');
	Route::post('/business-criteria/{id}', 'FranchisorController@saveBusinessCriteria');

	Route::get('/fajax/business/create-from-selection/{id}', 'FranchisorBusinessController@createFromSelection');

	Route::get('/fajax/business/getnames', 'FranchisorReportController@getBusinessNames');

	Route::get('/fajax/oopdoc/search/{phrase}', 'FranchiseAjaxController@searchOOPDoc');
	Route::get('/fajax/oopdoc/{id}', 'FranchiseAjaxController@getOOPDoc');

	Route::get('/franchise_image_gallery', 'FranchisorGalleryController@imageGallery');
	Route::post('/fajax/business/uploadgalleryimage', 'FranchiseAjaxController@uploadGalleryImage');
	Route::get('/fajax/business/deletegalleryimage/{gid}', 'FranchiseAjaxController@deleteGalleryImage');
});


Route::group(['middleware' => 'auth:2'], function(){
	Route::get('/admin_promo', 'AdminUserController@promo');
	Route::get('/admin_manage_active_users', 'AdminUserController@manageActiveUsers');
	Route::get('/admin_manage_inactive_users', 'AdminUserController@manageInactiveUsers');
	Route::get('/admin_download_inactive_users', 'AdminUserController@exportExcelInactiveUsers');
	Route::get('/admin_import_users', 'AdminUserController@importUsers');
	Route::get('/admin_franchisee_list', 'AdminFranchiseController@franchiseeList');
	Route::get('/admin_manage_business_selections', 'AdminBusinessController@manageBusinessSelections');
	Route::get('/admin_manage_nominations', 'AdminNominationController@manageNominations');
	Route::get('/admin', 'AdminCMSController@cms');
	Route::get('/admin_cms', 'AdminCMSController@cms');
	Route::get('/admin_cms/{id}', 'AdminCMSController@cmsEditor');
	Route::get('/admin_manage_contract', 'AdminCMSController@manageContract');
	Route::get('/admin_cms_email', 'AdminCMSController@cmsEmail');
	Route::get('/admin_cms_email/{id}', 'AdminCMSController@cmsEmailEditor');
	Route::get('/admin_cms_category', 'AdminCMSController@cmsCategory');
	Route::get('/admin_cms_roi', 'AdminCMSController@cmsROI');
	Route::get('/admin_signedup_users/{pid}', 'AdminUserController@signupUsers');
	Route::get('/admin_report', 'AdminController@report');


	Route::any('/imglist', ['as'=>'imglist', 'middleware'=>'auth', 'uses'=>'AdminCMSController@imageList']);
	//Image upload
	Route::any('/upload', ['middleware' => 'auth', 'uses' =>'AdminCMSController@upload']);


	Route::post('/aajax/savenews', 'AdminAjaxController@saveNews');
	Route::post('/aajax/cms/savepage/{id}', 'AdminAjaxController@savePage');
	Route::get('/aajax/cms/deletepage/{id}', 'AdminAjaxController@deletePage');
	Route::post('/aajax/cms/savecontract', 'AdminAjaxController@saveContract');

	Route::get('/aajax/promo/viewByFranchise/{id?}', 'AdminUserController@setPromoFilter');
	Route::post('/aajax/promo/save', 'AdminAjaxController@createPromo');
	Route::post('/aajax/promo/save/{id}', 'AdminAjaxController@savePromo');
	Route::get('/aajax/promo/delete/{id}', 'AdminAjaxController@deletePromo');
	Route::get('/aajax/promo/toggleactivation/{id}', 'AdminAjaxController@togglePromoActivation');
	Route::get('/aajax/promo/toggleneedactivation/{id}', 'AdminAjaxController@togglePromoNeedActivation');

	Route::post('/aajax/activeuser/setfilter', 'AdminUserController@setActiveUserFilter');
	Route::get('/aajax/user/getuserdetail/{id}', 'AdminUserController@getUserDetail');
	Route::post('/aajax/user/saveuserdetail/{id}', 'AdminUserController@saveUserDetail');
	Route::get('/aajax/user/delete/{id}', 'AdminUserController@deleteUser');
	Route::post('/aajax/user/import', 'AdminUserController@importUsersFromCSV');
	Route::post('/aajax/inactiveuser/setfilter', 'AdminUserController@setInactiveUserFilter');

	Route::get('/aajax/franchise/getfranchiseedetail/{id}', 'AdminFranchiseController@getFranchiseeDetail');
	Route::get('/aajax/franchise/togglefranchiseestatus/{id}', 'AdminFranchiseController@toggleFranchiseeActive');
	Route::get('/aajax/franchise/delete/{id}', 'AdminFranchiseController@deleteFranchisee');
	Route::post('/aajax/franchise/savefranchise/{id}', 'AdminFranchiseController@saveFranchisee');

	Route::get('/aajax/business/setfranchisefilter/{id}', 'AdminBusinessController@setFilterFranchise');

	Route::get('/aajax/nomination/setapprovalfilter/{code}', 'AdminNominationController@setFilterApproval');
	Route::get('/aajax/nomination/setfranchiseefilter/{code}', 'AdminNominationController@setFilterFranchisee');
	Route::get('/aajax/nomination/setapproval/{id}', 'AdminNominationController@toggleNominationApproval');
	Route::get('/aajax/nomination/delete/{id}', 'AdminNominationController@deleteNomination');

	Route::post('/aajax/cms/saveemail/{id}', 'AdminCMSController@saveEmail');

	Route::get('/aajax/cms/getindustry/{id}', 'AdminCMSController@getIndustry');
	Route::post('/aajax/cms/saveindustry/{id}', 'AdminCMSController@saveIndustry');
	Route::get('/aajax/cms/deleteindustry/{id}', 'AdminCMSController@deleteIndustry');

	Route::get('/aajax/cms/getcategory/{type}/{id}', 'AdminCMSController@getCategory');
	Route::get('/aajax/cms/getcategoryname/{type}/{id}', 'AdminCMSController@getCategoryName');
	Route::post('/aajax/cms/savecategory/{type}/{id}', 'AdminCMSController@saveCategory');
	Route::get('/aajax/cms/deletecategory/{type}/{id}', 'AdminCMSController@deleteCategory');

	Route::post('/aajax/adminreport', 'AdminController@ajaxReport');

	Route::get('/admin_test_email', 'AdminController@testEmail');
});


Route::get('/sync-test', 'AjaxController@syncTest');



Route::post('/api/GetCounters', 'APIController@getCounters');
Route::get('/api/GetLocation', 'APIController@getLocation');
Route::post('/api/GetLocation', 'APIController@getLocation');

Route::post('/api/LoginWithMember', 'APIController@loginWithMember');
Route::post('/api/LoginWithNonMember', 'APIController@loginWithNonMember');
Route::post('/api/Logout', 'APIController@logout');

Route::post('/api/CheckAccountExist', 'APIController@checkAccountExist');
Route::post('/api/RegisterByNomination', 'APIController@registerByNomination');
Route::post('/api/RegisterByPromocode', 'APIController@registerByPromocode');
Route::post('/api/ForgotPassword', 'APIController@forgotPassword');
Route::post('/api/ChangePassword', 'APIController@changePassword');
Route::post('/api/UpdateProfile', 'APIController@updateProfile');
Route::post('/api/GetMyProfile', 'APIController@getMyProfile');

Route::post('/api/NominateBusiness', 'APIController@nominateBusiness');
Route::post('/api/GetMyCoupon', 'APIController@getMyCoupon');
Route::post('/api/RemoveFromMyCoupon', 'APIController@removeFromMyCoupon');
Route::post('/api/SetLocation', 'APIController@setLocation');
Route::post('/api/AddToMyCoupon', 'APIController@addToMyCoupon');
Route::post('/api/AddReview', 'APIController@addReview');

Route::post('/api/GetConsumersGPS', 'APIController@getConsumersGPS');
Route::post('/api/GetConsumerDetail', 'APIController@getConsumerDetail');
Route::post('/api/GetBusinessReview', 'APIController@getBusinessReview');
Route::post('/api/GetCoupon', 'APIController@getCoupon');
Route::post('/api/CheckInTerritory', 'APIController@checkInTerritory');
Route::post('/api/FindBusiness', 'APIController@findBusiness');

Route::post('/api/test', 'APIController@test');
Route::get('/api/test', 'APIController@test');
