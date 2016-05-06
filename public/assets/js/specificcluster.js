$( document ).ready(function() {
	//branch breadcrumb clicked
	//populates the tbody
	$("#structure-select-all").prop("checked", false);
	$("#moving-select-all").prop("checked", false);
	$("#view-select-all").prop("checked", false);
	$(document).on('click', '#branch-breadcrumb', function(){
		var branch_id = $("#branch-breadcrumb").data('id');
		$.getJSON( "/getCenters/" + branch_id ) 
			.done(function( resp ) {
				$('#structure-table tbody').html("");
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	$('#structure-table').append("<tr><td><input type='checkbox' name='center' value='"+ value["id"] +"'  /><a class='structure-center' data-id='" + value["id"] + "'>  " + value["name"] + "</a><td></tr>");
			    });
			    //removes data and text in both breadcrumb DOM 
			    $( "#center-breadcrumb" ).attr( "data-id", "" );
				$( "#center-breadcrumb" ).html( "" );
				$("#center-id-modal").val("");
				$( "#group-breadcrumb" ).attr( "data-id", "" );
				$( "#group-breadcrumb" ).html( "" );
				$("#group-id-modal").val("");
				$("#add-center-button").show();
				$("#add-group-button").hide();
				$("#add-client-button").hide();
				$("#search-div").hide();
				$("#structure-select-all").prop("checked", false);
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	//center breadcrumb clicked
	//populates the tbody
	$(document).on('click', '#center-breadcrumb', function(){
		var center_id = $("#center-breadcrumb").data('id');
		$.getJSON( "/getGroups/" + center_id ) 
			.done(function( resp ) {
				$('#structure-table tbody').html("");
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	$('#structure-table').append("<tr><td><input type='checkbox' name='group' value='"+ value["id"] +"'  /><a class='structure-group' data-id='" + value["id"] + "'>  " + value["name"] + "</a><td></tr>");
			    });
			    //removes data and text in group breadcrumb DOM 
				$( "#group-breadcrumb" ).attr( "data-id", "" );
				$( "#group-breadcrumb" ).html( "" );
				$("#group-id-modal").val("");
				$("#add-center-button").hide();
				$("#add-group-button").show();
				$("#add-client-button").hide();
				$("#search-div").hide();
				$("#structure-select-all").prop("checked", false);
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	//one center is clicked
	$(document).on('click', '.structure-center', function(){
		var center_id = $(this).data("id");
		var $this = $(this);
		//$( "#center-breadcrumb" ).html( "asdasd" );
		//$( "#center-breadcrumb" ).data( "id", 52 );

		$.getJSON( "/getGroups/" + center_id ) 
			.done(function( resp ) {
				$( "#center-breadcrumb" ).attr( "data-id", center_id );
				$( "#center-breadcrumb" ).html( $this.html() );
				$("#center-id-modal").val(center_id);

				$('#structure-table tbody').html("");
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	$('#structure-table').append("<tr><td><input type='checkbox' name='group' value='"+ value["id"] +"'  /><a class='structure-group' data-id='" + value["id"] + "'>  " + value["name"] + "</a><td></tr>");
			    });
			    $("#add-center-button").hide();
				$("#add-group-button").show();
				$("#add-client-button").hide();
				$("#search-div").hide();
				$("#structure-select-all").prop("checked", false);
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	//one group is clicked
	$(document).on('click', '.structure-group', function(){
		var group_id = $(this).data("id");
		var $this = $(this);
		//$( "#center-breadcrumb" ).html( "asdasd" );
		//$( "#center-breadcrumb" ).data( "id", 52 );

		$.getJSON( "/getClients/" + group_id ) 
			.done(function( resp ) {
				$( "#group-breadcrumb" ).attr( "data-id", group_id );
				$( "#group-breadcrumb" ).html( $this.html() );
				$("#group-id-modal").val(group_id);

				$('#structure-table tbody').html("");
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	$('#structure-table').append("<tr class='structure-client'><td><input type='checkbox' name='client' value='"+ value["id"] +"'  /><a class='structure-client' data-id='" + value["id"] + "'>  " + value["last_name"]+ ", " + value["first_name"] + " " + value["middle_name"] + "</a><td></tr>");
			    });
			    $("#add-center-button").hide();
				$("#add-group-button").hide();
				$("#add-client-button").show();
				$("#search-div").show();
				$("#structure-select-all").prop("checked", false);
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	

	// $("tr").click(function(){
	//     $(this).addClass("selected").siblings().removeClass("selected");
	// });​

	
	$(document).on('click', '#select-button', function(){
		var selected = [];
		var name = [];
		var url;
		switch($("#structure-table input:checkbox:checked").not("#structure-select-all").first().attr("name")){
			case "center" : url = "getClientsFromCenter";
							break;
			case "group" : url = "getClientsFromGroup";
							break;
			case "client" : url = "getClient";
							break;
			default : alert("Please Select a Client");
						return;
		}

		$("#structure-table input:checkbox:checked").not("#structure-select-all").each(function(){
			selected.push($(this).val());
			name.push($(this).parent().children("a").html());
		});

		var tag_id = $("#tag-id").val();

		for(index in selected){
			$.getJSON( "/" + url + "/" + selected[index] + "/" + tag_id ) 
				.done(function( resp ) {
					// alert(resp);
				    // Log each key in the response data
				    $.each( resp, function( key, value ) {
				    	if(!($(".moving-client[data-id="+ value["id"] + "]").length))
				    		$('#selected-clients-table').append("<tr><td><input type='checkbox' name='client' value='"+ value["id"] +"'  /><a class='moving-client' data-id='" + value["id"] + "'>  " + value["last_name"]+ ", " + value["first_name"] + " " + value["middle_name"] +"</a><td></tr>");
				    });
				})
				.fail(function( jqxhr, textStatus, error ) {
				    alert(error);
			});
		}


		$( "#structure-table input:checkbox:checked" ).prop( "checked", false );
		
	});

	$(document).on('click', '#remove-button', function(){
		$("#selected-clients-table input:checkbox:checked").not("#moving-select-all").each(function(){
			$(this).parent().parent().remove();
		});
		$("#moving-select-all").prop("checked", false);
	});

	$('#add-client-form').submit(function(){
		var selected = [];
		$("#selected-clients-table a").each(function(){
			selected.push($(this).data("id"));
		});
		var $cluster_id = $("<input type='hidden' name='cluster_id'/>")
		$cluster_id.val($("#cluster-body").data("id"));
		$(this).append($cluster_id);
        var $hidden = $("<input type='hidden' name='clients'/>");
        $hidden.val(JSON.stringify(selected));
        $(this).append($hidden);
        return true;
	});

	$('#remove-client-form').submit(function(){
		var selected = [];
		$("#view-clients-table input:checkbox:checked").not("#view-select-all").each(function(){
			selected.push($(this).val());
		});
		var $cluster_id = $("<input type='hidden' name='cluster_id'/>")
		$cluster_id.val($("#cluster-body").data("id"));
		$(this).append($cluster_id);
        var $hidden = $("<input type='hidden' name='clients'/>");
        $hidden.val(JSON.stringify(selected));
        $(this).append($hidden);
        return true;
	});

	$(document).on('click', '.edit-user-button', function(){
		var cluster_user_id = $(this).data('id');

		$.getJSON( "/getActions/" + cluster_user_id ) 
			.done(function( resp ) {
				$("#cluster-user-id-edit-modal").val(cluster_user_id);
				$("#edit-user-form input[type=checkbox]").prop( "checked", false );
				for (var i = 0; i <= resp.length - 1; i++) {
					var temp = resp[i] - 1;
					$("#edit-user-form input[type=checkbox]")[temp].checked = true;
				};
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	$(document).on('click', '#edit-user-submit', function(){
		$('#edit-user-form').submit();
	});

	$(document).on('click', '.approve-user-button', function(){
		var cluster_user_id = $(this).data('id');

		$("#cluster-user-id-approve-modal").val(cluster_user_id);
	});

	$(document).on('click', '#approve-user-submit', function(){
		$('#approve-user-form').submit();
	});

	$("#search-client-cluster-form .help-block").hide();

	//region is selected
	//populates province
	//clears lower categories
	$( "#region-select" ).change(function() {
		var region_id = $(this).val();
		if(region_id == ""){
			$("#province-select").html("");
			$("#municipality-select").html('<option value="">None</option>');
			$("#barangay-select").html('<option value="">None</option>');
			$("#province-select").append('<option value="">None</option>');
		}
		else{
			$.getJSON( "/getProvinces/" + region_id ) 
				.done(function( resp ) {
					$("#province-select").html("");
					$("#municipality-select").html('<option value="">None</option>');
					$("#barangay-select").html('<option value="">None</option>');
					$("#province-select").append('<option value="">None</option>');
					$.each( resp, function( key, value ) {
				    	$("#province-select").append('<option value="'+ value["id"] +'">'+ value["name"] +'</option>');
					});
				})
				.fail(function( jqxhr, textStatus, error ) {
				    alert("There was an error");
			});
		}
	});

	//province is selected
	//municipalities province
	//clears lower categories
	$( "#province-select" ).change(function() {
		var province_id = $(this).val();
		if(province_id == ""){
			$("#municipality-select").html("");
			$("#barangay-select").html('<option value="">None</option>');
			$("#municipality-select").append('<option value="">None</option>');
		}
		else{
			$.getJSON( "/getMunicipalities/" + province_id ) 
				.done(function( resp ) {
					$("#municipality-select").html("");
					$("#barangay-select").html('<option value="">None</option>');
					$("#municipality-select").append('<option value="">None</option>');
					$.each( resp, function( key, value ) {
				    	$("#municipality-select").append('<option value="'+ value["id"] +'">'+ value["name"] +'</option>');
					});
				})
				.fail(function( jqxhr, textStatus, error ) {
				    alert("There was an error");
			});
		}
	});

	//municipality is selected
	//populates barangay
	$( "#municipality-select" ).change(function() {
		var municipality_id = $(this).val();
		if(municipality_id == ""){
			$("#barangay-select").html("");
			$("#barangay-select").append('<option value="">None</option>');
		}
		else{
			$.getJSON( "/getBarangays/" + municipality_id ) 
				.done(function( resp ) {
					$("#barangay-select").html("");
					$("#barangay-select").append('<option value="">None</option>');
					$.each( resp, function( key, value ) {
				    	$("#barangay-select").append('<option value="'+ value["id"] +'">'+ value["name"] +'</option>');
					});
				})
				.fail(function( jqxhr, textStatus, error ) {
				    alert("There was an error");
			});
		}
	});

	$(document).on('click', '#search-client-submit', function(){
		$("#search-client-cluster-form").submit();
	});

	$('#search-client-cluster-form').submit(function(e){
		e.preventDefault();
		var form = $('#search-client-cluster-form').serialize();
		var url = $(this).data('url');
		var valid = true;

		$("#search-client-cluster-form .help-block").hide();
		$("#search-client-cluster-form .has-error").removeClass("has-error");
		
		$("#search-client-cluster-form .required-text").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent()).addClass("has-error");
			}
			if($(this).val().length > 255){
				valid = false;
				($(this).parent().find(".max")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#search-client-cluster-form .required-select").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#search-client-cluster-form .check-length").each(function(){
			if($(this).val().length > 255){
				valid = false;
				($(this).parent().find(".max")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});

		$("#search-client-cluster-form #birthdate").each(function(){
			if(!isValidDate($(this).val()) && $(this).val() != ""){
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
					console.log(JSON.stringify(data));
					switch(parseInt(data["setting"])){
						case 1:
							$("#search-results-table thead").html("<tr><td>Has Record?</td></tr>");
							$("#search-results-table tbody").html("<tr><td><strong>"+ (data["data"] ? "The client has a record in this cluster" : "The client has no records in this cluster") +"</strong></td></tr>");
							break;
						case 2:
							$("#search-results-table tbody").html("");
							$("#search-results-table thead").html("");
							if(data["data"].length == 0) $("#search-results-table tbody").html("<strong>The client has no records in this cluster</strong>");
							else{
								$.each( data["data"], function( key, value ) {
									$("#search-results-table thead").append("<tr><td>MFI</td><td>Number of Loans</td></tr>");
									$("#search-results-table tbody").append("<tr><td>"+ value["name"] + "</td><td>"+ value["count"] +"</td></tr>");
								})
							}
							break;	
						case 3:
							$("#search-results-table tbody").html("");
							$("#search-results-table thead").html("");
							if(data["data"].length == 0) $("#search-results-table tbody").html("<strong>The client has no records in this cluster</strong>");
							else{
								$("#search-results-table thead").html("<tr><td colspan='8'>MFI</td></tr>");
								$.each( data["data"], function( key, value ) {
									$("#search-results-table tbody").append("<tr><td colspan='8'>"+ key +"</td></tr>");
									$("#search-results-table tbody").append("<tr><td></td><td>Branch</td><td>L. Type</td><td>Cycle</td><td>L. Amt.</td><td>Mat. Date</td><td>Status</td><td>As Of</td></tr>");
									$.each( value, function( x, loan ) {
										$("#search-results-table tbody").append("<tr><td></td><td>"+ loan["branch_name"] +"</td><td>"+ loan["loan_type_id"] +"</td><td>"+ loan["loan_cycle"] +"</td><td>"+ loan["principal_amount"] +"</td><td>"+ loan["maturity_date"] +"</td><td>"+ loan["status"] +"</td><td>" + loan["cutoff_date"] + "</td></tr>");
									})
								})
							}
							break;
						case 4:
							$("#search-results-table tbody").html("");
							$("#search-results-table thead").html("");
							if(data["data"].length == 0) $("#search-results-table tbody").html("<strong>The client has no records in this cluster</strong>");
							else{
								$("#search-results-table thead").html("<tr><td colspan='8'>MFI</td></tr>");
								$("#search-results-table tbody").html("");
								$.each( data["data"], function( key, value ) {
									$("#search-results-table tbody").append("<tr><td colspan='8'>"+ key +"</td></tr>");
									$("#search-results-table tbody").append("<tr><td></td><td>Branch</td><td>L. Type</td><td>Cycle</td><td>L. Amt.</td><td>Mat. Date</td><td>Status</td><td>As Of</td></tr>");
									$.each( value, function( x, loan ) {
										$("#search-results-table tbody").append("<tr><td></td><td>"+ loan["branch_name"] +"</td><td>"+ loan["loan_type_id"] +"</td><td>"+ loan["loan_cycle"] +"</td><td>"+ loan["principal_amount"] +"</td><td>"+ loan["maturity_date"] +"</td><td>"+ loan["status"] +"</td><td>" + loan["cutoff_date"] + "</td></tr>");
										if(loan["transactions"].length > 0) $("#search-results-table tbody").append("<tr><td></td><td></td><td>Transactions</td><td>Principal Amount</td><td>Interest Amount</td><td>Payment Date</td><td>Due Date</td><td>As of</td></tr>");
										$.each( loan["transactions"], function( y,transaction ) {
											$("#search-results-table tbody").append("<tr><td></td><td></td><td></td><td>"+ transaction["principal_amount"] +"</td><td>"+ transaction["interest_amount"] +"</td><td>"+ transaction["payment_date"] +"</td><td>"+ transaction["due_date"] +"</td><td>"+ transaction["cutoff_date"] + "</td></tr>");
										})
									})
								})
							}
							break;					
					}
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

	$( "#search-textbox" ).keyup(function() {
		if($(this).val() == "") $(".structure-client").show();
		else{
			$(".structure-client").hide();
			$(".structure-client")
				.filter(function( index ) {
				return ($( this ).children("td")[0].innerHTML).indexOf($( "#search-textbox" ).val()) > -1;
			})
				.show();
		}
	});

	$( "#structure-select-all" ).change(function() {
		var status = $(this).prop("checked");
		$(".structure-center").parent().children("input[type=checkbox]").prop("checked", status);
		$(".structure-group").parent().children("input[type=checkbox]").prop("checked", status);
		$(".structure-client").parent().children("input[type=checkbox]").prop("checked", status);
	});

	$( "#moving-select-all" ).change(function() {
		var status = $(this).prop("checked");
		$(".moving-client").parent().children("input[type=checkbox]").prop("checked", status);
	});

	$( "#view-select-all" ).change(function() {
		var status = $(this).prop("checked");
		$(".view-client").children("input[type=checkbox]").prop("checked", status);
	});

	$( "#branch-breadcrumb" ).click();
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