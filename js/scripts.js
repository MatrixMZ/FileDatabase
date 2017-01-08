$("[xd]").click(function() {
var x = $(this).attr('x');
var y = $(this).attr('y');
alert('kappa');
var text = $(this).html();
    $.ajax({
        type: "POST",
        url: "php/ajax.php",
        data: {
            name: text,
            age: 'stary dziad',
            row: row
        },
        success: function(msg) {
            $('#table').html(msg);
        },
        complete: function() {
        },
        error: function() {
            console.log( "Wystąpił błąd w połączniu :(");
        }
    });
});

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
