$(document).ready(function(){

    // $(window).bind('unload', function(){

        // alert(1);
        // $.ajax({
        //     type: 'get',
        //     async: false,
        //     url: 'role/logout'
        //
        // });
    // });

    $("#close_modal").click(function () {

        // $("#refreshbody").load(location.href + " #refreshbody>*", "");
        $('#NewRoleSave').trigger("reset");
    });


        $("#insertRole").click(function () {

        $('#ModalRole').modal('show');
        $('#clear_modal').remove();
        $('#save_role_data').remove();
        $('#cancel_update_button').remove();
        $('#update_button').remove();

        $('#close_modal').after("<input type='reset' id='clear_modal' onclick='' class='btn btn-default' value='Clear'/><input type='button' id='save_role_data' onclick='NewRoleSave();' class='btn btn-default' value='Save'/>");

        // document.getElementById("update_button").style.visibility = "hidden";
        // document.getElementById("save_role_data").style.visibility = "visible";

        // let element = document.getElementById("update_button");
        // let updateElement = element.outerHTML = "<input type='submit' id='save_role_data'  class='btn btn-default' value='Save'/>";
        // element.style.visibility = 'hidden';
        // document.getElementById("save_role_data").innerText = 'Save';
        // document.getElementById("cancel_role_edit").innerText = 'Clear';
        // $("#save_role_data").attr("onclick","");
        // $("#cancel_role_edit").attr("onclick","");
        // document.getElementById("NewRoleSave").reset();
        // $(".for_edit_role").attr("id","NewRoleSave");
        $('#NewRoleSave').trigger("reset");
        // $('#NewRoleSave').reset();
        // $(".containerRoleAdd").show();
        // $("#refreshbody").load(location.href + " #refreshbody>*", "");

        // FocusRoleName();
        var input = document.getElementById("name");
        input.focus();

    });

    // $("#resetRole").click(function () {
    //     document.getElementById("NewRoleSave").reset();
    // });

// $( "#NewRoleSave" ).submit(function( event ) {
//     // $("form[id='NewRoleSave']").submit(function (event) {
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


function showLoading(e) {
    kendo.ui.progress("#RoleGrid", true);
}


    function roleDetails() {

        //detect whether the Grid is already initialized or not

        if ($("#RoleGrid").getKendoGrid()) {
            $('#RoleGrid').data().kendoGrid.wrapper.empty();
            $('#RoleGrid').data().kendoGrid.destroy();
        }



        $("#RoleGrid").kendoGrid({
            dataSource: {
                transport: {
                    read: function (options) {
                        var url = 'role/details';
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
                                    // console.log(result.total);

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
                    data: "roles" , total: "total"
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
                    template: "<div id='cbRole'><input type='checkbox' class='checkbox' name='RoleID[]' id='#:id #'  value='#:id   #' /></div>"
                },

                {field: "id", hidden: true},
                {field: "name", title: "Name",
                    // template: '<a href="\\#" class="linkRole"  >#= name #</a>'
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

        var RoleGrid = $('#RoleGrid').data('kendoGrid');
        RoleGrid.thead.find("th:first")
            .append($("<input name='RoleID[]' type='checkbox' value='' id='check_all_role'/>"));
        RoleGrid.thead.find("[data-field=Checkbox]>.k-header-column-menu").remove();

        $("#check_all_role").click(function () {
            var checked_status = this.checked;
            $("input[name^='RoleID']").each(function () {
                this.checked = checked_status;
            });
        });

        // RoleGrid.table.on('click', '.linkRole', function(e) {
        //     showRoleDetails.call(RoleGrid, e);
        // });

    }

// function showRoleDetails(e){
//     var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
//     var testing = dataItem.id;
//     alert(testing);
// }

// $('div.hidemsg').delay(3000).slideUp(300);
// $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

function FocusRoleName() {
    var input = document.getElementById("name");
    input.focus();
}

function NewRoleSave() {


    // $("form[id='NewRoleSave']").submit(function (event) {
    event.preventDefault();


    var chkArray = [];
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#PermissionCheckboxList input:checked").each(function() {
        chkArray.push($(this).val());
    });
    /* we join the array separated by the comma */
    // var selected;
    // selected = chkArray.join(',') ;
    // console.log(chkArray);

    Role_name = $("#name").val();
    Role_slug = $("#slug").val();
    Permission = chkArray;
    // alert(Role_name);
    // alert(Role_slug);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var request =  $.ajax({
        type: 'post',
        url: 'role/store',
        //	 data:   $('#NewRoleSave').serialize(),
        data: {
            // '_token': _token,
            'name': Role_name,
            'slug': Role_slug,
            'permission': Permission,
        },
        dataType: "json"
        // success: function( data ){
        //     console.log(data);
        //     location.reload();
        //     $('#RoleAddModal').modal('hide');
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
            $('#ModalRole').modal('hide');
            $("#refreshbody").load(location.href + " #refreshbody>*", "");
            $('#RoleGrid').data('kendoGrid').dataSource.read();
            // $('body').removeClass('modal-open');
            // $(".containerRoleAdd").hide();
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
            // $('#ModalRole').modal('hide');
        }
    });



    event.preventDefault();

}


function edit_role(id) {

    $('#role_edit_value').val('');
    $('#ModalRole').modal('show');
    // $("#refreshmodal").load(location.href + " #refreshmodal>*", "");

    let val = $('#role_edit_value').val();
    if(!val) {

        if(id !== '') {

        $('#role_edit_value').val(1);

            // let element = document.getElementById("role_row_"+id);
            // element.parentNode.removeChild(element);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'

                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'role/edit',
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

                    // console.log(response.dataRolePermissions);


                    document.getElementById("name").value = response.dataRole.name;
                    document.getElementById("slug").value = response.dataRole.slug;

                    for (var i = 0; i < response.dataRolePermissions.length; i++) {
                        document.getElementById("permission_name_" + response.dataRolePermissions[i].permission_id).checked = true;
                        // $("#permission_name_" + response.dataRolePermissions[i].permission_id).prop('checked', true);
                    }
                    $('#role_edit_value').val('');


                    $('#clear_modal').remove();
                    $('#save_role_data').remove();
                    $('#cancel_update_button').remove();
                    $('#update_button').remove();
                    $('#close_modal').after("<input type='button' id='cancel_update_button' onclick='cancel_role_update("+id+")' class='btn btn-default' value='Cancel'/><input type='button' id='update_button' onclick='update_role("+id+")' class='btn btn-default' value='Update'/>");


                    // let element = document.getElementById("save_role_data");
                    // let updateElement = element.outerHTML = "<input type='button' id='update_button' onclick='update_role("+id+")' class='btn btn-default' value='Update'/>";
                    // element.style.visibility = 'hidden';

                    // document.getElementById("save_role_data").innerText = 'Update';
                    // document.getElementById("cancel_role_edit").innerText = 'Cancel';
                    // $("#save_role_data").attr("onclick","update_role("+id+")");
                    // $("#cancel_role_edit").attr("onclick","cancel_role_update("+id+")");
                    // document.getElementById("NewRoleSave").action = '';
                    // $(".for_edit_role").attr("id","");



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


function cancel_role_update(id) {
    // $("#NewRoleSave").attr("id","NewRoleSave");
    // $(".for_edit_role").attr("id","NewRoleSave");
    $('#NewRoleSave').trigger("reset");
    $('#ModalRole').modal('hide');
    $("#refreshbody").load(location.href + " #refreshbody>*", "");
}




function update_role(id) {


        if(id !== '') {

            var chkArray = [];
            /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
            $("#PermissionCheckboxList input:checked").each(function() {
                chkArray.push($(this).val());
            });
            /* we join the array separated by the comma */
            // var selected;
            // selected = chkArray.join(',') ;
            // console.log(selected);

            Role_name = $("#name").val();
            Role_slug = $("#slug").val();
            Permission = chkArray;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'
                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'role/update',
                data: {
                    // '_token': _token,
                    'id': id,
                    'name': Role_name,
                    'slug': Role_slug,
                    'permission': Permission,
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
                    $('#ModalRole').modal('hide');
                    $('#role_edit_value').val('');
                    $("#refreshbody").load(location.href + " #refreshbody>*", "");
                    $('#NewRoleSave').trigger("reset");
                }
                if (response.result == 'error') {
                    $('#role_edit_value').val('');

                }
            });

            // event.preventDefault();

        }

}


function delete_role(id) {


    if (confirm('Are you sure you want to Delete this role?')) {

        if(id !== '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'

                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'role/destroy',
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

                    $('#role_edit_value').val('');
                    $("#refreshbody").load(location.href + " #refreshbody>*", "");
                }
                if (response.result == 'error') {
                    $('#role_edit_value').val('');

                }
            });

            // event.preventDefault();

        }


    } else {
        $('#role_edit_value').val('');
    }

}








