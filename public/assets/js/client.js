$( document ).ready(function() {
	$(".help-block").hide();
	$("#edit-client-submit").hide();
	$("#edit-client-submit").prop("disabled", true);
	$("#edit-success").hide();
	$("#edit-fail").hide();
	$("#add-transactions-button").prop("disabled", true);
	$("#add-transactions-button").hide();

	$('#edit-client-form').submit(function(e){
		e.preventDefault();
		$("#edit-success").hide();
		$("#edit-fail").hide();
		var form = $('#edit-client-form').serialize();
		var url = $(this).data('url');
		var valid = true;

		$("#edit-client-form .help-block").hide();
		$("#edit-client-form .form-group.has-error").removeClass("has-error");
		
		$("#edit-client-form .required-text").each(function(){
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

		$("#edit-client-form .required-select").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-client-form #birthdate").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-client-form #cutoff-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-client-form #mobile-number").each(function(){
			if(isNaN($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		//AJAX: post to database
		if(valid == true){
			$.ajax({
				type : 'POST',
				url: url,
				data : form,
				dataType : 'json',
				success : function(data) {
					$("#edit-success").show();
					$("#edit-fail").hide();
					$("#edit-client-submit").hide();
					$("#edit-client-submit").prop("disabled", true);
					$("#edit-client-form input").prop("disabled", true);
					$("#edit-client-form select").prop("disabled", true);
					$("#edit-client-enable").show();
				},
				error : function(data, text, error) {
					$("#edit-fail").show();
					$("#edit-success").hide();
				}
			});
		}
	});

	$(document).on('click', '#edit-client-submit', function(){
		$('#edit-client-form').submit();
	});

	$(document).on('click', '#edit-client-enable', function(){
		$("#edit-client-submit").show();
		$("#edit-client-submit").prop("disabled", false);

		$("#edit-client-form input").prop("disabled", false);
		$("#edit-client-form select").prop("disabled", false);
		$(this).hide();
	});

	var one_day=1000*60*60*24;
	var status;
	$(document).on('click', '.loan-structure', function(){
		var loan_id = $(this).data("id");
		var $this = $(this);

		$.getJSON( "/getTransactions/" + loan_id ) 
			.done(function( resp ) {
				$("#loan-id-modal").attr("value", loan_id);
				$("#view-transactions-information").attr("data-id", loan_id);
				$("#view-transactions-table tbody").html("");
				$.each( resp, function( key, value ) {
					status = Math.ceil((new Date(value["due_date"]).getTime()-new Date(value["payment_date"]).getTime())/(one_day));
					status = status < 0 ? -status + " days late" : status + " days early";
			    	$('#view-transactions-table').append("<tr><td>"+ value["principal_amount"] +"</td><td>"+ value["interest_amount"] +"</td><td>"+ value["payment_date"] +"</td><td>"+ value["due_date"] +"</td><td>"+ status +"</td><td>" + value["cutoff_date"] +"</td></tr>");
			    });
			    $("#add-transactions-button").prop("disabled", false);
				$("#add-transactions-button").show();
				$this.parent().children(".selected").removeClass("selected");
				$this.addClass("selected");
				$("#add-transaction-form #principal-amount-loan-transaction-form").val($this.children("td")[3].innerHTML);
				$("#add-transaction-form #interest-amount-loan-transaction-form").val($this.children("td")[4].innerHTML);
				$("#add-transaction-form #principal-balance-transaction-form").val($this.children("td")[5].innerHTML);
				$("#add-transaction-form #interest-balance-transaction-form").val($this.children("td")[6].innerHTML);
				$("#isActive-select").children("option").filter("."+$this.children("td")[7].innerHTML).prop("selected","selected");
				$("#add-transaction-form #status-transaction-form").val($this.children("td")[9].innerHTML);
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	$(document).on('click', '#add-loan-submit', function(){
		$('#add-loan-form').submit();
	});

	$('#add-loan-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-loan-form').serialize();
		var url = $(this).data('url');
		var valid = true;

		$("#add-loan-form .help-block").hide();
		$("#add-loan-form .form-group.has-error").removeClass("has-error");
		
		$("#add-loan-form .required-text").each(function(){
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

		$("#add-loan-form .required-select").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-loan-form #release-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-loan-form #maturity-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-loan-form #cutoff-date-loan").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-loan-form .required-number").each(function(){
			if(isNaN($(this).val())){
				valid = false;
				($(this).parent().find(".number")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		//AJAX: post to database
		if(valid == true){
			$.ajax({
				type : 'POST',
				url: url,
				data : form,
				dataType : 'json',
				success : function(data) {
					data["isActive"] = (data["isActive"] == 1 ? "True" : "False");
					data["isReleased"] = (data["isReleased"] == 1 ? "True" : "False");
					$("#view-loans-table tbody").append("<tr class='loan-structure' data-id=" + data["id"] + "><td>" + data["loan_type_id"] + "</td><td>" + data["loan_cycle"] + "</td><td>" + data["released_date"] + "</td><td>" + data["principal_amount"] + "</td><td>" + data["interest_amount"] + "</td><td>" + data["principal_balance"] + "</td><td>" + data["interest_balance"] + "</td><td>" + data["isActive"] + "</td><td>" + data["isReleased"] + "</td><td>" + data["status"] + "</td><td>" + data["maturity_date"] + "</td><td>" + data["cutoff_date"] + "</td></tr>")
					// $('#structure-table').append("<tr><td><a href='/viewClient/" + data["id"] + " class='structure-client' data-id='" + data["id"] + "'>" + data["first_name"] + "</a><td></tr>");
					// alert(data["center_name"]);
					// $.each( data, function( key, value ) {
					// 	alert("key: " + key + " value: " + value);
				 //    })
				},
				error : function(data, text, error) {
					alert("error")
				}
			});
		}
	});

	$(document).on('click', '#add-transaction-submit', function(){
		$('#add-transaction-form').submit();
	});

	$('#add-transaction-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-transaction-form').serialize();
		var url = $(this).data('url');
		var valid = true;

		$("#add-transaction-form .help-block").hide();
		$("#add-transaction-form .form-group.has-error").removeClass("has-error");
		
		$("#add-transaction-form .required-text").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-transaction-form #payment-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-transaction-form #due-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-transaction-form #cutoff-date-transaction").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-transaction-form .required-select").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#add-transaction-form .required-number").each(function(){
			if(isNaN($(this).val())){
				valid = false;
				($(this).parent().find(".number")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		//AJAX: post to database
		if(valid == true){
			$.ajax({
				type : 'POST',
				url: url,
				data : form,
				dataType : 'json',
				success : function(data) {
					status = Math.ceil((new Date(data["transaction"]["due_date"]).getTime()-new Date(data["transaction"]["payment_date"]).getTime())/(one_day));
					status = status < 0 ? -status + " days late" : status + " days early";
					$('#view-transactions-table').append("<tr><td>"+ data["transaction"]["principal_amount"] +"</td><td>"+ data["transaction"]["interest_amount"] +"</td><td>"+ data["transaction"]["payment_date"] +"</td><td>"+ data["transaction"]["due_date"] +"</td><td>"+ status +"</td><td>" + data["transaction"]["cutoff_date"] +"</td></tr>");
					data["loan"]["isActive"] = (data["loan"]["isActive"] == 1 ? "True" : "False");
					var row = $('#view-loans-table .loan-structure.selected');
					row.children("td")[3].innerHTML = data["loan"]["principal_amount"];
					row.children("td")[4].innerHTML = data["loan"]["interest_amount"];
					row.children("td")[5].innerHTML = data["loan"]["principal_balance"];
					row.children("td")[6].innerHTML = data["loan"]["interest_balance"];
					row.children("td")[7].innerHTML = data["loan"]["isActive"];
					row.children("td")[9].innerHTML = data["loan"]["status"];
					// $("#view-transactions-table").append("<tr><td>" +  + "</td><td>" +  + "</td><td>" +  + "</td><td>" +  + "</td><td>")
					// // $.each( data, function( key, value ) {
					// 	alert(JSON.stringify(data["transaction"]));
					// 	alert(JSON.stringify(data["loan"]));
					// });
					// $.each( resp, function( key, value ) {
					// 	status = Math.ceil((new Date(value["due_date"]).getTime()-new Date(value["payment_date"]).getTime())/(one_day));
					// 	status = status < 0 ? -status + " days late" : status + " days early";
				 //    	$('#view-transactions-table').append("<tr><td>"+ value["principal_amount"] +"</td><td>"+ value["interest_amount"] +"</td><td>"+ value["payment_date"] +"</td><td>"+ value["due_date"] +"</td><td>"+ status +"</td><td>" + value["cutoff_date"] +"</td></tr>");
				 //    });
				},
				error : function(data, text, error) {
					alert("error")
				}
			});
		}
	});

	$('#add-tag-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-tag-form').serialize();
		var url = $(this).data('url');
		var valid = true;

		$("#add-tag-form .help-block").hide();
		$("#add-tag-form .form-group.has-error").removeClass("has-error");

		$("#add-tag-form .required-text").each(function(){
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

		$("#view-tags-table tbody td").each(function( index ) {
			if($(this).html() == $("#tag-name").val()){
				$("#add-tag-form .unique").show();
				$("#tag-name-div").addClass("has-error");
				valid = false;
				return false;
			}
		});

		//AJAX: post to database
		if(valid == true){
			$.ajax({
				type : 'POST',
				url: url,
				data : form,
				dataType : 'json',
				success : function(data) {
					$("#view-tags-table tbody").append("<tr><td>"+ data["name"] +"</td></tr>");
					// status = Math.ceil((new Date(data["transaction"]["due_date"]).getTime()-new Date(data["transaction"]["payment_date"]).getTime())/(one_day));
					// status = status < 0 ? -status + " days late" : status + " days early";
					// $('#view-transactions-table').append("<tr><td>"+ data["transaction"]["principal_amount"] +"</td><td>"+ data["transaction"]["interest_amount"] +"</td><td>"+ data["transaction"]["payment_date"] +"</td><td>"+ data["transaction"]["due_date"] +"</td><td>"+ status +"</td><td>" + data["transaction"]["cutoff_date"] +"</td></tr>");
					// data["isActive"] = (data["isActive"] == 1 ? "True" : "False");
					// var row = $('#view-loans-table .loan-structure.selected');
					// row.children("td")[3].innerHTML = data["loan"]["principal_amount"];
					// row.children("td")[4].innerHTML = data["loan"]["interest_amount"];
					// row.children("td")[5].innerHTML = data["loan"]["principal_balance"];
					// row.children("td")[6].innerHTML = data["loan"]["interest_balance"];
					// row.children("td")[7].innerHTML = data["loan"]["isActive"];
					// row.children("td")[9].innerHTML = data["loan"]["status"];
					// $("#view-transactions-table").append("<tr><td>" +  + "</td><td>" +  + "</td><td>" +  + "</td><td>" +  + "</td><td>")
					// // $.each( data, function( key, value ) {
					// 	alert(JSON.stringify(data["transaction"]));
					// 	alert(JSON.stringify(data["loan"]));
					// });
					// $.each( resp, function( key, value ) {
					// 	status = Math.ceil((new Date(value["due_date"]).getTime()-new Date(value["payment_date"]).getTime())/(one_day));
					// 	status = status < 0 ? -status + " days late" : status + " days early";
				 //    	$('#view-transactions-table').append("<tr><td>"+ value["principal_amount"] +"</td><td>"+ value["interest_amount"] +"</td><td>"+ value["payment_date"] +"</td><td>"+ value["due_date"] +"</td><td>"+ status +"</td><td>" + value["cutoff_date"] +"</td></tr>");
				 //    });
				},
				error : function(data, text, error) {
					alert("error")
				}
			});
		}
	});

	// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
	function isValidDate(dateString)
	{
	    // First check for the pattern
	    if(!/^\d{4}-\d{1,2}-\d{1,2}$/.test(dateString))
	        return false;

	    // Parse the date parts to integers
	    var parts = dateString.split("-");
	    var day = parseInt(parts[2], 10);
	    var month = parseInt(parts[1], 10);
	    var year = parseInt(parts[0], 10);

	    // Check the ranges of month and year
	    if(year < 1000 || year > 3000 || month == 0 || month > 12)
	        return false;


	    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

	    // Adjust for leap years
	    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
	        monthLength[1] = 29;

	    // Check the range of the day
	    return day > 0 && day <= monthLength[month - 1];
	};
});