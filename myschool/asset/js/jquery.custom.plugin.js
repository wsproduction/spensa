jQuery.fn.extend({
    loadingProgress : function(action) {
        return this.each(function(){
            if (action == 'start') {
                $('#loading-progress').slideDown('fast');
            } else if (action == 'stop') {
                $('#loading-progress').slideUp('fast');
            }
                
        });
    }
});