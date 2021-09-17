<?php
namespace App\Http\Controllers;

// ini_set('memory_limit', -1);
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\S3bucket;
use App\Models\Pdf_test;
use File;

use AWS\S3\S3Client;
use Aws\S3\S3Client as S3S3Client;
use Aws\CognitoIdentity\CognitoIdentityClient;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\PostObjectV4;


class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mainMenu'] = 'pdfManagement';
        $data['subMenu'] = 'pdfList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['products'] = DB::table('pdf_tests')->where('filename','LIKE','%'.$search_text.'%')->paginate(10);
            $data['folder_name'] = 'navinclassess';
           
       
            
        }else{
            $data['products'] = DB::table('pdf_tests')->paginate(10);

            $data['folder_name'] = 'navinclassess';
        }
        return view('admin.pdf-test.pdf-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mainMenu'] = 'pdfManagement';
        $data['subMenu'] = 'pdfList';

        return view('admin.pdf-test.upload-pdf',$data);

    }

    

    public function aws_temp_url(Request $request)
    {
        // print_r($_FILES);exit;

        if ($_FILES['file']['size'] == 0 && $_FILES['file']['error'] == 0) {
            echo json_encode(['code' => 201, 'status' => false]);
            exit;
        }

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

        $s3->putObject(array( 
            'Bucket' => $bucket,
            'Key'    => "testdata/".$fileName,
            'SourceFile' => $fileTmp,
            'ContentType' => 'application/pdf',
            'ACL' => 'private',
            'StorageClass' => 'REDUCED_REDUNDANCY',
           ));


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
        // echo "hello";exit;
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        
        $accessKey = "CFJCRZGYFSPGIHPGRL7E";
        $secretKey = "uXwwK1/VqejH+b/82xwHfHlfqAYf2pYgGU8IwxUO2J4";
        $region = "nyc3";
        $host = "https://nyc3.digitaloceanspaces.com";
        $bucket = "navinclasses";
        $fileName="testdata";
        
        
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
                'Key'    => "testdata/".$fileName,
                'Prefix' => ''
            ]);
    
        
            
            foreach ($videos as $video) {
                foreach ($video['Contents'] as $object) {
                    // echo $object['Key'] . PHP_EOL;
                    $folderName = explode('/',$object['Key']);
                    
                    if($folderName[0]== 'testdata' && ($object['Size'] > 0))
                    {
                        $aInsert = array(
                            'filename'  => basename($object['Key']),
                            'path'      => $object['Key'],
                            'size'      => $object['Size'],
                            'etag'      => trim($object['ETag'], '"'),
                            'type'      => 'pdf',
                            'admin_id'  => $admin_id,
                            'date'      => $object['LastModified']->format(\DateTime::ISO8601),
                        );
                        array_push($batchInsert, $aInsert);
                    }
                    
                   
                }


                // exit;
            }

            // print_r($batchInsert);exit;

        

            if (!empty($batchInsert)) {
                Pdf_test::where(['admin_id'=>$admin_id])->delete();
                
                // $this->db->where('admin_id', $admin_id)->delete('s3bucket');
            }


            // $this->db->insert_batch('s3bucket', $batchInsert);

            Pdf_test::insert($batchInsert);

        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

}
