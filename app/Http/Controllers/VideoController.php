<?php
namespace App\Http\Controllers;

// ini_set('memory_limit', -1);
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\S3bucket;
use File;

use AWS\S3\S3Client;
use Aws\S3\S3Client as S3S3Client;
use Aws\CognitoIdentity\CognitoIdentityClient;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\PostObjectV4;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'videoList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['products'] = DB::table('s3buckets')->where('filename','LIKE','%'.$search_text.'%')->paginate(10);
            $data['folder_name'] = 'navinclassess';
           
            return view('admin.video.video-list',$data);
            
        }else{
            $data['products'] = DB::table('s3buckets')->paginate(10);

            $data['folder_name'] = 'navinclassess';
            return view('admin.video.video-list',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'videoList';

        return view('admin.video.upload-video',$data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function aws_temp_url(Request $request)
    {
        // print_r($_FILES);exit;

        if ($_FILES['file']['size'] == 0 && $_FILES['file']['error'] == 0) {
            echo json_encode(['code' => 201, 'status' => false]);
            exit;
        }

        $accessKey = "CFJCRZGYFSPGIHPGRL7E";
        $secretKey = "uXwwK1/VqejH+b/82xwHfHlfqAYf2pYgGU8IwxUO2J4";
        $region = "nyc3";
        $host = "https://nyc3.digitaloceanspaces.com";
        $bucket = "navinclasses";

        


        $s3 = new S3S3Client([
            'version' => 'latest',
            'region' => $region,
            'endpoint' => $host,
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey
            ]
        ]);

    

        

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


        $fileName = $_FILES['file']['name'];
        // $uploadType = $_POST['type'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];


        $formInputs = ['acl' => 'private'];

        if (empty($fileType)) {
            $fileType = "application/octet-stream";
        }

        $fileKeyVal = 'navinclassess/' . $fileName;

        // if ($uploadType == 'video') {
        //     $fileKeyVal = 'navinclassess/' . $fileName;
        // } else {
        //     $fileKeyVal = 'pdffile/' . $fileName;
        // }

        $options = [
            ['acl' => 'private'],
            ['bucket' => $bucket],
            ['starts-with', '$key', $fileKeyVal],
            ['success_action_status' => '201'],
            ['x-amz-expires' => '3600'],
            ['Content-Type' => $fileType]
        ];

        $expires = '+2 hours';

        $postObject = new PostObjectV4($s3, $bucket, $formInputs, $options, $expires);

        $formAttributes = $postObject->getFormAttributes();

        $formInputs = $postObject->getFormInputs();

        return json_encode(['code' => 200, 'status' => true, 'formAttributes' => $formAttributes, 'formInputs' => $formInputs]);
    }

    public function listObjects(Request $request)
    {
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        
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
            
            
            // print_r('hello');exit;

       

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

        $batchInsert = array();
        
       

        try {

            $videos = $s3->getPaginator('ListObjects', [
                'Bucket' => $bucket,
                'Prefix' => ''
            ]);
    
        
            
            foreach ($videos as $video) {
                foreach ($video['Contents'] as $object) {
                    // dd($video['Contents']);
                    
                    $folderName = explode('/',$object['Key']);
                    
                    if($folderName[0]== 'navinclassess')
                    {

                        $aInsert = array(
                            'filename'  => basename($object['Key']),
                            'path'      => $object['Key'],
                            'size'      => $object['Size'],
                            'etag'      => trim($object['ETag'], '"'),
                            'type'      => 'video',
                            'admin_id'  => $admin_id,
                            'date'      => $object['LastModified']->format(\DateTime::ISO8601),
                        );
                        array_push($batchInsert, $aInsert);
                    }
                }
            }

            // print_r($batchInsert);exit;

        

            if (!empty($batchInsert)) {
                S3bucket::where(['admin_id'=>$admin_id])->delete();
                
                // $this->db->where('admin_id', $admin_id)->delete('s3bucket');
            }


            // $this->db->insert_batch('s3bucket', $batchInsert);

            S3bucket::insert($batchInsert);

        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

}
