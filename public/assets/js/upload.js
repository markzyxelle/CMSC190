$( document ).ready(function() {
    $("#client-approve-button").hide();
    $("#loan-approve-button").hide();

    var clients;
    //return json format of clients and show summarized report of clients
    $('#upload-client-csv').submit(function(e){
        e.preventDefault();
        // var form = $('#upload-csv').serialize();
        var form = new FormData();
        var url = $(this).data('url');

        form.append('_token', $("input[name='_token']").val())
        form.append('fileToUpload', $('#client-file')[0].files[0]);

        $.ajax({
            type : 'POST',
            url: url,
            data : form,
            dataType : 'json',
            processData: false,
            contentType: false,
            success : function(data) {
                clients = data;
                var approved = 0;
                var rejected = 0;
                var valid = true;
                //populate table
                $("#client-summary-table tbody").html("");
                $("#client-upload-status").html("");
                //place here
                $.each(data, function(x, item) {
                    if(x == 0 && item.length == 2){
                        valid = false;
                        return false;
                    }
                    // item[17] = "xxxxxxx";
                    // alert("Client " + x + " has details " + item);
                    if(x != 0){
                        (item[28]&&item[29] ? approved++ : rejected++);
                        $("#client-summary-table tbody").append("<tr" + (item[29] ? "" : " class='cutoff-date-error'") + (item[28] ? "" : " class='false'")  + "><td "+ (item[0] ? "" : "class='false'") +">" + item[1] + "</td><td "+ (item[2] ? "" : "class='false'") +">" + item[3] + "</td><td "+ (item[4] ? "" : "class='false'") +">" + item[5] + "</td><td "+ (item[6] ? "" : "class='false'") +">" + item[7] + "</td><td "+ (item[8] ? "" : "class='false'") +">" + item[9] + "</td><td "+ (item[10] ? "" : "class='false'") +">" + item[11] + "</td><td "+ (item[12] ? "" : "class='false'") +">" + item[13] + "</td><td "+ (item[14] ? "" : "class='false'") +">" + item[15] + "</td><td "+ (item[16] ? "" : "class='false'") +">" + item[17] + "</td><td "+ (item[18] ? "" : "class='false'") +">" + item[19] + "</td><td "+ (item[20] ? "" : "class='false'") +">" + item[21] + "</td><td "+ (item[22] ? "" : "class='false'") +">" + item[23] + "</td><td "+ (item[24] ? "" : "class='false'") +">" + item[25] + "</td><td "+ (item[26] ? "" : "class='false'") +">" + item[27] + "</td></tr>");
                    }
                    // $.each(item["transaction"], function(i, temp) {
                    //     alert("Client " + x + " has transaction details " + temp);
                    // });
                    // alert(item["transaction"]);
                });
                if(valid == true){
                    $("#client-upload-status").append("<div class='alert alert-info'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Data as of <strong id='success-number'>" + data[0][0] + ".</strong></div><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong id='success-number'>" + approved + "</strong> rows were successfully processed.</div><div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong id='failed-number'>" + rejected + "</strong> rows were not processed.</div>");
                    $("#client-approve-button").show();
                    $("#client-approve-button").removeAttr("disabled");
                }
                else{
                    $("#client-upload-status").append("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" + data[0][1] + "</strong></div>");
                }
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
    
    var loans;
    //return json format of loans and show summarized report of loans
    $('#upload-loan-csv').submit(function(e){
        e.preventDefault();
        // var form = $('#upload-csv').serialize();
        var form = new FormData();
        var url = $(this).data('url');

        form.append('_token', $("input[name='_token']").val())
        form.append('fileToUpload', $('#loan-file')[0].files[0]);

        var i;

        $.ajax({
            type : 'POST',
            url: url,
            data : form,
            dataType : 'json',
            processData: false,
            contentType: false,
            success : function(data) {
                loans = data;

                var loanApproved = 0;
                var loanRejected = 0;
                var transactionApproved = 0;
                var transactionRejected = 0;
                var valid = true;
                //populate table
                $("#loan-summary-table tbody").html("");
                $("#loan-upload-status").html("");
                $.each(data, function(x, item) {
                    if(x == 0 && item.length == 2){
                        valid = false;
                        return false;
                    }

                    if(x != 0){
                        // alert("x : " + x);
                        ((item["loan"][26]&&item["loan"][27]) ? loanApproved++ : loanRejected++);
                        $("#loan-summary-table tbody").append("<tr class='main-row" + (item["loan"][27] ? "" : " cutoff-date-error'")  + (item["loan"][26] ? "" : " false") + "' data-id='" + x + "'><td "+ (item["loan"][0] ? "" : "class='false'") +">" + item["loan"][1] + "</td><td "+ (item["loan"][2] ? "" : "class='false'") +">" + item["loan"][3] + "</td><td "+ (item["loan"][4] ? "" : "class='false'") +">" + item["loan"][5] + "</td><td "+ (item["loan"][6] ? "" : "class='false'") +">" + item["loan"][7] + "</td><td "+ (item["loan"][8] ? "" : "class='false'") +">" + item["loan"][9] + "</td><td "+ (item["loan"][10] ? "" : "class='false'") +">" + item["loan"][11] + "</td><td "+ (item["loan"][12] ? "" : "class='false'") +">" + item["loan"][13] + "</td><td "+ (item["loan"][14] ? "" : "class='false'") +">" + item["loan"][15] + "</td><td "+ (item["loan"][16] ? "" : "class='false'") +">" + item["loan"][17] + "</td><td "+ (item["loan"][18] ? "" : "class='false'") +">" + item["loan"][19] + "</td><td "+ (item["loan"][20] ? "" : "class='false'") +">" + item["loan"][21] + "</td><td "+ (item["loan"][22] ? "" : "class='false'") +">" + item["loan"][23] + "</td><td "+ (item["loan"][24] ? "" : "class='false'") +">" + item["loan"][25] + "</td></tr>");

                        // $("#loan-summary-table tbody").append('<tr><td colspan="5" ><table class="transaction-table" cellpadding="0" cellspacing="0"><thead><tr><th>Principal Paid</th><th>Interest Paid</th><th>Payment Date</th><th>Due Date</th></thead><tbody>');
                        if(item["transactions"].length > 0) $("#loan-summary-table tbody").append("<tr class='transaction-row' data-id='" + x + "'><td colspan='3'>Transaction</td><td colspan='2'>ID</td><td colspan='2'>Principal Paid</td><td colspan='2'>Interest Paid</td><td colspan='2'>Payment Date</td><td colspan='2'>Due Date</td></tr>");
                        $.each(item["transactions"], function(i, temp) {
                            $("#loan-summary-table tbody").append("<tr class='transaction-row" + (temp[11] ? "" : " cutoff-date-error") + (temp[10] ? "" : " false") + "' data-id='" + x + "'><td colspan='3'></td><td colspan='2' "+ (temp[0] ? "" : " class='false'") +">" + temp[1] + "</td><td colspan='2' "+ (temp[2] ? "" : " class='false'") +">" + temp[3] + "</td><td colspan='2' "+ (temp[4] ? "" : " class='false'") +">" + temp[5] + "</td><td colspan='2' "+ (temp[6] ? "" : " class='false'") +">" + temp[7] + "</td><td colspan='2' "+ (temp[8] ? "" : " class='false'") +">" + temp[9] + "</td></tr>");
                            ((temp[10]&&temp[11]) ? transactionApproved++ : transactionRejected++);
                            // alert("Client " + x + " has transaction details " + temp);
                            // $("#loan-summary-table tbody").append('<tr><td>' + temp[0] + '</td><td>' + temp[1] + '</td><td>' + temp[2] + '</td><td>' + temp[3] + '</td><td>' + temp[4] + '</td></tr>');
                        });
                        // $("#loan-summary-table tbody").append("</span>");
                        // $("#loan-summary-table tbody").append('</tbody></table></td></tr>');
                    }
                });
                if(valid == true){
                    $("#loan-upload-status").append("<div class='alert alert-info'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Data as of <strong>" + data[0][0] + ".</strong></div><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" + loanApproved + "</strong> loan rows were successfully processed.</div><div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" + loanRejected + "</strong> loan rows were not processed.</div><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" + transactionApproved + "</strong> transaction rows were processed.</div><div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" + transactionRejected + "</strong> transaction rows were not processed.</div>");
                    $("#loan-approve-button").show();
                    $("#loan-approve-button").removeAttr("disabled");
                }
                else{
                    $("#loan-upload-status").append("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" + data[0][1] + "</strong></div>");
                }
            },
            error : function(data, text, error) {
                alert(error);
            }
        });
    });

    $('#approve-loans-csv').submit(function() {
        var $hidden = $("<input type='hidden' name='loans'/>");
        $hidden.val(JSON.stringify(loans));
        $(this).append($hidden);
        return true;
    });
});