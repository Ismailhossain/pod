$(document).ready(function(){

	$("#ManualSearch").click(function () {
		$("#InvoiceFilter").val("");
		$("#ManualInvoiceFilter").val("");
		$('#ManualModal').modal('show');
	});



});


// End of DOC

function manualSearch() {

	$('#ManualModal').modal('hide');
	Scan_Outbound_Invoice();
}

//	function refresh_taskcGrid() {
//        $('#grid').data('kendoGrid').dataSource.read();
//    }

//    function refresh_taskcGrid() {
//        $('#grid').data('kendoGrid').dataSource.refresh();
//    }

function SetFocus() {
	var input = document.getElementById("FieldFilter");
	input.focus();
}
function SetFocusIn() {
	var input = document.getElementById("InvoiceFilter");
	input.focus();
}

// Truncate temp table

function truncate_driver_code() {


	// ReqUserID = $("#ReqUserID").val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var request = $.ajax({
		url: "outbound/deleteDcOut",
		type: "POST",
		// data: {
		// 	'ReqUserID': ReqUserID,
		// },
		dataType: "json"
	});

	request.done(function (msg) {
//            noty({
//                "text": msg.message,
//                "theme": "noty_theme_twitter",
//                "layout": "top",
//                "type": msg.result,
//                "animateOpen": {"height": "toggle"},
//                "animateClose": {"height": "toggle"},
//                "speed": 500,
//                "timeout": 2000,
//                "closeButton": false,
//                "closeOnSelfClick": true,
//                "closeOnSelfOver": false
//            });
//            $('#grid').data('kendoGrid').dataSource.read();
		if (msg.result == 'success') {
		}
	});

}

// End of truncate

// Start to Check Driver Code is on Process or not



// function getDriverCode(val) {
function getDriverCode() {

	// var mininput = val.length;
	//
	// if (mininput > 12 || mininput == 12) {

		var Driver_Code = $("#HiddenDC").val();

		var request =  $.ajax({
			type: 'POST',
			url: 'outbound/duplicate_dc',

			data: {

				'Driver_Code': Driver_Code

			},
			dataType: "json"

		});
		request.done(function (msg) {
			// noty({
			// 	"text": msg.message,
			// 	"theme": "noty_theme_twitter",
			// 	"layout": "top",
			// 	"type": msg.result,
			// 	"animateOpen": {"height": "toggle"},
			// 	"animateClose": {"height": "toggle"},
			// 	"speed": 500,
			// 	"timeout": 2000,
			// 	"closeButton": false,
			// 	"closeOnSelfClick": true,
			// 	"closeOnSelfOver": false
			// });
			if (msg.result == 'success') {
				driver_code(1);
			}
			if (msg.result == 'error') {

				$("#error").show();

				setTimeout("window.location.href = window.location.href;", 1500);

			}
		});
		// event.preventDefault();
	// }
}


// End Of checking Driver Code


// Start to scan outbound invoice

// function Scan_Outbound_Invoice(val) {
function Scan_Outbound_Invoice() {

	// var mininput = val.length;
	// if (mininput > 12 || mininput == 12) {

		// var Invoice_No = $("#InvoiceFilter").val();
		var ManualInvoiceFilter = $("#ManualInvoiceFilter").val();
		if(!ManualInvoiceFilter){
			var Invoice_No = $("#InvoiceFilter").val();
		}else if(ManualInvoiceFilter) {
			var Invoice_No = $("#ManualInvoiceFilter").val();
		}

		var Driver_Code = $("#HiddenDC").val();

		var request =  $.ajax({
			type: 'POST',
			url: 'outbound/sc_outbound_invoice',

			data: {
				'Invoice_No': Invoice_No,
				'Driver_Code': Driver_Code

			},
			dataType: "json"

		});

		request.done(function (msg) {
			// noty({
			// 	"text": msg.message,
			// 	"theme": "noty_theme_twitter",
			// 	"layout": "top",
			// 	"type": msg.result,
			// 	"animateOpen": {"height": "toggle"},
			// 	"animateClose": {"height": "toggle"},
			// 	"speed": 500,
			// 	"timeout": 2000,
			// 	"closeButton": false,
			// 	"closeOnSelfClick": true,
			// 	"closeOnSelfOver": false
			// });
			if (msg.result == 'success') {

//                    driver_code(Driver_Code, 2);
				$('#InvoiceFilter').val("");
				$("#ManualInvoiceFilter").val("");

//                     $("#grid").data("kendoGrid").dataSource.filter({});
				$('#grid').data('kendoGrid').dataSource.read();

			}
			if (msg.result == 'error') {

				$('#InvoiceFilter').val("");
				$("#ManualInvoiceFilter").val("");
				if (msg.Inlist == 'N') {
					alert('This Invoice is Not in the List, Please Scan Correct One!')
				}

			}
		});



//		event.preventDefault();

	// }


}


