<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule_live_product;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['mainMenu'] = 'studioManagement';
        $data['subMenu'] = 'studioList';
        $admin_id = $request->session()->get('loggedIn')['id'];

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['studios'] = DB::table('studios')->where('std_name','LIKE','%'.$search_text.'%')->where(['admin_id'=>$admin_id])->paginate(10);
           
            return view('admin.studio.studio-list',$data);
            
        }else{
            $data['studios'] = DB::table('studios')->where(['admin_id'=>$admin_id])->paginate(10);

          
            return view('admin.studio.studio-list',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'studioManagement';
        $data['subMenu'] = 'studioList';
        
        return view('admin.studio.add-studio',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'std_id'=>'required|unique:studios',
            'std_name'=>'required',
            // 'embed'=>'required',
            // 'std_embed_video'=>'required',
            // 'std_rtmp_url'=>'required',
            // 'std_rtmp_key'=>'required',
        ]);

        $data = array(

            'admin_id'=>$admin_id,
            'std_id'=>$request->std_id,
            'std_name'=>$request->std_name,
            // 'embed'=>$request->embed,
            // 'std_embed_video'=>$request->std_embed_video,
            'std_rtmp_url'=>$request->std_rtmp_url,
            // 'std_rtmp_key'=>$request->std_rtmp_key,           
            
        );

        $res = Studio::create($data);
        if($res)
        {
            return back()
            ->with('success', $request->std_name.' Has Been Added!.');
            
            
            
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
        $data['mainMenu'] = 'studioManagement';
        $data['subMenu'] = 'studioList';

        $data['studio'] = Studio::where(['id'=>$id])->first();
        return view('admin.studio.view-studio',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'studioManagement';
        $data['subMenu'] = 'studioList';

        $data['studio'] = Studio::where(['id'=>$id])->first();
        return view('admin.studio.edit-studio',$data);
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
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'std_id'=>'required|unique:studios',
            'std_name'=>'required',
            'embed'=>'required',
            'std_embed_video'=>'required',
            'std_rtmp_url'=>'required',
            'std_rtmp_key'=>'required',
        ]);

        $data = array(

            
            'std_id'=>$request->std_id,
            'std_name'=>$request->std_name,
            'embed'=>$request->embed,
            'std_embed_video'=>$request->std_embed_video,
            'std_rtmp_url'=>$request->std_rtmp_url,
            'std_rtmp_key'=>$request->std_rtmp_key,           
            
        );

        $res = Studio::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()
            ->with('success', $request->std_name.' Has Been Updated!.');
            
            
            
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
    public function destroy(Request $request,$studio_id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        Studio::where(['std_id'=>$studio_id,'admin_id'=>$admin_id])->delete();
        Schedule_live_product::where(['studio_id'=>$studio_id,'admin_id'=>$admin_id])->delete();
         return back()->with('success','Studio deleted successfully');
    }
}
