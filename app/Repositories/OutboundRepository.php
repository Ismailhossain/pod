<?php


namespace App\Repositories;
use Illuminate\Http\Response;
use App\Outbound;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use PDF;
class OutboundRepository
{
	
	
	/**
	 * Outbound constructor.
	 */
	public function __construct(Outbound $outbound)
	
	{

	
	}
	
	public function getAllOutbound(Request $request){
	
//		$outbounds = Outbound::all();
//		dd($outbounds);
//		$total =  Outbound::count();
//		return response()->json(array('outbounds'=>$outbounds,'total'=>$total),200);
	}
	
	/**
	 * Start to Display Outbound page.
	 *
	 */
	
	public function index(){
//		$outbounds =  Outbound::all();
//
////		dd($outbounds);
//		return view('outbound.index', compact('roles'));

		        return View('outbound.index');  // Need to call this so that route will know which view file need to show
		
	}
	
	/**
	 * Start to Truncate Temp Driver Code Table to Start New .
	 *
	 */
	
	public function do_truncate_dc_out( $request){

//		$ReqUserID = $request->ReqUserID;
		$ReqUserID = Auth::user()->id;
//		$ReqUserID = 1091;

//		dd($ReqUserID);
		
		DB::table('TMP_DRIVER_CODE')->where('Trans_ID', $ReqUserID)
			->delete();
//		DB::table('TMP_DRIVER_CODE')->where('Trans_ID', '=', $ReqUserID)->delete();
		
		DB::table('TMP_OUTBOUND_SCAN')->where('Trans_ID', $ReqUserID)
			->delete();
		
		
	}
	
	/**
	 * Start to Check Driver Code is available to process or not.
	 *
	 */

	public function get_duplicate_dc(Request $request){
		
		$Req_Driver_Code = $request->Driver_Code;
		$err = true;
//		$FoundDupDC = App\Flight::where('active', 1)
//			->orderBy('name', 'desc')
//			->take(10)
//			->get();
		$FoundDupDC = DB::table('TMP_DRIVER_CODE')->where('Driver_Code', $Req_Driver_Code)->first();
//		$total =  DB::table('TMP_DRIVER_CODE')->where('Driver_Code', $Req_Driver_Code)->count();
		if($FoundDupDC) {
		
		$err = $err;
//		$error .= "<ul><li><b>These Drive Code is currently on Processing, Please Try Later</b></li>";
		
		if ($err) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => "<ul><li><b>These Drive Code is currently on Processing, Please Try Later</b></li>",
			)));
		}
		}
		else {
			exit(json_encode(array(
				'result' => 'success',
				'message' => 'Driver Code is Available to Process  !',
			)));
			
		}
		
