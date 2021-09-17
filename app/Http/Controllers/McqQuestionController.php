<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mcq_question;
use App\Models\Upload_mcq_file;
use App\Models\Mcq_option;
use App\Models\Mcq;
use App\Models\Mcq_history;
use App\Models\Mcq_user_answer;
use App\Models\Mcq_ques_gp;

class McqQuestionController extends Controller
{
    public function mcqList()
    {       

        $admin_id = '2';
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
           

            $data['mcq_questions'] = Mcq::where('admin_id',$admin_id)->where('name','LIKE','%'.$search_text.'%')                                                                                                       
                                    ->paginate(10);

         
            
        }else{
            
            $data['mcq_questions'] = Mcq::where('admin_id',$admin_id)            
            ->paginate(10);

        }

        
        
        return view('admin.mcq.mcq-list',$data);
    }

    public function addMcq()
    {       

        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';
        return view('admin.mcq.add-mcq',$data);
    }

    public function saveMcq(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'name'=>'required',
            'instruction'=>'required',
            'time_limit'=>'required',
            'retake_attempt'=>'required',
            'passing_percent'=>'required',
            'correct_marks'=>'required',
           
        ]);

        $data = array(

            'admin_id'=>$admin_id,            
            'name'=>$request->name,
            'instruction'=>$request->instruction,
            'time_limit'=>$request->time_limit,
            'retake_attempt'=>$request->retake_attempt,
            'nooftimes'=>$request->nooftimes,
            'minimum_time_submit'=>$request->minimum_time_submit,
            'passing_percentage'=>$request->passing_percent,
            'correct_marks'=>$request->correct_marks,
            'negative_marks'=>$request->negative_marks,           
            'status'=>1,
            
        );

        $res = Mcq::create($data);
        if($res)
        {
           
            return back()
            ->with('success', $request->name.' Has Been Added!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }

    }

    public function viewMcq(Request $request,$id)
    {
         // echo "hello";exit;
         $data['mainMenu'] = 'databaseManagement';
         $data['subMenu'] = 'mcqQuestList';
        $data['mcq'] = Mcq::where(['id'=>$id])->first();
     //    dd($data['mcq']);
         return view('admin.mcq.view-mcq',$data);
    }


    // edit mcq

    public function editMcq(Request $request,$id)
    {
        // echo "hello";exit;
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';
       $data['mcq'] = Mcq::where(['id'=>$id])->first();
    //    dd($data['mcq']);
        return view('admin.mcq.edit-mcq',$data);
    }

  

    public function updateMcq(Request $request,$id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'name'=>'required',
            'instruction'=>'required',
            'time_limit'=>'required',
            'retake_attempt'=>'required',
            'passing_percent'=>'required',
            'correct_marks'=>'required',
           
        ]);

        $data = array(

                       
            'name'=>$request->name,
            'instruction'=>$request->instruction,
            'time_limit'=>$request->time_limit,
            'retake_attempt'=>$request->retake_attempt,
            'nooftimes'=>$request->nooftimes,
            'minimum_time_submit'=>$request->minimum_time_submit,
            'passing_percentage'=>$request->passing_percent,
            'correct_marks'=>$request->correct_marks,
            'negative_marks'=>$request->negative_marks,           
            'status'=>1,
            
        );

        $res = Mcq::where(['id'=>$id])->update($data);

        if($res)
        {
           
            return back()
            ->with('success', $request->name.' Has Been Updated!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }

    }

    public function deleteMcq(Request $request,$id)
    {
        
        Mcq::where(['id'=>$id])->delete();
        Mcq_history::where(['mcq_id'=>$id])->delete();
        Mcq_user_answer::where(['mcq_id'=>$id])->delete();
        Mcq_ques_gp::where(['mcq_id'=>$id])->delete();
         return back()->with('success','Mcq deleted successfully');
    }


    public function mapMcqQuestionList(Request $request,$id)
    {
        $admin_id = '2';
        // echo "hel
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqList';
       $data['mcq'] = Mcq::where(['id'=>$id])->first();
       $data['questions'] = Mcq_question::where(['admin_id'=>$admin_id])->select('id','question','code')->get();
       $data['mcq_questions'] = Mcq_ques_gp::where(['mcq_ques_gps.mcq_id'=>$id])
                    ->join('mcq_questions','mcq_questions.id','=','mcq_ques_gps.mcq_ques_id')
                    ->paginate(10,['mcq_questions.*','mcq_ques_gps.id as mcq_ques_mapid']);

                // dd($data['questions']);
    
        return view('admin.mcq.map-mcq-question',$data);
    }


    
    public function mapMcqQuestion(Request $request,$id)
    {
        $admin_id = '2';
        // echo "hel
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqList';
       $data['mcq'] = Mcq::where(['id'=>$id])->first();
       $data['questions'] = Mcq_question::where(['admin_id'=>$admin_id])->select('id','question','code')->get();
    
    
        return view('admin.mcq.map-mcq',$data);
    }
    

    

    public function saveMapMcqQuestion(Request $request,$id)
    {
        
        $mcq_ques_id = $request->mcq_ques_id;
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'mcq_ques_id'=>'required',
            
           
        ]);

        // $request->request

        if(!empty($mcq_ques_id))
        {
            foreach($mcq_ques_id as $mcq_ques)
            {
                $data = array(
                       
                    'admin_id'=>$admin_id,
                    'mcq_id'=>$id,
                    'mcq_ques_id'=>$mcq_ques,
                  
                    
                );

                Mcq_ques_gp::create($data);
            }
        }

      
        return back()
        ->with('success', 'Question Has Beeb Mapped!.');


    }

    public function deleteMapMcqQuestion($id)
    {
        
        Mcq_ques_gp::where(['id'=>$id])->delete();
         return back()->with('success','Mcq deleted successfully');
    }


}
