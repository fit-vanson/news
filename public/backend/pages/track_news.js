var $ = jQuery.noConflict();
var RecordId = '';
var ids = [];
var site_id = $("#site_id").val();

const url = new URL(window.location.href);
const searchParams = new URLSearchParams(url.search);


$(function () {
    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#select_MultipleSites").addClass("active");


    resetForm("DataEntry_formId");

    $(document).on('click', '.tp_pagination nav ul.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        onPaginationDataLoad(page);
    });

    $('input:checkbox').prop('checked', false);

    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });



    if (searchParams.has("news_id")) {
        $("#tabs_nav_site_news").addClass("active");
        searchParams.delete("news_id");
        const newUrl = `${window.location.pathname}?${searchParams.toString()}`;
        history.replaceState({}, document.title, newUrl);
    }

    $(document).on('click', '.click_search', function (event) {
        event.preventDefault();
        var tdValue = $(this).text(); // Lấy giá trị của thẻ <td>
        $("#search").val(tdValue)
        onSearch();
    });

    $("#search").on("change", function() {
        onSearch();
    });

});


function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
    $.ajax({
        url: base_url + "/backend/getTrackNewsTableData?site_id=" + site_id + "&page=" + page
            + "&search=" + $("#search").val(),
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        }
    });
}



function onSearch() {
    $.ajax({
        url: base_url + "/backend/getTrackNewsTableData?site_id=" + site_id + "&search=" + $("#search").val(),
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




function htmlDecode(input) {
    var doc = new DOMParser().parseFromString(input, "text/html");
    return doc.documentElement.textContent;
}

