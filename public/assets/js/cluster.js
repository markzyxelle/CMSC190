$( document ).ready(function() {

	$(document).on('click', '.leave-cluster-button', function(){
		$("#leave-cluster-id-modal").val($(this).data('id'));
	});

});