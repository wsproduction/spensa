$(function () {
    
    var protocol = window.location.protocol;
    var host = window.location.host;
    var lastTarget = '';
    
    var navId = $('#list-m-nav-apps-top a');
    var viewId = $('#live-view-content-apps');
    var cssId = $('#for-css');
    
    $('.cofig').live('click',function() {
        $(this).css('background-color','#f9f9f9');
        $(this).children('.content').slideDown('fast');
    }).mouseleave(function(){
        $(this).css('background-color','');
        $(this).children('.content').slideUp('fast');
    });
    
    /* Handles response */
    var handler = function(data) {
        $(data).find('data').each(function(){
            var css = $(this).find('css').text();
            var content = $(this).find('content').text();
             
            $(cssId).html(css);
            $(viewId).html(content);
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
        $(navId).address();
    }).change(function(event) {
        ajaxLoader(getTargetUrl(event.path));                
    });
});
