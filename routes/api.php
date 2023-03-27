<?php

use App\Http\Controllers\Admin\Advertiser\AdvertiserController;
use App\Http\Controllers\Admin\Buyer\BuyerController;
use App\Http\Controllers\Admin\Buyer\BuyerTierController;
use App\Http\Controllers\Admin\BuyerFilter\BuyerFilterController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Dashboard\DashboardUSController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\Lead\UKLeadController;
use App\Http\Controllers\Admin\Lead\USLeadController;
use App\Http\Controllers\Admin\Mapping\MappingController;
use App\Http\Controllers\Admin\Offer\OfferController;
use App\Http\Controllers\Admin\Partner\PartnerController;
use App\Http\Controllers\Admin\Postback\PostbackController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\User\CompanyController;
use App\Http\Controllers\CALeadController;
use App\Http\Controllers\Partner\PartPostbackController;
use App\Http\Controllers\PostbackTrackerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Partner\PartController;
use App\Http\Controllers\Partner\PartDashboardController;
use App\Http\Controllers\Partner\PartReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::get('refresh', 'AuthController@refresh');
        Route::middleware('auth:api')->group(function () {
            Route::get('user', 'AuthController@user');
            Route::post('logout', 'AuthController@logout');
        });
    });

/**** POST BACK Routes ***/
Route::post('conversion/track/postback', [PostbackTrackerController::class, 'postback'])->name('postback_tracker');
/**** Lead POST Routes ***/
Route::post('application/post', [UKLeadController::class, 'post']);
Route::post('application/usa/post', [USLeadController::class, 'post']);
Route::post('application/ca/post', [CALeadController::class, 'post']);
/**** REDIRECT Routes  ***/
Route::get('/application/redirecturl/{id}', 'UKLeadController@redirecturl');
Route::get('/application/usa/redirecturl/{id}', 'USLeadController@redirecturl');
Route::get('/application/ca/redirecturl/{id}', 'CALeadController@redirecturl');
/*** CheckStatus Route ***/
//Route::get('check-status/{countrycode}/{leadid}', [IframePostController::class, 'check_status'])->name('checkstatus');


Route::get('application/status/{correlationId}', [UKLeadController::class, 'CheckStatusNew'])->name('api-check-status');;
Route::get('application/usa/status/{correlationId}', [USLeadController::class, 'CheckStatusNew'])->name('api-check-status-us');;
Route::get('application/ca/status/{correlationId}', [CALeadController::class, 'CheckStatusNew'])->name('api-check-status-ca');;
/*** Lead Test Route ***/
Route::post('application/test', 'LeadTestController@testmodeca.php')->name('post.test');
/*** Lead Test Route ***/
/*** Mark CPF Lead as Funded Endpoint***/
Route::get('application/uk/tracking/{correlationId}', [UKLeadController::class, 'mark_cpf_funded'])->name('cpf-funded-uk');
Route::get('application/uk/pixel/{correlationId}', [UKLeadController::class, 'mark_cpf_funded'])->name('cpf-funded-uk');
Route::get('application/usa/cpf/{token}/{correlationId}', [USLeadController::class, 'mark_cpf_funded'])->name('cpf-funded-us');
Route::get('application/usa/pixel/{token}/{correlationId}', [USLeadController::class, 'mark_cpf_funded'])->name('cpf-funded-us');
Route::get('application/ca/tracking/{correlationId}', [CALeadController::class, 'mark_cpf_funded'])->name('cpf-funded-ca');
Route::get('application/ca/pixel/{correlationId}', [CALeadController::class, 'mark_cpf_funded'])->name('cpf-funded-ca');




Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::prefix('partner')->group(function () {

        /* Partner Account Settings */
        Route::get('/getPartnerReports/{id}', [PartReportController::class, 'getPartnerReports']);
        Route::get('/getUKReports/{id}', [PartReportController::class, 'getUKReports']);
        Route::get('/getUSReports/{id}', [PartReportController::class, 'getUSReports']);
        Route::get('/getOfferReports/{id}', [PartReportController::class, 'getOfferReports']);
        Route::get('/getPostbackReports/{id}', [PartReportController::class, 'getPostbackReports']);

        Route::get('/getPostbacks/{id}', [PartPostbackController::class, 'getPostbacks']);
        Route::get('/getPostback/{id}', [PartPostbackController::class, 'getPostback']);
        Route::apiResource('/postbacks', 'Partner\PartPostbackController');
        Route::apiResource('/offers', 'Partner\PartOfferController');



        /* Partner Account Settings */
        Route::get('/getUserData/{id}', [PartController::class, 'getUserData']);
        Route::patch('/updateAccountInfo/{id}', [PartController::class, 'updateAccountInfo']);
        Route::patch('/updateAccountPassword/{id}', [PartController::class, 'updateAccountPassword']);
        Route::patch('/updateCompany/{id}', [PartController::class, 'updateCompany']);
        /* Partner DATA Routes */
        Route::get('getDashboardLeadDataPartner/{id}', [PartDashboardController::class, 'getDashboardLeadDataPartner']);
        Route::get('getDashboardOfferDataPartner/{id}', [PartDashboardController::class, 'getDashboardOfferDataPartner']);
        Route::get('getDashboardOfferDataPartner/{id}', [PartDashboardController::class, 'getDashboardOfferDataPartner']);
        Route::get('getPartnerReports/{id}', [PartReportController::class, 'getPartnerReports']);
    });
});

