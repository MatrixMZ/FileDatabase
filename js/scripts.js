$("span.glyphicon-trash").click(function(){
    var row = $(this).closest('tr').attr('row');
    $.ajax({
        type: "POST",
        url: "php/ajax.php",
        data: {
            row: row,
            option: "delete"
        },
        success: function(msg) {
            $('#table').html(msg);
        }
    });
    
});
$("span.glyphicon-pencil").click(function(){
    var row = $(this).closest("tr").attr('row');
    var one = $('tr[row='+row+'] td[num=1]').text();
    var two = $('tr[row='+row+'] td[num=2]').text();
    var three = $('tr[row='+row+'] td[num=3]').text();
    $('tr[row='+row+']').html('<td>'+row+'</td><td><input value="'+one+'" id="name'+row+'" type="text" class="form-control" /></td><td><input id="lastname'+row+'" value="'+two+'" type="text" class="form-control" /></td><td><input id="pesel'+row+'" value="'+three+'" type="text" class="form-control" /></td><td><span class="sendedit glyphicon glyphicon-ok"></span> <span class="glyphicon glyphicon-remove reloadpage"></span></td>');
});
$(document).ready(function(){
    $(document).on("click", ".sendedit", function(){
        var row = $(this).closest('tr').attr('row');
        var name = $('input[id=name'+row+']').attr('value');
        var lastname = $('input[id=lastname'+row+']').attr('value');
        var pesel = $('input[id=pesel'+row+']').attr('value');

        if($.isNumeric(pesel) == true && pesel.length == 11 && $.isNumeric(name) == false && $.isNumeric(lastname) == false){
            $.ajax({
                type: "POST",
                url: "php/ajax.php",
                data: {
                option: "edit",
                row: row,
                name: name,
                lastname: lastname,
                pesel: pesel
            },
                success: function(msg) {
                $('#table').html(msg);
            }
            });
        }else{
            $('#adduser').html('Popraw błędy');
        }
    });
    $(document).on("click", ".reloadpage", function(){
        alert('reload');
        location.reload();
    });
});
$("#adduser").click(function(){
    var pesel = $('#pesel').val();
    var name = $('#name').val();
    var lastname = $('#lastname').val();
    if($.isNumeric(pesel) == true && pesel.length == 11 && $.isNumeric(name) == false && $.isNumeric(lastname) == false){
        $.ajax({
        type: "POST",
        url: "php/ajax.php",
        data: {
            option: "add",
            name: name,
            lastname: lastname,
            pesel: pesel
        },
        success: function(msg) {
            $('#table').html(msg);
            $('#adduser').html('Dodano');
        }
    });
    }else{
        $('#adduser').html('Popraw błędy');
    }
});
