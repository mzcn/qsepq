//check exist or not in DB
function check_exist($error_obj,url,error_info) {
	$loading = $('<img src="/images/loading.gif">');
	$error_obj.html('');
	$error_obj.append($loading);
	
	$.ajax({
		url: url,
		async: false,
		success: function(response) {
			if(response == 'ok') {
				validate_input_success($error_obj);
			} else if(response == 'exist') {
				validate_input_error($error_obj,error_info);
			} else {
				validate_input_error($error_obj,'服务器异常，请联系管理员！');
			}
		}
	});
}

function validate_input_error($error_obj, error_info) {
	$no = $('<img src="/images/no.gif" width="16px" height="16px">');
	$error_obj.html('');
	$error_obj.removeClass();
	$error_obj.addClass('onError');
	$error_obj.append($no);
	$error_obj.append('<font font="2" color="Red">' + error_info + '</font>');
}

function validate_input_success($error_obj) {
	$yes = $('<img src="/images/yes.png">');
	$error_obj.html('');
	$error_obj.removeClass();
	$error_obj.append($yes);
}

function isValidMail(email_address) {
	var reMail = /^(?:[a-z\d]+[_\-\+\.]?)*[a-z\d]+@(?:([a-z\d]+\-?)*[a-z\d]+\.)+([a-z]{2,})+$/i;
	return reMail.test(email_address);
}