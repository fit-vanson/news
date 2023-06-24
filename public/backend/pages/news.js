var $ = jQuery.noConflict();
var RecordId = '';
var BulkAction = '';
var ids = [];
var site_id = $("#site_id").val();


$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	resetForm("DataEntry_formId");

	$("#submit-form").on("click", function () {
        $("#DataEntry_formId").submit();
    });

    $("#submit-form-bulk").on("click", function () {
        $("#Bulk_formId").submit();
    });

	$(document).on('click', '.tp_pagination nav ul.pagination a', function(event){
		event.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
		onPaginationDataLoad(page);
	});

	$('input:checkbox').prop('checked',false);

    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

    $("#on_thumbnail").on("click", function () {
        media_type = 'Thumbnail';
        onGlobalMediaModalView();
    });

    $("#on_og_image").on("click", function () {
        media_type = 'SEO_Image';
        onGlobalMediaModalView();
    });

	$("#media_select_file").on("click", function () {

		var thumbnail = $("#thumbnail").val();

		if(media_type == 'Thumbnail'){

			if(thumbnail !=''){
				$("#news_thumbnail").val(thumbnail);
				$("#view_news_thumbnail").html('<img src="'+public_path+'/media/'+thumbnail+'">');
			}
			$("#remove_news_thumbnail").show();

		}else if (media_type == 'SEO_Image') {

            if(thumbnail !=''){
                $("#og_image").val(thumbnail);
                $("#view_og_image").html('<img src="'+public_path+'/media/'+thumbnail+'">');
            }

            $("#remove_og_image").show();
        }

		$('#global_media_modal_view').modal('hide');
    });

	$("#news_title").on("blur", function () {
		// if(RecordId ==''){
            onNewsSlug();
		// }
	});

    //Summernote
    $('#content').summernote({
        tabDisable: false,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'unlink','picture']],
            ['misc', ['undo', 'redo']],
            ['view', ['codeview', 'help']]
        ]
    });

});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
	$.ajax({
		url:base_url + "/backend/getNewsTableData?site_id="+site_id+"&category_id="+$("#category_id").val()+"&page="+page
		+"&search="+$("#search").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
	$.ajax({
		url:base_url + "/backend/getNewsTableData?site_id="+site_id+"&category_id="+$("#category_id").val()+"&search="+$("#search").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onSearch() {
	$.ajax({
		url: base_url + "/backend/getNewsTableData?site_id="+site_id+"&category_id="+$("#category_id").val()+"&search="+$("#search").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function resetForm(id) {
    $('#' + id).each(function () {
        this.reset();
    });

	$("#is_publish").trigger("chosen:updated");
}

function onListPanel() {
	$('.parsley-error-list').hide();
    $('#list-panel, .btn-form').show();
    $('#form-panel, #form-bulk, .btn-list').hide();
}

function onFormPanel() {
    resetForm("DataEntry_formId");
	RecordId = '';


    $("#is_publish").trigger("chosen:updated");
    $("#breaking_news").trigger("chosen:updated");
    $("#cate_id").val(0).trigger("chosen:updated");

	$("#remove_news_thumbnail").hide();
	$("#news_thumbnail").html('');

    $("#remove_og_image").hide();
    $("#og_image").html('');

    $('#content').summernote('code', '');


    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();
    $('#form-bulk').hide();

}

function onEditPanel() {
    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();
    $('#form-bulk').hide();

}

function onMediaImageRemove(type) {
	if(type == 'news_thumbnail'){

		$('#news_thumbnail').val('');
		$("#remove_news_thumbnail").hide();

	}
}

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
                onConfirmWhenAddEdit();
                return false;
            }
        }
    }
});

function onConfirmWhenAddEdit() {

    $.ajax({
		type : 'POST',
		url: base_url + '/backend/saveNewsData?site_id='+site_id,
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
	// var msg = TEXT["Do you really want to edit this record"];
    onLoadEditData()
	// onCustomModal("onLoadEditData");
}

function htmlDecode(input) {
    var doc = new DOMParser().parseFromString(input, "text/html");
    return doc.documentElement.textContent;
}

function onLoadEditData() {

    $.ajax({
		type : 'POST',
		url: base_url + '/backend/getNewsById',
		data: 'id='+RecordId,
		success: function (response) {
			var data = response;
            console.log(data.category_id)
			$("#RecordId").val(data.id);
			$("#news_title").val(htmlDecode(decodeURIComponent(data.title)));
			$("#slug").val(htmlDecode(decodeURIComponent(data.slug)));
			$("#summary").val(htmlDecode(decodeURIComponent(data.summary)));


			$("#is_publish").val(data.is_publish).trigger("chosen:updated");
			$("#breaking_news").val(data.breaking_news).trigger("chosen:updated");


            $("#cate_id").val(data.category_id).trigger("chosen:updated");

            if(data.original_url != null){
                $("#original_url").val(htmlDecode(decodeURIComponent(data.original_url)));
            }else{
                $('#original_url').val('');
            }

            if(data.description != null){
                $('#content').summernote('code', htmlDecode(decodeURIComponent(data.description)));
            }else{
                $('#content').summernote('code', '');
            }

 			if(data.thumbnail != null){
				$("#news_thumbnail").val(data.thumbnail);
				$("#view_news_thumbnail").html('<img src="'+public_path+'/media/'+data.thumbnail+'">');
				$("#remove_news_thumbnail").show();
			}else{
				$("#news_thumbnail").val('');
				$("#view_news_thumbnail").html('');
				$("#remove_news_thumbnail").hide();
			}

            if(data.og_title != null){
                $("#og_title").val(htmlDecode(decodeURIComponent(data.og_title)));
            }else{
                $("#og_title").val('');
            }

            if(data.og_keywords != null){
                $("#og_keywords").val(htmlDecode(decodeURIComponent(data.og_keywords)));
            }else{
                $("#og_keywords").val('');
            }

            if(data.og_description != null){
                $("#og_description").val(htmlDecode(decodeURIComponent(data.og_description)));
            }else{
                $("#og_description").val('');
            }

            if(data.og_image != null){
                $("#og_image").val(data.og_image);
                $("#view_og_image").html('<img src="'+public_path+'/media/'+data.og_image+'">');
                $("#remove_og_image").show();
            }else{
                $("#og_image").val('');
                $("#view_og_image").html('');
                $("#remove_og_image").hide();
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
		type : 'POST',
		url: base_url + '/backend/deleteNews',
		data: 'id='+RecordId,
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if(msgType == "success"){
				onSuccessMsg(msg);
				onRefreshData();
			}else{
				onErrorMsg(msg);
			}

			onCheckAll();
		}
    });
}

function onBulkAction() {
	ids = [];
	$('.selected_item:checked').each(function(){
		ids.push($(this).val());
	});

	if(ids.length == 0){
		var msg = TEXT["Please select record"];
		onErrorMsg(msg);
		return;
	}

	BulkAction = $("#bulk-action").val();
	if(BulkAction == ''){
		var msg = TEXT["Please select action"];
		onErrorMsg(msg);
		return;
	}

	if(BulkAction == 'publish'){
		var msg = TEXT["Do you really want to publish this records"];
	}else if(BulkAction == 'draft'){
		var msg = TEXT["Do you really want to draft this records"];
	}else if(BulkAction == 'delete'){
		var msg = TEXT["Do you really want to delete this records"];
	}

	onCustomModal(msg, "onConfirmBulkAction");
}

function onConfirmBulkAction() {

    $.ajax({
		type : 'POST',
		url: base_url + '/backend/bulkActionNews',
		data: 'ids='+ids+'&BulkAction='+BulkAction,
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if(msgType == "success"){
				onSuccessMsg(msg);
				onRefreshData();
				ids = [];
			}else{
				onErrorMsg(msg);
			}

			onCheckAll();
		}
    });
}

//News Slug
function onNewsSlug() {
	var StrName = $("#news_title").val();
	var str_name = StrName.trim();
	var strLength = str_name.length;
	if(strLength>0){
		$.ajax({
			type : 'POST',
			url: base_url + '/backend/hasNewsSlug',
			data: 'slug='+StrName,
			success: function (response) {
				var slug = response.slug;
				$("#slug").val(slug);
			}
		});
	}
}


function onFormBulk() {
    resetForm("Bulk_formId");
    $('#list-panel, .btn-form').hide();
    $('#form-panel').hide();
    $('#form-bulk, .btn-list').show();
}

jQuery('#Bulk_formId').parsley({
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
                onConfirmWhenAddBulk();
                return false;
            }
        }
    }
});

function onConfirmWhenAddBulk() {
    var formData = new FormData($("#Bulk_formId")[0]);
    $.ajax({
        type : 'POST',
        url: base_url + '/backend/saveProductCategoriesBulk',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType == "success") {
                resetForm("Bulk_formId");
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

