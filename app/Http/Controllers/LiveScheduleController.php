<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\Product;
use App\Models\Schedule_live_product;
use Illuminate\Support\Facades\DB;

class LiveScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$prod_id)
    {
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $admin_id = $request->session()->get('loggedIn')['id'];

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['studios'] = DB::table('schedule_live_products')->where('program_name','LIKE','%'.$search_text.'%')->where(['admin_id'=>$admin_id,'prod_id'=>$prod_id])->paginate(10);
           
            return view('admin.live-schedule.schedule-list',$data);
            
        }else{
           

            //  DB::enableQueryLog();
        $data['liveSchedules'] = Schedule_live_product::join('studios', 'studios.std_id', '=', 'schedule_live_products.studio_id')  
            ->where(['schedule_live_products.admin_id'=>$admin_id])            
            ->where(['schedule_live_products.prod_id'=>$prod_id])            
        ->paginate(10,['schedule_live_products.*']);

        //       $quries = DB::getQueryLog();
        //   dd($quries);
   

     


        $data['product'] = Product::where(['admin_id'=>$admin_id,'id'=>$prod_id])->first();



          
            return view('admin.live-schedule.schedule-list',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$prod_id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        
        $data['studios'] = Studio::where(['admin_id'=>$admin_id])->get();
        return view('admin.live-schedule.add-schedule',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$prod_id)
    {
        // dd($request->input());
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'std_id'=>'required',
            'program_name'=>'required',
            'seldate'=>'required',
            'starttime'=>'required',
            'endtime'=>'required',
            
        ]);


        $studio_id = $request->std_id;
        $seldate = $request->seldate;
        $program_name = $request->program_name;
        $star_date = $request->star_date;
        $end_date = $request->end_date;
        $datesingle = $request->datesingle;
        $starttime = $request->starttime;
        $endtime = $request->endtime;

        $_startdate = '';
	    $_enddate   = '';

        if ($seldate == 0) {
            $datesingle = $datesingle;
            $_startdate = $datesingle;
            $_enddate = $datesingle;
        } else {
                    $startdate = $star_date;
                    $_startdate = date("Y-m-d", strtotime($startdate));
                    $enddate = $end_date;
                    $_enddate = date("Y-m-d", strtotime($enddate));            

        }

        $str_dt = $_startdate;
        $end_dt = $_enddate;
        $str_tm = $starttime;
        $end_tm = $endtime;
				

        if (empty($studio_id) || empty($str_dt) || empty($end_dt) || empty($str_tm) || empty($end_tm) || empty($program_name)) {

            return back()
            ->with('error','Please Insert All Require Fields');
        }

        // DB::enableQueryLog();
       $checkSchedule =  Schedule_live_product::where(['program_name'=>$program_name,'prod_id'=>$prod_id,'studio_id'=>$studio_id,'admin_id'=>$admin_id])->get();

    //    $quries = DB::getQueryLog();
    //    dd($quries);

       
        if($checkSchedule->isEmpty())
        {
            // DB::enableQueryLog();

            $old_record = Schedule_live_product::select("*")
            ->whereBetween('start_date', [$str_dt, $end_dt])
            ->orWhereBetween('end_date', [$str_dt,$end_dt])
            ->where(['prod_id'=>$prod_id,'studio_id'=>$studio_id])
            ->get();

            // $quries = DB::getQueryLog();
        // dd($quries);

            $data1['admin_id'] = $admin_id;
					$data1['prod_id'] = $prod_id;
					$data1['studio_id'] = $studio_id;
					$data1['program_name'] = $program_name;
					$data1['start_date'] = $str_dt;
					$data1['end_date'] = $end_dt;
					$data1['start_time'] = str_replace(' ', '', $str_tm);
					$data1['end_time'] = str_replace(' ', '', $end_tm);
					// $data['topic'] = $topic;
					// $data['sort_order'] = $sortorder;
					// $data1['created_at'] = date('Y-m-d H:i:s');

                // dd($old_record);
                    if(!$old_record->isEmpty())
                    {
                        $status = 1;

						foreach ($old_record as $old_record2) {
							$tm_in = strtotime(date('Y-m-d') . ' ' . $old_record2->start_time);
							$tm_out = strtotime(date('Y-m-d') . ' ' . $old_record2->end_time);

							$tm_in2 = strtotime(date('Y-m-d') . ' ' . $str_tm);
							$tm_out2 = strtotime(date('Y-m-d') . ' ' . $end_tm);

							$mode = 1;

							$old_tm = round(($tm_out - $tm_in) / 3600);
							$new_tm = round(($tm_out2 - $tm_in2) / 3600);

							if ($tm_in2 < $tm_in && $tm_in2 != $tm_in) {
								$tmd1 = round(($tm_in - $tm_in2) / 3600);

								if ($new_tm <= $tmd1) {
									$mode = 1;
								} else {
									$mode = 0;
								}
							} else if ($tm_in2 > $tm_in && $tm_in2 != $tm_in) {
								$tmd1 = round(($tm_in2 - $tm_out) / 3600);

								if ($tmd1 >= 0) {
									$mode = 1;
								} else {
									$mode = 0;
								}
							} else {
								$mode = 0;
							}

							if ($mode == 0) {
								$status = 0;
								goto STOP;
								//                                break;
							} else {
								continue;
							}
						}

						STOP: if ($status == 1) {
                            $res = Schedule_live_product::create($data1);
                            if($res)
                            {
                                return back()
                                ->with('success', $program_name.' Has Been Added!.');
                                
                                
                                
                            }else{
                                return back()
                                ->with('error','Something Went Wrong!');
                            }
						} else {

                            return back()
                            ->with('error','This time range is not available in this date range!');
                           
						}
                    }else{

                        $res = Schedule_live_product::create($data1);
                        if($res)
                        {
                            return back()
                            ->with('success', $program_name.' Has Been Added!.');
                            
                            
                            
                        }else{
                            return back()
                            ->with('error','Something Went Wrong!');
                        }



                    }

          

        }else{
            return back()
            ->with('error','Duplicate Program In this Studio!');
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
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule_live_product::where(['id'=>$id])->delete();
         return back()->with('success','Studio deleted successfully');
    }
}
