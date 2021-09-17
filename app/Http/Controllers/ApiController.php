<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Models\Main_category;
use App\Models\Log;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin_user;
use App\Models\Otpsession;
use App\Models\User_device_id;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function registerOtpSent(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email','phone');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            // 'admin_id' => 'required',
            // 'password' => 'required|string|min:6|max:50'
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $phone = $request->phone;
        $otpdata = $this->send_otp($phone);
            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'otp sent To Registered Mobile Number.',
                'data'=>$otpdata
            ], 200);


        
    }

    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email','phone','message_id','otp','model_id','model_no');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            // 'admin_id' => 'required',
            'message_id' => 'required',
            'otp' => 'required',
            'model_id' => 'required',
            'model_no' => 'required',
            // 'password' => 'required|string|min:6|max:50'
        ]);
        
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


        $getOtp = Otpsession::where(['message_id'=>$request->message_id,'phone'=>$request->phone])->first();

        $admin_id = 2;

        if($getOtp->otp == $request->otp)
        {
             //Request is valid, create new user
             $getSalt = Admin_user::where(['id'=>$admin_id])->first();
            // dd($getSalt);
                $user = User::create([
                    'admin_id'=>$admin_id,
                    'user_unique_id'=>time().uniqid(),
                    'name' => $request->name,
                    'email' => $request->email,
                    // 'password' => bcrypt($request->password),            
                    'phone'=>$request->phone,             
                    //   'password'=>$hashed,
                    'ip_address'=>$request->ip()

                ]);
                
                $user_id = $user->id;
                $user = User::where(['id'=>$user_id,'status'=>'1'])->first();

                $user['salt'] = $getSalt->salt;

                $userDevice = array(
                    'user_id'=>$user_id,
                    'model_id'=>$request->model_id,
                    'model_no'=>$request->model_no,
                    'status'=>'1'
                );

                User_device_id::create($userDevice);
                //User created, return success response
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message' => 'User created successfully',
                    'data' => $user
                ], Response::HTTP_OK);



        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Otp Does Not Match!',
                'data'=>'{}'
            ], Response::HTTP_OK);
        }

        
       
    }
    
    //jwt login with email and password
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email','password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }
 	
 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
 
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }

    public function encryptionLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        

        $data = array(

            'email'=>$request->email,
            'password'=>$request->password,
            // 'role_id'=>'2',
        );

        // dd($data);

        if(Auth::guard('admin')->attempt($data))
        {
            $res = Admin_user::where(['email'=>$request->email])->first();
            // dd($res);

            $data = ['id'=>$res->id,'username'=>$res->username,'email'=>$res->email,'salt'=>$res->salt,'role_id'=>$res->role_id,'phone'=>$res->phone];
 
            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'User created successfully',
                'data' => $data
            ], Response::HTTP_OK);
        }else{

            return response()->json([
                'status'=>0,
                'success' => true,
                'message' => 'Invalid Credintials',
                'data' => '{}'
            ], Response::HTTP_OK);
            
        }
    

    }

    public function logs(Request $request)
    {
        $credentials = $request->only('user_id', 'activity');

        //valid credential
        $validator = Validator::make($credentials, [
            'user_id' => 'required',
            'activity' => 'required|string'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        

        $data = array(

            'user_id'=>$request->user_id,
            'activity'=>$request->activity,
            // 'role_id'=>'2',
        );


        $res = Log::create($data);
        if($res)
        {
            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'Log created successfully',
                'data' => '{}'
            ], Response::HTTP_OK);
        }else{

            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Something Went Wrong',
                'data' => '{}'
            ], 500);
        }
       
    

    }

    // login with mobile no and otp

    public function otpSendByPhone(Request $request)
    {
        $credentials = $request->only('phone');

        //valid credential
        $validator = Validator::make($credentials, [
            'phone' => 'required',
            
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $phone = $request->phone;

        $checkExistUser = User::where(['phone'=>$phone])->first();

        // dd($checkExistUser);

        if(!empty($checkExistUser))
        {
            $otpdata = $this->send_otp($phone);
            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'otp sent To Registered Mobile Number.',
                'data'=>$otpdata
            ], 200);
        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'user Does Not Exist.',
                'data'=>'{}'
            ], Response::HTTP_OK);
        }


    }

    public function otpMatchForLogin(Request $request)
    {
        $credentials = $request->only('phone','otp','message_id','model_id','model_no');

        //valid credential
        $validator = Validator::make($credentials, [
            'phone' => 'required',
            'otp' => 'required',
            'message_id' => 'required',
            'model_id' => 'required',
            'model_no' => 'required',
            
        ]);

        $admin_id = 2;

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


        $getOtp = Otpsession::where(['message_id'=>$request->message_id,'phone'=>$request->phone])->first();

        if($getOtp->otp == $request->otp)
        {
            
            // dd($getSalt);
            
            $user = User::where(['phone'=>$request->phone,'status'=>'1'])->first();

            $getSalt = Admin_user::where(['id'=>$admin_id])->first();
            $user['salt'] = $getSalt->salt;

            $userDevice =  User_device_id::where(['user_id'=>$user->id,'model_id'=>$request->model_id,'status'=>'1'])->first();
            if(!empty($userDevice))
            {
                 return response()->json([
                     'status'=>1,
                     'success' => true,
                     'message' => 'Login Success',
                     'data'=>$user
                 ], 200);
            }


            $userDevice = User_device_id::where(['user_id'=>$user->id])->get();
            // dd($userDevice->count());
            if($userDevice->count() < 3)
            {
                foreach($userDevice as $userDev)
                {
                    if($request->model_id != $userDev->model_id && $userDev->status == '0')
                    {
                        $data = array(
                            'user_id'=>$user->id,
                            'model_id'=>$request->model_id,
                            'model_no'=>$request->model_no,
                            'status'=>'1',
                            
                        );

                        $_userDevic = User_device_id::create($data);
                        if($_userDevic)
                        {
                            return response()->json([
                                'status'=>1,
                                'success' => true,
                                'message' => 'Login Success',
                                'data'=>$user
                            ], 200);
                        }

                        // exit;
                    }else{

                        return response()->json([
                            'status'=>0,
                            'success' => false,
                            'message' => 'logout From Other Device',
                            'data'=>'{}'
                        ], Response::HTTP_OK);
                    }
                }
               

            }else{

                return response()->json([
                    'status'=>0,
                    'success' => false,
                    'message' => 'Maximum Device Limit 3',
                    'data'=>'{}'
                ], Response::HTTP_OK);

            }


          





           

        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Otp Does Not Match!',
                'data'=>'{}'
            ], Response::HTTP_OK);
        }



      


    }

    public function resendOtp(Request $request)
    {
        $credentials = $request->only('phone');

        //valid credential
        $validator = Validator::make($credentials, [
            'phone' => 'required',
            
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $phone = $request->phone;

            $otpdata = $this->send_otp($phone);
            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'otp sent To Registered Mobile Number.',
                'data'=>$otpdata
            ], 200);
      


    }


    public function getProfile(Request $request)
    {
        $credentials = $request->only('user_unique_id','cat_id');

        //valid credential
        $validator = Validator::make($credentials, [
            'user_unique_id' => 'required',
            'cat_id' => 'required',
            
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

           $res =  User::where(['user_unique_id'=>$request->user_unique_id,'admin_id'=>$admin_id])->first();

           $profilePics = (!empty($res->profile_pics))?asset('public/uploads/profile/'.$res->profile_pics):"";

          $category =  Main_category::where(['id'=>$request->cat_id])->first();
          $categoryNmae = (!empty($category))?$category->name:"";
          
           $data = ['id'=>$res->id,'user_unique_id'=>$res->user_unique_id,'name'=>$res->name,'email'=>$res->email,'phone'=>$res->phone,'profile_pics'=>$profilePics,'category'=>$categoryNmae];

            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'data fetch successfully!.',
                'data'=>$data
            ], 200);
    }

    // edit prfile


    public function updateProfile(Request $request)
    {
        $credentials = $request->only('user_unique_id','image','name','email');

        // dd($credentials);

        //valid credential
        $validator = Validator::make($credentials, [
            'user_unique_id' => 'required',
            
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $admin_id = 2;

           $res =  User::where(['user_unique_id'=>$request->user_unique_id,'admin_id'=>$admin_id])->first();

           if(!empty($res))
           {
                $image =  $request->image;
                $name =  $request->name;
                $email =  $request->email;

                if(!empty($image))
                {
                    $d_image = base64_decode($image);
                    $i_file_name = time().'_appimage.png';                            
                    $put_image = file_put_contents('public/uploads/profile/'. $i_file_name, $d_image);
                    $update_data['picture']    = $i_file_name;
                    $data = array(
                        'name'=>$name,
                        'email'=>$email,
                        'profile_pics'=>$i_file_name,
                    );

                   $res =  User::where(['user_unique_id'=>$request->user_unique_id])->update($data);

                   if($res)
                   {
                        return response()->json([
                            'status'=>1,
                            'success' => true,
                            'message' => 'data Update successfully!.',
                            'data'=>$data
                        ], 200);
                   }else{

                        return response()->json([
                            'status'=>0,
                            'success' => false,
                            'message' => 'data Not Updated successfully!.',
                            'data'=>'{}'
                        ], 500);

                   }


                }else{

                    $data = array(
                        'name'=>$name,
                        'email'=>$email,
                        // 'profile_pics'=>$i_file_name,
                    );

                   $res =  User::where(['user_unique_id'=>$request->user_unique_id])->update($data);

                   
                   if($res)
                   {
                        return response()->json([
                            'status'=>1,
                            'success' => true,
                            'message' => 'data Update successfully!.',
                            'data'=>$data
                        ], 200);
                   }else{

                        return response()->json([
                            'status'=>0,
                            'success' => false,
                            'message' => 'data Not Updated successfully!.',
                            'data'=>'{}'
                        ], 500);

                   }



                }
           }else{
                return response()->json([
                    'status'=>0,
                    'success' => false,
                    'message' => 'User Not Found successfully!.',
                    'data'=>'{}'
                ], 200);
           }

           
    }






    public function send_otp($mobile)
	{
        // dd($mobile);
		$KEY = "upaU1gH0aWUSFG6k";
        $TMPID = "1207162141508403142";
        $OTP = rand(111111,999999);
        $MSG = urlencode("Dear Student, use OTP code $OTP to verify your account, Edukrypt APP");
        //$mobile = $number;
        $url = "https://www.hellotext.live/vb/apikey.php?apikey=$KEY&senderid=EDUKYT&templateid=$TMPID&number=$mobile&message=$MSG";
                
        $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);
        $output = file_get_contents($url,false,$context);
        $header = json_decode($output);

        
                
        if (empty($header) && $header->status!="Success") {

            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong!',
            ], 500);

           
        }

        $data = array(
            'message_id'=>$header->data->messageid,
            'phone'=>$mobile,
            'otp'=>$OTP
        );

        $otp = Otpsession::create($data);
        if($otp)
        {
            $return_data = array(
                'phone'=>$mobile,
                "message_id"=>$header->data->messageid
            );
            return $return_data;
        }

	}



   

   

  

}