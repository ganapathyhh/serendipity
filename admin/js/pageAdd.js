/***
*Publish Schedule editor
*
*If the scheduled details are ok then the data is updated based on schedule
*/

/**************
RIGHT SIDEBAR ON PUBLISH PAGE
*************/

/**
*Status getter class elements
*/

$('#status-edit').click(function(){
    $('#select-status').css('display', 'block');
    $(this).css('display', 'none');
});

$('#status-getter-ok-button').click(function(){
    $('#page-status-span').text($('#page-status-select').val());
    $('#publish-status-field').val($('#page-status-select').val());
    $('#select-status').css('display', 'none');
    $('#status-edit').css('display', 'inline');
});

$('#status-getter-cancel-button').click(function(){
    $('#status-edit').css('display', 'inline');
    $('#select-status').css('display', 'none');
});

/**
*Publish getter class elements
*/

$('#publish-edit').click(function(){
    $('#publish-status').css('display', 'block');
    $(this).css('display', 'none');
});


$('#publish-edit-ok').click(function(){
    if(isValidDate(parseInt($('#year-of-calendar').val()),parseInt( $('#month-of-calendar')[0].selectedIndex) + 1, parseInt($('#day-of-calendar').val())) &&((parseInt($('#hour-of-calendar').val()) >= 0 && parseInt($('#hour-of-calendar').val()) <= 24) && (parseInt($('#min-of-calendar').val()) >= 0 && parseInt($('#min-of-calendar').val()) <= 59))){
        var s = $('#month-of-calendar').val() + "-" + $('#day-of-calendar').val() + "-" + $('#year-of-calendar').val() + " @ " +  pad(parseInt($('#hour-of-calendar').val()),2) + " : " + pad(parseInt($('#min-of-calendar').val()), 2);
      $('#page-publish-span').text( s); 
        $('#publish-time-field').val(s);
        $('#publish-status').css('display', 'none');
        $('#publish-edit').css('display', 'inline');
  }
    return false;
});


$('#publish-edit-cancel').click(function(){
    $('#publish-edit').css('display', 'inline');
    $('#publish-status').css('display', 'none');
});

/**
*Event removal time editter
*/

$('#publish-remove-edit').click(function(){
    $('#publish-remove-status').css('display', 'block');
    $(this).css('display', 'none');
});

$('#publish-remove-edit-ok').click(function(){
    if(isValidDate(parseInt($('#year-of-calendar-2').val()),parseInt( $('#month-of-calendar-2')[0].selectedIndex) + 1, parseInt($('#day-of-calendar-2').val())) &&((parseInt($('#hour-of-calendar-2').val()) >= 0 && parseInt($('#hour-of-calendar-2').val()) <= 24) && (parseInt($('#min-of-calendar-2').val()) >= 0 && parseInt($('#min-of-calendar-2').val()) <= 59))){
        var s = $('#month-of-calendar-2').val() + "-" + $('#day-of-calendar-2').val() + "-" + $('#year-of-calendar-2').val() + " @ " +  pad(parseInt($('#hour-of-calendar-2').val()),2) + " : " + pad(parseInt($('#min-of-calendar-2').val()), 2);
      $('#page-publish-remove-span').text( s); 
        $('#publish-remove-time-field').val(s);
        $('#publish-remove-status').css('display', 'none');
        $('#publish-remove-edit').css('display', 'inline');
  }
    return false;
});

$('#publish-remove-edit-cancel').click(function(){
    $('#publish-remove-edit').css('display', 'inline');
    $('#publish-remove-status').css('display', 'none');
});

/**
*Checks for the valid date 
*
*Returns true if date is valid
*
*Returns false if date is invalid
*/

  function isValidDate(y, m, d) {
    m = parseInt(m, 10) - 1;
    return m >= 0 && m < 12 && d > 0 && d <= daysInMonth(m, y);
}

function daysInMonth(m, y) {
    switch (m) {
        case 1 :
            return (y % 4 == 0 && y % 100) || y % 400 == 0 ? 29 : 28;
        case 8 : case 3 : case 5 : case 10 :
            return 30;
        default :
            return 31;
    }
}

function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

/*$('#page-publish-submit, #publish-button').click(function(){
    alert(tinyMCE.get('#mytextarea').getContent());
    $('#source-code-editor').val(tinyMCE.get('#mytextarea').getContent());
    return false;
});*/

/*************
DATA INSERT INTO DATABASE BASED ON TIMEOUT
*************/
/*var timeout;

     $('body').on('keyup', '.field', function( event ){
          if( timeout )
                clearTimeout(timeout);

          timeout = setTimout( function( event ){
                autosave();
          },400); //i find 400 milliseconds works good

    });

    function autosave(){
         ....
    }*/
