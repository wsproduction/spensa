$(function () {
    
    $("#tabs").tabs();
    
    $('#fChangePassword').live('submit',function(){
        $(this).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                //console.log(parOut); 
                if (parOut) {
                    var obj = eval('(' + parOut +')');
                    if (obj.s == '3') {
                        $('label.error').remove();
                        $('#old_password').after($.base64.decode(obj.msg));
                    } else {
                        if (obj.s == '1') {
                            $('#fChangePassword')[0].reset();
                        }
                        $('#msg_change_password').html($.base64.decode(obj.msg));
                    }
                }
                
            }
        });
        return false;
    });
    
    $('#fChangeAvatar').live('submit',function(){
        $(this).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                //console.log(parOut); 
                $('#viewAvatar').attr('src',$.base64.decode(parOut));
            }
        });
        return false;
    });
    
    $('.btnOption').live('click',function(){
        $.post('account/option', {temp:$(this).attr('temp')}, function(o){
            $.get('account/readProject',function(o){
                $('table#listProject tbody').html(o);
            },'json');
        }, 'json');
    });
    
});