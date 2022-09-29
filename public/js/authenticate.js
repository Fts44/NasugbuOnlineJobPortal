
$('.showpassword').click(function(){
    var input = $('#pass');
    if(input.attr('type') === 'password'){
        $('#pass, #pass1').attr('type','text');
        $('.showpassword').removeClass('fa-eye-slash');
        $('.showpassword').addClass('fa-eye');
    }
    else{
        $('#pass, #pass1').attr('type','password');
        $('.showpassword').removeClass('fa-eye');
        $('.showpassword').addClass('fa-eye-slash');
    }
});
