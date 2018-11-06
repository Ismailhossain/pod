$(document).ready(function(){

    // $(window).bind('unload', function(){

    // alert(1);
    // $.ajax({
    //     type: 'get',
    //     async: false,
    //     url: 'permission/logout'
    //
    // });
    // });



    $("#insertPermission").click(function () {

        $('#ModalPermission').modal('show');
        // document.getElementById("NewPermissionSave").reset();

        $('#clear_modal').remove();
        $('#save_permission_data').remove();
        $('#cancel_update_button').remove();
        $('#update_button').remove();

        $('#close_modal').after("<input type='reset' id='clear_modal' onclick='' class='btn btn-default' value='Clear'/><input type='button' id='save_permission_data' onclick='NewPermissionSave();' class='btn btn-default' value='Save'/>");



        $('#NewPermissionSave').trigger("reset");
        // $('#NewPermissionSave').reset();
        // $(".containerPermissionAdd").show();
        // $("#refreshbody").load(location.href + " #refreshbody>*", "");

        // FocusPermissionName();
        var input = document.getElementById("name");
        input.focus();

    });

    // $("#resetPermission").click(function () {
    //     document.getElementById("NewPermissionSave").reset();
    // });

    // $( "#NewPermissionSave").submit(function( event ) {
    //     // $("form[id='NewPermissionSave']").submit(function (event) {
    //
    //
    //
    // });








});


// End of DOC

function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}

function NewPermissionSave() {

    Permission_name = $("#name").val();
    Permission_slug = $("#slug").val();
    // alert(Permission_name);
    // alert(Permission_slug);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var request =  $.ajax({
        type: 'post',
        url: 'permission/store',
        //	 data:   $('#NewPermissionSave').serialize(),
        data: {
            // '_token': _token,
            'name': Permission_name,
            'slug': Permission_slug
        },
        dataType: "json"
        // success: function( data ){
        //     console.log(data);
        //     location.reload();
        //     $('#PermissionAddModal').modal('hide');
        //     $('div.alert alert- alert-dismissable').delay(3000).slideUp(300);
        //
        // },
        // error: function( data ){
        //     var parsedJson = jQuery.parseJSON(response);
        // }
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
        if (msg.result == 'success') {
            $('#ModalPermission').modal('hide');
            $("#refreshbody").load(location.href + " #refreshbody>*", "");
            $('#PermissionGrid').data('kendoGrid').dataSource.read();
            // $('body').removeClass('modal-open');
            // $(".containerPermissionAdd").hide();
            // setTimeout(window.location.reload.bind(window.location), 1500);
            // $('div.alert alert- alert-dismissable').delay(3000).slideUp(300);
        }
        if (msg.result == 'error') {



            // $('.alert-danger').html(JSON.stringify(msg.errors));

            // // show the element you want to show
            // // $("#ModalValidation").show();
            // $('#ModalValidation').modal('show');
            // // Set a timeout to hide the element again
            // setTimeout(function(){
            //     // $("#ModalValidation").hide();
            //     $('#ModalValidation').modal('hide');
            // }, 3000);
            // printErrorMsg(response.responseJSON.error);
            // $('#ModalPermission').modal('hide');
        }
    });



    event.preventDefault();

}




function showLoading(e) {
    kendo.ui.progress("#PermissionGrid", true);
}


