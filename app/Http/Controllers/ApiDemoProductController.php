<?php

namespace App\Http\Controllers;

// use App\Models\Product;
use App\Models\Demo_product;
use App\Models\Billing;
use App\Models\Orderproductgroup;
use App\Models\Demo_category;
// use App\Models\Content;
use App\Models\Demo_content;
use App\Models\S3bucket;
use App\Models\Re_s3bucket;
use App\Models\Schedule_live_product;
use App\Models\Video_history;
use App\Models\User;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

use AWS\S3\S3Client;
use Aws\S3\S3Client as S3S3Client;
use Aws\CognitoIdentity\CognitoIdentityClient;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\PostObjectV4;


class ApiDemoProductController extends Controller
{
    protected $user;
 
    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    public function demoProductList(Request $request)
    {
        $data = $request->only('user_unique_id');
        $validator = Validator::make($data, [
            'user_unique_id' => 'required|string',          
            // 'admin_id' => 'required',
            
        ]);

        $admin_id = 2;
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $user = User::where(['user_unique_id'=>$request->user_unique_id,'status'=>'1'])->first();
        if(empty($user))
        {
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'User Not Found!',
                'data' => '{}'
            ], Response::HTTP_OK);
        }



        $billings = Demo_product::where(['status'=>'1'])
                    ->orderBy('sort_order', 'asc')         
                    ->get();

                    // dd($billings);

            $purchasedProduct = array();

            if(!empty($billings))
            {
                foreach($billings as $billing)
                {
                    $_purchasedProduct = array(
                        'product_id'=>$billing->id,
                        'name'=>$billing->name,
                        'type'=>$billing->type,
                        'image'=>asset('public/uploads/demo-products/'.$billing->image),
                        
                    );

                    array_push($purchasedProduct,$_purchasedProduct);

                    
                }
            }

            if(!empty($purchasedProduct))
            {
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'Product Fetch successfully',
                    'data' => $purchasedProduct
                ], Response::HTTP_OK);
            }else{

                return response()->json([
                    'status'=>0,
                    'success' => true,
                    'message' => 'Data Not Found',
                    'data' => $purchasedProduct
                ], Response::HTTP_OK);

            }            


    }



    public function demoVideoDownload(Request $request)
    {
        $data = $request->only('user_unique_id','product_id','video_id');
        $validator = Validator::make($data, [
            'user_unique_id'=>'required',       
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'video_id'=>'required'
            
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

      
            $bucket = S3bucket::where(['etag'=>$request->video_id])->first();
            // dd($bucket);
            if(!empty($bucket->path))
            {
                $path = $bucket->path;
                $getLink =  $this->getObjectlink($path);
     
                return response()->json([
                 'status'=>1,
                 'success' => true,
                 'message' => 'Link Created',
                 'data' => $getLink
                 ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status'=>0,
                    'success' => false,
                    'message' => 'Video Not Found',
                    'data' => '{}'
                    ], Response::HTTP_OK);
            }
           

           
      

    }


    public function getObjectlink($path)
    {
          

            $accessKey = "FE5BNXOOPWNOWFVTIC6A";
            $secretKey = "WHm2+naAHIISj2/B1dzKixvpZ+3smaJdmaGeohr0efI";
            $region = "sgp1";
            $host = "https://sgp1.digitaloceanspaces.com";
            $bucket = "paras-storage";

            $s3 = new S3S3Client([
                'version' => 'latest',
                'region' => $region,
                'endpoint' => $host,
                'credentials' => [
                    'key' => $accessKey,
                    'secret' => $secretKey
                ]
            ]);

            // dd($s3);

            $s3->putBucketCors([
                'Bucket' => $bucket, // REQUIRED
                'CORSConfiguration' => [ // REQUIRED
                    'CORSRules' => [ // REQUIRED
                        [
                            'AllowedMethods' => ['POST', 'GET', 'HEAD', 'DELETE', 'PUT'], // REQUIRED
                            'AllowedHeaders' => ['*'],
                            'AllowedOrigins' => ['*'], // REQUIRED
                            'ExposeHeaders' => ['ETag'],
                            'MaxAgeSeconds' => 0
                        ],
                    ],
                ]
            ]);

            try {
                //Creating a presigned URL
                $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => $bucket,
                    'Key' => $path
                ]);

                $request = $s3->createPresignedRequest($cmd, '+55 minutes');

                // Get the actual presigned-url
                $presignedUrl = (string)$request->getUri();

                $url = array(
                    'url'=>$presignedUrl
                );

                return $url;
                // echo json_encode(['code' => 200, 'status' => true, 'url' => $presignedUrl]);
            } catch (S3Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        
    }




    public function democategorycontent(Request $request)
    {
        $data = $request->only('product_id','user_unique_id');
        $validator = Validator::make($data, [
                   
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'user_unique_id'=>'required'
            
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

    //    $datacontent = [];

        $user = User::where(['user_unique_id'=>$request->user_unique_id,'status'=>'1'])->first();
        if(empty($user))
        {
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'User Not Found!',
                'data' => '{}'
            ], Response::HTTP_OK);
        }

    //    dd($billings);
         $categories = Demo_category::where(['product_id'=>$request->product_id,'admin_id'=>$admin_id])->get();
       if(!empty($categories))
       {
            return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'data  Found',
                    'data' => $categories
                ], Response::HTTP_OK);
                

           
       }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'data Not Found',
                'data' => '{}'
            ], Response::HTTP_OK);
       }

    }


    public function demoVideoContent(Request $request)
    {
        $data = $request->only('product_id','user_unique_id','cat_id');
        $validator = Validator::make($data, [
                   
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'user_unique_id'=>'required',
            'cat_id'=>'required'
            
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

        $user = User::where(['user_unique_id'=>$request->user_unique_id,'status'=>'1'])->first();
        if(empty($user))
        {
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'User Not Found!',
                'data' => '{}'
            ], Response::HTTP_OK);
        }

      
          $videos = Demo_content::join('re_s3buckets', 're_s3buckets.etag', '=', 'demo_contents.video_id')  
                            ->where(['demo_contents.cat_id'=>$request->cat_id])            
                            ->get(['demo_contents.*', 're_s3buckets.filename','re_s3buckets.path','re_s3buckets.size']);
            if($videos->count()>0)
            {
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'data  Found',
                    'data' => $videos
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status'=>0,
                    'success' => false,
                    'message' => 'data Not Found',
                    'data' => '{}'
                ], Response::HTTP_OK);
            }           
                

           
     

    }


  




}
