$( document ).ready(function() {
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
		//$( "#center-breadcrumb" ).html( "asdasd" );
		//$( "#center-breadcrumb" ).data( "id", 52 );
		var center_id = $(this).data("id")
		$( "#center-breadcrumb" ).attr( "data-id", center_id );
		$( "#center-breadcrumb" ).html( $(this).html() );
		$("#center-id-modal").val(center_id);

		$.getJSON( "/getGroups/" + center_id ) 
			.done(function( resp ) {
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
		//$( "#center-breadcrumb" ).html( "asdasd" );
		//$( "#center-breadcrumb" ).data( "id", 52 );
		var group_id = $(this).data("id")
		$( "#group-breadcrumb" ).attr( "data-id", group_id );
		$( "#group-breadcrumb" ).html( $(this).html() );
		$("#group-id-modal").val(group_id);

		$.getJSON( "/getClients/" + group_id ) 
			.done(function( resp ) {
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

		$.ajax({
			type : 'POST',
			url: url,
			data : form,
			dataType : 'json',
			success : function(data) {
				$('#structure-table').append("<tr><td><a class='structure-center' data-id='" + data["id"] + "'>" + data["center_name"] + "</a><td></tr>");
				// alert(data["center_name"]);
				// $.each( data, function( key, value ) {
				// 	alert("key: " + key + " value: " + value);
			 //    })
			},
			error : function(data, text, error) {
				alert("error")
			}
		});
	});

	$('#add-group-form').submit(function(e){
		e.preventDefault();
		var form = $('#add-group-form').serialize();
		var url = $(this).data('url');

		$.ajax({
			type : 'POST',
			url: url,
			data : form,
			dataType : 'json',
			success : function(data) {
				$('#structure-table').append("<tr><td><a class='structure-group' data-id='" + data["id"] + "'>" + data["group_name"] + "</a><td></tr>");
				// alert(data["center_name"]);
				// $.each( data, function( key, value ) {
				// 	alert("key: " + key + " value: " + value);
			 //    })
			},
			error : function(data, text, error) {
				alert("error")
			}
		});
	});

	$(document).on('click', '#add-center-submit', function(){
		$('#add-center-form').submit();
	});

	$(document).on('click', '#add-group-submit', function(){
		$('#add-group-form').submit();
	});

	$( "#branch-breadcrumb" ).click();
});