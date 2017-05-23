/**
 * Created by rational on 15-8-29.
 */
$(document).ready(function(){
    $('#btn_login').click(function(){
        if($.trim($('#email').val()) == '') {
            alert('请输入E-mail.');
            $('#email').focus();
            return;
        }

        if($.trim($('#password').val()) == '') {
            alert('请输入Password.');
            $('#password').focus();
            return;
        }

        $('#login_form').submit();
    });

})