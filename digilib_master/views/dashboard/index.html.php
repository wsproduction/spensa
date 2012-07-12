<div id="tempDialog"></div>
Hallow, kamu sudah login

<a href="#" id="button">Click me</a>

<div id="modal"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#button').click(function(e) {
            var aksi = $('#modal').reveal({ 
                heading : 'Warman Suganda',
                content : 'dddddd <br> dsdfsf ',
                trueButton : {label:'OKE',action:function(){alert('oke')}},
                animation: 'fade', 
                animationspeed: 600,
                closeonbackgroundclick: false,
                dismissmodalclass: 'close'
            });
            return false;
        });
        
        function test(){
             alert('sss');
        }
    });
</script>
