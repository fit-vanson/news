var $ = jQuery.noConflict();
var start_date = '';
var end_date = '';
var RecordId = '';

$(function () {
    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    start_date = moment().startOf('month')
    end_date = moment().endOf('month');
    //
    $("#start_date").val(start_date.format('YYYY-MM-D'))
    $("#end_date").val(end_date.format('YYYY-MM-D'))
    RecordId = $("#RecordId").val();


});

function onFilterAction() {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();

    $.ajax({
        url: base_url + "/backend/getUserNewsTableData?user_id="+RecordId+"&start_date="+start_date+"&end_date="+end_date,
        cache: false,
        success: function (response) {
            $('#tp_datalist').html(response);
        }
    });
}
/*
function onExcelExport() {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();


    var FinalPath = base_url + "/backend/user_news-excel-export?user_id="+RecordId+"&start_date="+start_date+"&end_date="+end_date;

    $.ajax({
        url:FinalPath,
        success:function(data){
            var filePath = base_url+'/public/export/'+data;
            window.open(filePath);
        }
    });
}*/

function onExcelExport() {
    // Lấy các thông tin cần thiết từ giao diện (user_id, start_date, end_date)
    var user_id = $("#RecordId").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();

    // Gửi yêu cầu AJAX đến route export.excel
    $.ajax({
        url: base_url + "/backend/user_news-excel-export",
        type: 'GET',
        data: {
            user_id: user_id,
            start_date: start_date,
            end_date: end_date
        },
        // xhrFields: {
        //     responseType: 'blob' // Yêu cầu dữ liệu nhận về là kiểu blob (binary data)
        // },
        success: function (data) {
            var fileName = data.file;
            // Tạo thẻ a để tải xuống tập tin
            var a = document.createElement('a');
            a.href = '/export/' + fileName;
            a.download = fileName; // Đặt tên tập tin khi tải xuống
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            // Xóa thẻ a sau khi đã tải xuống
            document.body.removeChild(a);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}








