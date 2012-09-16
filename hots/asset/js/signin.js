$(function () {
    
    $('#fLogin').live('submit',function(){
        $('.view-message').html('Loading ... ');
        $(this).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                if (parOut) {
                    var obj = eval('(' + parOut +')');
                    if (obj.s) {
                        window.location = $.base64.decode(obj.msg);
                    } else {
                        $('.view-message').html($.base64.decode(obj.msg)).fadeIn('slow');
                    } 
                }
            }
        });
        return false;
    });
    
});