// End of scan outbound invoice


// Start to display Outbound Grid

function driver_code(Type) {
	var Driver_Code = $("#HiddenDC").val();
	var mininput = Driver_Code.length;
	if (mininput > 12 || mininput == 12) {

		// var url = url_api + '?c=get_rec_outbound_list&module=rec&dc_no=' + Driver_Code + '&Type='+ Type;
//        alert(url);

		if ($("#grid").getKendoGrid()) { //detect whether the Grid is already initialized or not
			$('#grid').data().kendoGrid.wrapper.empty();
			$('#grid').data().kendoGrid.destroy();
		}
		$("#grid").kendoGrid({

			dataSource: {
				transport: {
					read: function (options) {
						var url = 'outbound/rec_outbound_list';
						$.ajax({
							url: url,
							type: "POST",
							dataType: "json",
							data: {
								'dc_no': Driver_Code,
								'Type': Type
							},
							success: function (result) {
								noty({
									"text": result.message,
									"theme": "noty_theme_twitter",
									"layout": "top",
									"type": result.total,
									"speed": 500,
									"timeout": 2000,
									"closeButton": false,
									"closeOnSelfClick": true,
									"closeOnSelfOver": false
								});

								if (result.total > 0) {
									console.log(result.total);
									$("#DC").hide();
									$("#IN").show();
//                                        $("#DC").hide();
									$("#rprint").show();
									$("#cprint").show();
//                                        $("#srelease").show();
//                                        $('#FieldFilter').val("");
									$("#InvoiceFilter").focus();
								}
								if (result.total == 0) {
									$('#FieldFilter').val("");
									$("#grid").hide();
									$("#error1").show();
									setTimeout("window.location.href = window.location.href;", 1500);

								}

								if (result.result == 'error') {

									$('#FieldFilter').val("");
									// $("#grid").hide();
									setTimeout("window.location.href = window.location.href;", 1000);
//                                        $("#grid").hide();
//                                        $("#grid").hide(".k-loading-image");
								}
								options.success(result);

							},
							error: function (result) {


								options.error(result);


							}
						});
					},
					update: function (options) {
						var OldInvoice = $("#OldInvoice").val();
						// var url = url_api + '?&c=do_edit_out_invoice&module=rec&OldInvoice=' + OldInvoice;
						var url = 'outbound/edit_out_invoice';
						var request = $.ajax({
							url: url,
							type: "POST",
							dataType: "json",
							data: {
								models: kendo.stringify(options.data.models),
								'OldInvoice': OldInvoice,
							},
							success: function (result) {
								noty({
									"text": result.message,
									"theme": "noty_theme_twitter",
									"layout": "top",
									"type": result.result,
									"speed": 500,
									"timeout": 2000,
									"closeButton": false,
									"closeOnSelfClick": true,
									"closeOnSelfOver": false
								});
								if (result.result == 'success') {

									$('#grid').data('kendoGrid').dataSource.read();
//                                      setTimeout("window.location.href = window.location.href;", 1000);
								} else {

									// $('#grid').data('kendoGrid').dataSource.read();
								}
								options.success(result);
							},
							error: function (result) {
								options.error(result);
							}
						});
					},
				},
				batch: true,
				// type: "data",
				schema: {
					model: {
						id: "RID",
						fields: {
							RID: {type: "number", editable: false,nullable: true},
							Invoice_No: {validation: {required: true}},
							LoadedDate: { type: "date" },
							Re_Print: { type: "date" },
						}
					},
					data: "entries", total: "total"
				}
			},
			groupable: true,
			resizable: true,
			scrollable: true,
			sortable: true,
			reorderable: true,
			columnMenu: true,
			navigatable: true,
//            databound: true,
			selectable: true,
			serverFiltering: true,
//            filter: { logic: "or", filters: [ { field: "Driver_Code", operator: "contains", value: "val" } ] },

			filterable: {
				extra: false,
				operators: {
					string: {
						startswith: "Starts with",
						endswith: "Ends with",
						eq: "Is equal to",
						neq: "Is not equal to",
						contains:"contains",
						doesnotcontain:"Does not contains"
//                        gte:"Greater than or equal",
//                        lte: "less than or equal"
					}
				}
			},
//                pageable: {
//                    refresh: true,
//                    pageSizes: [10, 20, 50, 100,"All"],
//                    pageSize: 10
////                    messages: {
////                        empty: "No data"
////                    }
//                },
//                noRecords: true,
//                messages: {
//                    noRecords: "There is no data on current page"
//                },
//                error: function(e) {
//
//
//                    console.log(e.total);
//                }

			columns: [
//                  {field: "Checkbox", title: " ", width: 30, encoded: false, filterable: false, sortable: false},
				{
					field: "", title: "", width: 30,
					template: "<div id='cb'><input type='checkbox' class='checkbox' name='StockRecID[]' id='#:RID #'  value='#:RID   #' /></div>"
				},
				{ command: ["edit"], title: "Action", width: 100 },
				{field: "RID", hidden: true},
				{field: "Invoice_ID", hidden: true},
				{field: "User_ID", hidden: true},
				{field: "Scan_Status", hidden: true},
				{field: "Invoice_No", title: "Invoice No", width: 150},
				{field: "SOURCEDOC", title: "Source Document", width: 150},
				{field: "Status", title: "Status", width: 150},
				{field: "Driver_Code", title: "Driver Code", width: 150},
				{field: "Name", title: "Driver Name", width: 150},
				{field: "Assistant_Code", title: "First Assistant Code", width: 200},
				{field: "Assistant_Name", title: "First Assistant Name", width: 200},
				{field: "Assistant2_Code", title: "Second Assistant Code", width: 200},
				{field: "Assistant2_Name", title: "Second Assistant Name", width: 200},
				{field: "Vehicle_No", title: "Vehicle No", width: 150},
				{field: "Checker_No", title: "Checker No", width: 150},
				{field: "Checker_Name", title: "Checker Name", width: 150},
				{field: "ML_NO", title: "ML No", width: 150},
				{field: "OUTLET", title: "OUTLET", width: 150},
				{field: "Re_Print", title: "Re-Print", width: 150,
					filterable: {
						extra: true,
						operators: {
							date: {
								eq: "Is equal to",
								neq: "Is not equal to",
								gte: "Is after or equal to",
								gt: "Is after",
								lte: "Is before or equal to",
								lt: "Is before"
							}
						}
					},
					template: '#= kendo.toString(Re_Print, "yyyy-MM-dd hh:mm:ss")#'
				},
				{field: "LoadedDate", title: "Loaded Date", width: 150,
					filterable: {
						extra: true,
						operators: {
							date: {
								eq: "Is equal to",
								neq: "Is not equal to",
								gte: "Is after or equal to",
								gt: "Is after",
								lte: "Is before or equal to",
								lt: "Is before"
							}
						}
					},
					template: '#= kendo.toString(LoadedDate, "yyyy-MM-dd hh:mm:ss")#'
				}

			],
			editable: {
				confirmation:true,
				cancelDelete: "No",
				window: {
					width: 500
				},
				mode: "popup",
				template: kendo.template($("#template").html())
			},
			dataBound: function () {
				$("div[data-role='grid']  table td").each(function () {
					if ($(this).text() == 'Scanned') {
						$(this).closest('tr').addClass("GreenCode");
						$(this).closest('tr').removeClass("k-alt");
						$(this).closest('tr').find('input').prop('checked',true);
					}
					if ($(this).text() == 'NO') {
						$(this).closest('tr').addClass("RedCode");
					}

				});
			},
			edit: function (e) {
				get_old_invoice();
				e.container.find(".k-edit-buttons.k-state-default").css("width", "480px");
			},
			cancel: function(e) {
				$('#grid').data('kendoGrid').dataSource.read();
			}

		}).data("kendoGrid");

//            var grid = $('#grid').data('kendoGrid');
////        grid.bind("dataBound",grid_invoice_code);
//            grid.thead.find("th:first")
//                    .append($("<input name='StockRecID[]' type='checkbox' value='' id='check_all'/>"));
//            grid.thead.find("[data-field=Checkbox]>.k-header-column-menu").remove();
//
//            $("#check_all").click(function () {
//                var checked_status = this.checked;
//                $("input[name^='StockRecID']").each(function () {
//                    this.checked = checked_status;
//                });
//            });

	}




}

