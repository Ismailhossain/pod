$(document).ready(function(){

    // $('#ModalUser').on('hidden.bs.modal', function () {
    //     $("#refreshbody").load(location.href + " #refreshbody>*", "");
    // });
    // $('div.alert alert-info').delay(3000).slideUp(300);
    $("#close_modal").click(function () {

        $('#NewUserSave').trigger("reset");
        $('#user_edit_value').val('');
        $("#refreshbody").load(location.href + " #refreshbody>*", "");

    });
    $("#insertUser").click(function () {

        $('#ModalUser').modal('show');
        $("#hide_password").show();
        $("#hide_password_confirmation").show();
        // document.getElementById("NewUserSave").reset();
        // $('#UserDataSave').trigger("reset");
        $('#NewUserSave').trigger("reset");

        $('#clear_modal').remove();
        $('#save_user_data').remove();
        $('#cancel_update_button').remove();
        $('#update_button').remove();

        $('#close_modal').after("<input type='reset' id='clear_modal' onclick='' class='btn btn-default' value='Clear'/><input type='button' id='save_user_data' onclick='NewUserSave();' class='btn btn-default' value='Save'/>");


        // document.getElementById("save_user_data").innerText = 'Save';
        // document.getElementById("cancel_user_edit").innerText = 'Clear';
        // // $("#save_user_data").attr("onclick","update_user_data("+id+")");
        // $("#cancel_user_edit").attr("onclick","");
        // // document.getElementById("UserDataSave").action = 'user/store';


        // $(".containerUserAdd").show();
        // $("#refreshbody").load(location.href + " #refreshbody>*", "");

        // FocusUserName();
        var input = document.getElementById("name");
        input.focus();

        $('#no_image_added1').remove();
        $('#my_user_image_url').remove();
        // $("#RefreshUserFile").load(location.href + " #RefreshUserFile>*", "");


    });

    // $( "#NewUserSave").submit(function( event ) {
    //     // $("form[id='NewUserSave']").submit(function (event) {
    // });


    $("#user_image").change(function () {
        $('#no_image_added1').remove();
        $('#my_user_image_url').remove();
        filePreview_user_image(this);
    });


});

// End of doc

function filePreview_user_image(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#user_image + img').remove();
            // $('#user_image').after('<img src="'+e.target.result+'" width="60" height="60" id="my_user_image_url" />');
            // $('#user_image_url').remove();
            document.getElementById("user_image_url").innerHTML = "<img style='width:60px;height:60px' src="+e.target.result+" id='my_user_image_url' />";

            // $('#desc_image + embed').remove();
            // $('#desc_image').after('<embed src="'+e.target.result+'" width="100" height="100">');
        }
        reader.readAsDataURL(input.files[0]);
    }
}


// Adding User

