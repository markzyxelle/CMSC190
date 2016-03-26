$( document ).ready(function() {	// $.post( "/getUsers/0", function(  ) {
	// 	alert( "dsfsdds" );
	// });

	// $.post( "/getUsers/0", { name: "John", time: "2pm" })
	// 	.done(function( data ) {
	//     	alert( "Data Loaded: " + data );
	// 	});

	// $.post("/getUsers/0", , function(data, textStatus) {
	// 	alert(data);
 //  //data contains the JSON object
 //  //textStatus contains the status: success, error, etc
	// }, "json");
	$.getJSON( "/getApprovedUsers/0" , function( resp ) {
		var htmlInside = "";
	    // Log each key in the response data
	    $.each( resp, function( key, value ) {
	    	htmlInside += "<tr>"
	    	htmlInside += "<td>"
	    	htmlInside += value['name']
	    	htmlInside += "</td>"
	    	htmlInside += "<td>"
	    	htmlInside += value['username']
	    	htmlInside += "</td>"
	    	htmlInside += "<td>"
	    	htmlInside += value['email']
	    	htmlInside += "</td>"
	        htmlInside += "<tr>"
	    });
	    $('#approved-users-table tbody').html(htmlInside);
	});

	$.getJSON( "/getPendingUsers/0" , function( resp ) {
		var htmlInside = "";
	    // Log each key in the response data
	    $.each( resp, function( key, value ) {
	    	htmlInside += "<tr>"
	    	htmlInside += "<td>"
	    	htmlInside += value['name']
	    	htmlInside += "</td>"
	    	htmlInside += "<td>"
	    	htmlInside += value['username']
	    	htmlInside += "</td>"
	    	htmlInside += "<td>"
	    	htmlInside += value['email']
	    	htmlInside += "</td>"
	    	htmlInside += "<td><button type='button' class='btn btn-info btn-sm modal-button' data-toggle='modal' data-target='#branchModal' data-value='"+ value['id'] +"'>Approve</button></td>"
	        htmlInside += "<tr>"
	    });
	    $('#pending-users-table tbody').html(htmlInside);
	});

	// $('.pagination').children().children().click(function() {
	// 	var clicked = $(this);
	// 	var start = clicked.html()-1;
	// 	$.getJSON( "/getApprovedUsers/" + start , function( resp ) {
	// 		var htmlInside = "";
	// 	    // Log each key in the response data
	// 	    $.each( resp, function( key, value ) {
	// 	    	htmlInside += "<tr>"
	// 	    	htmlInside += "<td>"
	// 	    	htmlInside += value['name']
	// 	    	htmlInside += "</td>"
	// 	    	htmlInside += "<td>"
	// 	    	htmlInside += value['username']
	// 	    	htmlInside += "</td>"
	// 	    	htmlInside += "<td>"
	// 	    	htmlInside += value['email']
	// 	    	htmlInside += "</td>"
	// 	        htmlInside += "<tr>"
	// 	    });
	// 	    $('#approved-users-table tbody').html(htmlInside);
	// 	    $('#approved-users-pagination li').removeClass("active");
	// 	    clicked.parent('li').addClass("active");
	// 	});
	// });

	$('#approved-users-pagination').children().children().on("click", function() {
		var clicked = $(this);
		var start = clicked.html()-1;
		$.getJSON( "/getApprovedUsers/" + start )
			.done(function( resp ) {
				var htmlInside = "";
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	htmlInside += "<tr>"
			    	htmlInside += "<td>"
			    	htmlInside += value['name']
			    	htmlInside += "</td>"
			    	htmlInside += "<td>"
			    	htmlInside += value['username']
			    	htmlInside += "</td>"
			    	htmlInside += "<td>"
			    	htmlInside += value['email']
			    	htmlInside += "</td>"
			        htmlInside += "<tr>"
			    });
			    $('#approved-users-table tbody').html(htmlInside);
			    $('#approved-users-pagination li').removeClass("active");
			    clicked.parent('li').addClass("active");
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	$('#pending-users-pagination').children().children().on("click", function() {
		var clicked = $(this);
		var start = clicked.html()-1;
		$.getJSON( "/getPendingUsers/" + start ) 
			.done(function( resp ) {
				var htmlInside = "";
			    // Log each key in the response data
			    $.each( resp, function( key, value ) {
			    	htmlInside += "<tr>"
			    	htmlInside += "<td>"
			    	htmlInside += value['name']
			    	htmlInside += "</td>"
			    	htmlInside += "<td>"
			    	htmlInside += value['username']
			    	htmlInside += "</td>"
			    	htmlInside += "<td>"
			    	htmlInside += value['email']
			    	htmlInside += "</td>"
			    	htmlInside += "<td><button type='button' class='btn btn-info btn-sm modal-button' data-toggle='modal' data-target='#branchModal' data-value='"+ value['id'] +"''>Approve</button></td>"
			        htmlInside += "<tr>"
			    });
			    $('#pending-users-table tbody').html(htmlInside);
			    $('#pending-users-pagination li').removeClass("active");
			    clicked.parent('li').addClass("active");
			})
			.fail(function( jqxhr, textStatus, error ) {
			    alert("There was an error");
		});
	});

	$(document).on('click', '.modal-button', function(){
		$("#user-id-modal").val($(this).data("value"));
	});

	$(document).on('click', '#approve-user-submit', function(){
		$( "#approve-user-form" ).submit();
	});
});