// Start to get the old invoice in according to change into new one

function get_old_invoice() {

	var Invoice_NoE = $("#Invoice_NoE").val();
	var OldInvoice = $("#OldInvoice").val(Invoice_NoE);
//    document.getElementById("OldInvoice").value = Invoice_NoE;
// 	var OldInvoice = $("#OldInvoice").val();
//    alert(OldInvoice);

}

//    function gridDataBound(e) {
//        var grid = e.sender;
//        if (grid.dataSource.total() == 0) {
//            var colCount = grid.columns.length;
//            $(e.sender.wrapper)
//                    .find('tbody')
//                    .append('<tr class="kendo-data-row"><td colspan="' + colCount + '" class="no-data">Sorry, No Data :(</td></tr>');
//        }
//        if (grid.dataSource.total() == 0) {
////            setInterval(function(){ myTimer() }, 1000);
//            setTimeout("window.location.href = window.location.href;", 1000);
//            $('#FieldFilter').val("");
//        }
//    }

//    function myTimer() {
//
//        document.getElementById("FieldFilter").innerHTML = '';
//    }


// End of display Outbound Grid



// Start to truncate scanned outbound invoice

function truncate_outbound_scan() {
	var request = $.ajax({
		url: "outbound/truncate_outbound_scan",
		type: "POST",
		// data: {
		// 	'ReqUserID': ReqUserID,
		// },
		dataType: "json"
	});
	request.done(function (msg) {
//            noty({
//                "text": msg.message,
//                "theme": "noty_theme_twitter",
//                "layout": "top",
//                "type": msg.result,
//                "animateOpen": {"height": "toggle"},
//                "animateClose": {"height": "toggle"},
//                "speed": 500,
//                "timeout": 2000,
//                "closeButton": false,
//                "closeOnSelfClick": true,
//                "closeOnSelfOver": false
//            });
		$('#grid').data('kendoGrid').dataSource.read();
		if (msg.result == 'success') {
			localStorage.removeItem("HiddenDC");
			$("#grid").data("kendoGrid").dataSource.filter({});
//                setTimeout("window.location.href = window.location.href;", 10000);
//                window.location.href = window.location.href;

		}
	});
	event.preventDefault();
}
// End of truncate scanned outbound invoice



