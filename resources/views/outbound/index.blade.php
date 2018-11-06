@extends('layouts.master')
<style type="text/css" title="currentStyle">
    input#minus {
        width:20px;
        height:20px;
        background-color: Transparent;
        background-repeat:no-repeat;
        border:1px solid #666666;
        border-radius: 3px;
    }
    /*.k-grid table {*/

    /*width: 2001px;*/
    /*}*/
    .barcode {
        float: left;
    }
    .in{
        display: none;
    }
    #cdialog-task-error{
        display: none;

    }
    #cdialog-task-confirm-approve{
        display: none;
    }
    #cdialog-task-confirm-reject{
        display: none;
    }
    #cdialog-task-updaterelease-approve{
        display: none;
    }

    .k-dropdown-wrap.k-state-default {
        background-color: #363940;
        border-color: #63656a;
    }
    .k-state-selected.k-state-focused,
    .k-state-selected.k-state-highlight
    {
        color: white;
        background: black;
        border-color: black;
    }

    .k-item.k-state-hover,
    .k-item.k-state-hover:hover
    {
        color: white;
        background: black;
    }
    .GreenCode{
        background-color:#009933;
        color:#000000;
    }
    .RedCode{
        background-color:#FF0000;
        color:#000000;
    }

    .lbl {
        padding-left: 0px !important;
        padding-top: 0px !important;
        width: 200px;
    }


</style>

@section('script')
    {!! Html::script('assets/js/outbound/outbound.js') !!}

    <script type="text/javascript">

	    $(document).ready(function(){

//        rescan_outbound();


		    truncate_driver_code();
		    // Load
		    SetFocus ();
		    SetFocusIn();


//        $("#cdialog-task-error").hide();
//        $("#cdialog-task-confirm-approve").hide();
//        $("#cdialog-task-confirm-reject").hide();
//        $("#cdialog-task-updaterelease-approve").hide();


		    $("#refresh").click(function () {
			    $('#FieldFilter').val('');
//            $("#grid").data("kendoGrid").dataSource.filter({});
			    var input = document.getElementById("FieldFilter");
			    input.focus();
		    });
		    $("#refreshinvoice").click(function () {
			    $('#InvoiceFilter').val('');
//            $("#grid").data("kendoGrid").dataSource.filter({});
			    var input = document.getElementById("InvoiceFilter");
			    input.focus();
		    });

//        start of filtering part

//        $("#FieldFilter").keyup(function () {
//            var val = $('#FieldFilter').val();
//            //alert(val);
//            if (val) {
//
//                $("#grid").data("kendoGrid").dataSource.filter({
//                    logic: "or",
//                    filters: [
//                        {
//                            field: "Driver_Code",
//                            operator: "contains",
//                            value: val
//                        },
//                        {
//                            field: "Name",
//                            operator: "contains",
//                            value: val
//                        },
//                        {
//                            field: "Invoice_No",
//                            operator: "contains",
//                            value: val
//                        },
//                        {
//                            field: "Vehicle_No",
//                            operator: "contains",
//                            value: val
//                        }
//                    ]
//                });
//            } else {
//                $("#grid").data("kendoGrid").dataSource.filter({});
//            }
//
//        });

//        end of filtering part

		    var TypingTimer;                //timer identifier
		    var DoneTypingInterval = 700;  //time in ms, 5 second for example

		    //on keyup, start the countdown
		    $("#FieldFilter").on('keyup', function () {
			    clearTimeout(TypingTimer);
			    TypingTimer = setTimeout(DoneDCTyping, DoneTypingInterval);
		    });

		    //on keydown, clear the countdown
		    $("#FieldFilter").on('keydown', function () {
			    clearTimeout(TypingTimer);
		    });

////        $("#FieldFilter").on('paste keyup keypress blur change paste', function(e) {
//		    $("#FieldFilter").keyup(function (event) {
//
//			    var teststorage = document.getElementById('FieldFilter').value;
//			    localStorage.setItem('HiddenDC',teststorage);
//			    document.getElementById("HiddenDC").value = localStorage.getItem("HiddenDC");
//
//			    if (!event.ctrlKey) {
//				    getDriverCode(this.value);
////                driver_code(this.value,1);
//			    }
//
//		    });


//        $( "#InvoiceFilter" ).bind( 'keyup paste', function() {
//            Scan_Outbound_Invoice(this.value);
//        });

		    $("#InvoiceFilter").on('keyup', function () {
			    clearTimeout(TypingTimer);
			    TypingTimer = setTimeout(DoneINTyping, DoneTypingInterval);
		    });

		    //on keydown, clear the countdown
		    $("#InvoiceFilter").on('keydown', function () {
			    clearTimeout(TypingTimer);
		    });

//		    $( "#InvoiceFilter" ).on( 'keyup', function(event) {
//
//			    if (!event.ctrlKey) {
//				    Scan_Outbound_Invoice(this.value);
//			    }
//		    });

		    $("#ReasonNameD").kendoDropDownList({
			    optionLabel: "Please Select Reason",
			    dataTextField: "Reason_Name",
			    dataValueField: "Reason_ID",
			    autoBind: false,
//			filter: "contains",
			    minLength: 1,
			    dataSource: {
//				    type: "json",
				    transport: {
					    read: {
						    type: 'get',
						    url: 'outbound/get_reason',
						    dataType: 'json'
					    }
				    },
				    schema: {
					    data: "found"
				    }
			    }
		    }).data("kendoDropDownList");
//        $(window).on('beforeunload', function () {
//            if(true){
//                return "You are leaving the page";
//            }
//        });


		    window.onbeforeunload = warning;
//        window.onunload  = askConfirm;
//        $(window).unload(function(){
//            console.log("got it");
//            truncate_driver_code ();
//        });



	    });

	    //  END of DOC invoices

	    function DoneDCTyping() {

		    var teststorage = document.getElementById('FieldFilter').value;
		    localStorage.setItem('HiddenDC',teststorage);
		    document.getElementById("HiddenDC").value = localStorage.getItem("HiddenDC");
		    getDriverCode();

	    }
	    function DoneINTyping() {

		    Scan_Outbound_Invoice();

	    }



	    //      var timeout;
	    function warning() {
//          rescan_outbound();
		    truncate_driver_code ();
//          return "You are leaving the page" + truncate_driver_code ();
//          return "You are leaving the page";
		    return ;
	    }
	    //      function askConfirm() {
	    //          truncate_driver_code ();
	    //          return "You are leaving the page";
	    //      }



	    // Check browser support

	    //      window.localStorage['HiddenDC'] = document.getElementById('FieldFilter').value;




    </script>