function NewUserSave() {
    let name = document.getElementById('name').value;
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let status_id = document.getElementById('status_id').value;
    // let role_name = document.getElementById('role_name').value;
    var role_name = $("#role_name").val();
    let password = document.getElementById('password').value;
    let password_confirmation = document.getElementById('password_confirmation').value;
    let file = document.getElementById('user_image');
    let files = file.files;
    // console.log(role_name);

    // var name = $("#name").val();
    // var username = $("#username").val();
    // var email = $("#email").val();
    // var status_id = $("#status_id").val();
    // var role_name = $("#role_name").val();
    // var password = $("#password").val();
    // var password_confirmation = $("#password_confirmation").val();
    // var user_image = $("#user_image").val();

    let formData = new FormData();
    formData.append('name', name);
    formData.append('username', username);
    formData.append('email', email);
    formData.append('status_id', status_id);
    formData.append('role_name', role_name);
    formData.append('password', password);
    formData.append('password_confirmation', password_confirmation);
    formData.append('user_image', files[0]);
    // console.log(files[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // 'Content-type': 'multipart/form-data'
        }
    });
    var request =  $.ajax({
        type: 'post',
        url: 'user/store',
        processData: false,
        contentType: false,
        headers: {

            // 'Content-Type':'multipart/form-data'
        },
        // data: {
        //     // '_token': _token,
        //     'name': name,
        //     'username': username,
        //     'email': email,
        //     'status_id': status_id,
        //     'role_name': role_name,
        //     'password': password,
        //     'password_confirmation': password_confirmation,
        //     'user_image': user_image,
        // },
        data : formData,
        // data: $('#NewUserSave').serialize(), // Remember that you need to have your csrf token included
        dataType: "json"
        // success: function( data ){
        //     console.log(data);
        //     location.reload();
        //     $('#UserAddModal').modal('hide');
        //     $('div.alert alert- alert-dismissable').delay(3000).slideUp(300);
        //
        // },
        // error: function( data ){
        //     var parsedJson = jQuery.parseJSON(response);
        // }
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
            $('#ModalUser').modal('hide');
            $('#user_edit_value').val('');
            $("#refreshbody").load(location.href + " #refreshbody>*", "");
            // $('#UserGrid').data('kendoGrid').dataSource.read();


            // $('body').removeClass('modal-open');
            // $(".containerUserAdd").hide();
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

    event.preventDefault();
}


// Edit User

function edit_user(id) {

    $("#hide_password").hide();
    $("#hide_password_confirmation").hide();
    // $('#no_image_added1 + img').remove();
    $('#my_user_image_url').remove();
    $('#ModalUser').modal('show');
    // document.getElementById("NewUserSave").reset();
    // $('#NewUserSave').trigger("reset");
    let val = $('#user_edit_value').val();
    if(!val) {
        if(id !== '') {

        $('#user_edit_value').val(1);

            // let element = document.getElementById("user_row_"+id);
            // element.parentNode.removeChild(element);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-type': 'text/html;charset=ISO-8859-1'

                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'user/edit',
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

                    // console.log(response.dataUserRoles);



                        let all_image_url = $('#all_image_url').val();

                        if(response.dataUser.image !== ""){
                            user_image_url = all_image_url + '/images/' + response.dataUser.image ;
                            // $("#my_user_image_url").attr("src",user_image_url);
                            document.getElementById("user_image_url").innerHTML = "<img style='width:60px;height: 60px' src="+ user_image_url +" id='my_user_image_url' />";

                        }else {
                            $("#no_image_added1").html("No image added previously");
                        }

                    // if (response.dataUser.status == 1) {
                    //     document.getElementById("status_id").selected = 1;
                    // }else {
                    //     document.getElementById("status_id").selected = 0;
                    // }

                    document.getElementById("hidden_user_id").value = response.dataUser.id;
                    document.getElementById("name").value = response.dataUser.name;
                    document.getElementById("username").value = response.dataUser.username;
                    document.getElementById("email").value = response.dataUser.email;
                    document.getElementById("hidden_user_image").value = response.dataUser.image;

                    document.querySelector('#status_id [value="' + response.dataUser.status + '"]').selected = true;
                    for (var i = 0; i < response.dataUserRoles.length; i++) {
                        document.querySelector('#role_name [value="' + response.dataUserRoles[i].role_id + '"]').selected = true;
                    }


                    // $('#my_user_image_url').remove();

                    $('#clear_modal').remove();
                    $('#save_user_data').remove();
                    $('#cancel_update_button').remove();
                    $('#update_button').remove();
                    $('#close_modal').after("<input type='button' id='cancel_update_button' onclick='cancel_user_update("+id+")' class='btn btn-default' value='Cancel'/><input type='button' id='update_button' onclick='update_user("+id+")' class='btn btn-default' value='Update'/>");





                        // document.getElementById("save_user_data").innerText = 'Update';
                        // document.getElementById("cancel_user_edit").innerText = 'Cancel';
                        // // $("#save_user_data").attr("onclick","update_user_data("+id+")");
                        // $("#cancel_user_edit").attr("onclick","cancel_user_update("+id+")");
                        // document.getElementById("UserDataSave").action = 'user/update';
                        // //$('#ModalComponent').scrollTop(0);
                        // document.body.scrollTop = 0; // For Safari
                        // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera


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


function update_user(id) {

    if(id !== '') {

        let name = document.getElementById('name').value;
        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let status_id = document.getElementById('status_id').value;
        // let role_name = document.getElementById('role_name').value;
        var role_name = $("#role_name").val();
        // let password = document.getElementById('password').value;
        // let password_confirmation = document.getElementById('password_confirmation').value;
        let hidden_user_image = document.getElementById('hidden_user_image').value;
        let file = document.getElementById('user_image');
        let files = file.files;
        // console.log(role_name);
        // var name = $("#name").val();
        // var username = $("#username").val();
        // var email = $("#email").val();
        // var status_id = $("#status_id").val();
        // var role_name = $("#role_name").val();
        // var password = $("#password").val();
        // var password_confirmation = $("#password_confirmation").val();
        // var user_image = $("#user_image").val();

        let formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('username', username);
        formData.append('email', email);
        formData.append('status_id', status_id);
        formData.append('role_name', role_name);
        formData.append('hidden_user_image', hidden_user_image);
        // formData.append('password', password);
        // formData.append('password_confirmation', password_confirmation);
        formData.append('user_image', files[0]);
        // console.log(files[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                // 'Content-type': 'multipart/form-data'
            }
        });
        var request =  $.ajax({
            type: 'post',
            url: 'user/update',
            processData: false,
            contentType: false,
            headers: {

                // 'Content-Type':'multipart/form-data'
            },
            // data: {
            //     // '_token': _token,
            //     'name': name,
            //     'username': username,
            //     'email': email,
            //     'status_id': status_id,
            //     'role_name': role_name,
            //     'password': password,
            //     'password_confirmation': password_confirmation,
            //     'user_image': user_image,
            // },
            data : formData,
            // data: $('#NewUserSave').serialize(), // Remember that you need to have your csrf token included
            dataType: "json"
            // success: function( data ){
            //     console.log(data);
            //     location.reload();
            //     $('#UserAddModal').modal('hide');
            //     $('div.alert alert- alert-dismissable').delay(3000).slideUp(300);
            //
            // },
            // error: function( data ){
            //     var parsedJson = jQuery.parseJSON(response);
            // }
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
                $('#ModalUser').modal('hide');
                $("#refreshbody").load(location.href + " #refreshbody>*", "");
                // $('#UserGrid').data('kendoGrid').dataSource.read();
                $('#user_edit_value').val('');
                $('#NewUserSave').trigger("reset");


                // $('body').removeClass('modal-open');
                // $(".containerUserAdd").hide();
                // setTimeout(window.location.reload.bind(window.location), 1500);
                // $('div.alert alert- alert-dismissable').delay(3000).slideUp(300);
            }
            if (response.result == 'error') {

                $('#user_edit_value').val('');

                // // show the element you want to show
                // $('#ModalValidation').modal('show');
                // // Set a timeout to hide the element again
                // setTimeout(function(){
                //     // $("#ModalValidation").hide();
                //     $('#ModalValidation').modal('hide');
                // }, 3000);

            }
        });


    }

}

function cancel_user_update(id) {

    $('#ModalUser').modal('hide');
    $('#user_edit_value').val('');
    $("#refreshbody").load(location.href + " #refreshbody>*", "");
}


function delete_user(id) {


        if (confirm('Are you sure you want to Delete this user?')) {

        if(id !== '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            var request =  $.ajax({
                type: 'post',
                url: 'user/destroy',
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

                    $('#user_edit_value').val('');
                    $("#refreshbody").load(location.href + " #refreshbody>*", "");
                }
                if (response.result == 'error') {
                    $('#user_edit_value').val('');

                }
            });

            // event.preventDefault();

        }


} else {
            $('#user_edit_value').val('');
}

}

