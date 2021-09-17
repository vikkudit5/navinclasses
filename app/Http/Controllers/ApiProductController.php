<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Billing;
use App\Models\Orderproductgroup;
use App\Models\Category;
use App\Models\Main_category;
use App\Models\Content;
use App\Models\S3bucket;
use App\Models\Re_s3bucket;
use App\Models\Schedule_live_product;
use App\Models\Video_history;
use App\Models\Tag;
use App\Models\Pdf_test;
use App\Models\Ebook;

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


class ApiProductController extends Controller
{
    protected $user;
 
    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }


    public function getMainCategory(Request $request)
    {
        

        $admin_id = 2;
        
      

        $category = Main_category::where(['parent_id'=>'0','status'=>'1','type'=>'content'])->orderBy('id', 'DESC')->get();

         

            if(!empty($category))
            {
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'Category Fetch successfully',
                    'data' => $category
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status'=>0,
                    'success' => true,
                    'message' => 'Data Not Found',
                    'data' => "{}"
                ], Response::HTTP_OK);
                
            }              


    }



    public function purchasedProductList(Request $request)
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

        $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit'])            
            ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')      
            ->join('products','products.id','=','orderproductgroups.product_id')                                                                 
            ->get(['orderproductgroups.*','products.name','products.image','products.type']);

            $purchasedProduct = array();

            if(!empty($billings))
            {
                foreach($billings as $billing)
                {
                    $_purchasedProduct = array(
                        'product_id'=>$billing->product_id,
                        'name'=>$billing->name,
                        'type'=>$billing->type,
                        'image'=>asset('public/uploads/products/'.$billing->image),
                        'billing_id'=>$billing->billing_id,
                    );

                    array_push($purchasedProduct,$_purchasedProduct);

                    
                }
            }

            if(!empty($purchasedProduct))
            {
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'User created successfully',
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

// product content details
    public function productContentList(Request $request)
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

        $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
            ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')                                                                        
            ->first(['orderproductgroups.*']);

        $video = Content::join('re_s3buckets', 're_s3buckets.etag', '=', 'contents.video_id')  
            ->where(['product_id'=>$request->product_id,'contents.type'=>'video'])            
           ->get(['contents.*', 're_s3buckets.filename','re_s3buckets.size']);


             //days left
            $future = strtotime($billings->expire_date); //Future date.
            $timefromdb = strtotime(date('Y-m-d'));//source time
            $timeleft = $future-$timefromdb;
            $daysleft = round((($timeleft/24)/60)/60);


            $data = array(
                 'expire_on'=>$billings->expire_date,
                'days_left'=>$daysleft,
                'total_video'=>$video->count(),
                'video_view'=>0,
                'video_percent'=>4,
                'total_practice'=>50,
                'attempt_practice'=>0,
                'practice_percent'=>4,
                // 'contents'=>array()
            );

        if($billings->count()>0)
        {

              
            // $catid = 0;
            // $result = $this->multilevel($catid,$admin_id,$request->product_id,$billings);

            // array_push($data['contents'],$result);
            // $result = $billings->expire_date;
    
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'data Fetch successfully',
                    'data' => $data
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

    public function multilevel($cat_id,$admin_id,$product_id)
    {
       

        // multilevel
        $main_array = array();
        $results =  Category::where(['product_id'=>$product_id,'admin_id'=>$admin_id,'parent_id'=>$cat_id])->get();
        if(!empty($results))        
         {
 
            foreach ($results as $data) {
                if ($data->type == 'category') {
                    $sub_array = array(
                        'id'    =>  $data->id,
                        'parent_id'  =>  $data->parent_id,
                        'name' =>  $data->name,
                        'type'  =>  $data->type,
                        'subcat'   =>  $this->multilevel($data->id,$admin_id,$product_id)
                    );
                } else {
                    $sub_array = array(
                        'id'    =>  $data->id,
                        'parent_id'  =>  $data->parent_id,
                        'name' =>  $data->name,
                        'type'  =>  $data->type,
                        'content' => array(
                            'video'=>array(),
                            'pdf'=>array(),
                            'practice_test'=>array()
                        )
                    );

                    
                    $contents = Content::join('re_s3buckets', 're_s3buckets.etag', '=', 'contents.video_id')  
                                 ->where(['cat_id'=>$data->id])            
                                ->get(['contents.*', 're_s3buckets.filename','re_s3buckets.size']);

                                // dd($contents);

                    if(!empty($contents))
                    {
                        foreach($contents as $content)
                        {
                            if($content->type == 'video')
                            {
                                $_video_arr = array(
                                    'product_id'=>$content->product_id,
                                    'cat_id'=>$content->cat_id,
                                    'video_id'=>$content->video_id,
                                    'filename'=>$content->filename,
                                    'size'=>$content->size,
                                );
                                array_push($sub_array['content']['video'],$_video_arr);

                            }else if($content->type == 'pdf')
                            {
                                $_video_arr = array(
                                    'product_id'=>$content->product_id,
                                    'cat_id'=>$content->cat_id,
                                    'video_id'=>$content->video_id,
                                    'filename'=>$content->filename,
                                    'size'=>$content->size,
                                );
                                array_push($sub_array['content']['pdf'],$_video_arr);
                            }else if($content->type == 'practice_test')
                            {
                                $_video_arr = array(
                                    'product_id'=>$content->product_id,
                                    'cat_id'=>$content->cat_id,
                                    'video_id'=>$content->video_id,
                                    'filename'=>$content->filename,
                                    'size'=>$content->size,
                                );
                                array_push($sub_array['content']['practice_test'],$_video_arr);
                            }

                          
                        }
                    }
                }
 
                array_push($main_array, $sub_array);
            }
        }
        return $main_array;
    }

    public function videoDownload(Request $request)
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

        $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
        ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')    
                                                                   
        ->get(['orderproductgroups.*']);

        // dd(!$billings->isEmpty());

        if(!$billings->isEmpty())
        {
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
           

           
        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Not Autorised User',
                'data' => '{}'
            ], Response::HTTP_OK);
        }

    }


    public function getObjectlink($path)
    {
         

        //     $accessKey = "CFJCRZGYFSPGIHPGRL7E";
        // $secretKey = "uXwwK1/VqejH+b/82xwHfHlfqAYf2pYgGU8IwxUO2J4";
        // $region = "nyc3";
        // $host = "https://nyc3.digitaloceanspaces.com";
        // $bucket = "navinclasses";

        $accessKey = env('AWS_S3_ACCESS_KEY');
        $secretKey = env('AWS_S3_SECRET_KEY');
        $region = env('AWS_REGION');
        $host = env('AWS_HOST');
        $bucket = env('AWS_BUCKET');


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


    public function showAllLiveProduct(Request $request)
    {
        $results = array(
            'liveschedule'=>array(),
            'upcomingevents'=>array()
        );
        $data = $request->only('user_unique_id', 'admin_id');
        $validator = Validator::make($data, [
            'user_unique_id' => 'required|string',          
            // 'admin_id' => 'required',
            
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

        $results_data = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit'])            
            ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')      
            ->join('products','products.id','=','orderproductgroups.product_id')                                                                 
            ->join('schedule_live_products','schedule_live_products.prod_id','=','orderproductgroups.product_id')                                                                 
            ->join('studios','studios.std_id','=','schedule_live_products.studio_id')                                                                 
            ->join('admin_users','admin_users.id','=','products.teacher_id')                                                                 
            ->get(['schedule_live_products.*','billings.user_unique_id','admin_users.username']);


        $purchasedProduct = array();

            if(!empty($results_data))
            {
                foreach($results_data as $result)
                {
                    // for live schdule data current date
                    $curr_date = date('Y-m-d');
                    $result_alls = Schedule_live_product::where(['prod_id'=>$result->prod_id,'id'=>$result->id,'admin_id'=>$admin_id])
                            // ->whereRaw('(now() between start_date and end_date)')
                            ->Where('start_date',$curr_date)
                            
                            ->get();

                    if(!empty($result_alls))
                    {
                        foreach($result_alls as $result_all)
                        {
                            $res = array(
                                'id'=>$result_all->id,
                                'studio_id'=>base64_encode($result_all->studio_id),
                                'prod_id'=>$result_all->prod_id,
                                'program_name'=>$result_all->program_name,
                                'start_date'=>$result_all->start_date,
                                'end_date'=>$result_all->end_date,
                                'start_time'=>$result_all->start_time,
                                'end_time'=>$result_all->end_time,
                                'status'=>$result_all->status,
                                // 'sch_chat'=>$result_all->sch_chat,
                                'created_at'=>$result_all->created_at,
                                'author'=>$result->username,
                                'livestatus'=>'1',
                            );

                            array_push($results['liveschedule'],$res);
                        }

                    }

                    // for upcoming schdule event

                    $result_alls = Schedule_live_product::where(['prod_id'=>$result->prod_id,'id'=>$result->id,'admin_id'=>$admin_id])                            
                            ->where('start_date', '>', $curr_date)                            
                            ->get();

                    if(!empty($result_alls))
                    {
                        foreach($result_alls as $result_all)
                        {
                            $res = array(
                                'id'=>$result_all->id,
                                'studio_id'=>$result_all->studio_id,
                                'prod_id'=>$result_all->prod_id,
                                'program_name'=>$result_all->program_name,
                                'start_date'=>$result_all->start_date,
                                'end_date'=>$result_all->end_date,
                                'start_time'=>$result_all->start_time,
                                'end_time'=>$result_all->end_time,
                                'status'=>$result_all->status,
                                'author'=>$result->username,
                                // 'sch_chat'=>$result_all->sch_chat,
                                'created_at'=>$result_all->created_at,
                                'livestatus'=>'1',
                            );

                            array_push($results['upcomingevents'],$res);
                        }

                    }



                }
            }

            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'data Fetch successfully',
                'data' => $results
            ], Response::HTTP_OK);

        //   dd($results);       


    }

    public function categorycontent(Request $request)
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

       $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
       ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')                                                                        
       ->first(['orderproductgroups.*']);

    //    dd($billings);

       if(!empty($billings))
       {
            

                $categories = Category::where(['product_id'=>$request->product_id,'admin_id'=>$admin_id])->get();
                // $datacontent['re_s3buckets'] = Re_s3bucket::get();
                // $datacontent['contents'] = Content::where(['product_id'=>$request->product_id])->get();

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


    public function videoContent(Request $request)
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

    //    $datacontent = [];

       $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
       ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')                                                                        
       ->first(['orderproductgroups.*']);

    //    dd($billings);

       if(!empty($billings))
       {
          $videos = Content::join('re_s3buckets', 're_s3buckets.etag', '=', 'contents.video_id')  
                            ->where(['contents.cat_id'=>$request->cat_id])            
                            ->get(['contents.*', 're_s3buckets.filename','re_s3buckets.path','re_s3buckets.size']);

            

            if($videos->count()>0)
            {
                $tags = Content::join('tags', 'tags.video_id', '=', 'contents.video_id')  
                            ->where(['contents.cat_id'=>$request->cat_id])   
                            ->orderBy('tags.sort_order','asc')         
                            ->get(['contents.*', 'tags.name','tags.video_id','tags.time','tags.sort_order']);

             

                $content = array(
                    'videos'=>$videos,
                    'tags'=>$tags
                );

              
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'data  Found',
                    'data' => $content
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status'=>0,
                    'success' => false,
                    'message' => 'data Not Found',
                    'data' => '{}'
                ], Response::HTTP_OK);
            }           
                

           
       }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'data Not Found',
                'data' => '{}'
            ], Response::HTTP_OK);
       }

    }


    public function videoHistories(Request $request)
    {
        $data = $request->only('product_id','user_unique_id','cat_id','','video_id','time','date');
        $validator = Validator::make($data, [
                   
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'user_unique_id'=>'required',
            'cat_id'=>'required',
            'video_id'=>'required',
            'time'=>'required',
            'date'=>'required',
            
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

        $data = array(
            'admin_id'=>$admin_id,
            'user_unique_id'=>$request->user_unique_id,
            'product_id'=>$request->product_id,
            'cat_id'=>$request->cat_id,
            'video_id'=>$request->video_id,
            'time'=>$request->time,
            'date'=>$request->date,
        );

 

      $insert =  Video_history::create($data);

      if($insert)
      {
        return response()->json([
            'status'=>1,
            'success' => true,
            'message' => 'History created successfully',
            'data' => '{}'
        ], Response::HTTP_OK);
      }else{

        return response()->json([
            'status'=>0,
            'success' => false,
            'message' => 'User created successfully',
            'data' => '{}'
        ], Response::HTTP_OK);
      }
      
      

   

    }

    public function mcqContent(Request $request)
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

    //    $datacontent = [];

       $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
       ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')                                                                        
       ->first(['orderproductgroups.*']);

    //    dd($billings);

       if(!empty($billings))
       {
          $videos = Content::join('mcqs', 'mcqs.id', '=', 'contents.video_id')  
                            ->where(['contents.cat_id'=>$request->cat_id,'contents.type'=>'practice_test'])  
                                      
                            ->get(['contents.*', 'mcqs.name']);

            

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
                

           
       }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'data Not Found',
                'data' => '{}'
            ], Response::HTTP_OK);
       }

    }

    public function pdfContent(Request $request)
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

    //    $datacontent = [];

       $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
       ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')                                                                        
       ->first(['orderproductgroups.*']);

    //    dd($billings);

       if(!empty($billings))
       {
          $videos = Content::join('pdf_tests', 'pdf_tests.etag', '=', 'contents.video_id')  
                            ->where(['contents.cat_id'=>$request->cat_id,'contents.type'=>'pdf'])  
                                      
                            ->get(['contents.*', 'pdf_tests.filename','pdf_tests.etag']);

            

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
                

           
       }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'data Not Found',
                'data' => '{}'
            ], Response::HTTP_OK);
       }

    }


    public function pdfTestDownload(Request $request)
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

        $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
        ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')    
                                                                   
        ->get(['orderproductgroups.*']);

        // dd(!$billings->isEmpty());

        if(!$billings->isEmpty())
        {
            $bucket = Pdf_test::where(['etag'=>$request->video_id])->first();
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
           

           
        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Not Autorised User',
                'data' => '{}'
            ], Response::HTTP_OK);
        }

    }


    //Ebook


    public function ebookContent(Request $request)
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

    //    $datacontent = [];

       $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
       ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')                                                                        
       ->first(['orderproductgroups.*']);

    //    dd($billings);

       if(!empty($billings))
       {
          $videos = Content::join('ebooks', 'ebooks.etag', '=', 'contents.video_id')  
                            ->where(['contents.cat_id'=>$request->cat_id,'contents.type'=>'ebook'])  
                                      
                            ->get(['contents.*', 'ebooks.filename','ebooks.etag']);

            

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
                

           
       }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'data Not Found',
                'data' => '{}'
            ], Response::HTTP_OK);
       }

    }

    public function ebookDownload(Request $request)
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

        $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
        ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')    
                                                                   
        ->get(['orderproductgroups.*']);

        // dd(!$billings->isEmpty());

        if(!$billings->isEmpty())
        {
            $bucket = Ebook::where(['etag'=>$request->video_id])->first();
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
           

           
        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Not Autorised User',
                'data' => '{}'
            ], Response::HTTP_OK);
        }

    }







}
