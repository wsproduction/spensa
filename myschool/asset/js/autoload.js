$(function () {
    var protocol = window.location.protocol;
    var host = window.location.host;
        
    $('#live-view').css('min-height' , screen.height);
   
    // Accordion Top Menu 
    $('#m-account-parent').live('click',function(){
        var source = $(this);
        var tempClass = $(source).attr('class');
        var target = $(source).attr('href');
        
        if (tempClass=='slide-on') {
            $(source).removeClass('slide-on').addClass('slide-of');
            $(target).slideUp('fast');
        } else {
            $(source).removeClass('slide-of').addClass('slide-on');
            $(target).slideDown('fast');
        }
        
        return false;
    });
    
    $('body').live('click',function() {
        $('#m-account-parent').removeClass('slide-on').addClass('slide-of');
        $($('#m-account-parent').attr('href')).slideUp('fast');
    });
    
    // Accordion Left Menu
    $('ul.m-left li[type=parent] a').live('click',function(){
        var source = $(this);
        var parent = $(this).parent();
        var tempClass = $(parent).attr('class');
        var target = $(source).attr('href');
        
        if (tempClass=='toggle-on') {
            $(parent).removeClass('toggle-on').addClass('toggle-of');
            $(target).slideUp('fast');
        } else {
            $(parent).removeClass('toggle-of').addClass('toggle-on');
            $(target).slideDown('fast');
        }
        return false;
    });
   
    // Load Page List
    $.ajax({
        url : protocol + '//' + host + '/menu/apps',
        dataType : 'json',
        contentType: "application/json; charset=utf-8",
        beforeSend : function() {
            $('#list-m-apps').html('Loading...');
        },
        success :function(o){
            var m = '';
            var t;
            for (var i=0; i < o.length;i++) {
                t = o[i];
                m += '<li><a href="' + t.url + '">' + t.title + '</a></li>';
            }
            $('#list-m-apps').html(m);
        }
    });
    
    
    $.ajax({
        url: protocol + '//' + host + '/profile/me',
        dataType : 'json',
        success: function(data) {
            var thumbnail = data.thumbnail;
            $('a#profile-name-left').html(data.name);
            $('img#profile-thumbnail-small').attr('src', thumbnail.small);
        }
    });
    
});