Route::group([
        'middleware' => 'api'
    ]
    , function ($router) {
        Route::prefix('admin')->group(function () {
            /* Admin Account Settings */
            Route::get('getDashboardDataUK', [DashboardController::class, 'getDashboardDataUK']);
            Route::get('getDashboardDataUS', [DashboardUSController::class, 'getDashboardDataUS']);
            Route::get('getDashboardDataOffer', [DashboardController::class, 'getDashboardDataOffer']);

            Route::apiResource('users', '\App\Http\Controllers\UsersController');
            Route::apiResource('company', '\App\Http\Controllers\Admin\User\CompanyController');
            Route::apiResource('payment', '\App\Http\Controllers\Admin\User\PaymentController');
            Route::apiResource('buyers', '\App\Http\Controllers\Admin\Buyer\BuyerController');
            Route::apiResource('tiers', '\App\Http\Controllers\Admin\Buyer\BuyerTierController');
            Route::apiResource('partners', '\App\Http\Controllers\Admin\Partner\PartnerController');
            Route::apiResource('filters', '\App\Http\Controllers\Admin\BuyerFilter\BuyerFilterController');
            Route::apiResource('buyer-filters', '\App\Http\Controllers\Admin\BuyerFilter\BuyerFilterController');
            Route::apiResource('advertisers', '\App\Http\Controllers\Admin\Advertiser\AdvertiserController');
            Route::apiResource('uk-lead', '\App\Http\Controllers\Admin\Lead\UKLeadController');
            Route::apiResource('us-lead', '\App\Http\Controllers\Admin\Lead\UKLeadController');
            Route::apiResource('mappings', '\App\Http\Controllers\Admin\Mapping\MappingController');
            Route::apiResource('offers', '\App\Http\Controllers\Admin\Offer\OfferController');
            Route::apiResource('invoices', '\App\Http\Controllers\Admin\Invoice\InvoiceController');
            Route::apiResource('postbacks', '\App\Http\Controllers\Admin\Postback\PostbackController');


            Route::get('getUkLeadLog/{id}', [UKLeadController::class, 'getUkLeadLog']);
            /*** Invoice Routes ***/
            Route::get('getBuyerInvoices/{id}', [InvoiceController::class, 'getBuyerInvoices']);
            Route::get('getPartnerInvoices/{id}', [InvoiceController::class, 'getPartnerInvoices']);
            Route::get('getTierInvoices/{id}', [InvoiceController::class, 'getTierInvoices']);
            Route::get('revenueChartData', [DashboardController::class, 'revenueChartData']);


            Route::get('sendInvoice/{id}', [InvoiceController::class, 'sendInvoice']);
            Route::get('downloadInvoice/{id}', [InvoiceController::class, 'downloadInvoice']);




            Route::get('getAllCompanyData', [CompanyController::class, 'getAllCompanyData']);


            Route::get('getAllInvoices/{id}', [InvoiceController::class, 'getAllInvoices']);
            Route::get('getAdvertiserInvoices/{id}', [InvoiceController::class, 'getAdvertiserInvoices']);
            Route::get('getAdvertiserInvoices/{id}', [InvoiceController::class, 'getAdvertiserInvoices']);
            Route::get('getCompanyInvoices/{id}', [InvoiceController::class, 'getCompanyInvoices']);

            Route::get('fetchUserIds', [PartnerController::class, 'fetchUserIds']);
            Route::patch('updatePartnerPayment/{id}', [PartnerController::class, 'updatePartnerPayment']);
            Route::get('fetchFilterDataOptions', [MappingController::class, 'fetchFilterDataOptions']);
            Route::get('fetchFilterUKData', [ReportController::class, 'fetchFilterUKData']);
            Route::get('fetchFilterUSData', [ReportController::class, 'fetchFilterUSData']);
            Route::get('fetchFilterPostbackData', [ReportController::class, 'fetchFilterPostbackData']);
            Route::get('mappings/view_mappings/{vendor_id}', [MappingController::class, 'viewMapping']);
            Route::get('buyer-filters/fetchSelectOptions', [BuyerFilterController::class, 'fetchSelectOptions']);
            Route::get('buyer-filters/fetchIndividualFilter/{id}', [BuyerFilterController::class, 'fetchIndividualFilter']);
            Route::get('offers/getAllOffers', [OfferController::class, 'getAllOffers']);

            Route::get('getUKReports', [ReportController::class, 'getUKReports']);
            Route::get('getUSReports', [ReportController::class, 'getUSReports']);
            Route::get('getPostbackReports', [ReportController::class, 'getPostbackReports']);
            Route::get('getReferralReports', [ReportController::class, 'getReferralReports']);
            Route::get('getOfferReports', [ReportController::class, 'getOfferReports']);

//            Route::get('getReferralReports', [ReportController::class, 'getReferralReports']);
            Route::get('getPostbackMapping/{id}', [PostbackController::class, 'getPostbackMapping']);

        });
    });

