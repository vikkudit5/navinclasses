<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Mcq;
use App\Models\Billing;
use App\Models\Admin_user;
use App\Models\Mcq_question;
use App\Models\Mcq_option;
use App\Models\Mcq_history;
use App\Models\Mcq_user_answer;
use App\Models\Mcq_ques_gp;

class ApiMcqController extends Controller
{
    public function getInstruction(Request $request)
    {
        $admin_id = 2;
        $credentials = $request->only('mcq_id','product_id','user_unique_id');

        //valid credential
        $validator = Validator::make($credentials, [
            'mcq_id' => 'required',
            'product_id' => 'required',
            'user_unique_id' => 'required',
          
            
        ]);       

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


        $mcq = Mcq::where(['admin_id'=>$admin_id,'id'=>$request->mcq_id])->first();        
        if(!empty($mcq))
        {
            if($mcq->retake_attempt == 'limited')
            {
                $total_history = Mcq_history::where(['mcq_id'=>$request->mcq_id,'product_id'=>$request->product_id,'user_unique_id'=>$request->user_unique_id])->count();
                if($total_history > $mcq->nooftimes)
                {
                    return response()->json([
                        'status'=>0,
                        'success' => false,
                        'message' => 'You Have Crossed Maximum Attempt!',
                        'data'=>'{}'
                    ], 200);
                }

            }
            // dd($total_history);
           
            $mcq_ques_gp =  Mcq_ques_gp::where(['admin_id'=>$admin_id,'mcq_id'=>$request->mcq_id])->count();
            // $totalQues = $mcq_ques_gp->count();
            $data = array(
                'id'=>$mcq->id,
                'name'=>$mcq->name,
                'instruction'=>$mcq->instruction,
                'retake_attempt'=>$mcq->retake_attempt,
                'nooftimes'=>$mcq->nooftimes,
                'time_limit'=>$mcq->time_limit,
                'correct_marks'=>$mcq->correct_marks,
                'negative_marks'=>$mcq->negative_marks,
                'total_ques'=>$mcq_ques_gp
            );

            return response()->json([
                'status'=>1,
                'success' => true,
                'message' => 'Insturction Fetch Success',
                'data'=>$data
            ], 200);
        }else{
            return response()->json([
                'status'=>0,
                'success' => false,
                'message' => 'Mcq Not Found!',
                'data'=>'{}'
            ], 200);
        }

    }

