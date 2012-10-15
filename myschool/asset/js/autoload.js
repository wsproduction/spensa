$(function () {
    var protocol = window.location.protocol;
    var host = window.location.host;
    
    //alert(window.location.protocol);
    //alert(window.location.hash); // read achor (#) URL
    
    $('#live-view').css({
        //'min-height':parseInt(screen.height) - 148 + 'px'
        'min-height' : parseInt(screen.height) + 'px'
    });
    /**/
   
    /*
    *$('#live-view').mCustomScrollbar({
        scrollEasing:"easeOutQuint",
        scrollButtons:{
            enable:false
        }
    });*/
   
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
    })
    
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
        url : protocol + '//' + host + '/menu/pages',
        dataType : 'json',
        contentType: "application/json; charset=utf-8",
        beforeSend : function() {
            $('#list-m-pages').html('Loading...');
        },
        success :function(o){
            var m = '';
            var t;
            for (var i=0; i < o.length;i++) {
                t = o[i];
                m += '<li><a href="' + t.url + '">' + t.title + '</a></li>';
            }
            $('#list-m-pages').html(m);
        }
    });
    
    
    $.ajax({
        url: protocol + '//' + host + '/profile/me',
        dataType : 'json',
        success: function(data) {
            var thumbnail = data.thumbnail;
            $('a#profile-name-left').html(data.name);
            $('img#profile-thumbnail-small').attr('src', 'http://myschool.spensa.ws/web/src/myschool/asset/upload/images/thumbnail-small/' + thumbnail.small);
        }
    });
    
});