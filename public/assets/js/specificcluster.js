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
			    	$('#structure-table').append("<tr><td><input type='checkbox' name='client' value='"+ value["id"] +"'  /><a class='structure-client' data-id='" + value["id"] + "'>  " + value["first_name"] + "</a><td></tr>");
			    });
			    $("#add-center-button").hide();
				$("#add-group-button").hide();
				$("#add-client-button").show();
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
		switch($("#structure-table input:checkbox:checked").first().attr("name")){
			case "center" : url = "getClientsFromCenter";
							break;
			case "group" : url = "getClients";
							break;
			case "client" : url = "getClient";
							break;
			default : alert("Please Select a Client");
						return;
		}

		$("#structure-table input:checkbox:checked").each(function(){
			selected.push($(this).val());
			name.push($(this).parent().children("a").html());
		});

		for(index in selected){
			$.getJSON( "/" + url + "/" + selected[index] ) 
				.done(function( resp ) {
				    // Log each key in the response data
				    $.each( resp, function( key, value ) {
				    	if(!($(".moving-client[data-id="+ value["id"] + "]").length))
				    		$('#selected-clients-table').append("<tr><td><input type='checkbox' name='client' value='"+ value["id"] +"'  /><a class='moving-client' data-id='" + value["id"] + "'>  " + value["first_name"] + "</a><td></tr>");
				    });
				})
				.fail(function( jqxhr, textStatus, error ) {
				    alert("There was an error while accessing " + name[index]);
			});
		}
		$( "#structure-table input:checkbox:checked" ).prop( "checked", false );
		
	});

	$(document).on('click', '#remove-button', function(){
		$("#selected-clients-table input:checkbox:checked").each(function(){
			$(this).parent().parent().remove();
		});
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
		$("#view-clients-table input:checkbox:checked").each(function(){
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

	$( "#branch-breadcrumb" ).click();
});