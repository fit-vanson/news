var $ = jQuery.noConflict();
var RecordId = '';
var BulkAction = '';
var ids = [];
var start_date = '';
var end_date = '';

$(function () {
    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
/*    start_date = moment().startOf('month')
    end_date = moment().endOf('month');

    $("#start_date").val(start_date.format('YYYY-MM-D'))
    $("#end_date").val(end_date.format('YYYY-MM-D'))
    onFilterAction()*/


    resetForm("DataEntry_formId");

    $("#submit-form").on("click", function () {
        $("#DataEntry_formId").submit();
    });

    $(document).on('click', '.users_pagination nav ul.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        onPaginationDataLoad(page);
    });

    $('input:checkbox').prop('checked', false);

    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

    $("#status_id").chosen();
    $("#status_id").trigger("chosen:updated");

    $("#role_id").chosen();
    $("#role_id").trigger("chosen:updated");

    $('.toggle-password').on('click', function () {
        $(this).toggleClass('fa-eye-slash');
        let input = $($(this).attr('toggle'));
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });

    $("#on_thumbnail").on("click", function () {
        onGlobalMediaModalView();
    });

    $("#media_select_file").on("click", function () {
        var thumbnail = $("#thumbnail").val();

        if (thumbnail != '') {
            $("#photo_thumbnail").val(thumbnail);
            $("#view_photo_thumbnail").html('<img src="' + public_path + '/media/' + thumbnail + '">');
        }

        $("#remove_photo_thumbnail").show();
        $('#global_media_modal_view').modal('hide');
    });

});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
    $.ajax({
        url: base_url + "/backend/getUsersTableData?page=" + page,
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        }
    });
}

function onRefreshData() {
    $.ajax({
        url: base_url + "/backend/getUsersTableData",
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        }
    });
}

function onSearch() {
    var search = $("#search").val();
    $.ajax({
        url: base_url + "/backend/getUsersTableData?search=" + search,
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        }
    });
}

function resetForm(id) {
    $('#' + id).each(function () {
        this.reset();
    });

    $("#status_id").trigger("chosen:updated");
    $("#role_id").trigger("chosen:updated");
}

function onListPanel() {
    $('.parsley-error-list').hide();
    $('#list-panel, .btn-form').show();
    $('#form-panel, .btn-list').hide();
}

function onFormPanel() {
    var passtype = $('#password').attr('type');
    if (passtype == 'text') {
        $(".toggle-password").removeClass("fa-eye-slash");
        $(".toggle-password").addClass("fa-eye");
        $('#password').attr('type', 'password');
    }

    resetForm("DataEntry_formId");
    RecordId = '';

    $("#status_id").trigger("chosen:updated");

    $("#remove_photo_thumbnail").hide();
    $("#photo_thumbnail").html('');

    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();
}

function onEditPanel() {
    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();
}

function onMediaImageRemove(type) {
    $('#photo_thumbnail').val('');
    $("#remove_photo_thumbnail").hide();
}

function showPerslyError() {
    $('.parsley-error-list').show();
}

jQuery('#DataEntry_formId').parsley({
    listeners: {
        onFieldValidate: function (elem) {
            if (!$(elem).is(':visible')) {
                return true;
            } else {
                showPerslyError();
                return false;
            }
        },
        onFormSubmit: function (isFormValid, event) {
            if (isFormValid) {
                onConfirmWhenAddEdit();
                return false;
            }
        }
    }
});

function onConfirmWhenAddEdit() {

    $.ajax({
        type: 'POST',
        url: base_url + '/backend/saveUsersData',
        data: $('#DataEntry_formId').serialize(),
        success: function (response) {
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType == "success") {
                resetForm("DataEntry_formId");
                onRefreshData();
                onSuccessMsg(msg);
                onListPanel();
            } else {
                onErrorMsg(msg);
            }

            onCheckAll();
        }
    });
}

function onEdit(id) {
    RecordId = id;
    var msg = TEXT["Do you really want to edit this record"];
    onCustomModal(msg, "onLoadEditData");
}

