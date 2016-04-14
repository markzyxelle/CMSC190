$( document ).ready(function() {
	$("#addClientModal .help-block").hide();
	//branch breadcrumb clicked
	//populates the tbody
	$(document).on('click', '#branch-breadcrumb', function(){
		var branch_id = $("#branch-breadcrumb").data('id');
		$.getJSON( "/getCenters/" + branch_id ) 
			.done(function( resp ) {
				$('#structure-table tbody').html("");
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	$('#structure-table').append("<tr><td><a class='structure-center' data-id='" + value["id"] + "'>" + value["name"] + "</a><td></tr>");
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
			    	$('#structure-table').append("<tr><td><a class='structure-group' data-id='" + value["id"] + "'>" + value["name"] + "</a><td></tr>");
			    });
			    //removes data and text in group breadcrumb DOM 
				$( "#group-breadcrumb" ).attr( "data-id", "" );
				$( "#group-breadcrumb" ).html( "" );
				$("#group-id-modal").val("");
				$("#add-center-button").hide();
				$("#add-group-button").show();
				$("#add-client-button").hide();
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
			    	$('#structure-table').append("<tr><td><a class='structure-group' data-id='" + value["id"] + "'>" + value["name"] + "</a><td></tr>");
			    });
			    $("#add-center-button").hide();
				$("#add-group-button").show();
				$("#add-client-button").hide();
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
			    	$('#structure-table').append("<tr><td><a class='structure-client' data-id='" + value["id"] + "'>" + value["first_name"] + "</a><td></tr>");
			    });
			    $("#add-center-button").hide();
				$("#add-group-button").hide();
				$("#add-client-button").show();
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	$('#add-center-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-center-form').serialize();
		var url = $(this).data('url');
		var unique = true;
		

		//center name is required
		if($("#center-name").val() == ""){
			$("#center-required-span").show();
			$("#center-required-strong").show();
			$("#center-unique-span").hide();
			$("#center-unique-strong").hide();
			$("#center-name-form").addClass( "has-error" );
		}
		else{
			//check if name is already used
			$(".structure-center").each(function( index ) {
				if($(this).html() == $("#center-name").val()){
					$("#center-unique-span").show();
					$("#center-unique-strong").show();
					$("#center-required-span").hide();
					$("#center-required-strong").hide();
					$("#center-name-form").addClass( "has-error" );
					unique = false;
					return false;
				}
			});

			//AJAX: post to database
			if(unique == true){
				$.ajax({
					type : 'POST',
					url: url,
					data : form,
					dataType : 'json',
					success : function(data) {
						$('#structure-table').append("<tr><td><a class='structure-center' data-id='" + data["id"] + "'>" + data["name"] + "</a><td></tr>");
						$("#center-unique-span").hide();
						$("#center-unique-strong").hide();
						$("#center-required-span").hide();
						$("#center-required-strong").hide();
						$("#center-name-form").removeClass( "has-error" );
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
		}
	});

	$('#add-group-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-group-form').serialize();
		var url = $(this).data('url');
		var unique = true;
		

		//group name is required
		if($("#group-name").val() == ""){
			$("#group-required-span").show();
			$("#group-required-strong").show();
			$("#group-unique-span").hide();
			$("#group-unique-strong").hide();
			$("#group-name-form").addClass( "has-error" );
		}
		else{
			//check if name is already used
			$(".structure-group").each(function( index ) {
				if($(this).html() == $("#group-name").val()){
					$("#group-unique-span").show();
					$("#group-unique-strong").show();
					$("#group-required-span").hide();
					$("#group-required-strong").hide();
					$("#group-name-form").addClass( "has-error" );
					unique = false;
					return false;
				}
			});

			//AJAX: post to database
			if(unique == true){
				$.ajax({
					type : 'POST',
					url: url,
					data : form,
					dataType : 'json',
					success : function(data) {
						$('#structure-table').append("<tr><td><a class='structure-group' data-id='" + data["id"] + "'>" + data["name"] + "</a><td></tr>");
						$("#group-required-span").hide();
						$("#group-required-strong").hide();
						$("#group-unique-span").hide();
						$("#group-unique-strong").hide();
						$("#group-name-form").removeClass( "has-error" );
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
		}
	});

	$('#add-client-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-client-form').serialize();
		var url = $(this).data('url');
		var valid = true;

		$("#addClientModal .help-block").hide();
		$("#addClientModal .form-group.has-error").removeClass("has-error");
		
		$(".required-text").each(function(){
			if($(this).val() == ""){
				valid = false;
				($(this).parent().find(".required")).show();
				($(this).parent().parent()).addClass("has-error");
			}
		});
	});

	$(document).on('click', '#add-center-submit', function(){
		$('#add-center-form').submit();
	});

	$(document).on('click', '#add-group-submit', function(){
		$('#add-group-form').submit();
	});

	$(document).on('click', '#add-client-submit', function(){
		$('#add-client-form').submit();
	});

	//region is selected
	//populates province
	//clears lower categories
	$( "#region-select" ).change(function() {
		var region_id = $(this).val();
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
	});

	//province is selected
	//municipalities province
	//clears lower categories
	$( "#province-select" ).change(function() {
		var province_id = $(this).val();
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
	});

	//municipality is selected
	//populates barangay
	$( "#municipality-select" ).change(function() {
		var municipality_id = $(this).val();
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
	});

	// $("tr").click(function(){
	//     $(this).addClass("selected").siblings().removeClass("selected");
	// });​

	$( "#branch-breadcrumb" ).click();
});