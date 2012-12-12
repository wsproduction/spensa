$(function () {
    
    var protocol = window.location.protocol;
    var host = window.location.host;
    var lastTarget = '';
    
    $('.cofig .parent-title').live('click',function() {
        $('.cofig').css('background-color','#f9f9f9');
        $('.cofig').children('.content').slideDown('fast');
    });
    
    $('.cofig').mouseleave(function(){
        $(this).css('background-color','');
        $(this).children('.content').slideUp('fast');
    });
    
    $('.cofig .content a').live('click',function(){
        $('.cofig').css('background-color','');
        $('.cofig').children('.content').slideUp('fast');
    });
    
    /* Handles response */
    var handler = function(data) {
        $(data).find('data').each(function(){
            var css = $(this).find('css').text();
            var content = $(this).find('content').text();
             
            $('#for-css').html(css);
            $('#live-view-content-apps').html(content);
            $(this).loadingProgress('stop');
        });    
    };
    
    var ajaxLoader = function(target) {
        /* Loads the apps content and inserts it into the content area */
        if (target && target != lastTarget) {
            lastTarget = target;
            $.ajax({
                url: protocol + '//' + host + '/' + target,
                dataType : "xml",
                beforeSend : function() {
                    $(this).loadingProgress('start');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    handler(XMLHttpRequest.responseText);
                },
                success: function(data, textStatus, XMLHttpRequest) {
                    handler(data);
                }
            });
        }
    };
    
    var getTargetUrl = function(url) {
        var split = url.split('/apps/load/');
        if (typeof split[1] == 'undefined') {
            return false;
        } else {
            return split[1];
        }
    };
    
    /* First Load */
    ajaxLoader(getTargetUrl(document.location.href));
    
    /* Adress jQuery */
    $.address.state('/').init(function() {
        $('#list-m-nav-apps-top a').address();
    }).change(function(event) {
        ajaxLoader(getTargetUrl(event.path));                
    });
});
