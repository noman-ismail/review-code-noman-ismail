<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$ad = DB::table('admin_setting')->first();
define('admin',base64_decode($ad->admin_path));
// dd(admin);

Route::get('/'.admin , 'admin\AdminPanel@login')->middleware("guest:admin")->name('admin');
Route::get('/login' , 'login\UserPanel@login')->middleware("guest:login")->name('login');
Route::post('/login' , 'login\UserPanel@login')->name('user_login');
Route::post('/'.admin , 'admin\AdminPanel@login')->name('admin_login');
Route::get('/register' , 'login\UserPanel@register')->middleware("guest:login")->name('register');
Route::post('/register' , 'login\UserPanel@register')->name('user_register');
Route::get('/sms_testing' , 'login\UserPanel@sendSmsToNumber');
    // <!-------------------------- admin Route ------------------------!>
Route::group(['prefix'=>'/'.admin,'middleware'=>['auth:admin']],function(){
    Route::get('/dashboard' , 'admin\AdminPanel@dashboard')->name('admin-dashboard');
    Route::post('/change-status' , 'admin\AdminPanel@change_status');
    Route::match(['get','post'],'/stats-dashboard' , 'admin\AdminPanel@stats_dashboard')->name('stats-dashboard');
    Route::match(['get','post'],'/update-login' , 'admin\AdminPanel@login_credentials')->name('login-update');
    Route::match(['get','post'],'/national-list' , 'admin\AdminPanel@national')->name('add-national');
    Route::match(['get','post'],'/city-list' , 'admin\AdminPanel@cities')->name('cities');
    Route::match(['get','post'],'/province' , 'admin\AdminPanel@province')->name('province');
    Route::match(['get','post'],'/official-designations' , 'admin\AdminPanel@ofc_dsg')->name('ofc_dsg');
    Route::match(['get','post'],'/society-designations' , 'admin\AdminPanel@society_dsg')->name('society_dsg');
    Route::match(['get','post'],'/login-info' , 'admin\AdminPanel@update_login')->name('admin-update');
    Route::match(['get','post'],'/sms-setting' , 'admin\AdminPanel@sms_setting')->name('sms-setting');
    Route::match(['get','post'],'/email-setting' , 'admin\AdminPanel@email_setting')->name('email-setting');
    Route::match(['get','post'],'/cabinets' , 'admin\AdminPanel@cabinets')->name('cabinets');
    Route::match(['get','post'],'/add-cabinets' , 'admin\AdminPanel@add_cabinets')->name('add-cabinets');
    Route::get('/general-setting', 'settings\GeneralsettingController@index');   
    Route::match(['get','post'],'/district-cabinet', 'settings\GeneralsettingController@distric_cabinet')->name('district-cabinet-setting');   
    Route::patch('/general-setting', 'settings\GeneralsettingController@store'); 
    // <!-----------------------------National Panel-----------------------!>
    Route::get('/national-dashboard' , 'admin\NationalPanel@dashboard')->name('national-dashboard');
    Route::match(['get','post'],'/add-national-user' , 'admin\NationalPanel@add_user')->name('add-n-user');
    Route::match(['get','post'],'/national-user-list' ,'admin\NationalPanel@national_user_list')->name('national-u-list');
    Route::match(['get','post'],'/national-login-update' , 'admin\NationalPanel@update_login')->name('national-login-update');

    // <!-----------------------------Province Panel-----------------------!>
    
    Route::get('/province-dashboard' , 'admin\ProvincePanel@dashboard')->name('province-dashboard');
    Route::match(['get','post'],'/add-province-user' , 'admin\ProvincePanel@add_user')->name('add-p-user');
    Route::match(['get','post'],'/province-user-list' ,'admin\ProvincePanel@province_user_list')->name('province-u-list');
    Route::match(['get','post'],'/province-login-update' , 'admin\ProvincePanel@update_login')->name('province-login-update');
    // Route::match(["get", "post"],'/budget-list-report', 'admin\ProvincePanel@budget_report')->name('budget-list-report');
    // Route::match(["get", "post"],'/budget-list-pdf', 'admin\ProvincePanel@budget_pdf')->name('budget-list-pdf');
    Route::match(["get", "post"],'/budget-distribution-report', 'admin\ProvincePanel@budget_distribution')->name('distribution-report');
    Route::match(["get", "post"],'/budget-dis-pdf', 'admin\ProvincePanel@distribution_pdf')->name('distribution-pdf');
    Route::match(["get", "post"],'/budget-request-report', 'admin\ProvincePanel@budget_request')->name('budget-report');
    Route::match(["get", "post"],'/budget-req-pdf', 'admin\ProvincePanel@budget_pdf')->name('budget-pdf');
    Route::match(["get", "post"],'/fund-request-report', 'admin\ProvincePanel@fund_request')->name('fund-report');
    Route::match(["get", "post"],'/fund-req-pdf', 'admin\ProvincePanel@fund_pdf')->name('fund-pdf');
    Route::match(["get", "post"],'/death-report', 'admin\ProvincePanel@death_report')->name('death-report');
    Route::match(["get", "post"],'/death-pdf', 'admin\ProvincePanel@death_pdf')->name('death-pdf');
    Route::match(["get", "post"],'/expense-report', 'admin\ProvincePanel@expense_report')->name('expense-report');
    Route::match(["get", "post"],'/expense-pdf', 'admin\ProvincePanel@expense_pdf')->name('expense-pdf');
    // <!-----------------------------distric Panel-----------------------!>
    Route::get('/district-dashboard' , 'admin\DistrictPanel@dashboard')->name('district-dashboard');
    Route::get('/ledger' , 'admin\DistrictPanel@ledger')->name('ledger');
    Route::get('/jobs/list', 'admin\jobsController@jobsList')->name('job-list');
    Route::post('/positions' , 'admin\AdminPanel@positions');
    Route::match(['get','post'],'/collect-payment' , 'admin\DistrictPanel@collect_payment')->name('collect-payment');
    Route::match(['get','post'],'/fund-request' , 'admin\DistrictPanel@fund_request')->name('fund-request');
    Route::match(['get','post'],'/add-district-user' , 'admin\DistrictPanel@add_user')->name('add-d-user');
    Route::match(['get','post'],'/district-user-list' ,'admin\DistrictPanel@district_user_list')->name('district-u-list');
    Route::match(['get','post'],'/fund-periods' ,'admin\DistrictPanel@fund_periods')->name('fund-periods');
    Route::match(['get','post'],'/funds' ,'admin\DistrictPanel@fund_history')->name('funds');
    Route::match(['get','post'],'/fund-history' ,'admin\DistrictPanel@fund_history')->name('fund-history');
    Route::match(['get','post'],'/fund-collector' ,'admin\DistrictPanel@fund_collector')->name('fund-collector');
    Route::match(["get", "post"],'/jobs', 'admin\jobsController@addjobs')->name('jobs-create');
    Route::match(['get','post'],'/district-login-update' , 'admin\DistrictPanel@update_login')->name('district-login-update');
    Route::match(['get','post'],'/about-cabinet' ,'admin\DistrictPanel@about_cabinet')->name('about-cabinet');
    Route::match(['get','post'],'/cabinet-team' , 'admin\DistrictPanel@cabinet_content')->name('cabinet-content');
    Route::match(['get','post'],'/about-cabinet-meta' , 'admin\DistrictPanel@about_cabinet_meta')->name('about-cabinet-meta');
    Route::match(['get','post'],'/cabinet-team-meta' , 'admin\DistrictPanel@cabinet_team_meta')->name('cabinet-team-meta');
    Route::match(['get','post'], '/user-list','admin\DistrictPanel@user_list')->name('user-list');
    Route::match(["get", "post"],'/death-claim', 'admin\DistrictPanel@death_claim')->name('death-claim');
    Route::match(["get", "post"],'/death-claim-list', 'admin\DistrictPanel@death_claim_list')->name('death-claim-list');
    Route::match(["get", "post"],'/death-claim-requests', 'admin\DistrictPanel@death_requests')->name('death-claim-requests');
    Route::match(["get", "post"],'/cabinet/jobs-meta', 'admin\DistrictPanel@jobsmeta')->name('district-jobs-meta');
    Route::match(["get", "post"],'/cabinet/events-meta', 'admin\DistrictPanel@eventsmeta')->name('district-events-meta');
    Route::match(["get", "post"],'/cabinet/news-meta', 'admin\DistrictPanel@newsmeta')->name('district-news-meta');
    Route::match(["get", "post"],'/cabinet/members-meta', 'admin\DistrictPanel@membersmeta')->name('district-members-meta');
    Route::match(["get", "post"],'/cabinet/notifications-meta', 'admin\DistrictPanel@notificationMeta')->name('district-notifications-meta');
    Route::match(["get", "post"],'/tehsil-list', 'admin\DistrictPanel@tahsil_list')->name('tehsil');
    Route::match(["get", "post"],'/transfer-to-province', 'admin\DistrictPanel@transfer_province')->name('transfer-to-province');
    Route::match(["get", "post"],'/district-ledger', 'admin\DistrictPanel@district_ledger')->name('district-ledger');
    Route::match(["get", "post"],'/transfer-payment', 'admin\DistrictPanel@transfer_payment')->name('transfer-payment');
    Route::match(["get", "post"],'/fc-ledger-report', 'admin\DistrictPanel@fcledger_report')->name('fc-ledger-report');
    Route::match(["get", "post"],'/fc-ledger-pdf', 'admin\DistrictPanel@fcledger_pdf')->name('fc-ledger-pdf');
    Route::match(["get", "post"],'/district-ledger-report', 'admin\DistrictPanel@dcledger_report')->name('district-ledger-report');
    Route::match(["get", "post"],'/district-ledger-pdf', 'admin\DistrictPanel@dcledger_pdf')->name('district-ledger-pdf');
    Route::match(["get", "post"],'/fund-history-report', 'admin\DistrictPanel@fund_report')->name('fund-history-report');
    Route::match(["get", "post"],'/fund-history-pdf', 'admin\DistrictPanel@fund_pdf')->name('fund-history-pdf');

    // <!----------------------------- BLOGS ROUTES -----------------------!>
    Route::get('/blogs/list', 'cms\BlogsController@blogsList');
    Route::match(["get", "post"] ,'/blogs', 'cms\BlogsController@addBlogs')->name("blog-create");
    Route::match(["get", "post"], '/blogs/meta', 'cms\BlogsController@meta');
    Route::match(["get", "post"], '/blogs/category', 'cms\BlogsController@blogCategory');
    Route::match(["get", "post"], '/blogs/cats-store', 'cms\BlogsController@catsStore');
    Route::post('/category/order', 'cms\BlogsController@catsorder');

      //Authors Routes 
    Route::get('/authors', 'AuthorsController@addauthors');
    Route::post('/authors/save', 'AuthorsController@addauthorsSave');
    Route::get('/authors/list', 'AuthorsController@authorsList')->name('authors-list');
    
     // <!----------------------------- EVENT ROUTES -----------------------!>
    Route::get('/event', 'admin\EventController@eventList')->name('event');
    Route::match(["get", "post"],'/event/new', 'admin\EventController@_new')->name("create-event");
    // <!----------------------------- ABOUT ROUTES -----------------------!>
    Route::match(["get", "post"] , '/about', 'cms\AboutController@about');
    Route::match(["get", "post"] , '/about/attorneys', 'cms\AboutController@attorneys');
    Route::match(["get", "post"] , '/about/reviews', 'cms\AboutController@reviews');

    // <!----------------------------- HOME ROUTES -----------------------!>

    Route::match(["get", "post"] , '/homepage', 'cms\HomeContoller@homemeta');
    Route::match(["get", "post"] , '/homepage/grants', 'cms\HomeContoller@grants');
    Route::match(["get", "post"] , '/homepage/initiatives', 'cms\HomeContoller@initiatives');
    Route::match(["get", "post"] , '/homepage/interest', 'cms\HomeContoller@interest');
    Route::match(["get", "post"] , '/footer', 'cms\HomeContoller@footer')->name("footer");

    // <!-----------------------CONTACT PAGE ROUTES -----------------------!>

    Route::match(["get", "post"],'/contact', 'CmsController@contact')->name("contact-page");
    Route::post('/contactus/store', 'CmsController@storecontactus');
    Route::match(["get", "post"], '/jobs-meta', 'CmsController@jobsmeta')->name("jobs-meta");
    Route::match(["get", "post"], '/event-meta', 'CmsController@eventmeta')->name("event-meta");
    Route::match(["get", "post"], '/news-meta', 'CmsController@newsmeta')->name("news-meta");
    Route::match(["get", "post"], '/notifications-meta', 'CmsController@notificationsmeta')->name("notifications-meta");
    Route::match(["get", "post"], '/documents-meta', 'CmsController@documentsmeta')->name("documents-meta");
    Route::match(["get", "post"],'/faqs', 'CmsController@faqs')->name("faqs");
    Route::get('/faqs-list', 'CmsController@allfaqs');
    Route::match(["get", "post"], '/faqs/meta', 'CmsController@faqs_meta');
    Route::post('/faqs/store', 'CmsController@faqsstore');
    Route::post('/faqs/order', 'CmsController@faqsorder');
    Route::get('/privacy-policy', 'CmsController@privacypolicy')->name("privacy");
    Route::post('/privacy/store', 'CmsController@storeprivacypolicy');
    Route::get('/terms-condition', 'CmsController@termscondition')->name("terms");
    Route::post('/terms/store', 'CmsController@storetermscondition');
    Route::match(["get", "post"],'/welfare-benefits', 'CmsController@welfarebenefit')->name("welfare-benefits");
    Route::match(["get", "post"],'/download/new', 'CmsController@CreatDownloads')->name("create-download");
    Route::get('/downloads', 'CmsController@downloadList')->name('download-list');
    Route::get('/news/list', 'cms\NewsController@newsList')->name("news-list");
    Route::match(["get", "post"] ,'/news', 'cms\NewsController@addnews')->name("news-create");
    Route::match(["get", "post"],'/budget-list-pdf', 'admin\BudgetController@budget_pdf')->name('budget-list-pdf');
    // Route::match(["get", "post"],'/budget-list-pdf', 'admin\BudgetController@view_budget_pdf')->name('budget-list-pdf');

    // <!------------------------ Budget Routs --------------------------!>

    Route::match(["get", "post"],'/add-budget', 'admin\BudgetController@add_budget')->name('add-budget');
    Route::match(["get", "post"],'/budget-list', 'admin\BudgetController@budget_list')->name('budget-list');
    Route::match(["get", "post"],'/budget-stat', 'admin\BudgetController@budget_stat')->name('budget-stat');
    Route::match(["get", "post"],'/budget-distribution', 'admin\BudgetController@budget_distribution')->name('budget-distribution');
    Route::match(["get", "post"],'/budget-allocate', 'admin\BudgetController@budget_allocation')->name('budget-allocate');
    Route::match(["get", "post"],'/official-brands', 'admin\AdminPanel@official_brands')->name('official-brands');

    Route::match(["get", "post"],'/budget-request', 'admin\BudgetController@budget_request')->name('budget-request');
    Route::match(["get", "post"],'/expense-sheet', 'admin\CommonController@expense_sheet')->name('expense-sheet');
    Route::match(["get", "post"],'/add-expense', 'admin\CommonController@add_expense')->name('add-expense');
    Route::match(["get", "post"],'/pension-paper', 'cms\CalculatorController@pension_paper')->name('pension-paper');
    Route::match(["get", "post"],'/pension-calculator', 'cms\CalculatorController@pension_calculator')->name('pension-calculator');
    Route::match(["get", "post"],'/gp-fund', 'cms\CalculatorController@gp_fund')->name('gp-fund');
    Route::match(["get", "post"],'/pension-paper-meta', 'cms\CalculatorController@meta_pension_paper')->name('pension-paper-meta');
    Route::match(["get", "post"],'/pension-calculator-meta', 'cms\CalculatorController@meta_pension_calculator')->name('pension-calculator-meta');

    Route::match(["get", "post"],'/gp-fund-meta', 'cms\CalculatorController@meta_gp_fund')->name('gp-fund-meta');
    Route::get('/icons', 'CmsController@icons')->name('icons');
    Route::match(["get", "post"] , '/ads', 'AdsController@index');
    Route::match(["get", "post"],'/sidebar-settings', 'admin\AdminPanel@sidebar_settings');
    Route::match(["get", "post"] , '/sorting', 'admin\AdminPanel@_sorting');
    Route::get('/image-crop', 'AdminAjaxController@Croppie')->name("cropie");
    Route::post('/ajaxfunction', 'AjaxController@ajax')->name('remaining-budget');
    Route::post('/update-users', 'AjaxController@update_user')->name('update-users');


});
    Route::get('/'.admin.'/logout',function(){
        Auth::guard('admin')->logout();
        return redirect('/'.admin);
    })->name('adminlogout');
    // <!-------------------------- user Route ------------------------!>
    Route::group(['prefix'=>'/login','middleware'=>['auth:login']],function(){
        Route::get('/dashboard' , 'login\UserPanel@dashboard')->name('user-dashboard');
        Route::get('/amount-history', 'login\UserPanel@amount_history')->name('amount-history');
        Route::get('/funds-history', 'login\UserPanel@fund_history')->name('funds-history');
        Route::match(['get','post'], '/personal-information' , 'login\UserPanel@personal_info')->name('personal-information');
        Route::match(['get','post'], '/nominee-information' , 'login\UserPanel@nominee_info')->name('nominee-information');
        Route::match(['get','post'], '/family-information' , 'login\UserPanel@family_info')->name('family-information');
        Route::match(['get','post'], '/add-funds' , 'login\UserPanel@add_funds')->name('add-funds');
        Route::match(['get','post'], '/account-setting' , 'login\UserPanel@account_setting')->name('account-setting');
        Route::match(['get','post'], '/logout' , function(){
            Auth::guard('login')->logout();
            return redirect('/login');
        })->name('user-logout');
    });
    Route::group([],function(){
        Route::get('/' , 'MainController@home')->name('base_url');
        Route::get('/about-us' , 'MainController@aboutUs')->name('about_us');
        Route::get('/welfare-benefits' , 'MainController@wellfareBenefits')->name('wellfare_benefits');
        Route::get('/events' , 'MainController@events')->name('events');
        Route::post('/more-event' , 'MainController@more_events')->name('more-events');
        Route::get('/jobs' , 'MainController@jobs')->name('jobs');
        Route::get('/blogs' , 'MainController@blogs')->name('blogs');
        Route::get('/news' , 'MainController@news')->name('news');
        Route::get('/notifications' , 'MainController@govt_notification')->name('govt-notifications');
        Route::get('/documents' , 'MainController@imp_document')->name('imp-document');
        Route::get('/contact-us' , 'MainController@contact_us')->name('contact-us');
        Route::post('/contactform' , 'AjaxController@contactform');
        Route::get('/pakistan' , 'MainController@national')->name('national-cabinet');
        Route::get('/district' , 'MainController@district')->name('district-cabinet');
        Route::get('/privacy-policy', 'MainController@privacy');
        Route::get('/terms-conditions', 'MainController@terms');
        Route::get('/faqs', 'MainController@_faqs');
        Route::get('/download', 'AdsController@download')->name('download');
        Route::post('/faqsform', 'AjaxController@faqsform');
        Route::get('/404', 'MainController@notFound')->name('404');
        Route::post('/fetch-cities', 'AjaxController@ajax')->name('fetch-cities');
        Route::match(['get','post'],'/forgot-password', 'MainController@forgot_password')->name('forgot-password');
        Route::match(['get','post'],'/pension-calculator', 'PensionController@view')->name('pension_view');
        Route::post('/calculate-pension', 'PensionController@calculate')->name('calculate-pension');
        Route::get('/pension/pdf', 'PensionController@generate_pdf')->name('pension-pdf');
        Route::get('sitemap.xml', 'SitemapController@_show');
        Route::get('/{url}/{url1}' , 'MainController@cabinet_pages');
        Route::get('/{url}', function ($url) {
            $last_id = get_postid("last_id");
            $page_id = get_postid("page_id");
            $full =  get_postid("full");
            $seg = Request::segment(1);
            if (is_numeric($last_id) and $seg!="404"){
                if ($page_id==1 or $page_id==2 or $page_id==3 or $page_id==4  or $page_id==5 ){
                    return (new \App\Http\Controllers\MainController())->single();
                }else{
                    session(['back_url' => url()->previous()]);
                    return redirect( route( "404" ));
                }
            }else{
                return (new \App\Http\Controllers\MainController())->about_cabinet($seg);
            }
        });
    });