<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminRolesController;
use App\Http\Controllers\AdminModuleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\McqController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryInsideController;
use App\Http\Controllers\EncryptionController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SuperadminDashboardController;
use App\Http\Controllers\SubadminController;
use App\Http\Controllers\SubadminRoleController;
use App\Http\Controllers\SubadminPermissionController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\LiveScheduleController;
use App\Http\Controllers\ReVideoController;
use App\Http\Controllers\SubadminModuleController;
use App\Http\Controllers\DemoProductController;
use App\Http\Controllers\DemoCategoryInsideController;
use App\Http\Controllers\DemoContentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\McqQuestionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\EbookController;

//FrontendController
use App\Http\Controllers\FrontendAuthController;
use App\Http\Controllers\FrontendController;


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

//Front websit
Route::get('/',[FrontendController::class,'index']);
Route::get('/sign-up',[FrontendAuthController::class,'signUp']);
Route::post('/sign-up',[FrontendAuthController::class,'saveSignUp']);

Route::get('/course-list',[FrontendController::class,'courseList']);
Route::get('/course-grid',[FrontendController::class,'courseGrid']);
Route::get('/course/{any}',[FrontendController::class,'courseDetails']);



// Route::get('/',[AuthController::class,'login']);
Route::get('/admin-login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout']);
Route::post('/admin-login',[AuthController::class,'makeLogin'])->name('login');

Route::get('/superadmin',[AuthController::class,'superAdminlogin']);
Route::post('/superadmin',[AuthController::class,'superAdminMakeLogin'])->name('superAdminlogin');

