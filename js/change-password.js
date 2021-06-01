$(()=>{
    $('#profile-page').addClass("active");
    
    // add event listner (focusout) -- validate new and confirm password
    $('#new_password').focusout((e)=>{
        if($('#new_password').val() != '' && $('#confirm_password').val() != '')
            passwordComfirm(e);
    });
    $('#confirm_password').keyup((e)=>{
        passwordComfirm(e);
    });

    // check if user input new password same as confirm password
    function passwordComfirm(e){
        if($('#new_password').val() != $('#confirm_password').val()){
            $('#confirm_password').removeClass('valid').addClass('invalid');
            $('#confirm_btn').prop('disabled',true);
        }else {
            $('#confirm_password').removeClass('invalid').addClass('valid');
            $('#confirm_btn').prop('disabled',false);
        }
    }
})