@endsection

@section('title')
    @parent

    | Outbound Management
@endsection

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($errors))
        {{--@if(count($errors))--}}
        {{--@if (count($errors) > 0)--}}
        <div class="alert-danger">


            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach


        </div>
    @endif
    {{--@if ($errors->any())--}}
    {{--<ul class="alert alert-danger">--}}
    {{--@foreach ($errors->all() as $error)--}}
    {{--<li>{{ $error }}</li>--}}
    {{--@endforeach--}}
    {{--</ul>--}}
    {{--@endif--}}
    {{--<div class="alert alert-danger print-error-msg" style="display:none">--}}
    {{--<ul></ul>--}}
    {{--</div>--}}

    {{--@if(Session::has('message'))--}}
    {{--<div class="alert alert-{{ Session::get('message-type') }} alert-dismissable hidemsg">--}}
    {{--<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>--}}
    {{--<i class="{{ Session::get('message-type') == 'success' ? 'ok' : 'remove'}}"></i> {{ Session::get('message') }}--}}
    {{--<i class="glyphicon glyphicon-{{ Session::get('message-type') == 'success' ? 'ok' : 'remove'}}"></i> {{ Session::get('message') }}--}}
    {{--</div>--}}
    {{--@endif--}}

    @if (Session::has('message'))
        <div class="alert alert-info ">{{ Session::get('message') }}</div>
    @endif



    <!-- Start of Assign With Different Roles Access -->

    {{--@if (auth()->user()->hasRole('root'))--}}
    {{--Hello Root--}}
    {{--@else--}}
    {{--Hello standard user--}}
    {{--@endif--}}



    <!-- End of Assign With Different Roles Access -->

    @can('Can_Register')


    @endcan


    <!-- Modal -->

    <!-- Start of Outbound Templating   -->

    <script id="template" type="text/x-kendo-template">
        <div id="details-container" >
            {{--<input type="text" ID="Client_ID" hidden>--}}
            <table   style=" margin-left:20px; margin-right:auto; " >

                <tr>
                    <th class="lbl">Invoice No</th>
                    <td><input id="Invoice_NoE" name="Invoice_NoE" data-bind="value:Invoice_No" class="k-input k-textbox" style="width: 300px"></td>
                </tr>

            </table>
        </div>
    </script>

    <input type="hidden" id="OldInvoice" value="" >
    <input type="hidden" id="ReqUserID" value=" {{ Auth::user()->id }}" >
    <input type="hidden" id="HiddenDC"  value="">

    <!-- Modal -->
    <div class="modal fade" id="ManualModal"  role="dialog" aria-labelledby="ManualModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLabel">Manual Search</h5>
                </div>
                <div class="modal-body">
                    <span> Invoice No :   <input type="text" class="k-input k-textbox "  autofocus id='ManualInvoiceFilter'
                                                    placeholder="Search for..."> </span>
                    <span><a href="#" type="button" id="MSearch" class="btn k-button" onclick="manualSearch()"></i>Search</a></span>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Search</button>--}}
                </div>
            </div>
        </div>
    </div>




    <div id="cdialog-task-error" title="Error">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Please select Request</p>
    </div>
    <div id="cdialog-task-confirm-approve" title="confirmation">

        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>After Confirmation - </p>
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Please Proceed with Print</p>
    </div>

    <div id="cdialog-task-updaterelease-approve" title="confirmation">
        <div id="ReasonName">
            <tr>
                <th>Reason Name -</th>
                <td>
                    <input type="text"  id="ReasonNameD" value="" class="k-input " style="width: 350px" >
                </td>
            </tr>
            <b></b>
        </div>
    </div>
    <div class="barcode" id="DC" >
        <form id="auto_search">
            <span> Driver Code :   <input type="text" autofocus  class="k-input k-textbox" id='FieldFilter' placeholder="Search for..."> </span>
            <button id="refresh" class="btn btn-default" type="button"><span class="fa fa-refresh" aria-hidden="true"></span></button>

        </form>

    </div>
    <div class="barcode " id="IN" style="display: none" >
        <form id="live_insearch" >
        <span> Invoice No :   <input type="text" class="k-input k-textbox "  autofocus id='InvoiceFilter'
                                     placeholder="Search for..."> </span>
            <button id="refreshinvoice" class="btn btn-default" type="button"><span class="fa fa-refresh"
                                                                                    aria-hidden="true"></span></button>
            {{--<button class="k-button k-button-icontext k-grid-edit" type="button"><span class="driver_co"> <a href="?m=rec&c=show_outbound">*}--}}
                    {{--{*<p>{$LANG->q('driver_co')}</p></a>  </span></button>--}}
            <a href="{{ url('outbound') }}" type="button" class="btn k-button"></i>Back to Driver Code</a>
            <span><a href="#" type="button" id="ManualSearch" class="btn k-button"></i>Manual Search</a></span>

        </form>

    </div>
    <br />
    <br />
    <p id="p1" hidden>Error</p>
    <p id="p2" hidden>Cancel</p>
    <p id="p3" hidden>Confirm</p>
    <br />
    <br />
    <div id="grid"></div>
    <br />
    <div id="error" style="display: none">
        <h3 style="color: darkred">Sorry, This Driver Code is currently Under Processing, Please Try Later </h3>

    </div>
    <div id="error1" style="display: none">
        <h3 style="color: darkred">Sorry, No Data :( </h3>

    </div>
    <div class="confirm_invoices in" id="cprint">
        {{--<input type="submit" id="confirmPDF" onclick="confirmprint()"  value="Confirm" class="k-button k-button-icontext k-grid-edit"/>--}}
        <input type="submit" id="confirmPDF" onclick="confirmprint()"  value="Confirm" class="k-button k-button-icontext k-grid-edit"/>
        <span><input type="submit" id="reprint" onclick='reprint();' value="Reprint"  class="k-button k-button-icontext k-grid-edit"/>
    <span> <input type="submit" id="release" onclick="releaseinvoice()"  value="Delete" class="k-button k-button-icontext k-grid-edit"/></span>
</span>
    </div>
    <div id="dialog-confirm" title="Confirm!" style='display:none'>
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Still have some Unchecked Invoices For this Outlet do you wish to continue!</p>
    </div>




    <!-- End of Outbound Templating   -->

    {{--<div class="wrap-toolbar-btn">--}}
    {{--<div class="row">--}}
        {{--<div class="col-sm-2">--}}
            {{--<div class="">--}}
                {{--Driver Code :--}}
            {{--</div>--}}
            {{--<label for="">Driver Code:</label>--}}
        {{--</div>--}}
        {{--<div class="col-sm-5">--}}
            {{--<div class="">--}}
                {{--<div class="input-group">--}}
                    {{--<input type="text" class="form-control" id='FilterDriverCode' placeholder="Search for..."/>--}}
                    {{--<span id="refreshDriverCode" class="input-group-addon" style="cursor:pointer">--}}
                        {{--<i class="fa fa-refresh"></i>--}}
                    {{--</span>--}}
                {{--</div>--}}


            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
{{--</br>--}}
    {{--<div id="Outboundgrid">   </div>--}}











{{--    <a href="{{ url('outbound/print_pdf&RID=' . 1 . '&Driver_code=' . 2) }}" type="button" class="btn k-button"></i>Generate Sample PDF</a>--}}
{{--    <a href="{{ url('outbound/testing') }}" type="button" class="btn k-button"></i>Generate Sample PDF</a>--}}




@endsection



