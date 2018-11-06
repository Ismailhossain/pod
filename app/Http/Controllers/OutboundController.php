<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Request;
use Illuminate\Http\Response;
use App\Role;
use App\User;
use App\Outbound;
use App\Repositories\OutboundRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use PDF;
class OutboundController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OutboundRepository $outboundRepository)
    {
        $this->middleware('auth');
	    $this->outboundRepository = $outboundRepository;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
//	    $physicalpath = public_path(). '\images';
//	    $linkpath = url('images');
//	    print_r($physicalpath);
//	    dd($linkpath);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
//       return $this->outboundRepository->getAllOutbound($request);
       
       
       
//	    $value = $request->session()->get('key', 'default'); // This default value will be returned if the specified key does not exist in the session
//	    $request->session()->regenerate();
//	    $value = $request->session()->get('key', function () {
//		    return 'default';   // the Closure will be executed and its result returned
//	    });
////        $value1 =  $request->session()->token();
//	    $value1 =  $request->session()->getId();
//	    dd($value1);
    }
	
	/**
	 * Start to Display Outbound page.
	 *
	 */
	
	public function index(Request $request)
	{
//		$token = $request->cookie('login_session');
//		dd($token);
		
		
		return $this->outboundRepository->index();
	}
	
	/**
	 * Start to Truncate Temp Driver Code Table to Start New .
	 *
	 */
	
	public function do_truncate_dc_out(Request $request)
	{
		return $this->outboundRepository->do_truncate_dc_out($request);
	}
	
	/**
	 * Start to Check Driver Code is available to process or not.
	 *
	 */
    
    public function get_duplicate_dc(Request $request)
    {
       return $this->outboundRepository->get_duplicate_dc($request);
    }
	
	/**
	 * If Driver Code is available Display Outbound List.
	 *
	 */
    
    public function get_rec_outbound_list(Request $request)
    {
       return $this->outboundRepository->get_rec_outbound_list($request);
    }
	
	/**
	 * Start to Scan Invoice and insert into temp table.
	 *
	 */
    
    public function do_insert_temp_outbound_scan(Request $request)
    {
       return $this->outboundRepository->do_insert_temp_outbound_scan($request);
    }
	
	/**
	 * Start to Edit Outbound Invoice .
	 *
	 */
    
    public function do_edit_out_invoice(Request $request)
    {
       return $this->outboundRepository->do_edit_out_invoice($request);
    }
    
	/**
	 * Start to Get Release Reason Outbound Invoice Status .
	 *
	 */
	
	public function get_reason(Request $request)
	{
		return $this->outboundRepository->get_reason($request);
	}
	
	/**
	 * Start to Release Outbound Invoice Status .
	 *
	 */
    
    public function do_status_release(Request $request)
    {
       return $this->outboundRepository->do_status_release($request);
    }
    
	/**
	 * Start to Truncate Outbound Scanned Invoice .
	 *
	 */
    
    public function do_truncate_outbound_scan(Request $request)
    {
       return $this->outboundRepository->do_truncate_outbound_scan($request);
    }
    
	/**
	 * Start to Check Total Outbound Invoice .
	 *
	 */
	
	public function do_check_total_invoice(Request $request)
	{
		return $this->outboundRepository->do_check_total_invoice($request);
	}
 
	/**
	 * Start to Update Outbound Invoice Status.
	 *
	 */
	
	public function do_update_outbound(Request $request)
	{
		return $this->outboundRepository->do_update_outbound($request);
	}
 
	/**
	 * Start to Update Reprint Outbound Invoice Status.
	 *
	 */
	
	public function do_update_outbound_reprint(Request $request)
	{
		return $this->outboundRepository->do_update_outbound_reprint($request);
	}
	
	/**
	 * Start to Print and Re-Print Outbound Invoice After Confirm.
	 *
	 */
	
	public function print_invoice_pdf(Request $request, $RID , $Driver_code, $Reprint)
	{
		return $this->outboundRepository->print_invoice_pdf($request,$RID, $Driver_code, $Reprint );
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
//	    $del = User::find($id);
//	    $del->delete();
//	    if ($del) {
//		    Session::flash('message', 'Successfully deleted the user!');
//		    return Redirect::to('user/show');
//	    }
    }


    
}
