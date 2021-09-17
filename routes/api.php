<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\ApiDemoProductController;
use App\Http\Controllers\ApiMcqController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('registerotpsent', [ApiController::class, 'registerOtpSent']);
Route::post('register', [ApiController::class, 'register']);
Route::post('otpsendbyphone', [ApiController::class, 'otpSendByPhone']);
Route::post('otpmatchforlogin', [ApiController::class, 'otpMatchForLogin']);

Route::post('encryption_login', [ApiController::class, 'encryptionLogin']);

// Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    
    Route::post('logs', [ApiController::class, 'logs']);
    Route::post('resendotp', [ApiController::class, 'resendOtp']);
    Route::post('getprofile', [ApiController::class, 'getProfile']);
    Route::post('updateprofile', [ApiController::class, 'updateProfile']);

    Route::post('purchasedproductlist', [ApiProductController::class, 'purchasedProductList']);
    Route::post('productcontentlist', [ApiProductController::class, 'productContentList']);
    Route::post('videodownload', [ApiProductController::class, 'videoDownload']);
    Route::post('showallliveproduct', [ApiProductController::class, 'showAllLiveProduct']);
    Route::post('categorycontent', [ApiProductController::class, 'categorycontent']);
    Route::post('videocontent', [ApiProductController::class, 'videoContent']);
    Route::post('videohistories', [ApiProductController::class, 'videoHistories']);
    Route::get('getmaincategory', [ApiProductController::class, 'getMainCategory']);
    Route::post('mcqcontent', [ApiProductController::class, 'mcqContent']);
    Route::post('pdfcontent', [ApiProductController::class, 'pdfContent']);
    Route::post('pdftestdownload', [ApiProductController::class, 'pdfTestDownload']);
    Route::post('ebookcontent', [ApiProductController::class, 'ebookContent']);
    Route::post('ebookdownload', [ApiProductController::class, 'ebookDownload']);

    Route::post('demo-product-list',[ApiDemoProductController::class,'demoProductList']);
    Route::post('demo-category-content',[ApiDemoProductController::class,'democategorycontent']);
    Route::post('demo-video-content',[ApiDemoProductController::class,'demoVideocontent']);
    Route::post('demo-video-download',[ApiDemoProductController::class,'demoVideoDownload']);

    Route::post('instruction',[ApiMcqController::class,'getInstruction']);
    Route::post('mcqquestion',[ApiMcqController::class,'getMcqQuestion']);
    Route::post('saveuserans',[ApiMcqController::class,'saveUserAns']);
    Route::post('mcqresult',[ApiMcqController::class,'mcqResult']);
   
// });