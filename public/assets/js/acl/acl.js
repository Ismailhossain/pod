// $(document).ready(function(){


    // $("#acl_list").click(function () {
    //     alert(1);
    // });


// });


// End of DOC


function aclDetails() {

    // event.preventDefault();

    register_token = $("#user_register_token").val();
    console.log(register_token);
    // register_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjU4OTZiNDgyNjIwMDliNDBmOGUwN2M4ZTY5MTdkMjJmMjg3NDJjM2Y0OGMyOGRmMTgwY2Q0NTkzNTJmNjE5YTk4NTgxOWQxMDBiYWQwNmU1In0.eyJhdWQiOiIxIiwianRpIjoiNTg5NmI0ODI2MjAwOWI0MGY4ZTA3YzhlNjkxN2QyMmYyODc0MmMzZjQ4YzI4ZGYxODBjZDQ1OTM1MmY2MTlhOTg1ODE5ZDEwMGJhZDA2ZTUiLCJpYXQiOjE1MzcyNDU3MTUsIm5iZiI6MTUzNzI0NTcxNSwiZXhwIjoxNTY4NzgxNzE1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.G35YDngO3dkgTAf4NA48S3wvjp5i11z8J6tkkx0uLMYKCK6W4MengGcuidoGvZ5cOXu4TI2wGwOr-vKntYJPf25j5-JQO448L-ElymW2SFjdVDYwzQ11X4koFWzgf1oHumQNjupi8F12Hfyqn0lakRsR5Fh63Hstn6cZr1kUe25kfhzf6iSDjx2URR30PrAtbSBVlK10bkoPIRdmZdQouK4A36CK8j4q0U1FUHKMylfB-JR2zH83SCeEhB-72uAy8SpxUrYQt888TNHQp66XfJ1nW4vgGM74DYsF3qi3BcDNHj4WZlC-yKtDF-hjbebEWFaUVlGlozk4x3sPXfFVlSdo34S-CJGmzBDfJ7wUv_lUiLfHSpvhq1cicY4j0_W6VY8aUANWj-Er4r5YflGg6QtkQV9si7htzN0jAsAKfbY939b5mj8vEQre78hJw82TqBNZEfnpwSfV7utMlt_V61XpzFV8QytgrhksgZb7Iu2dEdRYU8teOYbhJYAviIUHa1jjQhKD_fiJDYmifvhWNTrvwglmU9bQp1PJrLuHI-43SyNgiXBGOzuJEMx1Q0gRwqcN1ZgcGro1Eszr-0KwfwR2xJ3e0aWSKfLdy_SDw4gOjvAM79Glnm9OSBilrIXx08xSIhw_JJ6N0LMarJ7N0MybQ9EC5zrCurWTPuqm7Ec';


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var request =  $.ajax({
        type: 'post',
        url: 'api/acl/show',
        data: {
            // '_token': _token,
        },
        headers: {
            'Authorization': 'Bearer ' + register_token,
            'Accept': 'application/json'
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
    request.done(function (response) {
        // noty({
        //     "text": msg.message,
        //     "theme": "noty_theme_twitter",
        //     "layout": "top",
        //     "type": msg.result,
        //     "animateOpen": {"height": "toggle"},
        //     "animateClose": {"height": "toggle"},
        //     "speed": 500,
        //     "timeout": 2000,
        //     "closeButton": false,
        //     "closeOnSelfClick": true,
        //     "closeOnSelfOver": false
        // });
        if (response.result == 'success') {

            console.log(response);

        }
        if (response.result == 'error') {

        }
    });



    event.preventDefault();

}