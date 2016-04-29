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

		$("#edit-client-form #cutoff-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
				return false;
			}
			if(new Date($(this).val()) < new Date($(this).data("saved"))){
				valid = false;
				($(this).parent().find(".earlier-date")).show();
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
				$("#add-transaction-form #loan-id-modal").attr("value", loan_id);
				$("#view-transactions-information").attr("data-id", loan_id);
				$("#view-transactions-table tbody").html("");
				$.each( resp, function( key, value ) {
					status = Math.ceil((new Date(value["due_date"]).getTime()-new Date(value["payment_date"]).getTime())/(one_day));
					status = status < 0 ? -status + " days late" : status + " days early";
			    	$('#view-transactions-table tbody').append("<tr><td>"+ value["principal_amount"] +"</td><td>"+ value["interest_amount"] +"</td><td>"+ value["payment_date"] +"</td><td>"+ value["due_date"] +"</td><td>"+ status +"</td><td>" + value["cutoff_date"] + ($("#view-transactions-information").data("activity") == 1 ? "</td><td><button type='button' class='btn btn-info btn-sm modal-button raised edit-transaction-button' data-toggle='modal' data-target='#edit-transaction-modal' data-id='"+ value["id"] +"'>Edit Transaction</button></td><td><button type='button' class='btn btn-danger btn-sm modal-button raised delete-transaction-button' data-toggle='modal' data-target='#delete-transaction-modal' data-id='"+ value["id"] +"'>Delete Transaction</button>" : "") + "</td></tr>");
			    	// $('#view-transactions-table tbody').append("<td><button type='button' class='btn btn-info btn-sm modal-button raised edit-transaction-button' data-toggle='modal' data-target='#edit-transaction-modal' data-id='"+ value["id"] +"'>Edit</button></td><td><button type='button' class='btn btn-danger btn-sm modal-button raised delete-transaction-button' data-toggle='modal' data-target='#delete-transaction-modal' data-id='"+ value["id"] +"'>Delete</button></td>");
			    	// $('#view-transactions-table tbody').append("</tr>");
			    });
			    $("#add-transactions-button").prop("disabled", false);
				$("#add-transactions-button").show();
				$this.parent().children(".selected").removeClass("selected");
				$this.addClass("selected");
				$("#add-transaction-form #principal-amount-loan-transaction-form").val($this.children("td")[3].innerHTML);
				$("#add-transaction-form #interest-amount-loan-transaction-form").val($this.children("td")[4].innerHTML);
				$("#add-transaction-form #principal-balance-transaction-form").val($this.children("td")[5].innerHTML);
				$("#add-transaction-form #interest-balance-transaction-form").val($this.children("td")[6].innerHTML);
				$("#add-transaction-form #isActive-select").children("option").filter("."+$this.children("td")[7].innerHTML).prop("selected","selected");
				$("#add-transaction-form #status-transaction-form").val($this.children("td")[9].innerHTML);
				$("#add-transaction-form #cutoff-date-loan").val($this.children("td")[11].innerHTML);
				$("#edit-transaction-form #principal-amount-loan-transaction-form").val($this.children("td")[3].innerHTML);
				$("#edit-transaction-form #interest-amount-loan-transaction-form").val($this.children("td")[4].innerHTML);
				$("#edit-transaction-form #principal-balance-transaction-form").val($this.children("td")[5].innerHTML);
				$("#edit-transaction-form #interest-balance-transaction-form").val($this.children("td")[6].innerHTML);
				$("#edit-transaction-form #isActive-select").children("option").filter("."+$this.children("td")[7].innerHTML).prop("selected","selected");
				$("#edit-transaction-form #status-transaction-form").val($this.children("td")[9].innerHTML);
				$("#edit-transaction-form #cutoff-date-loan").val($this.children("td")[11].innerHTML);
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
					$("#view-loans-table tbody").append("<tr class='loan-structure' data-id=" + data["id"] + "><td>" + data["loan_type_id"] + "</td><td>" + data["loan_cycle"] + "</td><td>" + data["released_date"] + "</td><td>" + data["principal_amount"] + "</td><td>" + data["interest_amount"] + "</td><td>" + data["principal_balance"] + "</td><td>" + data["interest_balance"] + "</td><td>" + data["isActive"] + "</td><td>" + data["isReleased"] + "</td><td>" + data["status"] + "</td><td>" + data["maturity_date"] + "</td><td>" + data["cutoff_date"] + ($("#view-loans-information").data("activity") == 1 ? "</td><td><button type='button' class='btn btn-info btn-sm modal-button raised edit-loan-button' data-toggle='modal' data-target='#edit-loan-modal'>Edit Loan</button></td><td><button type='button' class='btn btn-danger btn-sm modal-button raised delete-loan-button' data-toggle='modal' data-target='#delete-loan-modal'>Delete Loan</button>" : "")+"</td></tr>")
					$("#add-loan-form").find("input[type=text]").val("");
					$("#add-loan-form").find("input[type=date]").val("");
					$("#add-loan-form").find("select option").prop("selected", "");
					$("#add-loan-form").find("select option[value='1']").prop("selected", "selected");
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

		$("#add-transaction-form #cutoff-date-loan").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
				return false;
			}
			if(new Date($(this).val()) < new Date($(".loan-structure.selected").children("td")[11].innerHTML)){
				valid = false;
				($(this).parent().find(".earlier-date")).show();
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
					var tempstring = "";
					status = Math.ceil((new Date(data["transaction"]["due_date"]).getTime()-new Date(data["transaction"]["payment_date"]).getTime())/(one_day));
					status = status < 0 ? -status + " days late" : status + " days early";
					tempstring += "<tr><td>"+ data["transaction"]["principal_amount"] +"</td><td>"+ data["transaction"]["interest_amount"] +"</td><td>"+ data["transaction"]["payment_date"] +"</td><td>"+ data["transaction"]["due_date"] +"</td><td>"+ status +"</td><td>" + data["transaction"]["cutoff_date"];
					if($("#view-transactions-information").data("activity") == 1){
						tempstring += "</td><td><button type='button' class='btn btn-info btn-sm modal-button raised edit-transaction-button' data-toggle='modal' data-target='#edit-transaction-modal' data-id='"+ data["transaction"]["id"] +"'>Edit Transaction</button></td><td><button type='button' class='btn btn-danger btn-sm modal-button raised delete-transaction-button' data-toggle='modal' data-target='#delete-transaction-modal' data-id='"+ data["transaction"]["id"] +"'>Delete Transaction</button>";
					}
					tempstring += "</td></tr>";
					$('#view-transactions-table tbody').append(tempstring);
					data["loan"]["isActive"] = (data["loan"]["isActive"] == 1 ? "True" : "False");
					var row = $('#view-loans-table .loan-structure.selected');
					row.children("td")[3].innerHTML = data["loan"]["principal_amount"];
					row.children("td")[4].innerHTML = data["loan"]["interest_amount"];
					row.children("td")[5].innerHTML = data["loan"]["principal_balance"];
					row.children("td")[6].innerHTML = data["loan"]["interest_balance"];
					row.children("td")[7].innerHTML = data["loan"]["isActive"];
					row.children("td")[9].innerHTML = data["loan"]["status"];
					row.children("td")[11].innerHTML = data["loan"]["cutoff_date"];
					$("#add-transaction-form").find("#transaction-part-form input[type=text]").val("");
					$("#add-transaction-form").find("#transaction-part-form input[type=date]").val("");
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
					alert(error)
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
					$("#view-tags-table tbody").append("<tr><td>"+ data["tag"]["name"] +"</td><td><button type='button' class='btn btn-danger btn-sm modal-button raised delete-tag-button' data-toggle='modal' data-target='#delete-tag-modal' data-id='"+ data["client_tag"]["id"] +"'>Delete Tag</button></td></tr>");
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

	$(document).on('click', '.delete-loan-button', function(){
		$("#delete-loan-id-modal").val($(this).parent().parent().data('id'));
	});

	$(document).on('click', '.delete-transaction-button', function(){
		$("#delete-transaction-id-modal").val($(this).data('id'));
	});

	$(document).on('click', '.delete-tag-button', function(){
		$("#delete-tag-id-modal").val($(this).data('id'));
	});

	$(document).on('click', '.edit-loan-button', function(){
		$("#edit-loan-form #loan-id-modal").val($(this).parent().parent().data('id'));

		var row = $(this).parent().parent();

		$("#edit-loan-form #loan-type").val(row.children("td")[0].innerHTML);
		$("#edit-loan-form #cycle-number").val(row.children("td")[1].innerHTML);
		$("#edit-loan-form #release-date").val(row.children("td")[2].innerHTML);
		$("#edit-loan-form #principal-amount-loan").val(row.children("td")[3].innerHTML);
		$("#edit-loan-form #interest-amount-loan").val(row.children("td")[4].innerHTML);
		$("#edit-loan-form #principal-balance").val(row.children("td")[5].innerHTML);
		$("#edit-loan-form #interest-balance").val(row.children("td")[6].innerHTML);
		$("#edit-loan-form #status").val(row.children("td")[9].innerHTML);
		$("#edit-loan-form #maturity-date").val(row.children("td")[10].innerHTML);
		$("#edit-loan-form #cutoff-date-loan").val(row.children("td")[11].innerHTML);
		$("#edit-loan-form #isActive-select").children("option").filter("."+row.children("td")[7].innerHTML).prop("selected","selected");
		$("#edit-loan-form #isReleased-select").children("option").filter("."+row.children("td")[8].innerHTML).prop("selected","selected");

		$("#edit-loan-form .help-block").hide();
		$("#edit-loan-form .form-group.has-error").removeClass("has-error");
	});

	$(document).on('click', '#edit-loan-submit', function(){
		$('#edit-loan-form').submit();
	});

	$('#edit-loan-form').submit(function() {
		var valid = true;

		$("#edit-loan-form .help-block").hide();
		$("#edit-loan-form .form-group.has-error").removeClass("has-error");
		
		$("#edit-loan-form .required-text").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-loan-form #release-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-loan-form #maturity-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-loan-form #cutoff-date-loan").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
				return false;
			}
			if(new Date($(this).val()) < new Date($(".loan-structure.selected").children("td")[11].innerHTML)){
				valid = false;
				($(this).parent().find(".earlier-date")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-loan-form .required-select").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-loan-form .required-number").each(function(){
			if(isNaN($(this).val())){
				valid = false;
				($(this).parent().find(".number")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});
		if(valid == false) return false;
        return true;
    });

	$(document).on('click', '.edit-transaction-button', function(){
		$("#edit-transaction-form #transaction-id-modal").val($(this).data('id'));

		var row = $(this).parent().parent();

		$("#edit-transaction-form #principal-amount-transaction").val(row.children("td")[0].innerHTML);
		$("#edit-transaction-form #interest-amount-transaction").val(row.children("td")[1].innerHTML);
		$("#edit-transaction-form #payment-date").val(row.children("td")[2].innerHTML);
		$("#edit-transaction-form #due-date").val(row.children("td")[3].innerHTML);
		$("#edit-transaction-form #cutoff-date-transaction").val(row.children("td")[5].innerHTML);
		$("#edit-transaction-form #cutoff-date-transaction").attr("data-saved", row.children("td")[5].innerHTML);

		$("#edit-transaction-form .help-block").hide();
		$("#edit-transaction-form .form-group.has-error").removeClass("has-error");
	});

	$(document).on('click', '#edit-transaction-submit', function(){
		$('#edit-transaction-form').submit();
	});

	$('#edit-transaction-form').submit(function() {
		var valid = true;

		$("#edit-transaction-form .help-block").hide();
		$("#edit-transaction-form .form-group.has-error").removeClass("has-error");
		
		$("#edit-transaction-form .required-text").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-transaction-form #payment-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-transaction-form #due-date").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-transaction-form #cutoff-date-transaction").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
				return false;
			}
			if(new Date($(this).val()) < new Date($(this).attr("data-saved"))){
				valid = false;
				($(this).parent().find(".earlier-date")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-transaction-form #cutoff-date-loan").each(function(){
			if(!isValidDate($(this).val())){
				valid = false;
				($(this).parent().find(".wrong-format")).show();
				($(this).parent().parent()).addClass("has-error");
				return false;
			}
			if(new Date($(this).val()) < new Date($(".loan-structure.selected").children("td")[11].innerHTML)){
				valid = false;
				($(this).parent().find(".earlier-date")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-transaction-form .required-select").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#edit-transaction-form .required-number").each(function(){
			if(isNaN($(this).val())){
				valid = false;
				($(this).parent().find(".number")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});
		if(valid == false) return false;
        return true;
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