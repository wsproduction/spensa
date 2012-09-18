$(function () {
    
    $('.box-button .optFollow').live('click',function(){
        window.location = $(this).attr('link');
    });
    
    /* WYSIWYG elRTE */
    elRTE.prototype.options.panels.web2pyPanel = [
    'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
    'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
    'link', 'image'
    ];
    elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];
    
    var opts = {
        cssClass : 'el-rte',
        // lang     : 'ru',
        height   : 300,
        width    : 558,
        toolbar  : 'web2pyToolbar',
        cssfiles : ['css/elrte-inner.css']
    }
    $('#text_answer').elrte(opts);
        
    $('#fFollow').live('submit',function(){
        $(this).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                if (parOut) {
                    var obj = eval('(' + parOut +')');
                    if (obj.s == '1') {
                        window.location = $.base64.decode(obj.link);
                    } else {
                        alert('Proces Error');
                    }
                }
            }
        });
        return false;
    });
    
    $('#file-view').dialog({
        title:'File Reader',
        autoOpen: false,
        height: 540,
        width: 620,
        modal: true,
        resizable: false
    });
    
    $('a[href=#view]').live('click',function(){
        $( "#file-view" ).dialog( "open" );
        return false;
    });
    
    $('#conf-delete').dialog({
        title:'Delete Confirmation',
        resizable: false,
        autoOpen: false,
        height:140,
        modal: true,
        buttons: {
            "Yes": function() {
                dialogID = $( this );
                link = $( this ).attr('link');
                aid = $( this ).attr('aid');
                file = $( this ).attr('file');
                $.post(link, {
                    id:aid,
                    file:file
                }, function(o){
                    if (o) {
                        $( dialogID ).dialog( "close" );
                        $('.box-upload').fadeIn('slow');
                        $('.icon-file').fadeOut('slow');
                    }
                }, 'json');
            },
            "No": function() {
                $( this ).dialog( "close" );
            }
        }
    });    
    
    $('a[href=#delete]').live('click',function(){
        $( "#conf-delete" ).dialog( "open" );
        return false;
    });
    
});