    public function getMcqQuestion(Request $request)
    {
        $admin_id = 2;
        $data = $request->only('product_id','user_unique_id','mcq_id');
        $validator = Validator::make($data, [
                   
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'user_unique_id'=>'required',
            'mcq_id'=>'required'
            
        ]);      

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


        $billings = Billing::where(['billings.admin_id'=>$admin_id,'billings.user_unique_id'=>$request->user_unique_id,'billings.paymentstatus'=>'Credit','orderproductgroups.product_id'=>$request->product_id])            
        ->join('orderproductgroups', 'orderproductgroups.billing_id', '=', 'billings.id')  
        ->join('products','products.id','=','orderproductgroups.product_id')                                                                      
        ->first(['orderproductgroups.*','products.name','products.teacher_id']);

        
        if(!empty($billings))
        {
            $teacher_name = '';

                if(!empty($billings->teacher_id))
                {

                    $teacher =  Admin_user::where(['id'=>$billings->teacher_id])->first();
                    $teacher_name = $teacher->username;
                }

             $mcq_questions = DB::table('mcq_questions as M')
                ->join('mcq_ques_gps as MQ', 'M.id', '=', 'MQ.mcq_ques_id')  
                ->join('mcqs as MS', 'MS.id', '=', 'MQ.mcq_id')  
                ->where(['MQ.admin_id'=>$admin_id])              
                ->select('M.*')
                ->get();

                
                if(!empty($mcq_questions))
                {
                    $future = strtotime($billings->expire_date); //Future date.
                    $timefromdb = strtotime(date('Y-m-d'));//source time
                    $timeleft = $future-$timefromdb;
                    $daysleft = round((($timeleft/24)/60)/60);

                    $__mcq_data = array(
                        'product_name'=>$billings->name,
                        'teacher_name'=>$billings->teacher_name,
                        'expire_on'=>$billings->expire_date,
                        'days_left'=>$daysleft,  
                        'question'=>array()         
                    );


                    foreach($mcq_questions as $mcq_question)
                    {              

                        $mcq_data = array(
                            'id'=>$mcq_question->id,
                            'question'=>$mcq_question->question,
                            'solution'=>$mcq_question->solution,
                            'correct_option_id'=>$mcq_question->correct_option_id,
                            'option'=>array()
                        );

                        $options = Mcq_option::where(['question_id'=>$mcq_question->id])->get();
                        if(!empty($options))
                        {
                            foreach($options as $option)
                            {
                                $_option = array(
                                    'q_id'=>$option->question_id,
                                    'id'=>$option->id,
                                    'options'=>$option->options,
                                    
                                );
                                array_push($mcq_data['option'],$_option);
                            }
                        }

                        array_push($__mcq_data['question'],$mcq_data);
                    }

                    return response()->json([
                        'status'=>1,
                        'success' => true,
                        'message' => 'Question Found!',
                        'data'=>$__mcq_data
                    ], 200);

                

                }else{
                    return response()->json([
                        'status'=>0,
                        'success' => false,
                        'message' => 'Question Not Found!',
                        'data'=>'{}'
                    ], 200);
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

    public function saveUserAns(Request $request)
    {
        $admin_id = 2;
        $data = $request->only('mcq_id','user_unique_id','product_id','mcqresults');
        $validator = Validator::make($data, [
                   
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'user_unique_id'=>'required',
            'mcq_id'=>'required',
            'mcqresults'=>'required',

            
        ]);      

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $data = array(
            'mcq_id'=>$request->mcq_id,
            'product_id'=>$request->product_id,
            'user_unique_id'=>$request->user_unique_id,

        );

        $res = Mcq_history::create($data);
        $mcq_hist_id = $res->id;
        $mcqresults = $request->mcqresults;
        if(!empty($mcqresults))
        {
            foreach($mcqresults as $mcqresult)
            {
                $result = array(
                    'mcq_id'=>$request->mcq_id,
                    'mcq_hist_id'=>$mcq_hist_id,
                    'user_unique_id'=>$request->user_unique_id,
                    'ques_id'=>$mcqresult['ques_id'],
                    'option_id'=>$mcqresult['option_id'],
                );

                $_result = Mcq_user_answer::create($result);
            }

            $this->updateQuizHistory($request->mcq_id,$mcq_hist_id,$request->user_unique_id,$admin_id);

            $returnData = array(
                'mcq_hist_id'=>$mcq_hist_id
            );

            return response()->json([
                'status'=>'1',
                'success' => true,
                'message' => 'mcq answer saved',
                'data' => $returnData
            ], Response::HTTP_OK);

        }
        

    }

    public function updateQuizHistory($mcq_id,$mcq_hist_id,$user_unique_id,$admin_id)
    {
        $correctOpt = [];

        $inCorrectOpt = [];
       $mcq_user_answer =  Mcq_user_answer::where(['mcq_id'=>$mcq_id,'mcq_hist_id'=>$mcq_hist_id,'user_unique_id'=>$user_unique_id])->get();

       if($mcq_user_answer->count()>0)
       {
            foreach($mcq_user_answer as $mcq_user_answ)
            {
                $checkCorrectOpt = Mcq_question::where(['id'=>$mcq_user_answ->ques_id,'correct_option_id'=>$mcq_user_answ->option_id])->first();
                
                if(!empty($checkCorrectOpt))
                {
                    
                    $correctOpt[] = $mcq_user_answ->ques_id;
                }else{
                    
                    $inCorrectOpt[] = $mcq_user_answ->ques_id;
                }

            }
       }

       $mcq_ques_gp =  Mcq_ques_gp::where(['admin_id'=>$admin_id,'mcq_id'=>$mcq_id])->get();
       $totalUserAns = $mcq_user_answer->count();
       $totalMcqQues = $mcq_ques_gp->count();

       $lefts = $totalMcqQues - $totalUserAns;
       $totalQues = $totalMcqQues;
       $correctQues = count($correctOpt);
       $inCorrectQues = count($inCorrectOpt);

       $mcq = Mcq::where(['admin_id'=>$admin_id,'id'=>$mcq_id])->first();
       $correct_marks = $mcq->correct_marks;
       $negative_marks = $mcq->negative_marks;

       $totalCorrectMark = $correctQues * $correct_marks;
       $totalInCorrectMark = $inCorrectQues * $negative_marks;

       $totalMarks = $totalCorrectMark - $totalInCorrectMark;
       $totalPercentage = ($totalMarks * 100)/$totalMcqQues;

       $data = array(
           'percentage'=>$totalPercentage,
           'correct'=>$correctQues,
           'wrong'=>$inCorrectQues,
           'attempt'=>$totalUserAns,
           'lefts'=>$lefts,
           'marks'=>$totalMarks,
           'total_ques'=>$totalMcqQues,
       );

       Mcq_history::where(['id'=>$mcq_hist_id])->update($data);

    //    dd($totalPercentage);

       
    }

    public function mcqResult(Request $request)
    {
        $admin_id = 2;
        $data = $request->only('mcq_id','user_unique_id','product_id','mcq_hist_id');
        $validator = Validator::make($data, [
                   
            // 'admin_id' => 'required',
            'product_id'=>'required',
            'user_unique_id'=>'required',
            'mcq_id'=>'required',
            'mcq_hist_id'=>'required',

            
        ]);      

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // DB::enableQueryLog();

        $mcq_questions = Mcq_history::where(['MU.mcq_hist_id'=>$request->mcq_hist_id])            
            ->join('mcq_user_answers as MU', 'MU.mcq_hist_id', '=', 'mcq_histories.id')                                                                    
            ->join('mcq_questions as MQ', 'MQ.id', '=', 'MU.ques_id')                                                                    
            ->get(['MQ.*','MU.ques_id','MU.option_id']);

            // dd($mcq_questions);

            // dd(DB::getQueryLog());


        if(!empty($mcq_questions))
        {
            $mcq_data = array();
            foreach($mcq_questions as $mcq_question)
            {
                $user_option = Mcq_option::where(['MQ.id'=>$mcq_question->option_id])
                        ->join('mcq_questions as MQ', 'MQ.id', '=', 'mcq_options.question_id')
                        ->first('mcq_options.*');   
                        
                $correct_option = Mcq_option::where(['MQ.id'=>$mcq_question->correct_option_id])
                        ->join('mcq_questions as MQ', 'MQ.id', '=', 'mcq_options.question_id')
                        ->first('mcq_options.*');     


                $data = array(
                    'question'=>$mcq_question->question,
                    'user_ans'=>(!empty($user_option->options))?$user_option->options:"",
                    'correct_option'=>$correct_option->options,
                    'solution'=>$mcq_question->solution,
                );

                // dd($data);
                

                array_push($mcq_data,$data);

              

            }

            return response()->json([
                'status'=>'1',
                'success' => true,
                'message' => 'Data Found',
                'data' => $mcq_data
            ], Response::HTTP_OK);

        }else{

            return response()->json([
                'status'=>'0',
                'success' => false,
                'message' => 'No Data Found',
                'data' => '{}'
            ], Response::HTTP_OK);

        }

        

    }

}
