$(document).ready(function () {    $('#dataTables-baojias').DataTable({        responsive: true    });    //name lose focus    $name = $('#name');    $name_error = $('#name_error');    $name.bind('focusout', function () {        if (($.trim($name.val())) === '') {            validate_input_error($name_error, '请输入项目名称！');            return false;        } else {            check_name_exist();        }    });    //customer lose focus    $customer = $('#customer');    $customer_error = $('#customer_error');    $customer.bind('focusout', function () {        if (($.trim($customer.val())) === '') {            validate_input_error($customer_error, '请输入客户名称！');            return false;        } else {            validate_input_success($customer_error);        }    });    //add info submit    $('#btn_save').click(function () {        $name.triggerHandler('focusout');        if ($('.onError').length > 0) {            //the first error text get focus            if ($('span.onError').siblings('input').get(0) != undefined) {                $('span.onError').siblings('input').get(0).focus();            } else {                $('span.onError').siblings('select').get(0).focus();            }            return false;        }    });    $('#btn_reset').click(function () {        if ($('#id').val() == '') {            window.location.href = "/baojias/add";        } else {            window.location.href = "/baojias/edit?id=" + $('#id').val();        }    });    $('#category').change(function () {        $.ajax({            url: '/baojias/getDetails?name=' + encodeURIComponent($.trim($("#category").find("option:selected").text())),            dataType: 'json',            success: function (response) {                if (response.result == 'ok') {                    var data = response.data;                    $('#detail').empty();                    $('#detail').append('<option value="">---请选择---</option>');                    for (i = 0; i < data.length; i++) {                        $('#detail').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');                    }                }            }        });    });    $('#detail').change(function () {        var id = $('#detail').val();        var tmp = jQuery.parseJSON(details);        $.each(tmp, function (key, val) {            if (val.id == id) {                $('#brand').val(val.brand);                $('#type').val(val.type);                $('#unit_price').val(val.unit_price);                $('#cost_price').val(val.cost_price);                $('#unit').val(val.unit);                $('#size').val(val.size);            }        });        var total = $('#unit_price').val() * $('#count').val();        $('#total').val(total);    });    $('#count').bind('focusout', function () {        if (($.trim($('#count').val())) === '') {            $('#total').val(0);        } else {            var total = parseInt($('#unit_price').val()) * parseInt($('#count').val());            $('#total').val(total);        }    });    $('#tax').bind('focusout', function () {        var value = $.trim($('#tax').val());        if (value > 100) {            $('#tax').val('');        }        getTotal(total_all);    });    $('#tour_cost').bind('focusout', function () {        var value = $.trim($('#tour_cost').val());        if (value > 100) {            $('#tour_cost').val('');        }        getTotal(total_all);    });    $('#setup_cost').bind('focusout', function () {        var value = $.trim($('setup_cost').val());        if (value > 100) {            $('#setup_cost').val('');        }        getTotal(total_all);    });    $('#btn_cancel_detail').click(function () {        $(':input', '#myModal')            .not(':button, :submit, :reset, :hidden')            .val('')            .removeAttr('checked')            .removeAttr('selected');        $("#count").val(1);        $("#errorMsg").hide();    });    $('#btn_add_detail').click(function () {        var detail_name = $("#detail").find("option:selected").text();        var brand = $('#brand').val();        var type = $('#type').val();        var size = $('#size').val();        var unit_price = $('#unit_price').val();        var cost_price = $('#cost_price').val();        var total = $('#total').val();        var count = $('#count').val();        var unit = $('#unit').val();        var remark = $('#remark').val();        var project_id = $('#project_name').val();        var project_name = $("#project_name").find("option:selected").text();        var category = $("#category").find("option:selected").text();        var parent_id = $('#baojia_id').val();        var msg = "";        if (project_id == '') {            msg = '项目名称，';        }        if ($('#category').val() == '') {            msg = msg + '分类，';        }        if ($('#detail').val() == '') {            msg = msg + '明细，';        }        if ($('#count').val() == '') {            msg = msg + '数量，';        }        if (msg !== '') {            msg = "请注意：" + msg + "为必填项!";            $("#errorMsg").html(msg);            $("#errorMsg").show();            return;        }        var data = {            detail_name: detail_name,            brand: brand,            type: type,            size: size,            unit_price: unit_price,            cost_price: cost_price,            total: total,            count: count,            unit: unit,            remark: remark,            project_id: project_id,            project_name: project_name,            category: category,            parent_id: parent_id        };        $.ajax({            url: '/baojias/addDetail',            data: data,            dataType: 'json',            type: 'post',            success: function (response) {                if (response.result == 'ok') {                    loadTable(parent_id);                    $(':input', '#myModal')                        .not(':button, :submit, :reset, :hidden')                        .val('')                        .removeAttr('checked')                        .removeAttr('selected');                    $("#count").val(1);                    $("#myModal").modal('hide');                }            }        });    });});//check name exist or notfunction check_name_exist() {    var parameters = '/baojias/checkExist?name=' + encodeURIComponent($.trim($name.val())) + '&id=' + $('#baojia_id').val();    check_exist($name_error, parameters, '该总项目名称已存在！');}function deleteDetail(id, parent_id) {    $.ajax({        url: '/baojias/deleteDetail?id=' + id,        success: function (response) {            if (response == 'ok') {                loadTable(parent_id);            }        }    });}function loadTable(parent_id) {    $.ajax({        url: '/baojias/loadTable?id=' + parent_id,        dataType: 'json',        success: function (response) {            if (response.result == 'ok') {                mergeTable(response.data);            }        }    });}function getTotal(total_all) {    var tax = 0;    var setup_cost = 0;    var tour_cost = 0;    if (total_all != 0) {        if ($.trim($('#tax').val()) != '') {            tax = total_all * parseInt($.trim($('#tax').val())) * 0.01;        }        if ($.trim($('#tour_cost').val()) != '') {            tour_cost = total_all * parseInt($.trim($('#tour_cost').val())) * 0.01;        }        if ($.trim($('#setup_cost').val()) != '') {            setup_cost = total_all * parseInt($.trim($('#setup_cost').val())) * 0.01;        }    }    $('#total_price').val(total_all + tax + setup_cost + tour_cost);}function getDetailsForPreview(parent_id) {    $.ajax({        url: '/baojias/getDefails?id=' + parent_id,        dataType: 'json',        success: function (response) {            if (response.result == 'ok') {                mergeTable(response.data, true);            }        }    });}function mergeTable(objData, preview) {    $('#detail_body').html('');    var arrJson = objData;    var str = '';    total_all = 0;    var projectNameMap = {};    var len = arrJson.length;    for (var i = 0; i < len; i++) {        if (projectNameMap[arrJson[i].project_name] == undefined) {            var list = [];            list.push(arrJson[i]);            projectNameMap[arrJson[i].project_name] = list;        } else {            projectNameMap[arrJson[i].project_name].push(arrJson[i]);        }    }    for (var projectName in projectNameMap) {        var pdata = projectNameMap[projectName];        var detailCategoryMap = {};        for (var i = 0; i < pdata.length; i++) {            if (detailCategoryMap[pdata[i].category] == undefined) {                var list = [];                list.push(pdata[i]);                detailCategoryMap[pdata[i].category] = list;            } else {                detailCategoryMap[pdata[i].category].push(pdata[i]);            }        }        str += "<tr class='odd gradeC'><td rowspan='" + pdata.length + "'>" + pdata[0].project_id + "</td><td rowspan='" + pdata.length + "'>" + projectName + "</td>";        for (var detailCategory in detailCategoryMap) {            var data = detailCategoryMap[detailCategory];            str += "<td rowspan='" + data.length + "'>" + detailCategory + "</td>";            for (var i = 0; i < data.length; i++) {                if (i == 0) {                    str += '<td class="center">' + data[i].detail_name + '</td>' +                    '<td class="center">' + data[i].brand + '</td>' +                    '<td class="center">' + data[i].type + '</td>' +                    '<td class="center">' + data[i].size + '</td>' +                    '<td class="center">' + data[i].unit_price + '</td>' +                    '<td class="center">' + data[i].count + '</td>' +                    '<td class="center">' + data[i].unit + '</td>' +                    '<td class="center">' + data[i].total + '</td>' +                    '<td class="center">' + data[i].remark + '</td>';                } else {                    str += '<tr class="odd gradeC">' +                    '<td class="center">' + data[i].detail_name + '</td>' +                    '<td class="center">' + data[i].brand + '</td>' +                    '<td class="center">' + data[i].type + '</td>' +                    '<td class="center">' + data[i].size + '</td>' +                    '<td class="center">' + data[i].unit_price + '</td>' +                    '<td class="center">' + data[i].count + '</td>' +                    '<td class="center">' + data[i].unit + '</td>' +                    '<td class="center">' + data[i].total + '</td>' +                    '<td class="center">' + data[i].remark + '</td>';                }                if (!preview) {                    str += '<td class="center"><a onclick="if(confirm(\'确定删除该条记录吗？\')) deleteDetail(' + data[i].id + ',\'' + data[i].parent_id + '\');" ' +                    'class="btn btn-outline btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a></td>';                }                str += '</tr>';                total_all += parseInt(data[i].total);                getTotal(total_all);            }        }    }    $('#detail_body').html(str);}function removeBaojia(parent_id) {    BootstrapDialog.confirm('确定删除该条记录吗？', function (result) {        if (result) {            $.ajax({                url: '/baojias/delete?id=' + parent_id,                success: function (response) {                    if (response === 'ok') {                        $("#" + parent_id).remove();                        BootstrapDialog.alert("报价删除成功！");                    }                }            });        } else {            return false;        }    });}function exportExcel(parent_id) {    var params = {        id: parent_id,        tp: 1    };    BootstrapDialog.show({        title: '导出报价单',        message: '请选择导出模版',        buttons: [{            label: '模版一',            action: function (dialogRef) {                params.tp = 1;                window.location.href = "/baojias/export?id=" + params.id + "&tp=" + params.tp;                dialogRef.close();            }        }, {            label: '模版二',            action: function (dialogRef) {                params.tp = 2;                window.location.href = "/baojias/export?id=" + params.id + "&tp=" + params.tp;                dialogRef.close();            }        }, {            id: 'button-c',            label: '模版三',            action: function (dialogRef) {                params.tp = 3;                window.location.href = "/baojias/export?id=" + params.id + "&tp=" + params.tp;                dialogRef.close();            }        }]    });}