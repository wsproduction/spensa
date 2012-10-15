
    $.address.state('/').init(function() {
        $(navId).address();
    }).change(function(event) {
        var value = event.path;
        var target = value.split('/pages/load/');
        /* Handles response*/
        var handler = function(data) {
            
            $(data).find('data').each(function(){
                var css = $(this).find('css').text();
                var script = $(this).find('script').text();
                var content = $(this).find('content').text();
                
                $(cssId).html(css);
                $(scriptId).html(script);
                $(viewId).html(content);
                $('#loading-progress').slideUp('slow');
            });
            
        };
        
        //var src = ''
        //if 
                
        //if (target[0] != '' || target[0] != 'index') {
        /* Loads the page content and inserts it into the content area*/
        $.ajax({
            url: protocol + '//' + host + '/' + target[1],
            dataType : "xml",
            beforeSend : function() {
                $('#loading-progress').slideDown('fast');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                handler(XMLHttpRequest.responseText);
            },
            success: function(data, textStatus, XMLHttpRequest) {
                handler(data);
            }
        });
    //}
                
    });