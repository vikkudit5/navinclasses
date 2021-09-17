<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mcq_question;
use App\Models\Upload_mcq_file;
use App\Models\Mcq_option;
use File;

class McqController extends Controller
{
    public function mcqQuestionList()
    {       

        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
           

            $data['mcq_questions'] = Mcq_question::where('mcq_questions.question','LIKE','%'.$search_text.'%')
                                    ->join('mcq_options', 'mcq_questions.correct_option_id', '=', 'mcq_options.id')                                                                       
                                    ->paginate(10, ['mcq_questions.*', 'mcq_options.options']);

           
            return view('admin.mcq.mcq-question-list',$data);
            
        }else{
            
            $data['mcq_questions'] = Mcq_question::join('mcq_options', 'mcq_questions.correct_option_id', '=', 'mcq_options.id')            
            ->paginate(10, ['mcq_questions.*', 'mcq_options.options']);

            return view('admin.mcq.mcq-question-list',$data);
        }

    }

    public function uploadQuestion(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        // print_r($_FILES);exit;
        $name = basename(__FILE__, '.php');
      
        $ext = $request->doc_file->extension();

        
        if ($ext != 'docx') {
            return back()->with('error','File Should Be Docs Only!');
        }



        $imageName = time().rand().'.'.$ext;  
     
        $request->doc_file->move(public_path('uploads/quiz'), $imageName);

        $thumb_url = base_path() . "/public/uploads/quiz/" . $imageName;

        $data = array(            
            'filename' => $thumb_url,          

        );

        $res = Upload_mcq_file::create($data);
       
       
        $insert_id =  $res->id;;
        
       $file_url =  Upload_mcq_file::where(['id'=>$insert_id])->first();
       $path = $file_url->filename;
       
       //    $phpWord = new \PhpOffice\PhpWord\PhpWord();
       $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
       //    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);

       $section = $phpWord->addSection();
       $_file_name = explode(".", $imageName);
       $orig_name = $_file_name[0];
       $source = base_path() . "/public/uploads/quiz/{$orig_name}.html";
      

       // Saving the document as HTML file...
       $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
       $objWriter->save($source);

       $all_data = array(
        'questions' => array()
        );
    // $path = base_url()."uploads/quiz/www.html";
    $file_name = asset('/')."public/uploads/quiz/{$orig_name}.html";
    $pagecontents = file_get_contents($file_name);

    preg_match_all('#<table (.*?)</table>#is', $pagecontents, $_all_functions);
    $function_keys = $_all_functions[1];

    foreach ($function_keys as $key => $value) {
        // print_r($value);
        preg_match_all('#<tr>(.*?)</tr>#is', $value, $match);
        $matches = $match[1];

        // print_r(strip_tags($matches[1], '<img>'));
        // exit;

        $data = array(
            'admin_id'=>$admin_id,
            'no_of_options' => trim(strip_tags($matches[0])),
            'question' => trim(strip_tags($matches[1], '<img>')),
            'solution' => trim(strip_tags($matches[2], '<img>')),
            'conceptual_type' => trim(strip_tags($matches[3])),
            'author' => trim(strip_tags($matches[4])),
            'level' => trim(strip_tags($matches[5])),
            'correct_ans' => trim(strip_tags($matches[6])),
            'code' => trim(strip_tags($matches[7])),
            
        );

        
        $mcqQues = Mcq_question::create($data);
        $question_id = $mcqQues->id;
        
        $i = 1;
        foreach ($matches as $key => $matche) {
            // var_dump($key);exit;
            if (($key == 0) || ($key == 1) || ($key == 2) || ($key == 3) || ($key == 4) || ($key == 5) || ($key == 6) || ($key == 7)) {
            } else {


                $option_data = array(
                    'question_id' => $question_id,
                    'no_of_options' => $i,
                    'options' => trim(strip_tags($matche, '<img>')),
                    
                );

                $mcqQues = Mcq_option::create($option_data);
                $i++;
            }
        }

        $get_quest = Mcq_question::where(['id'=>$question_id])->first();       
        $correct_opt = $get_quest->correct_ans;

        $a = strip_tags($correct_opt);
        $c =  preg_replace("/\r|\n/", "", $a);

       $practice_quiz =  Mcq_option::where(['no_of_options'=>$c,'question_id'=>$question_id])->first();

        $update_data = array(
            'correct_option_id' => trim($practice_quiz->id)
        );

        Mcq_question::where(['id'=>$question_id])->update($update_data);
      

    }

        return back()->with('success',' Question Has Been Uploaded Successfully!.');

    }


    public function editMcqQuestion(Request $request,$id)
    {
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';

        $data['mcq_questions'] = Mcq_question::Where(['id'=>$id])->first();
        $data['mcq_options'] =  Mcq_option::where(['question_id'=>$id])->get();

                        

        return view('admin.mcq.edit-mcq-question',$data);
    }

    public function updateMcqQuestion(Request $request,$id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';

        $request->validate([
            'question'=>'required',
           
        ]);

       

        $data = array(

            'admin_id'=>$admin_id,
            'question'=>$request->question,
            'solution'=>$request->solution,
            'conceptual_type'=>$request->conceptual_type,
            'level'=>$request->level,
            'code'=>$request->code,
            'correct_option_id'=>$request->correct_option,           
            
        );

        $res = Mcq_question::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', ' Question Has Been Updated!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }

    
    }

    public function viewMcqQuestion(Request $request,$id)
    {
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';

        $data['mcq_questions'] = Mcq_question::Where(['id'=>$id])->first();
        $data['mcq_options'] =  Mcq_option::where(['question_id'=>$id])->get();

                        

        return view('admin.mcq.view-mcq-question',$data);
    }

    public function deleteMcqQuestion(Request $request,$id)
    {
        Mcq_question::where(['id'=>$id])->delete();
        Mcq_option::where(['question_id'=>$id])->delete();
        return back()->with('success','Post deleted successfully');
    }


    // Mcq Option 

    public function mcqOptionList(Request $request,$id)
    {
        
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
           
            $data['mcq_question'] =  Mcq_question::where(['id'=>$id])->first();
            $data['mcq_options'] = Mcq_option::where(['question_id'=>$id])->where('options','LIKE','%'.$search_text.'%')
                                    ->paginate(10);                                                                    
                                    

           
            return view('admin.mcq.mcq-options-list',$data);
            
        }else{
            
            
            $data['mcq_question'] =  Mcq_question::where(['id'=>$id])->first();
            $data['mcq_options'] =  Mcq_option::where(['question_id'=>$id])->paginate(10);

            return view('admin.mcq.mcq-options-list',$data);
        }
    }

    public function editMcqOption(Request $request,$id)
    {
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';

        $data['Mcq_option'] = Mcq_option::Where(['id'=>$id])->first();  

        return view('admin.mcq.edit-mcq-option',$data);
    }

    public function updateMcqOption(Request $request,$id)
    {
        

        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';

        $request->validate([
            'option'=>'required',
           
        ]);       

        $data = array(
           
            'options'=>$request->option,            
        );

        $res = Mcq_option::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', ' Question Has Been Updated!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }
    }

    public function viewMcqOption(Request $request,$id)
    {
        $data['mainMenu'] = 'databaseManagement';
        $data['subMenu'] = 'mcqQuestList';

        $data['Mcq_option'] = Mcq_option::Where(['id'=>$id])->first();  

        return view('admin.mcq.view-mcq-option',$data);
    }


    
    public function deleteMcqOption(Request $request,$id)
    {
        // Mcq_question::where(['id'=>$id])->delete();
        Mcq_option::where(['id'=>$id])->delete();
        return back()->with('success','Post deleted successfully');
    }




}
