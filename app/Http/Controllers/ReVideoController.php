<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Re_s3bucket;
use App\Models\Category;
use App\Models\S3bucket;

class ReVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'revideoList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['products'] = DB::table('re_s3buckets')->where('filename','LIKE','%'.$search_text.'%')->paginate(10);
            $data['folder_name'] = 'navinclassess';
           
            return view('admin.video.video-list',$data);
            
        }else{
            $data['products'] = DB::table('re_s3buckets')->paginate(10);

            $data['folder_name'] = 'navinclassess';
            return view('admin.re-video.video-list',$data);
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
        $data['subMenu'] = 'revideoList';
        // $data['videos'] = s3bucket::get();
        $etag_arr = [];
        $reetag_arr = [];
        $s3videos = s3bucket::get();
        if(!empty($s3videos))
        {
            foreach($s3videos as $video)
            {
               $etag_arr[] =  $video->etag;
            }
        }

        $re_videos = Re_s3bucket::get();
        
        if(!empty($re_videos))
        {
            foreach($re_videos as $re_video)
            {
                $reetag_arr[] =  $re_video->etag;
            }
        }       
        
        $notMapids =  array_diff($etag_arr,$reetag_arr);

      


        $data['videos'] = s3bucket::whereIn('etag',$notMapids)->get();

        return view('admin.re-video.upload-video',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $originalname = $request->originalname;
        $customname = $request->customname;
        $time = $request->time;
        $video_id = $request->video_id;
        
        $public_datas = array_combine($video_id,$customname);
        $time_datas = array_combine($video_id,$time);

       

        
        if(!empty($public_datas))
        {
            foreach($public_datas as $key=>$public_data)
            {
                $s3bucket = s3bucket::where(['etag'=>$key])->first();
                // dd($key);
                $data = array(
                    'filename'=>$s3bucket->filename,
                    'public_name'=>$public_data,
                    'path'=>$s3bucket->path,
                    'etag'=>$s3bucket->etag,
                    'size'=>$s3bucket->size,
                    'type'=>$s3bucket->type,
                    'admin_id'=>$s3bucket->admin_id,
                    'date'=>$s3bucket->date,
                );

                Re_s3bucket::create($data);


            }
        }

        if(!empty($time_datas))
        {
            foreach($time_datas as $key=>$time_data)
            {
                
                $s3bucket = s3bucket::where(['etag'=>$key])->first();
                $data = array(
                    'duration'=>$time_data,
                    
                );

                Re_s3bucket::where(['etag'=>$key])->update($data);


            }

            return back()
                ->with('success', ' Video Has Been Added!.');
        }

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
        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'revideoList';

        $data['video'] = Re_s3bucket::where(['etag'=>$id])->first();
       
        return view('admin.re-video.edit-video',$data);
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

        $request->validate([
            'public_name'=>'required',
            'time'=>'required'
            
        ]);

        $data = array(
            'public_name'=>$request->public_name,
            'duration'=>$request->time
        );

        $res = Re_s3bucket::where(['etag'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', $request->public_name.' Has Been updated!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Re_s3bucket::where(['etag'=>$id])->delete();
        return back()->with('success','Post deleted successfully');
    }
}
