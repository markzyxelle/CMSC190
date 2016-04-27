$( document ).ready(function() {
	$(".help-block").hide();

	$(document).on('click', '.edit-branch-button', function(){
		$('#branch-id-modal').val($(this).data("id"));
		$('#branch-name').val($(this).parent().parent().children("td")[0].innerHTML);
	});

	$(document).on('click', '#edit-branch-submit', function(){
		$('#edit-branch-form').submit();
	});

	$('#edit-branch-form').submit(function() {
		var valid = true;

		$("#edit-branch-form .help-block").hide();
		$("#edit-branch-form .form-group.has-error").removeClass("has-error");
		
		$("#edit-branch-form .required-text").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
			if($(this).val().length > 255){
				valid = false;
				($(this).parent().find(".max")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		if(valid == false) return false;
        return true;
    });
});