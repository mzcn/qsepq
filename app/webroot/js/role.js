$(document).ready(function(){    $('#dataTables-role').DataTable({        responsive: true    });    //name lose focus    $name = $('#role_name');    $name_error = $('#name_error');    $name.bind('focusout',function(){        if(($.trim($name.val())) === '') {            validate_input_error($name_error, '请输入角色名称！');            return false;        } else {            check_name_exist();        }    });	//add info submit	$('#btn_save').click(function(){        $name.triggerHandler('focusout');				if($('.onError').length > 0) {			//the first error text get focus			if($('span.onError').siblings('input').get(0) != undefined) {				$('span.onError').siblings('input').get(0).focus();			} else {				$('span.onError').siblings('select').get(0).focus();			}			return false;		}	});		$('#btn_reset').click(function(){        if($('#id').val() == '') {            window.location.href = "/roles/add";        } else {            window.location.href = "/roles/edit?id="+$('#role_id').val();        }	});});//check name exist or notfunction check_name_exist() {	var parameters = '/roles/checkExist?name=' + encodeURIComponent($.trim($name.val())) + '&id=' + $('#role_id').val();	check_exist($name_error,parameters,'该角色名称已存在！');}