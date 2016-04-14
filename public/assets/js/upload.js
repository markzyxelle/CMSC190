$( document ).ready(function() {
    $("#client-approve-button").hide();

    var clients;
    $('#upload-csv').submit(function(e){
        e.preventDefault();
        // var form = $('#upload-csv').serialize();
        var form = new FormData();
        var url = $(this).data('url');

        form.append('_token', $("input[name='_token']").val())
        form.append('fileToUpload', $('#fileToUpload')[0].files[0]);

        $.ajax({
            type : 'POST',
            url: url,
            data : form,
            dataType : 'json',
            processData: false,
            contentType: false,
            success : function(data) {
                clients = data;
                //populate table
                $("#summary-table tbody").html("");
                $.each(data, function(x, item) {
                    // item[17] = "xxxxxxx";
                    // alert("Client " + x + " has details " + item);
                    $("#client-summary-table tbody").append("<tr><td>" + item[0] + "</td><td>" + item[2] + "</td><td>" + item[3] + "</td><td>" + item[4] + "</td><td>" + item[5] + "</td><td>" + item[6] + "</td><td>" + item[7] + "</td><td>" + item[8] + "</td><td>" + item[10] + "</td><td>" + item[11] + "</td><td>" + item[14] + "</td><td>" + item[16] + "</td><td>" + item[17] + "</td></tr>");
                    // $.each(item["transaction"], function(i, temp) {
                    //     alert("Client " + x + " has transaction details " + temp);
                    // });
                    // alert(item["transaction"]);
                });
                $("#client-approve-button").show();
                $("#client-approve-button").removeAttr("disabled");
            },
            error : function(data, text, error) {
                alert("error")
            }
        });
    });

    $('#approve-clients-csv').submit(function() {
        var $hidden = $("<input type='hidden' name='clients'/>");
        $hidden.val(JSON.stringify(clients));
        $(this).append($hidden);
        return true;
    });
    // $(document).on('click', 'body', function(){
    //     alert(JSON.stringify(test));
    // });
});