function permissionDetails() {

    //detect whether the Grid is already initialized or not

    if ($("#PermissionGrid").getKendoGrid()) {
        $('#PermissionGrid').data().kendoGrid.wrapper.empty();
        $('#PermissionGrid').data().kendoGrid.destroy();
    }



    $("#PermissionGrid").kendoGrid({
        dataSource: {
            transport: {
                read: function (options) {
                    var url = 'permission/details';
                    // $.ajaxSetup({
                    //     headers: {
                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //     }
                    // });
                    var request = $.ajax({
                        type: 'get',
                        url: url,
                        dataType: "json", // "jsonp" is required for cross-domain requests; use "json" for same-domain requests
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

                            }

                            if (result.result == 'error') {


                            }
                            options.success(result);

                        },
                        error: function (result) {
                            options.error(result);
                        }
                    });

                }
            },

            // type: "data",
            // dataType: "json",
//                transport: {read: url},
            schema: {
                data: "permissions" , total: "total"
            }

        },
        groupable: true,
        resizable: true,
        scrollable: true,
        sortable: true,
        reorderable: true,
        columnMenu: true,
        // selectable: true,
        navigatable: true,
//            databound: true,
//            serverFiltering: true,
//            filter: { logic: "or", filters: [ { field: "Driver_Code", operator: "contains", value: "val" } ] },

        filterable: {
            extra: false
        },
        pageable: {
            refresh: true,
            pageSizes: [10, 20, 50, 100],
            pageSize: 10
        },
//                pageable: {refresh: true, pageSizes: [10, 20, 50, 100], pageSize: 10},

        columns: [
//                  {field: "Checkbox", title: " ", width: 30, encoded: false, filterable: false, sortable: false},
            {
                field: "", title: "",
                template: "<div id='cbPermission'><input type='checkbox' class='checkbox' name='PermissionID[]' id='#:id #'  value='#:id   #' /></div>"
            },

            {field: "id", hidden: true},
            {field: "name", title: "Name",
                // template: '<a href="\\#" class="linkPermission"  >#= name #</a>'
            },
            // {field: "label", title: "Label", width: 150},
            {field: "slug", title: "Slug"},
//              {field: "slug", title: "Team", width: 100,
//                    template: "# if (slug == null) { #" +
//                    "<span data-content=' '>Not Assigned</span>" +
//                    "# } else { #" +
//                    "<span data-content='#: slug#'>#=slug#</span>" +
//                    "# } #"
//              },
            { command: ["edit", "destroy"], title: "Action" },
        ],
        editable: {
            confirmation:true,
            cancelDelete: "No",
            mode: "popup",
            template: kendo.template($("#template").html())
        },

    }).data("kendoGrid");

    var PermissionGrid = $('#PermissionGrid').data('kendoGrid');
    PermissionGrid.thead.find("th:first")
        .append($("<input name='PermissionID[]' type='checkbox' value='' id='check_all_permission'/>"));
    PermissionGrid.thead.find("[data-field=Checkbox]>.k-header-column-menu").remove();

    $("#check_all_permission").click(function () {
        var checked_status = this.checked;
        $("input[name^='PermissionID']").each(function () {
            this.checked = checked_status;
        });
    });

    // PermissionGrid.table.on('click', '.linkPermission', function(e) {
    //     showPermissionDetails.call(PermissionGrid, e);
    // });

}

// function showPermissionDetails(e){
//     var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
//     var testing = dataItem.id;
//     alert(testing);
// }

// $('div.hidemsg').delay(3000).slideUp(300);
// $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

function FocusPermissionName() {
    var input = document.getElementById("name");
    input.focus();
}