//
///*   DATA ROUTES  */
//Route::delete('fetchUserIds', [AdvertiserController::class, 'fetchUserIds']);
//Route::delete('deletePostback/{id}', [PostbackController::class, 'deletePostback']);
//Route::get('getMappingTierIDs', [MappingController::class, 'getMappingTierIDs']);
//
//Route::get('getBuyerInvoices/{id}', [InvoiceController::class, 'getBuyerInvoices']);
//Route::get('getTierInvoices/{id}', [InvoiceController::class, 'getTierInvoices']);
//Route::get('getPartnerInvoices/{id}', [InvoiceController::class, 'getPartnerInvoices']);
//Route::get('getAdvertiserInvoices/{id}', [InvoiceController::class, 'getAdvertiserInvoices']);
//Route::get('getCompanyInvoices/{id}', [InvoiceController::class, 'getCompanyInvoices']);
//
//



//Route::post('/users', [UsersController::class, 'store']);
//Route::get('/getUsers', [UsersController::class, 'getUsers']);
//Route::delete('/deleteUser/{id}', [UsersController::class, 'destroy']);
//Route::get('/getUser/{id}', [UsersController::class, 'show']);
//Route::post('/editUser/{id}', [UsersController::class, 'edit']);
//
//Route::post('/editCompany/{id}', [CompanyController::class, 'update']);
//
//Route::get('/getBuyers', [BuyerController::class, 'getBuyers']);
//Route::post('/addBuyer', [BuyerController::class, 'storeBuyer']);
//Route::get('/getBuyer/{id}', [BuyerController::class, 'getBuyer']);
//Route::delete('/deleteBuyer/{id}', [BuyerController::class, 'destroy']);
//
//
//Route::post('/addTier', [BuyerTierController::class, 'storeTier']);
//Route::get('/getTier/{id}', [BuyerTierController::class, 'getTier']);
//Route::get('/getTiers', [BuyerTierController::class, 'getTiers']);
//Route::delete('/deleteTier/{id}', [BuyerTierController::class, 'destroy']);
//
//Route::apiResource('tiers', '\App\Http\Controllers\Admin\Buyer\BuyerTierController');
//
//
//Route::post('/addPartner', [PartnerController::class, 'storePartner']);
//Route::get('/getPartners', [PartnerController::class, 'getPartners']);
//Route::get('/getPartner/{id}', [PartnerController::class, 'getPartner']);
//Route::post('/deletePartner/{id}', [PartnerController::class, 'deletePartner']);
//Route::post('/editPartner/{id}', [PartnerController::class, 'editPartner']);
//Route::post('/viewPartner/{id}', [PartnerController::class, 'viewPartner']);
//
//
//Route::post('/addAdvertiser', [AdvertiserController::class, 'storeAdvertiser']);
//Route::get('/getAdvertisers', [AdvertiserController::class, 'getAdvertisers']);
//Route::post('/deleteAdvertiser/{id}', [AdvertiserController::class, 'deleteAdvertiser']);
//Route::get('/getAdvertiser/{id}', [AdvertiserController::class, 'getAdvertiser']);
//Route::post('/editAdvertiser/{id}', [AdvertiserController::class, 'editAdvertiser']);
//Route::post('/viewAdvertiser/{id}', [AdvertiserController::class, 'viewAdvertiser']);

//
//Route::post('/addBuyerFilter', [BuyerFilterController::class, 'storeBuyerFilter']);
//Route::get('/getBuyerFilters', [BuyerFilterController::class, 'getBuyerFilters']);
//Route::post('/deleteBuyerFilter/{id}', [BuyerFilterController::class, 'deleteBuyerFilter']);
//Route::get('/getBuyerFilter/{id}', [BuyerFilterController::class, 'getBuyerFilter']);
//Route::post('/editBuyerFilter/{id}', [BuyerFilterController::class, 'editBuyerFilter']);
//Route::post('/viewBuyerFilter/{id}', [BuyerFilterController::class, 'viewBuyerFilter']);
//
//
//Route::get('/getFilterList', [BuyerFilterController::class, 'getFilterList']);
//Route::get('/getFilter/{id}', [BuyerFilterController::class, 'getFilter']);
//Route::post('/addFilter', [BuyerFilterController::class, 'store']);
//
//
//Route::get('/getUKLead/{id}', [UKLeadController::class, 'getUKLead']);
//Route::get('/getUKLeads', [UKLeadController::class, 'getUKLeads']);
//
//Route::get('/getReports', [ReportController::class, 'getReports']);
//Route::get('/getReport/{id}', [ReportController::class, 'getReport']);
//
//Route::get('/getMappings', [MappingController::class, 'getMappings']);
//Route::get('/getMapping/{id}', [MappingController::class, 'getMapping']);
//
//
//Route::get('/getOffers', [OfferController::class, 'getOffers']);
//Route::get('/getOffer/{id}', [OfferController::class, 'getOffer']);

//Route::post('login', [UserController::class, 'login']);
//Route::post('register', [UserController::class, 'register']);
//Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


