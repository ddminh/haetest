$(document).ready(function(){
    $('#dialogMessage .form-control').each(function(){
       $(this).focus(function(){
          hideValidate(this);
      });
   });
    
   /* Submit message */
   $('#dialogMessageSubmit').click(function(){ 
        /* Validate */
        var name = $('#dialogMessageName');
        var email = $('#dialogMessageEmail');
        var message = $('#dialogMessageContent');
        var check = true;

        if($(name).val().trim() == ''){
            showValidate(name);
            check=false;
        }


        if($(email).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
            showValidate(email);
            check=false;
        }

        if($(message).val().trim() == ''){
            showValidate(message);
            check=false;
        }
        if($(message).val().length > 300) {
            showValidate(message);
            check=false;
        }
        $('#dialogMesageError').hide();
        $('#dialogMesageSuccess').hide();
        if(check) {
            /* Ajax submit */
            $.ajax({
                url: 'action/actions.php?action=postMessage',
                data: {name: $('#dialogMessageName').val(), email: $('#dialogMessageEmail').val(), message: $('#dialogMessageContent').val()},
                dataType: 'json',
                success: function(response) {
                    if(response.result == 1) {
                        $('#dialogMesageSuccess').show();
                        $('#dialogMesageError').hide();
                        location.reload();
                    }else {
                        $('#dialogMesageError').show();
                        $('#dialogMessageError').val(response.errorMessage);
                        $('#dialogMesageSuccess').hide();
                    }
                }
            });
         } else {
             $('#dialogMesageError').show();
         }
    });
    
    /* Login */
    $('#dialogLoginSubmit').click(function(){
        var username = $('#dialogLoginUsername').val();
        var password = $('#dialogLoginPassword').val();
        $.ajax({
            url: 'action/actions.php?action=login',
            data: {username: username, 'password': password},
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.result == 1) {
                    $('#dialogLoginSuccess').show();
                    $('#dialogLoginError').hide();
                    location.reload();
                }else {
                    $('#dialogLoginError').show();
                    $('#dialogLoginError').val(response.errorMessage);
                    $('#dialogLoginSuccess').hide();
                }
            }
        });
    });
    
    /* Edit message */
    $('#dialogEditSubmit').click(function() {
        var id = $('#dialogEditId').val();
        var message = $('#dialogEditMessage').val();
        $.ajax({
            url: 'action/actions.php?action=editMessage',
            data: {id: id, 'message': message},
            dataType: 'json',
            success: function(response) {
                if(response.result == 1) {
                    $('#dialogEditSuccess').show();
                    $('#dialogEditError').hide();
                    var card = $('.card-info[rel='+id+']');
                    $(card).find('.card-text').html(message);
                    $(card).fadeIn('2000');
                }else {
                    $('#dialogEditError').show();
                    $('#dialogEditError').val(response.errorMessage);
                    $('#dialogEditSuccess').hide();
                }
            }
        });
    });
    
    /* Delete message */
    $('#dialogDeleteSubmit').click(function() {
        var id = $('#dialogDeleteId').val();
        $.ajax({
            url: 'action/actions.php?action=deleteMessage',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                if(response.result == 1) {
                    $('#dialogDeleteSuccess').show();
                    $('#dialogDeleteError').hide();
                    var card = $('.card-info[rel='+id+']');
                    $(card).fadeOut('2000');
                }else {
                    $('#dialogDeleteError').show();
                    $('#dialogDeleteError').val(response.errorMessage);
                    $('#dialogDeleteSuccess').hide();
                }
            }
        })
    });
    
    /* Pagination */
    switch (page) {
        case 1: 
            $('#li_page1').addClass('active');
            break;
        case 2:
            $('#li_page2').addClass('active');
            break;
        case 3:
           $('#li_page3').addClass('active');
           break;
       default: 
           $('#li_page1').addClass('active');
            break;
    }
});

/* Edit message */
 function clickEditButton(object) 
 {
    $('#dialogEditError').hide();
    $('#dialogEditSuccess').hide();
    var id = $(object).parents('.card').attr('rel');
    var name = $(object).parents('.card').find('.guest-name').html();
    var message = $(object).parents('.card').find('.guest-info').find('.card-text').html();
    $('#dialogEditId').val(id);
    $('#dialogEditName').val(name);
    $('#dialogEditMessage').val(message);
 }
 
 /* Delete message */
 function clickDeleteButton(object) {
     $('#dialogDeleteSuccess').hide();
     $('#dialogDeleteSError').hide();
     var id = $(object).parents('.card').attr('rel');
     $('#dialogDeleteId').val(id);
 }
 
 function showValidate(input) {
        var thisAlert = $(input).parent();
        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
// In order to float above the BootStrap navigation
$('.ui-dialog').css('z-index',9999);