// start of release status


function releaseinvoice() {
	var RID = [];


	$('#cb :checked').each(function () {
		RID.push($(this).val());

	});

	if (jQuery.isEmptyObject(RID)) {
		$("#dialog:ui-dialog").dialog("destroy");
		$("#cdialog-task-error").dialog({
			resizable: false,
			height: 200,
			modal: true,
			buttons: {
				OK: {
					text: 'OK',
					click: function () {
						$(this).dialog("close");
					}
				}
			}
		});
	}

	else {

		$(function () {
			$("#dialog:ui-dialog").dialog("destroy");
			$("#cdialog-task-updaterelease-approve").dialog({
				title: 'Please Select Reason and Confirm',
				resizable: false,
				width: 410,
				height: 200,
				modal: true,
				buttons: {
					Confirmation: {
						text: $("#p3").text(),
						click: function () {
							var Reason_ID = $("#ReasonNameD").val();
							var request =  $.ajax({
								type: 'POST',
								url: 'outbound/status_release',
								data: {
									RID: RID,
									Reason_ID: Reason_ID
								},
								dataType: "json"

							});
							request.done(function (msg) {
								noty({
									"text": msg.message,
									"theme": "noty_theme_twitter",
									"layout": "top",
									"type": msg.result,
									"animateOpen": {"height": "toggle"},
									"animateClose": {"height": "toggle"},
									"speed": 500,
									"timeout": 2000,
									"closeButton": false,
									"closeOnSelfClick": true,
									"closeOnSelfOver": false
								});
								$('#grid').data('kendoGrid').dataSource.read();
								if (msg.result == 'success') {
									$('#InvoiceFilter').val("");
									$("#grid").data("kendoGrid").dataSource.filter({});

								}else {
									truncate_outbound_scan();

								}
							});

//        event.preventDefault();
							$(this).dialog("close");
							SetFocus ();
						}

					},
					Cancel: {
						text: $("#p2").text(),
						click: function () {
							$(this).dialog("close");
						}
					}
				}
			});
		});


	}

}

