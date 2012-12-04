$(function () {
    var protocol = window.location.protocol;
    var host = window.location.host;
    
    var loadScript = function(filename, filetype){
        if (filename.isArray) {
            alert('is Aray');
        } else {
            //if (filesadded.indexOf("["+filename+"]")==-1){   
            var fileref;
            if (filetype=="js"){
                fileref=document.createElement('script');
                fileref.setAttribute("id","scriptMe");
                fileref.setAttribute("type","text/javascript");
                fileref.setAttribute("src", filename);
            }
            else if (filetype=="css"){
                fileref=document.createElement("link");
                fileref.setAttribute("rel", "stylesheet");
                fileref.setAttribute("type", "text/css");
                fileref.setAttribute("href", filename);
            }
            if (typeof fileref!="undefined") {
                document.getElementsByTagName("head")[0].appendChild(fileref);
            }
        //}
        }  
    }
    
    $.ajax({
        url: protocol + '//' + host + '/asset/app',
        dataType : 'json',
        success: function(data) {
            var template = data.template;
            loadScript(protocol + '//' + host + '/web/src/' + data.folder + '/asset/template/' + template.name + '/css/' + template.css, 'css');
            loadScript(protocol + '//' + host + '/web/src/' + data.folder + '/asset/js/autoload.js', 'js');
            loadScript(protocol + '//' + host + '/web/src/' + data.folder + '/asset/js/ajax-address.js', 'js');
        }
    });
    
    
});
