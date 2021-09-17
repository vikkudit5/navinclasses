<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($video_id)
    {
        // echo $video_id;exit;
        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'revideoList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['tags'] = DB::table('tags')->where('video_id','LIKE','%'.$search_text.'%')->paginate(10);
          
            
        }else{
            $data['tags'] = DB::table('tags')->paginate(10);

            
        }

        $data['video'] = DB::table('re_s3buckets')->where('etag',$video_id)->first();
        return view('admin.tag.tag-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($video_id)
    {
      
        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'revideoList';

       
        $data['video'] = DB::table('re_s3buckets')->where('etag',$video_id)->first();
        return view('admin.tag.add-tag',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$video_id)
    {
        
        $request->validate([
            'name'=>'required',
            'time'=>'required',
            
        ]);

        $_sortOrder = Tag::get()->last();
        if(empty($_sortOrder))
        {
            $sort_order = 1;
        }else{
           $sort_order =  $_sortOrder->sort_order +1;
        }

        $time = explode(':', $request->time);
        $duration_in_sec = ($time[0]*3600) + ($time[1]*60) + $time[2];

        // dd($duration_in_sec);


        $data = array(

        
            'video_id'=>$video_id,
            'name'=>$request->name,
            'time'=>$duration_in_sec,
            'sort_order'=>$sort_order,
            
            
        );

        $res = Tag::create($data);

        if($res)
        {
            return back()
            ->with('success', ' Tag Has Been Added!.');
            
            
            
        }else{
            return back()
            ->with('error','Something Went Wrong!');
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
    public function edit($video_id,$id)
    {
     

        $data['mainMenu'] = 'video';
        $data['subMenu'] = 'revideoList';

       
        $data['tag'] = DB::table('tags')->where('video_id',$video_id)->first();
        // dd($data['tag']);
        $data['video'] = DB::table('re_s3buckets')->where('etag',$video_id)->first();
        return view('admin.tag.edit-tag',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $video_id, $id)
    {
        $request->validate([
            'name'=>'required',
            'time'=>'required',
            
        ]);


        $time = explode(':', $request->time);
        $duration_in_sec = ($time[0]*3600) + ($time[1]*60) + $time[2];


        
        $data = array(

            'name'=>$request->name,
            'time'=>$duration_in_sec,
            'sort_order'=>$request->sort_order,
            
            
        );

        $res = Tag::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', ' Tag Has Been Updated!.');
            
            
            
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
    public function destroy($vidoe_id,$id)
    {
        // $delete = Tag::where(['id'=>$id])->first();
        
      
        Tag::where(['id'=>$id])->delete();
         return back()->with('success','Post deleted successfully');
    }
}