//		dd($Req_Driver_Code);
//		$outbounds = Outbound::all();
//		dd($outbounds);
//		$total =  Outbound::count();
//
//		return response()->json(array('FoundDupDC'=>$FoundDupDC,'total'=>$total),200);
		
	}
	
	/**
	 * If Driver Code is available Display Outbound List.
	 *
	 */
	public function get_rec_outbound_list(Request $request){
		
		$rec = $request->dc_no;
		$Type = $request->Type;
		$ReqUserID = Auth::user()->id;
	
//		dd($rec);
//		dd($Type);
		
		$err = true;
//		$found = Outbound::where('Driver_Code', $rec)
//			->orderBy('Scan_Status', 'desc')
////			->take(10)
//			->get();
		$founds = DB::table('VW_REC_OUTBOUND')->where([
			['Driver_Code', '=', $rec],
//			['subscribed', '<>', '1'],
		])->orderBy('Scan_Status', 'desc')->get();
//		$founds = DB::table('VW_REC_OUTBOUND')->where('Driver_Code', $rec)->orderBy('Scan_Status', 'desc')->get();
		$total =  DB::table('VW_REC_OUTBOUND')->where('Driver_Code', $rec)->count();
//		foreach ($founds as $found) {
//		    $Invoice_No[] = $found->Invoice_No;
//	    }
//		dd($founds);
		
		if (!$founds) {
//		if ((!$founds) && ($Type == 1)) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => '<ul><li><b>Sorry, No Data :(</b></li>'
			)));
		}
		if ($founds) {
		
//			foreach ($founds as $found) {
//				$founds['Checkbox'] = '<div id="cb"><input name="StockRecID[]" type="checkbox" value="' . $found['RID'] . '" /></div>';
//			}
			
			$entries = $founds;
//		dd($entries);

		$FoundDupDC = DB::table('TMP_DRIVER_CODE')->where('Driver_Code', $rec)->first();
		if(!$FoundDupDC) {
			
			// Finding Driver ID in the database
			
			$foundDriverID = DB::table('MS_DRIVER')->select('Driver_ID')->where('Driver_Code', $rec)->first();
			if($foundDriverID) {

//			foreach ($foundDriverIDS as $foundDriverID) {
//				$driver_id = $foundDriverID->Driver_ID;
//			}
				$driver_id = $foundDriverID->Driver_ID;
//			dd($driver_id);
				DB::table('TMP_DRIVER_CODE')->insert(
					['Trans_ID' => $ReqUserID, 'Driver_ID' => $driver_id,'Driver_Code' => $rec]
				);
			}
			
			
		
		
		}
//		if($TempDCInsert) {
//
//		}
//		else {
//			exit(json_encode(array(
//				'result' => 'success',
//				'message' => 'Drive Code is Available to Process  !',
//			)));
//
//		}

//		dd($Req_Driver_Code);
//		$outbounds = Outbound::all();
//		dd($outbounds);
//		$total =  Outbound::count();
			return response()->json(array('entries'=>$entries,'total'=>$total),200);
		}
	}
	
	/**
	 * Start to Scan Invoice and insert into temp table.
	 *
	 */
	public function do_insert_temp_outbound_scan(Request $request){
		
		$Invoice_No = $request->Invoice_No;
		$Driver_Code = $request->Driver_Code;
		$ReqUserID = Auth::user()->id;

//		dd($Invoice_No);
//		dd($Driver_Code);
		$found = DB::table('VW_REC_OUTBOUND')->where([
			['Invoice_No', '=', $Invoice_No],
			['Driver_Code', '=', $Driver_Code],
//			['subscribed', '<>', '1'],
		])->first();
		if (!$found) {
			exit(json_encode(array(
				'result' => 'error',
				'Inlist' => 'N',
				'message' => 'Sorry, No Data :(',
			)));
		}
		
		if ($found) {
			$RID = $found->RID;
			$Driver_ID = $found->Driver_ID;
		}
		
		$FoundDupIN = DB::table('TMP_OUTBOUND_SCAN')->select('Invoice_No')->where('Invoice_No', $Invoice_No)->first();
		
		if(!$FoundDupIN) {
			$doInsert =	DB::table('TMP_OUTBOUND_SCAN')->insert(
				['RID' => $RID, 'Invoice_No' => $Invoice_No,'Driver_ID' => $Driver_ID,
				 'Trans_ID' => $ReqUserID,'Scan_Status' => 'Scanned']
			);
		}
		if ($doInsert) {
			exit(json_encode(array(
				'result' => 'success',
				't' => 'add',
				'message' => 'Outbound Invoice Scanned Successfully!'
			)));
		} else {
			exit(json_encode(array(
				'result' => 'error',
				'message' => 'Outbound Invoice not Scanned. Try it again.',
			)));
		}

	}
	
	/**
	 * Start to Edit Outbound Invoice .
	 *
	 */
	
	public function do_edit_out_invoice(Request $request){
		
		$models = json_decode($request->models);
		foreach ($models as $model) {
			$RID = $model->RID;
			$Invoice_No = $model->Invoice_No;
			$SourceDoc = $model->SOURCEDOC;
			}
		$OldInvoice = $request->OldInvoice;
		$ReqUserID = Auth::user()->id;
		
		$timestr =  Carbon::now();
		$timestr =  $timestr->toDateTimeString();
		$err = "";
		
		
		$error = "<ul>";


		if ($SourceDoc == 'YES' ) {
			$err = 1;
			$error .= "<li><b>Please Select Invoice With NO Source Document</b></li>";
		}
		if (!$Invoice_No) {
			$err = 1;
			$error .= "<li><b>Please key in Invoice No</b></li>";
		}else {
			
			$FoundDupInvoice = DB::table('INVOICE_SUMMARY')->select('Invoice_No')->where('Invoice_No', $Invoice_No)->first();
			if ($FoundDupInvoice) {
				$err = 1;
				$error .= "<li><b>Please key in valid Invoice. Duplicate Invoice found.</b></li>";
			}
		}
		
		$error .= "</ul>";
		
//		if (!$Invoice_No || $FoundDupInvoice || $SourceDoc == 'YES') {
		if ($err == 1) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => $error,
			)));
		}
	
		$found = DB::table('VW_REC_INVOICE')->select('RID')->where('RID', $RID)->first();
