$(function () {
    var protocol = window.location.protocol;
    var host = window.location.host;
    var loading = $('#loading-progress');
    var navId = $('#list-m-nav-page-top a');
    var viewId = $('#live-view-content-page');
    var cssId = $('#for-css');
    
    /* Handles response*/
    var handler = function(data) {
        $(data).find('data').each(function(){
            var css = $(this).find('css').text();
            var script = $(this).find('script').text();
            var content = $(this).find('content').text();
            
            var newScriptName = script.split('|')[1];
            
            $.rloader({
                defaultcache : true,
                defaultasync : false
            });
            
            $.rloader({
                src : newScriptName
            });
            
                
            $(cssId).html(css);
            $(viewId).html(content);
            $(loading).slideUp('slow');
        });    
    };
    
    var ajaxLoader = function(target) {
        /* Loads the page content and inserts it into the content area*/
        $.ajax({
            url: protocol + '//' + host + '/' + target,
            dataType : "xml",
            beforeSend : function() {
                $(loading).slideDown('fast');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                handler(XMLHttpRequest.responseText);
            },
            success: function(data, textStatus, XMLHttpRequest) {
                handler(data);
            }
        });
    };
    
    var getTargetUrl = function(url) {
        var split = url.split('/pages/load/');
        return split[1];
    };
    
    // First Loader
    var firstTarget = getTargetUrl(document.location.href);
    ajaxLoader(firstTarget);
    
    $.address.state('/').init(function() {
        $(navId).address();
    }).internalChange(function(event) {
        var value = event.path;
        var target = value.split('/pages/load/');
        ajaxLoader(target[1]);                
    });
    
});