function onLoadEditData() {

    $.ajax({
        type: 'POST',
        url: base_url + '/backend/getUserById',
        data: 'id=' + RecordId,
        success: function (response) {

            var data = response;

            var passtype = $('#password').attr('type');
            if (passtype == 'text') {
                $(".toggle-password").removeClass("fa-eye-slash");
                $(".toggle-password").addClass("fa-eye");
                $('#password').attr('type', 'password');
            }

            $("#RecordId").val(data.id);
            $("#name").val(data.name);
            $("#email").val(data.email);
            $("#password").val(data.bactive);
            $("#phone").val(data.phone);
            $("#address").val(data.address);
            $("#status_id").val(data.status_id).trigger("chosen:updated");
            $("#role_id").val(data.role_id).trigger("chosen:updated");

            if (data.photo != null) {
                $("#photo_thumbnail").val(data.photo);
                $("#view_photo_thumbnail").html('<img src="' + public_path + '/media/' + data.photo + '">');
                $("#remove_photo_thumbnail").show();
            } else {
                $("#photo_thumbnail").val('');
                $("#view_photo_thumbnail").html('');
                $("#remove_photo_thumbnail").hide();
            }

            onEditPanel();
        }
    });
}

function onDelete(id) {
    RecordId = id;
    var msg = TEXT["Do you really want to delete this record"];
    onCustomModal(msg, "onConfirmDelete");
}

function onConfirmDelete() {

    $.ajax({
        type: 'POST',
        url: base_url + '/backend/deleteUser',
        data: 'id=' + RecordId,
        success: function (response) {
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType == "success") {
                onSuccessMsg(msg);
                onRefreshData();
            } else {
                onErrorMsg(msg);
            }

            onCheckAll();
        }
    });
}

function onBulkAction() {
    ids = [];
    $('.selected_item:checked').each(function () {
        ids.push($(this).val());
    });

    if (ids.length == 0) {
        var msg = TEXT["Please select record"];
        onErrorMsg(msg);
        return;
    }

    BulkAction = $("#bulk-action").val();
    if (BulkAction == '') {
        var msg = TEXT["Please select action"];
        onErrorMsg(msg);
        return;
    }

    if (BulkAction == 'active') {
        var msg = TEXT["Do you really want to active this records"];
    } else if (BulkAction == 'inactive') {
        var msg = TEXT["Do you really want to inactive this records"];
    } else if (BulkAction == 'delete') {
        var msg = TEXT["Do you really want to delete this records"];
    }

    onCustomModal(msg, "onConfirmBulkAction");
}

function onConfirmBulkAction() {

    $.ajax({
        type: 'POST',
        url: base_url + '/backend/bulkActionUsers',
        data: 'ids=' + ids + '&BulkAction=' + BulkAction,
        success: function (response) {
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType == "success") {
                onSuccessMsg(msg);
                onRefreshData();
                ids = [];
            } else {
                onErrorMsg(msg);
            }

            onCheckAll();
        }
    });
}

function onFilterAction() {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();

    $.ajax({
        url: base_url + "/backend/getNewsChartData?start_date="+start_date+"&end_date="+end_date,
        cache: false,
    }).done(viewChart);
}
function viewChart(result) {
    // Hủy biểu đồ cũ nếu đã tồn tại
    if (window.myChart) {
        window.myChart.destroy();
    }

    let ctx = document.getElementById('yearly_chart_canvas').getContext('2d');
    ctx.canvas.style.height = '500px';

    let incomeOverviewData = {
        labels: result.labels,
        datasets: []
    };
    const colors = ['red', 'blue', 'green', 'orange', 'purple', 'yellow']; // và các màu khác tuỳ ý

    let i = 0;
    for (const [name, data] of Object.entries(result.total_news)) {
        const sum = data.reduce((total, currentValue) => total + currentValue, 0);

        incomeOverviewData.datasets.push({
            type: 'line',
            tension: 0.1,
            label: name + ' (Tổng:'+ sum +')',
            data: data,
            fill: false,
            borderColor: colors[i % colors.length], // Chọn màu tương ứng cho dòng
        });
        i++;
    }

    window.myChart = new Chart(ctx, {
        type: 'line',
        data: incomeOverviewData,
    });
}