//		dd($found);
		if ($found) {
			    DB::table('INVOICE_TRANS')->where('RID', $RID)->update(['Invoice_No' => $Invoice_No]);
			    DB::table('INVOICE_SUMMARY')->where('Invoice_No', $OldInvoice)->update(['Invoice_No' => $Invoice_No]);
				$doInsert =	DB::table('INVOICE_LOG_OUT')->insert(['RID' => $RID, 'Invoice_No' => $Invoice_No,
					'Edit_By' => $ReqUserID,'Update_Date' => $timestr]);
		}
		if ($doInsert) {
			exit(json_encode(array(
				'result' => 'success',
				't' => 'add',
				'message' => 'Invoice Updated Successfully !'
			)));
		} else {
			exit(json_encode(array(
				'result' => 'error',
				'message' => 'Invoice not Updated. Try it again.',
			)));
		}
	}
	
	/**
	 * Start to Get Release Reason Outbound Invoice Status .
	 *
	 */
	
	public function get_reason(Request $request)
	{
//		$roles =  Role::all();
		$found = DB::table('MS_REASONS')->select('Reason_ID','Reason_Name')->get();
//		$total =  DB::table('MS_REASONS')->count();
		
//		if($found){
//			$entries = $found;
//		}
//		echo json_encode($entries);
		return response()->json(array('found'=>$found),200);
		
	}
	
	/**
	 * Start to Release Outbound Invoice Status .
	 *
	 */
	
	
	public function do_status_release(Request $request){
		
		
		$RID = $request->RID;
		$Reason_ID = $request->Reason_ID;
		$ReqUserID = Auth::user()->id;
		$Status = 3;
		$SourceDoc = 'NO';
		
		$timestr =  Carbon::now();
		$timestr =  $timestr->toDateTimeString();
		$err = "";
//		dd($RID);
//		dd($timestr);
		
		if (!$Reason_ID) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => '<b>Please Select Reason.</b>'
			)));
		}
		foreach ($RID as $ID) {
		$found = DB::table('VW_REC_OUTBOUND')->select('RID','User_ID','Invoice_No','Status','Status_ID',
			'SOURCEDOC','Reason_ID')->where('RID', $ID)->first();
			
			if ($found) {
			$Status_ID = $found->Status_ID;
			$Invoice_No = $found->Invoice_No;
//				dd($Status_ID);
			}
			if ($Status_ID != $Status) {
				
				exit(json_encode(array(
					'result' => 'error',
					'message' => '<b>Please Select Only  Pending for Outbound Status.</b>',
				)));
				
			}
			elseif ($Status_ID == $Status) {
				
				
				DB::table('INVOICE_TRANS')->where('RID', $ID)->update(['Status' => 5,'Reason_ID' => $Reason_ID,
					'OutboundDate' => $timestr,'OutboundBy' => $ReqUserID]);
				
				DB::table('INVOICE_SUMMARY')->where('Invoice_No', $Invoice_No)->update(['Status' => 5]);
				
			}
			
			$flag = 1;
		}
		if ($flag == 1) {
			$message = 'Invoice Released Successfully.';
		} else {
			$message = 'Invoice Not Released Successfully.';
		}
		exit(json_encode(array(
			'result' => 'success',
			't' => 'add',
			'message' => $message
		)));

	}
	
	/**
	 * Start to Truncate Outbound Scanned Invoice .
	 *
	 */
	
	public function do_truncate_outbound_scan(Request $request)
	{
		$ReqUserID = Auth::user()->id;
		$doDelete= DB::table('TMP_OUTBOUND_SCAN')->where('Trans_ID', $ReqUserID)
			->delete();
		
		if ($doDelete) {
			exit(json_encode(array(
				'result' => 'success',
				't' => 'add',
				'message' => ' Temporary Outbound Scan Table Successfully Truncate !'
			)));
		} else {
			exit(json_encode(array(
				'result' => 'error',
				'message' => 'Try it again.',
			)));
		}
	}
	
	/**
	 * Start to Check Total Outbound Invoice .
	 *
	 */
	
	public function do_check_total_invoice(Request $request)
	{
		$Driver_code = $request->Driver_code;
		$ReqUserID = Auth::user()->id;
		$timestr =  Carbon::now();
		$timestr =  $timestr->toDateTimeString();
//		$timestr =  $timestr->toDateString();
		
//		$found = DB::table('VW_REC_OUTBOUND')->select('ML_ID','Driver_Code',DB::raw('CAST(LoadedDate AS DATE) as LoadedDate'))->distinct()
		$founds = DB::table('VW_REC_OUTBOUND')
			->select('ML_ID','Driver_Code','LoadedDate')
			->distinct()
			->where([
//			['CAST(LoadedDate AS DATE)', '=', $timestr],
			[DB::raw('CAST(LoadedDate AS DATE)'), '=', $timestr],  // If need to compare date
			['Driver_Code', '=', $Driver_code],
//			['subscribed', '<>', '1'],
			])
			->get();
		if ($founds) {
			
			foreach ($founds as $found) {
				$ML_ID [] = $found->ML_ID;
			}
//			dd($ML_ID);
		}
		unset($founds);
		foreach ($ML_ID as $ML_IDs) {
			
			$founds = DB::table('VW_REC_OUTBOUND')
				->select('ML_ID',DB::raw('COUNT(Invoice_No) AS ChkInvoice'),'LoadedDate')
				->distinct()
				->where([
//			['CAST(LoadedDate AS DATE)', '=', $timestr],
					[DB::raw('CAST(LoadedDate AS DATE)'), '=', $timestr],  // If need to compare date
					['ML_ID', '=', $ML_IDs],
//			['subscribed', '<>', '1'],
				])
				->groupBy('ML_ID', 'LoadedDate')->get();
			
			if ($founds) {
				foreach ($founds as $found) {
					$totalCheckedIn [] = $found->ChkInvoice;
				}
				$totalCheckedInvoice = array_sum($totalCheckedIn);
			}
			unset($founds);
			$founds = DB::table('INVOICE')
				->select('ML_ID',DB::raw('COUNT(Invoice_No) AS TotalInvoice'),'Invoice_Date')
				->distinct()
				->where([
					[DB::raw('CAST(Invoice_Date AS DATE)'), '=', $timestr],  // If need to compare date
					['ML_ID', '=', $ML_IDs],
//			['subscribed', '<>', '1'],
				])
				->groupBy('ML_ID', 'Invoice_Date')->get();
			
			if ($founds) {
				foreach ($founds as $found) {
					$totalIn [] = $found->TotalInvoice;
				}
				$totalInvoice = array_sum($totalIn);
			}
			unset($founds);
			
		}
		$RemainingInvoice = $totalInvoice - $totalCheckedInvoice;
		if ($totalInvoice != $totalCheckedInvoice ) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => '<b>Still have '.$RemainingInvoice.' Unchecked Invoices for this Outlet do you wish to continue ! </b>',
			)));
		}
		
