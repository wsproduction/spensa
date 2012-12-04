/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    $('#province').change(function(o){
        $('#district').html('<option value="">Loading...</option>');
        $.get('getDistrict', {id:$(this).val()}, function(o){ 
            $('#district').html(o);
        },'json');
    });
    
    $('#subdomain').keyup(function(e){
        $('#out_subdomain').text($(this).val());
    });
    
    
});