// end of release status

// Download PDF of confirm invoices


function beforeconfirm(){

	var Driver_code = $("#HiddenDC").val();
//        alert(Driver_code);

//        var url = url_api + '?c=do_check_total_invoice&module=rec&Driver_code=' + Driver_code;
	var request = $.ajax({
		url: "outbound/check_total_invoice",
		type: "POST",
		data: {
			Driver_code: Driver_code
		},
		dataType: "json",
		//dataType: "text"
		success: function (result) {
//                noty({
//                    "text": result.message,
//                    "theme": "noty_theme_twitter",
//                    "layout": "top",
//                    "type": result.total,
//                    "speed": 500,
//                    "timeout": 2000,
//                    "closeButton": false,
//                    "closeOnSelfClick": true,
//                    "closeOnSelfOver": false
//                });
			if (result.result == 'error') {


				$( "#dialog-confirm" ).dialog({
					width : 400,
					height:200,
					modal: true,
					buttons: {
						"Ok": function() {
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							setTimeout("window.location.href = window.location.href;", 50);
//                                $( this ).dialog( "close" );
						}
					}
				});


//                    $.confirm({
//                        title: 'Confirm!',
//                        content: 'Still have some Unchecked Invoices For this Outlet do you wish to continue!',
//                        buttons: {
////                            confirm: function () {
////
//////                                $.alert('Confirmed!');
////                            },
//                            confirm: {
//                                btnClass: 'btn-green',
//                                action: function(){}
//                            },
//                            cancel: {
//                                btnClass: 'btn-red',
//                                action: function(){
//                                    setTimeout("window.location.href = window.location.href;", 50);
//                                }
//                            },
////                            cancel: function () {
////
////                                setTimeout("window.location.href = window.location.href;", 50);
//////                                $.alert('Canceled!');
////                            },
//
//                        }
//                    });


//                if (confirm("Still have some Unchecked Invoices For this Outlet do you wish to continue! ")) {
//                    return true;
//                }
//                else {
//                    setTimeout("window.location.href = window.location.href;", 100);
//                    return false;
//                }


			}
//                options.success(result);
		},
		error: function (result) {
//                options.error(result);
		}
	});
//        request.done(function (msg) {
////            noty({
////                "text": msg.message,
////                "theme": "noty_theme_twitter",
////                "layout": "top",
////                "type": msg.result,
////                "animateOpen": {"height": "toggle"},
////                "animateClose": {"height": "toggle"},
////                "speed": 500,
////                "timeout": 3000,
////                "closeButton": false,
////                "closeOnSelfClick": true,
////                "closeOnSelfOver": false
////            });
//            if (msg.result == 'success') {
//
//            }
//            if (msg.result == 'error') {
//
////                if (confirm("Still have some Unchecked Invoices For this Outlet do you wish to continue! ")) {
////                    return true;
////                }
////                else {
////                    setTimeout("window.location.href = window.location.href;", 100);
////                    return false;
////                }
//            }
//        });

}


