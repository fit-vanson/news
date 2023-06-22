var $ = jQuery.noConflict();

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$("#submit-form").on("click", function () {
        $("#DataEntry_formId").submit();
    });
});
$("#select_MultipleSites").addClass("active");

function showPerslyError() {
    $('.parsley-error-list').show();
}

jQuery('#DataEntry_formId').parsley({
    listeners: {
        onFieldValidate: function (elem) {
            if (!$(elem).is(':visible')) {
                return true;
            }
            else {
                showPerslyError();
                return false;
            }
        },
        onFormSubmit: function (isFormValid, event) {
            if (isFormValid) {
                onUpdate();
                return false;
            }
        }
    }
});

function onUpdate() {

    $.ajax({
		type : 'POST',
		url: base_url + '/backend/saveCustomJS',
		data: $('#DataEntry_formId').serialize(),
		success: function (response) {
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType == "success") {
				onSuccessMsg(msg);
            } else {
                onErrorMsg(msg);
            }
        }
    });
}