function edit_permission(id) {

    $('#permission_edit_value').val('');
    $('#ModalPermission').modal('show');
    // $("#refreshmodal").load(location.href + " #refreshmodal>*", "");

    let val = $('#permission_edit_value').val();
    if(!val) {

        if(id !== '') {

            $('#permission_edit_value').val(1);

            // let element = document.getElementById("permission_row_"+id);
            // element.parentNode.removeChild(element);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'

                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'permission/edit',
                data: {
                    // '_token': _token,
                    'id': id,

                },
                // data: formData,
                // data: $('#NewUserSave').serialize(), // Remember that you need to have your csrf token included
                dataType: "json"
            });
            request.done(function (response) {
                noty({
                    "text": response.message,
                    "theme": "noty_theme_twitter",
                    "layout": "top",
                    "type": response.result,
                    "animateOpen": {"height": "toggle"},
                    "animateClose": {"height": "toggle"},
                    "speed": 500,
                    "timeout": 2000,
                    "closeButton": false,
                    "closeOnSelfClick": true,
                    "closeOnSelfOver": false
                });
                if (response.result == 'success') {


                    document.getElementById("name").value = response.dataPermission.name;
                    document.getElementById("slug").value = response.dataPermission.slug;


                    $('#permission_edit_value').val('');


                    $('#clear_modal').remove();
                    $('#save_permission_data').remove();
                    $('#cancel_update_button').remove();
                    $('#update_button').remove();
                    $('#close_modal').after("<input type='button' id='cancel_update_button' onclick='cancel_permission_update("+id+")' class='btn btn-default' value='Cancel'/><input type='button' id='update_button' onclick='update_permission("+id+")' class='btn btn-default' value='Update'/>");


                    // let element = document.getElementById("save_permission_data");
                    // let updateElement = element.outerHTML = "<input type='button' id='update_button' onclick='update_permission("+id+")' class='btn btn-default' value='Update'/>";
                    // element.style.visibility = 'hidden';

                    // document.getElementById("save_permission_data").innerText = 'Update';
                    // document.getElementById("cancel_permission_edit").innerText = 'Cancel';
                    // $("#save_permission_data").attr("onclick","update_permission("+id+")");
                    // $("#cancel_permission_edit").attr("onclick","cancel_permission_update("+id+")");
                    // document.getElementById("NewPermissionSave").action = '';
                    // $(".for_edit_permission").attr("id","");



                    // setTimeout(window.location.reload.bind(window.location), 1500);
                    // $('div.alert alert- alert-dismissable').delay(3000).slideUp(300);
                }
                if (response.result == 'error') {

                    // // show the element you want to show
                    // $('#ModalValidation').modal('show');
                    // // Set a timeout to hide the element again
                    // setTimeout(function(){
                    //     // $("#ModalValidation").hide();
                    //     $('#ModalValidation').modal('hide');
                    // }, 3000);

                }
            });

            // event.preventDefault();

        }


    }
    else {
        alert("You are already Editing one User");
        return;

    }

}


function cancel_permission_update(id) {
    // $("#NewPermissionSave").attr("id","NewPermissionSave");
    // $(".for_edit_permission").attr("id","NewPermissionSave");
    $('#NewPermissionSave').trigger("reset");
    $('#ModalPermission').modal('hide');
    $("#refreshbody").load(location.href + " #refreshbody>*", "");
}


function update_permission(id) {


    if(id !== '') {



        Role_name = $("#name").val();
        Role_slug = $("#slug").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                // 'Content-type': 'text/html;charset=ISO-8859-1'
            }
        });
        var request =  $.ajax({
            type: 'post',
            url: 'permission/update',
            data: {
                // '_token': _token,
                'id': id,
                'name': Role_name,
                'slug': Role_slug,
            },
            dataType: "json"
        });
        request.done(function (response) {
            noty({
                "text": response.message,
                "theme": "noty_theme_twitter",
                "layout": "top",
                "type": response.result,
                "animateOpen": {"height": "toggle"},
                "animateClose": {"height": "toggle"},
                "speed": 500,
                "timeout": 2000,
                "closeButton": false,
                "closeOnSelfClick": true,
                "closeOnSelfOver": false
            });
            if (response.result == 'success') {

                // $("#NewRoleSave").attr("id","NewRoleSave");

                $('#ModalPermission').modal('hide');
                $('#permission_edit_value').val('');
                $("#refreshbody").load(location.href + " #refreshbody>*", "");
                $('#NewPermissionSave').trigger("reset");

            }
            if (response.result == 'error') {
                $('#permission_edit_value').val('');

            }
        });

        // event.preventDefault();

    }

}

function delete_permission(id) {


    if (confirm('Are you sure you want to Delete this permission?')) {

        if(id !== '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'

                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'permission/destroy',
                data: {
                    // '_token': _token,
                    'id': id,
                },
                dataType: "json"
            });
            request.done(function (response) {
                noty({
                    "text": response.message,
                    "theme": "noty_theme_twitter",
                    "layout": "top",
                    "type": response.result,
                    "animateOpen": {"height": "toggle"},
                    "animateClose": {"height": "toggle"},
                    "speed": 500,
                    "timeout": 2000,
                    "closeButton": false,
                    "closeOnSelfClick": true,
                    "closeOnSelfOver": false
                });
                if (response.result == 'success') {

                    $('#permission_edit_value').val('');
                    $("#refreshbody").load(location.href + " #refreshbody>*", "");
                }
                if (response.result == 'error') {
                    $('#permission_edit_value').val('');

                }
            });

            // event.preventDefault();

        }


    } else {
        $('#permission_edit_value').val('');
    }

}