function confirmprint() {



	var RID = [];
	var Driver_code = $("#HiddenDC").val();
	var Reprint = 'N';
	//       alert(Driver_code);
	$('#cb :checked').each(function () {
		RID.push($(this).val());
	});

	if (jQuery.isEmptyObject(RID)) {
		$("#dialog:ui-dialog").dialog("destroy");
		$("#cdialog-task-error").dialog({
			resizable: false,
			height: 200,
			modal: true,
			buttons: {
				OK: {
					text: 'OK',
					click: function () {
						$(this).dialog("close");
					}
				}
			}
		});
	} else {
		$(function () {

			beforeconfirm();

			$("#dialog:ui-dialog").dialog("destroy");
			$("#cdialog-task-confirm-approve").dialog({
				resizable: false,
				height: 200,
				modal: true,
				buttons: {
					Confirmation: {
						text: $("#p3").text(),
						click: function () {
							var request = $.ajax({
								url: "outbound/update_outbound",
								type: "POST",
								data: {
									RID: RID,
									Driver_code: Driver_code
								},
								dataType: "json",
								//dataType: "text"
							});

							request.done(function (msg) {
								noty({
									"text": msg.message,
									"theme": "noty_theme_twitter",
									"layout": "top",
									"type": msg.result,
									"animateOpen": {"height": "toggle"},
									"animateClose": {"height": "toggle"},
									"speed": 500,
									"timeout": 2000,
									"closeButton": false,
									"closeOnSelfClick": true,
									"closeOnSelfOver": false
								});

								$('#check_all').prop('checked', false);
								$('#grid').data('kendoGrid').dataSource.read();
								if (msg.result === 'success') {
									mergerRID = RID.toString();
									mergerDC = Driver_code.toString();
									mergerRGP = Reprint.toString();
//                                        $('#FieldFilter').val("");
									localStorage.removeItem("HiddenDC");
									$.colorbox({
										iframe: true,
										innerWidth: "90%",
										innerHeight: "90%",
										href: 'outbound/print_pdf/' + mergerRID + '/' + mergerDC + '/' + mergerRGP
									});
									truncate_outbound_scan();
								} else {
									truncate_outbound_scan();
								}
							});
							$(this).dialog("close");
							$('#FieldFilter').val("");
							$("#grid").data("kendoGrid").dataSource.filter({});
						}

					},
					Cancel: {
						text: $("#p2").text(),
						click: function () {
							$(this).dialog("close");
						}
					}
				}
			});
		});
	}


}

// End of Download PDF of confirm invoices

// reprint PDF of confirm invoices

function reprint() {

	var RID = [];

	var Driver_code = $("#HiddenDC").val();
	var Reprint = 'Y';
	$('#cb :checked').each(function () {
		RID.push($(this).val());
	});

	if (jQuery.isEmptyObject(RID)) {
		$("#dialog:ui-dialog").dialog("destroy");
		$("#cdialog-task-error").dialog({
			resizable: false,
			height: 200,
			modal: true,
			buttons: {
				OK: {
					text: 'OK',
					click: function () {
						$(this).dialog("close");
					}
				}
			}
		});
	}

	else {
		$(function () {
			$("#dialog:ui-dialog").dialog("destroy");
			$("#cdialog-task-confirm-approve").dialog({
				resizable: false,
				height: 200,
				modal: true,
				buttons: {
					Confirmation: {
						text: $("#p3").text(),
						click: function () {
							var request = $.ajax({
								url: "outbound/update_outbound_reprint",
								type: "POST",
								data: {
									RID: RID,
									Driver_code: Driver_code,
									Reprint: Reprint,
								},
								dataType: "json"
								//dataType: "text"
							});

							request.done(function (msg) {
								noty({
									"text": msg.message,
									"theme": "noty_theme_twitter",
									"layout": "top",
									"type": msg.result,
									"animateOpen": {"height": "toggle"},
									"animateClose": {"height": "toggle"},
									"speed": 500,
									"timeout": 2000,
									"closeButton": false,
									"closeOnSelfClick": true,
									"closeOnSelfOver": false
								});


								$('#check_all').prop('checked', false);
								$('#grid').data('kendoGrid').dataSource.read();

								if (msg.result === 'success') {
									mergerRID = RID.toString();
									mergerDC = Driver_code.toString();
									mergerRGP = Reprint.toString();
//                                        mergerIN = Invoice_No.toString();
									$.colorbox({
										iframe: true,
										innerWidth: "90%",
										innerHeight: "90%",
										href: 'outbound/print_pdf/' + mergerRID + '/' + mergerDC + '/' + mergerRGP
									});
									truncate_outbound_scan();
								}else {
									truncate_outbound_scan();
								}
							});
							$(this).dialog("close");
							$('#FieldFilter').val("");
							$("#grid").data("kendoGrid").dataSource.filter({});
							SetFocus ();
						}
					},
					Cancel: {
						text: $("#p2").text(),
						click: function () {
							$(this).dialog("close");
						}

					}

				}
			});
		});
	}


}


// End reprint PDF of confirm invoices