//		dd($RemainingInvoice);
	}
	
	/**
	 * Start to Update Outbound Invoice Status .
	 *
	 */
	
	public function do_update_outbound(Request $request)
	{
		
		$ReqUserID = Auth::user()->id;
		$timestr =  Carbon::now();
		$timestr =  $timestr->toDateTimeString();
//		$timestr =  $timestr->toDateString();
		$RID = $request->RID;
//		$Driver_code = $request->Driver_code;
		
//		dd($Driver_code);
		
		$Status = 3;
		$StatusPending = 1;
		$SourceDoc = 'YES';
		
		/**
		 * Get Driver code
		 */
		
//		$RIDS     = '';
		foreach($RID as $ID){
//			$RIDS .= (($RIDS) ? ',' : '') . "" . $ID . "";
			$RIDS[] = $ID;
		}
		$found = DB::table('VW_REC_OUTBOUND')
			->select('Driver_Code')
			->take(1)
			->whereIn('RID', $RIDS)
//			->where([
////			['subscribed', '<>', '1'],
//			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->first();
//		dd($found);
		if ($found) {
			$Driver_Code = $found->Driver_Code;
//		dd($Driver_code);
		
		}
		unset($found);
		
		/**
		 * Get Invoice No
		 * Check Total Invoice clicked
		 */
		
		$found = DB::table('VW_REC_OUTBOUND')
			->select('RID','Invoice_No')
			->where([
			['Driver_Code','=', "$Driver_Code"],
			['Status_ID', '=', $Status],
			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->get();

		$entries = $found;
//		dd($entries);
		$totalChecked = count($RID);
		$totalInvoice = count($entries);
//		dd($totalChecked);
//		dd($totalInvoice);
		unset($found);
		if ($totalChecked != $totalInvoice ) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => '<b>Please Select All Pending for Outbound Invoices Together to get the Gate Pass </b>',
			)));
		}
		
		/**
		 * Check Status and source doc
		 */
		
		$check_status = DB::table('VW_REC_OUTBOUND')
			->select('Invoice_No')
			->whereIn('RID', $RIDS)
			->where([
				['Status_ID', '<>', $Status],
			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->get();
//		dd($check_status);
		$check_status = count($check_status);
		if ($check_status != 0) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => '<b>Please Select Only Pending for Outbound Status.</b>',
			)));
		}
		
		
		$check_doc = DB::table('VW_REC_OUTBOUND')
			->select('Invoice_No')
			->whereIn('RID', $RIDS)
			->where([
				['SOURCEDOC', '=', 'NO'],
			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->get();
//		dd($check_doc);
//		$check_doc = count($check_doc);
//		if ($check_doc->count() > 0) {
		if ($check_doc->isNotEmpty()) {
			exit(json_encode(array(
				'result' => 'error',
				'message' => '<b>Please Select Only those Invoice have Source Document.</b>',
			)));
		}
		
		foreach($entries as $k => $v){
			
			DB::table('INVOICE_TRANS')->where('RID', $v->RID)->update(['Status' => 1,
				'OutboundDate' => $timestr,'OutboundBy' => $ReqUserID]);
			
			DB::table('INVOICE_SUMMARY')->where('Invoice_No', $v->Invoice_No)->update(['Status' => 1]);
			
		}
		
		exit(json_encode(array(
			'result' => 'success',
			't' => 'add',
			'message' => 'Outbound Status Updated Successfully.'
		)));
		
		
	}
	
	/**
	 * Start to Print and Re-Print Outbound Invoice After Confirm.
	 *
	 */
	
	public function print_invoice_pdf(Request $request, $RID , $Driver_code, $Reprint)
	{
		
		$ReqUserID = Auth::user()->id;
		$timestr =  Carbon::now();
		$timestr =  $timestr->toDateTimeString();
		
		
		$ID = request()->segment(3);
		$Driver_code = request()->segment(4);
		$Reprint = request()->segment(5);
//		$Reprint = $request->Reprint;
		$IDA = explode(',', $ID);
	
		$found = DB::table('VW_REC_OUTBOUND AS vro')
			->select('Driver_Code','Name','Assistant_Name','Assistant2_Name','Vehicle_No','Status_ID',
				'Status','Checker_Name','Question_1','Question_2','Question_3','Question_4',
				'Question_5','Question_6','Question_7')
			->join('MS_CRITERIA AS mcq', 'vro.Criteria_Code', '=', 'mcq.Criteria_Code')
			->take(1)
			->whereIn('RID', $IDA)
//			->where([
////			['subscribed', '<>', '1'],
//			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->first();
		$entriesRequest = $found;
		unset($found);
		
		/**
		 * Get Invoice No
		 * Get Total Invoice
		 */
		
		$found = DB::table('VW_REC_OUTBOUND')
			->select('Invoice_No','Status_ID')
			->where([
				['Driver_Code','=', "$Driver_code"],
				['Status_ID', '=', 1],
			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->get();
		
		$entries = $found;
		unset($found);
		$total = count($entries);
//		dd($entries);
		
		/**
		 * Get Question Answer
		 */
		
		$foundanswer = DB::table('VW_CRITERIA_QUESTION')
			->select('Criteria_Code','Question_Name','Question_ANS','Create_Date')
//			->where([
//				['Driver_Code','=', "$Driver_code"],
//				['Status_ID', '=', 1],
//			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->get();
		$entriesAnswer = $foundanswer;
//		dd($entriesAnswer);
		
		
		$invoices = '';
		foreach ($entries as $k => $v) {
			$invoices .= (($invoices) ? ',' : '') . $v->Invoice_No;
		}
//		PDF = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
//		PDF::SetCreator(PDF_CREATOR);
		PDF::SetAuthor('mobileOne');
		PDF::SetTitle('Total Confirm Invoices');
		PDF::SetSubject('Confirm Invoices');
		PDF::SetKeywords('Report, Stock, Request, transaction, guide');
		
		if($Reprint == 'N') {
// Custom Header
			PDF::setHeaderCallback(function($pdf) {
				
				// Set font
				$pdf->SetFont('helvetica', 'B', 20);
				// Title
				$pdf->Cell(0, 15, 'Gate Pass', 0, false, 'C', 0, '', 0, false, 'M', 'M');
				
			});

// Custom Footer
			PDF::setFooterCallback(function($pdf) {
				
				// Position at 15 mm from bottom
				$pdf->SetY(-15);
				// Set font
				$pdf->SetFont('helvetica', 'I', 8);
				// Page number
				$pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
				
			});
		}
		if($Reprint == 'Y') {
// Custom Header
			PDF::setHeaderCallback(function($pdf) {
				
				// Set font
				$pdf->SetFont('helvetica', 'B', 20);
				// Title
				$pdf->Cell(0, 15, 'Gate Pass (Reprint)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
				
			});

// Custom Footer
			PDF::setFooterCallback(function($pdf) {
				
				// Position at 15 mm from bottom
				$pdf->SetY(-15);
				// Set font
				$pdf->SetFont('helvetica', 'I', 8);
				// Page number
				$pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
				
			});
		}

		
		// set default monospaced font
		PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
//		PDF::SetMargins(7, 18, 7);
		
		PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
		PDF::SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		// set default font subsetting mode
		PDF::setFontSubsetting(true);
		
		PDF::SetFont('dejavusans', '', 10, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		PDF::AddPage();
//		PDF::AddPage('L', 'A4');

//		$html = '<table width="100%" cellpadding="2" style="font-size: 11px;">
//					<tr>
//					<td><h4>ISO 22000.2005</h4></td>
//					<td><h4>BGS Trading Sdn Bhd</h4></td>
//					<td><h4>Issue No: OPRP-MR-PASS</h4></td>
//					</tr>
//
//
//
//                </table><br/><br/><table>';
//
//		$html .= '<table border="1px" cellpadding="2px">
//
//                <tbody >
//       		    <tr >
//                        <th  data-field="dn" >Total Document Number :</th>
//                        <td >' . $total . '</td>
//                 </tr>
//                 <tr >
//                        <th  data-field="dn" >Driver Name :</th>
//                        <td >' . $entriesRequest->Name. '</td>
//                 </tr>
//
//                 <tr >
//                        <th  data-field="dn" >Driver Code :</th>
//                        <td >' . $entriesRequest->Driver_Code . '</td>
//                 </tr>
//                 <tr >
//                        <th  data-field="dn" >First Assistant Name :</th>
//                        <td >' . $entriesRequest->Assistant_Name . '</td>
//                 </tr>
//                   <tr >
//                        <th  data-field="dn" >Second Assistant Name :</th>
//                        <td >' . $entriesRequest->Assistant2_Name . '</td>
//                 </tr>
//
//				   <tr>
//						<th  data-field="in">Document No :</th>';
//		$html .= '<td>';
//
//
//		$html .= '<table width="100%" cellpadding="2" style="font-size: 10px;">';
//
//
//		$html .= '<tr>
//
//                            <td  align="center" style="">' . $invoices .  '</td>
//
//                        </tr>';
//
//		$html .='</table>';
//		//       $html .= '<span>' . $invoices . '</span>';
//		$html .= '</td>
//				</tr>
//
//                 <tr >
//                        <th  data-field="vcn">Vehicle No :</th>
//                        <td >' . $entriesRequest->Vehicle_No . '</td>
//                 </tr>
//                 <tr >
//                 		<th  data-field="date">Report Date :</th>
//                 		<td >' . $timestr . '</td>
//                 </tr>
//
//                </tb>
//                <tbody>
//
//
//
//            </table><br/><br/>';
//
//		$html .= '<table border="1px" cellpadding="2px">
//
//                <tbody >
//       			<tr >
//                        <th  data-field="dn" ><h5>Release Criteria Question : </h5></th>
//                        <td ><h5>Release Criteria Answer : </h5></td>
//                 </tr>';
//		foreach ($entriesAnswer as $ID) {
//			$html .= '
//                 <tr >
//                        <th  data-field="dn" >' . $ID->Question_Name . '</th>
//                        <td >' . $ID->Question_ANS . '</td>
//                 </tr>';
//		}
//
//		$html .= '
//
//
//                </tb>
//                <tbody>
//            </table><br/><br/>';
//
//
//		$html .= '<table width="100%" cellpadding="2" style="font-size: 11px;">
//					<tr><td colspan="5"></td></tr>
//					<tr><td colspan="5"></td></tr>
//                   <tr style="text-align:left">
//                        <td width="40%" style="text-align:left;"><br><span style="font-size: 11px; text-align:left;">Checked By :</span>
//                            <br><b>' . $entriesRequest->Checker_Name . '</b>
//                        </td>
//                        <td colspan="1"></td>
//                        <td  width="40%" style="text-align:left;"><br><b>...............................................</b>
//                            <br><span style="font-size: 11px; text-align:left;">Approved for Released By </span>
//                        </td>
//                    </tr>
//
//                </table><br/><br/><table>';
		
		
		
		
		$view = view('print.invoice', compact('entriesRequest','total','invoices','timestr','entriesAnswer'));
		$html = $view->render();
		
		PDF::writeHTML($html, true, false, true, false, '');
//		PDF::lastPage();
		PDF::Output('Outbound Invoice','I'); // I is using not to DW directly, D for direct DW,
//		$pdf->Output('Print Collection- ' . $entriesRequest->Request_No, 'I');
	}
	
	/**
	 * Start to Update Reprint Outbound Invoice Status.
	 *
	 */
	
	public function do_update_outbound_reprint(Request $request)
	{
		
		$ReqUserID = Auth::user()->id;
		$timestr =  Carbon::now();
		$timestr =  $timestr->toDateTimeString();
//		$timestr =  $timestr->toDateString();
		
		$RID = $request->RID;
		
		$Status = 1;
		
		$totalChecked = count($RID);
		
		/**
		 * Get Driver code
		 */

//		$RIDS     = '';
		foreach($RID as $ID){
//			$RIDS .= (($RIDS) ? ',' : '') . "" . $ID . "";
			$RIDS[] = $ID;
		}
		$found = DB::table('VW_REC_OUTBOUND')
			->select('Driver_Code')
			->take(1)
			->whereIn('RID', $RIDS)
//			->where([
////			['subscribed', '<>', '1'],
//			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->first();
//		dd($found);
		if ($found) {
			$Driver_Code = $found->Driver_Code;
//		dd($Driver_code);
		
		}
		unset($found);
		
		/**
		 * Get Invoice No
		 * Check Total Invoice clicked
		 */
		
		$found = DB::table('VW_REC_OUTBOUND')
			->select('Invoice_No')
			->where([
				['Driver_Code','=', "$Driver_Code"],
				['Status_ID', '=', $Status],
			])
//			->groupBy('ML_ID', 'Invoice_Date')
			->get();
		
		$entries = $found;
//		dd($entries);
		$totalInvoice = count($entries);
		unset($found);
		
		
		
		foreach($RID as $ID){
//
			$found = DB::table('VW_REC_OUTBOUND')
				->select('RID','User_ID','Invoice_No','Status','Status_ID')
			->where([
				['RID','=', $ID],
			])
//				->whereIn('RID', $RIDS)
//			->groupBy('ML_ID', 'Invoice_Date')
			->first();
//			dd($found);
			
			if ($found->Status_ID != $Status || $totalChecked != $totalInvoice) {
				
				exit(json_encode(array(
					'result' => 'error',
					'message' => '<b>Please Select Only All POD-Pending for delivery Status together to perform this Action.</b>',
				)));
				
				
			}
			if ($found->Status_ID  == $Status) {
				
				
				DB::table('INVOICE_TRANS')
					->where('RID', $ID)
					->update(['Re_Print' => $timestr]);
				
				DB::table('Re_Print_Log')
					->insert(['RID' => $ID,
					'Re_Print_By' => $ReqUserID,'Re_Print_Date' => $timestr]);
				
			}
			$flag = 1;
		}
		
		if ($flag == 1) {
			$message = 'Reprint Status Updated Successfully.';
		} else {
			$message = 'Reprint Status Not Updated Successfully.';
		}
		
		
		exit(json_encode(array(
			'result' => 'success',
			't' => 'add',
			'message' => $message
		)));
	
	}
	
	
	public function storeOutbound($request){


	}
	

}