Route::group(['middleware'=>'auth:admin'],function(){

  Route::get('admin/reset-user-password/{id}',[AuthController::class,'resetPassword']);
  Route::post('admin/reset-user-password/{id}',[AuthController::class,'updateResetPassword']);

    Route::get('admin/dashboard',[DashboardController::class,'show']);
    Route::get('superadmin/dashboard',[SuperadminDashboardController::class,'show']);

    Route::get('superadmin/admin-roles',[AdminRolesController::class,'index']);
    Route::get('superadmin/add-roles',[AdminRolesController::class,'create']);
    Route::post('/superadmin/add-roles',[AdminRolesController::class,'store']);
    Route::get('superadmin/edit-admin-role/{id}',[AdminRolesController::class,'edit']);
    Route::post('superadmin/edit-admin-role/{id}',[AdminRolesController::class,'update']);
    Route::get('superadmin/view-admin-role/{id}',[AdminRolesController::class,'show']);
    Route::get('superadmin/delete-admin-role/{id}',[AdminRolesController::class,'destroy']);

    Route::get('superadmin/admin-modules/{id?}',[AdminModuleController::class,'index']);
    Route::get('superadmin/add-module/{role_id}',[AdminModuleController::class,'create']);
    Route::post('superadmin/add-module/{role_id}',[AdminModuleController::class,'store']);
    Route::get('superadmin/view-admin-module/{id}/{role_id}',[AdminModuleController::class,'show']);
    Route::get('superadmin/edit-admin-module/{id}/{role_id}',[AdminModuleController::class,'edit']);
    Route::post('superadmin/edit-admin-module/{id}/{role_id}',[AdminModuleController::class,'update']);
    Route::get('superadmin/delete-admin-module/{id}',[AdminModuleController::class,'destroy']);


    Route::get('superadmin/admin-user',[AdminUserController::class,'index']);
    Route::get('superadmin/add-admin-user',[AdminUserController::class,'create']);
    Route::post('superadmin/add-admin-user',[AdminUserController::class,'store']);
    Route::get('superadmin/view-admin-user/{id}',[AdminUserController::class,'show']);
    Route::get('superadmin/edit-admin-user/{id}',[AdminUserController::class,'edit']);
    Route::post('superadmin/edit-admin-user/{id}',[AdminUserController::class,'update']);
    Route::get('superadmin/delete-admin-user/{id}',[AdminUserController::class,'destroy']);

    Route::get('superadmin/module-permission/{id}/{role_id}',[ModulePermissionController::class,'index']);
    Route::get('superadmin/add-module-permission/{user_id}/{role_id}',[ModulePermissionController::class,'create']);
    Route::post('superadmin/add-module-permission/{user_id}/{role_id}',[ModulePermissionController::class,'store']);
    Route::get('superadmin/edit-module-permission/{id}',[ModulePermissionController::class,'edit']);
    Route::post('superadmin/edit-module-permission/{id}',[ModulePermissionController::class,'update']);
    Route::get('superadmin/delete-module-permission/{id}',[ModulePermissionController::class,'destroy']);

    Route::get('admin/product-list',[ProductController::class,'index']);
    Route::get('admin/add-product',[ProductController::class,'create']);
    Route::post('admin/add-product',[ProductController::class,'store']);
    Route::get('admin/edit-product/{id}',[ProductController::class,'edit']);
    Route::get('admin/view-product/{id}',[ProductController::class,'show']);
    Route::post('admin/edit-product/{id}',[ProductController::class,'update']);
    Route::get('admin/delete-product/{id}',[ProductController::class,'destroy']);


    Route::get('admin/demo-product-list',[DemoProductController::class,'index']);
    Route::get('admin/add-demo-product',[DemoProductController::class,'create']);
    Route::post('admin/add-demo-product',[DemoProductController::class,'store']);
    Route::get('admin/edit-demo-product/{id}',[DemoProductController::class,'edit']);
    Route::get('admin/view-demo-product/{id}',[DemoProductController::class,'show']);
    Route::post('admin/edit-demo-product/{id}',[DemoProductController::class,'update']);
    Route::get('admin/delete-demo-product/{id}',[DemoProductController::class,'destroy']);




    Route::get('admin/main-category-list/{catid?}',[CategoryController::class,'index']);
    Route::get('admin/add-main-category/{catid?}',[CategoryController::class,'create']);
    Route::post('admin/save-main-category',[CategoryController::class,'saveCategory']);
    Route::post('admin/save-sub-category',[CategoryController::class,'saveSubCategory']);
    Route::post('admin/get-sub-category',[CategoryController::class,'getSubCategory']);
    Route::get('admin/edit-main-category/{id}',[CategoryController::class,'edit']); 
		Route::post('admin/edit-main-category/{id}',[CategoryController::class,'update']);	   
		Route::get('admin/view-main-category/{id}',[CategoryController::class,'show']);	   
		Route::get('admin/delete-main-category/{id}',[CategoryController::class,'destroy']);	
		Route::get('admin/get-subcategory',[CategoryController::class,'getSubcategory']);	


    Route::get('admin/category-list/{id}/{catid?}',[CategoryInsideController::class,'index']);    
		Route::get('admin/add-category/{id}/{catid?}',[CategoryInsideController::class,'create']);	
		Route::post('admin/save-category',[CategoryInsideController::class,'store']);	  			 
		Route::get('admin/view-category/{id}',[CategoryInsideController::class,'show']);   
		Route::get('admin/category-status/{id}/{action}',[CategoryInsideController::class,'changeStatus']);         	
		Route::get('admin/edit-category/{id}',[CategoryInsideController::class,'edit']); 
		Route::post('admin/edit-category/{id}',[CategoryInsideController::class,'update']);	   
		Route::get('admin/delete-category/{id}',[CategoryInsideController::class,'destroy']);	

    Route::get('admin/demo-category-list/{id}/{catid?}',[DemoCategoryInsideController::class,'index']);    
		Route::get('admin/add-demo-category/{id}/{catid?}',[DemoCategoryInsideController::class,'create']);	
		Route::post('admin/save-demo-category',[DemoCategoryInsideController::class,'store']);	  			 
		Route::get('admin/view-demo-category/{id}',[DemoCategoryInsideController::class,'show']);   
		Route::get('admin/demo-category-status/{id}/{action}',[DemoCategoryInsideController::class,'changeStatus']);         	
		Route::get('admin/edit-demo-category/{id}',[DemoCategoryInsideController::class,'edit']); 
		Route::post('admin/edit-demo-category/{id}',[DemoCategoryInsideController::class,'update']);	   
		Route::get('admin/delete-demo-category/{id}',[DemoCategoryInsideController::class,'destroy']);	




    

    Route::get('admin/mcq-question-list',[McqController::class,'mcqQuestionList']);
    Route::post('admin/upload-question',[McqController::class,'uploadQuestion']);
    Route::get('admin/edit-mcq-question/{id}',[McqController::class,'editMcqQuestion']);
    Route::post('admin/edit-mcq-question/{id}',[McqController::class,'updateMcqQuestion']);
    Route::get('admin/view-mcq-question/{id}',[McqController::class,'viewMcqQuestion']);
    Route::get('admin/delete-mcq-question/{id}',[McqController::class,'deleteMcqQuestion']);

    Route::get('admin/mcq-option-list/{id}',[McqController::class,'mcqOptionList']);
    Route::get('admin/edit-mcq-option/{id}',[McqController::class,'editMcqOption']);
    Route::post('admin/edit-mcq-option/{id}',[McqController::class,'updateMcqOption']);
    Route::get('admin/view-mcq-option/{id}',[McqController::class,'viewMcqOption']);
    Route::get('admin/delete-mcq-option/{id}',[McqController::class,'deleteMcqOption']);

    Route::get('admin/mcq-list',[McqQuestionController::class,'mcqList']);
    Route::get('admin/add-mcq',[McqQuestionController::class,'addMcq']);
    Route::post('admin/add-mcq',[McqQuestionController::class,'saveMcq']);
    Route::get('admin/view-mcq/{id}',[McqQuestionController::class,'viewMcq']);
    Route::get('admin/edit-mcq/{id}',[McqQuestionController::class,'editMcq']);
    Route::post('admin/edit-mcq/{id}',[McqQuestionController::class,'updateMcq']);
    Route::get('admin/delete-mcq/{id}',[McqQuestionController::class,'deleteMcq']);
    Route::get('admin/map-mcq-question-list/{id}',[McqQuestionController::class,'mapMcqQuestionList']);
    Route::get('admin/map-mcq-question/{id}',[McqQuestionController::class,'mapMcqQuestion']);
    Route::post('admin/map-mcq-question/{id}',[McqQuestionController::class,'saveMapMcqQuestion']);
    Route::get('admin/delete-map-mcq-question/{id}',[McqQuestionController::class,'deleteMapMcqQuestion']);

    Route::get('admin/user-list',[UserController::class,'index']);
    Route::get('admin/add-user',[UserController::class,'create']);
    Route::post('admin/add-user',[UserController::class,'store']);
    Route::get('admin/edit-user/{id}',[UserController::class,'edit']);
    Route::get('admin/view-user/{id}',[UserController::class,'show']);
    Route::post('admin/edit-user/{id}',[UserController::class,'update']);
    Route::get('admin/delete-user/{id}',[UserController::class,'destroy']);

    Route::get('admin/encryption-list',[EncryptionController::class,'index']);
    Route::get('admin/add-encryption-user',[EncryptionController::class,'create']);
    Route::post('admin/add-encryption-user',[EncryptionController::class,'store']);
    Route::get('admin/edit-encryption-user/{id}',[EncryptionController::class,'edit']);
    Route::post('admin/edit-encryption-user/{id}',[EncryptionController::class,'update']);
    Route::get('admin/view-encryption-user/{id}',[EncryptionController::class,'show']);

    Route::get('admin/price-list/{id}',[PriceController::class,'index']);
    Route::get('admin/add-price/{id}',[PriceController::class,'create']);
    Route::post('admin/add-price/{id}',[PriceController::class,'store']);
    Route::get('admin/edit-price/{id}/{product_id}',[PriceController::class,'edit']);
    Route::post('admin/edit-price/{id}/{product_id}',[PriceController::class,'update']);
    Route::get('admin/view-price/{id}/{product_id}',[PriceController::class,'show']);
    Route::get('admin/delete-price/{id}',[PriceController::class,'destroy']);

    Route::get('admin/subadmin-role-list',[SubadminRoleController::class,'index']);
    Route::get('admin/add-roles',[SubadminRoleController::class,'create']);
    Route::get('admin/edit-admin-role/{id}',[SubadminRoleController::class,'edit']);
    Route::post('admin/edit-admin-role/{id}',[SubadminRoleController::class,'update']);
    Route::post('/admin/add-roles',[SubadminRoleController::class,'store']);
    Route::get('admin/view-admin-role/{id}',[SubadminRoleController::class,'show']);
    Route::get('admin/delete-admin-role/{id}',[SubadminRoleController::class,'destroy']);


    Route::get('admin/subadmin-user-list',[SubadminController::class,'index']);
    
    Route::get('admin/add-admin-user',[SubadminController::class,'create']);
    Route::post('admin/add-admin-user',[SubadminController::class,'store']);
    Route::get('admin/view-admin-user/{id}',[SubadminController::class,'show']);
    Route::get('admin/edit-admin-user/{id}',[SubadminController::class,'edit']);
    Route::post('admin/edit-admin-user/{id}',[SubadminController::class,'update']);
    Route::get('admin/delete-admin-user/{id}',[SubadminController::class,'destroy']);

    Route::get('admin/module-permission/{id}',[SubadminPermissionController::class,'index']);
    Route::get('admin/add-module-permission/{user_id}',[SubadminPermissionController::class,'create']);
    Route::post('admin/add-module-permission/{user_id}',[SubadminPermissionController::class,'store']);
    Route::get('admin/edit-module-permission/{id}',[SubadminPermissionController::class,'edit']);
    Route::post('admin/edit-module-permission/{id}',[SubadminPermissionController::class,'update']);
    Route::get('admin/delete-module-permission/{id}',[SubadminPermissionController::class,'destroy']);

    Route::get('admin/subadmin-module/{id}',[SubadminModuleController::class,'index']);
    Route::get('admin/add-submodule/{id}',[SubadminModuleController::class,'create']);
    Route::post('admin/add-module-permission/{user_id}',[SubadminModuleController::class,'store']);
    Route::get('admin/edit-module-permission/{id}',[SubadminModuleController::class,'edit']);
    Route::post('admin/edit-module-permission/{id}',[SubadminModuleController::class,'update']);
    Route::get('admin/delete-module-permission/{id}',[SubadminModuleController::class,'destroy']);


    

    Route::get('admin/video-list',[VideoController::class,'index']);
    Route::get('admin/upload-video',[VideoController::class,'create']);
    Route::post('admin/aws_temp_url',[VideoController::class,'aws_temp_url']);
    Route::post('admin/listobjects',[VideoController::class,'listObjects']);
    Route::get('admin/listobjects',[VideoController::class,'listObjects']);

    Route::get('admin/content-list/{id}/{catid}',[ContentController::class,'index']);
    Route::get('admin/add-content/{id}/{catid}',[ContentController::class,'create']);
    Route::post('admin/add-content/{id}/{catid}',[ContentController::class,'store']);
    Route::get('admin/delete-content/{id}',[ContentController::class,'destroy']);

    Route::get('admin/demo-content-list/{id}/{catid}',[DemoContentController::class,'index']);
    Route::get('admin/add-demo-content/{id}/{catid}',[DemoContentController::class,'create']);
    Route::post('admin/add-demo-content/{id}/{catid}',[DemoContentController::class,'store']);
    Route::get('admin/delete-demo-content/{id}',[DemoContentController::class,'destroy']);



    Route::get('admin/order-list',[OrderController::class,'index']);
    Route::get('admin/create-order',[OrderController::class,'create']);
    Route::post('admin/create-order',[OrderController::class,'store']);
    Route::post('admin/get-product-price',[OrderController::class,'getProductPrice']);
    Route::post('admin/get-price-duration',[OrderController::class,'getPriceDuration']);
    Route::get('admin/view-order-product-list/{id}',[OrderController::class,'orderProductList']);
    Route::post('admin/change-order-status',[OrderController::class,'changeOrderStatus']);



    Route::get('admin/studio-list',[StudioController::class,'index']);
    Route::get('admin/add-studio',[StudioController::class,'create']);
    Route::post('admin/add-studio',[StudioController::class,'store']);
    Route::get('admin/view-studio/{id}',[StudioController::class,'show']);
    Route::get('admin/edit-studio/{id}',[StudioController::class,'edit']);
    Route::post('admin/edit-studio/{id}',[StudioController::class,'update']);
    Route::get('admin/delete-studio/{id}',[StudioController::class,'destroy']);


    Route::get('admin/live-schedule-list/{id}',[LiveScheduleController::class,'index']);
    Route::get('admin/add-schedule/{id}',[LiveScheduleController::class,'create']);
    Route::post('admin/add-schedule/{id}',[LiveScheduleController::class,'store']);
   
    Route::get('admin/delete-liveschedule/{id}',[LiveScheduleController::class,'destroy']);


    Route::get('admin/re-video-list',[ReVideoController::class,'index']);
    Route::get('admin/re-upload-video',[ReVideoController::class,'create']);
    Route::post('admin/re-upload-video',[ReVideoController::class,'store']);
    Route::get('admin/edit-re-video/{id}',[ReVideoController::class,'edit']);
    Route::post('admin/edit-re-video/{id}',[ReVideoController::class,'update']);
    Route::get('admin/delete-re-video/{id}',[ReVideoController::class,'destroy']);


    Route::get('admin/tag-list/{id}',[TagController::class,'index']);
    Route::get('admin/add-tag/{id}',[TagController::class,'create']);
    Route::post('admin/add-tag/{id}',[TagController::class,'store']);
    Route::get('admin/edit-tag/{video_id}/{id}',[TagController::class,'edit']);
    Route::post('admin/edit-tag/{video_id}/{id}',[TagController::class,'update']);
    Route::get('admin/delete-tag/{video_id}/{id}',[TagController::class,'destroy']);

    Route::get('admin/pdf-list',[PdfController::class,'index']);
    Route::get('admin/upload-pdf',[PdfController::class,'create']);
    Route::post('admin/pdf_aws_temp_url',[PdfController::class,'aws_temp_url']);
    Route::post('admin/pdflistobjects',[PdfController::class,'listObjects']);
    Route::get('admin/pdflistobjects',[PdfController::class,'listObjects']);


    Route::get('admin/ebook-list',[EbookController::class,'index']);
    Route::get('admin/upload-ebook',[EbookController::class,'create']);
    Route::post('admin/ebook_aws_temp_url',[EbookController::class,'aws_temp_url']);
    Route::post('admin/ebooklistobjects',[EbookController::class,'listObjects']);
    Route::get('admin/ebooklistobjects',[EbookController::class,'listObjects']);


    



    



    

    
});
