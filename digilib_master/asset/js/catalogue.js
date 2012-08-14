/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    /* WYSIWYG elRTE */
    elRTE.prototype.options.panels.web2pyPanel = [
    'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
    'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
    'link', 'image'
    ];
    elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];
    
    var opts = {
        cssClass : 'el-rte',
        // lang     : 'ru',
        height   : 180,
        width    : 600,
        toolbar  : 'web2pyToolbar',
        cssfiles : ['css/elrte-inner.css']
    }
    $('#profile').elrte(opts);
    
    /* CHANGE VALUE ACTIONS */  
    $('#country').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $.get(url, {
            id:id
        }, function(o){
            $('#city').html(o);
        }, 'json');
    });
    $('#ddcLevel1').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $.get(url, {
            id:id
        }, function(o){
            $('#ddcLevel2').html(o);
        }, 'json');
    });
    $('#ddcLevel2').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $.get(url, {
            id:id
        }, function(o){
            $('#ddcLevel3').html(o);
        }, 'json');
    });
    
    /* SUBMIT ACTIONS */    
    $('#fAdd').live('submit',function(){
        /*frmID = $(this);
        msgID = $('#message');
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        
        $(msgID).fadeOut('slow');
        $.post(url, data, function(o){
            if (o[0]) {
                if (o[1]) {
                    $(frmID)[0].reset();
                }
            }
            $(msgID).html(o[2]).fadeIn('slow');
        }, 'json');
        */
       
        var stepStatus = $('#stepStatus').val();
        
        // TabStatus
        $('li#s1').css('background','#ccc');
        $('li#s2').css('background','#ccc');
        $('li#s3').css('background','#ccc');
        $('li#s4').css('background','#ccc');
        $('li#s5').css('background','#ccc');
       
        if (stepStatus == 1) {
            $('#addStep1').fadeOut('slow',function(){
                $('#addStep2').fadeIn('slow');
            });
            stepStatus++;
        } else if (stepStatus == 2) {
            $('#addStep2').fadeOut('slow',function(){
                $('#addStep3').fadeIn('slow');
            });
            
            $.get('getWriter', {
                sa : $('#sessionAuthor').val()
            }, function(o){
                if (o[0]) {
                    row2 = o[1];
                    row3 = $('#title').val();
                } else {
                    row2 = $('#title').val();
                    row3 = '';
                }
                $('#preview_call_number #print_row_2').text(row2.substr(0,3).toUpperCase());
                $('#preview_call_number #print_row_3').text(row3.substr(0,1).toLowerCase());
            }, 'json');
            
            stepStatus++;
        }       
        
        $('li#s' + stepStatus).css('background','#fff');
        $('#stepStatus').val(stepStatus);
        
        return false;
    });
    
    $('#fUpload').live('submit',function(){
        $(this).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                //console.log(parOut); 
                if (parOut) {
                    var obj = eval('(' + parOut +')');
                    console.log(obj.html); 
                    $('#pesan').html($.base64.decode(obj.html));
                }
            }
        });
        return false;
    });
    
    /* BUTTON ACTION */
    $('#btnAddData').live('click',function(){
        window.location = $(this).attr('link');
    });
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    $('#btnDeleteData').live('click',function(){
        var hiddenID = $('#hiddenID').val();
        var splitID = hiddenID.split(',');
        var arrayID = new Array();
        var idxArray = 0;
        var tempID;
        for (var i = 0 ; i < splitID.length ; i++) {
            tempID = splitID[i];
            if ($('#list_' + tempID).is(':checked')) {
                arrayID[idxArray] = tempID;
                idxArray++;
            }
        }
        
        if (arrayID.length > 0) {
            var conf = confirm("Are you sure to delete data?");
            if (conf) {
                $.post('catalog/delete', {
                    val:arrayID
                }, function(o){
                    $.get('catalog/read', {
                        p:Get_Cookie('_page')
                    }, function(o){
                        $('table#list tbody').html(o);
                    }, 'json');
                }, 'json');
            }
        } else {
            alert('No item Selected');
        }
    });
    $('#btnAddAuthor').live('click',function(){
        if ($('#first_name_author').valid() && $('#description_author').valid()) {
            $.post('addAuthorTemp', {
                sa : $('#sessionAuthor').val(),
                first_name_author : $('#first_name_author').val(),
                last_name_author : $('#last_name_author').val(),
                front_degree_author : $('#front_degree_author').val(),
                back_degree_author : $('#back_degree_author').val(),
                description_author : $('#description_author').val()
            }, function(o){
                var status = o[0];
                var message = o[2];
                if (status) {
                    $.get('readAuthorTemp', {
                        p:Get_Cookie('_page_author'),
                        sa : $('#sessionAuthor').val()
                    }, function(o){
                        $('table#listAuthorSelected tbody').html(o);
                    }, 'json');
                }
                $('#messageAuthor').html(message);
            }, 'json'); 
        }
    });
    $('#listAuthorSelected a.delete').live('click',function(){
        thisID = $(this);
        var conf = confirm("Are you sure to delete?");
        if (conf) {
            $.post('deleteAuthorTemp', {
                val: $(thisID).attr('value')
            }, function(o){
                $.get('readAuthorTemp', {
                    p:Get_Cookie('_page_author'),
                    sa : $('#sessionAuthor').val()
                }, function(o){
                    $('table#listAuthorSelected tbody').html(o);
                }, 'json');
            }, 'json');
        }
        return false;
    });
    
    // TAB ACTION
    $('#btnPrev').live('click',function(){
        var stepStatus = $('#stepStatus').val();
        if (stepStatus == 2) {
            $('#addStep2').fadeOut('slow',function(){
                $('#addStep1').fadeIn('slow');
            });
            stepStatus--;
        } else if (stepStatus == 3) {
            $('#addStep3').fadeOut('slow',function(){
                $('#addStep2').fadeIn('slow');
            });
            stepStatus--;
        }   
        $('#stepStatus').val(stepStatus);
    });
    
    /* CHECKBOX ACTION */
    $('#cbSelectAll').live('click',function(){
        var hiddenID = $('#hiddenID').val();
        var splitID = hiddenID.split(',');
        var i;
        
        if($(this).is(':checked')){
            for (i=1; i<=splitID.length;i++) {
                $('#row_' + splitID[i]).removeClass().addClass('selected');
            }
            $('.cbList').attr('checked', true);
        } else {            
            for (i=1; i<splitID.length;i++) {
                $('#row_' + splitID[i]).removeClass().addClass($('#row_' + splitID[i]).attr('temp'));
            }
            $('.cbList').attr('checked', false);
        }
    });
    $('.cbList').live('click',function(){
        $('#cbSelectAll').attr('checked', false);
        if($(this).is(':checked')){
            $('#row_' + $(this).val()).removeClass().addClass('selected');
        } else {
            $('#row_' + $(this).val()).removeClass().addClass($('#row_' + $(this).val()).attr('temp'));
        }
    });
    
    /* SET COOKIE */
    Set_Cookie('_page', 1, '', '/', '', '');
    Set_Cookie('_page_author', 1, '', '/', '', '');
    
    /* PAGING */
    // INDEX
    $('#paging').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        $.get('catalogue/read', {
            p:page
        }, function(o){
            Set_Cookie('_page', page, '', '/', '', '');
            $('table#list tbody').html(o);
        }, 'json');
    });
    $('#prevPaging').live('click',function(){
        keyID = $('#paging');
        var page = parseInt($(keyID).val())-1;
        if (page>0) {
            $.get('catalogue/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
        }
    });
    $('#nextPaging').live('click',function(){
        keyID = $('#paging');
        var page = parseInt($(keyID).val())+1;
        if (page<$('#maxPaging').val()) {
            $.get('catalogue/read', {
                p:page
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list tbody').html(o);
            }, 'json');
        }
        
    });
    // ADD - LEVEL 1
    $('#pagePagingLevel1').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        $.get('readDdc', {
            p:page,
            parent:0,
            level:1
        }, function(o){
            Set_Cookie('_page', page, '', '/', '', '');
            $('table#list1 tbody').html(o);
        }, 'json');
    });
    $('#prevPagingLevel1').live('click',function(){
        keyID = $('#pagePagingLevel1');
        var page = parseInt($(keyID).val())-1;
        if (page>0) {
            $.get('readDdc', {
                p:page,
                parent:0,
                level:1
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list1 tbody').html(o);
            }, 'json');
        }
    });
    $('#nextPagingLevel1').live('click',function(){
        keyID = $('#pagePagingLevel1');
        var page = parseInt($(keyID).val())+1;
        if (page<$('#maxPagingLevel1').val()) {
            $.get('readDdc', {
                p:page,
                parent:0,
                level:1
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list1 tbody').html(o);
            }, 'json');
        }
    });
    // ADD - LEVEL 2
    $('#pagePagingLevel2').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        var parentId = parseInt($('#tempSelectId1').val());
        $.get('readDdc', {
            p:page,
            parent:parentId,
            level:2
        }, function(o){
            Set_Cookie('_page', page, '', '/', '', '');
            $('table#list2 tbody').html(o);
        }, 'json');
    });
    $('#prevPagingLevel2').live('click',function(){
        keyID = $('#pagePagingLevel2');
        var page = parseInt($(keyID).val())-1;
        var parentId = parseInt($('#tempSelectId1').val());
        if (page>0) {
            $.get('readDdc', {
                p:page,
                parent:parentId,
                level:2
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list2 tbody').html(o);
            }, 'json');
        }
    });
    $('#nextPagingLevel2').live('click',function(){
        keyID = $('#pagePagingLevel2');
        var page = parseInt($(keyID).val())+1;
        var parentId = parseInt($('#tempSelectId1').val());
        if (page<$('#maxPagingLevel2').val()) {
            $.get('readDdc', {
                p:page,
                parent:parentId,
                level:2
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list2 tbody').html(o);
            }, 'json');
        }
    });
    // ADD - LEVEL 3
    $('#pagePagingLevel3').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        var parentId = parseInt($('#tempSelectId2').val());
        $.get('readDdc', {
            p:page,
            parent:parentId,
            level:3
        }, function(o){
            Set_Cookie('_page', page, '', '/', '', '');
            $('table#list3 tbody').html(o);
        }, 'json');
    });
    $('#prevPagingLevel3').live('click',function(){
        keyID = $('#pagePagingLevel3');
        var page = parseInt($(keyID).val())-1;
        var parentId = parseInt($('#tempSelectId2').val());
        if (page>0) {
            $.get('readDdc', {
                p:page,
                parent:parentId,
                level:3
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list3 tbody').html(o);
            }, 'json');
        }
    });
    $('#nextPagingLevel3').live('click',function(){
        keyID = $('#pagePagingLevel3');
        var page = parseInt($(keyID).val())+1;
        var parentId = parseInt($('#tempSelectId2').val());
        if (page<$('#maxPagingLevel3').val()) {
            $.get('readDdc', {
                p:page,
                parent:parentId,
                level:3
            }, function(o){
                Set_Cookie('_page', page, '', '/', '', '');
                $('table#list3 tbody').html(o);
            }, 'json');
        }
    });
    // AUTHOR Temp
    $('#pagePagingAuthor').live('change',function(){
        keyID = $(this);
        var page = parseInt($(keyID).val());
        $.get('readAuthorTemp', {
            p:page,
            sa : $('#sessionAuthor').val()
        }, function(o){
            Set_Cookie('_page_author', page, '', '/', '', '');
            $('table#listAuthorSelected tbody').html(o);
        }, 'json');
    });
    $('#prevPagingAuthor').live('click',function(){
        keyID = $('#pagePagingAuthor');
        var page = parseInt($(keyID).val())-1;
        if (page>0) {
            $.get('readAuthorTemp', {
                p:page,
                sa : $('#sessionAuthor').val()
            }, function(o){
                Set_Cookie('_page_author', page, '', '/', '', '');
                $('table#listAuthorSelected tbody').html(o);
            }, 'json');
        }
    });
    $('#nextPagingAuthor').live('click',function(){
        keyID = $('#pagePagingAuthor');
        var page = parseInt($(keyID).val())+1;
        if (page<$('#maxPagingAuthor').val()) {
            $.get('readAuthorTemp', {
                p:page,
                sa : $('#sessionAuthor').val()
            }, function(o){
                Set_Cookie('_page_author', page, '', '/', '', '');
                $('table#listAuthorSelected tbody').html(o);
            }, 'json');
        }
    });
    
    /* ROW SELECTED */
    /*
    $('#listAuthor tbody tr[isa=option]').live('click',function(){
        thisId = $(this);
        var html;
        var tempID = $(thisId).attr('value');
        var tempAuhtorSelected = $("#tempAuthorSelected").val();
        var splitTempAuthorSelected = tempAuhtorSelected.split(',');
        
        var ket = true;
        for (var i = 0; i<=splitTempAuthorSelected.length;i++) {
            if (splitTempAuthorSelected[i]==tempID) {
                ket = false;
                break;
            }
        }
        
        if (ket) {
            tempAuhtorSelected += ',' + tempID;
            $("#tempAuthorSelected").val(tempAuhtorSelected);
        }
        
        html = '<tr>';
        html += '   <td class="first" style="text-align:center;">' + splitTempAuthorSelected.length + '</td>';
        html += '   <td>kkfkfk</td>';
        html += '   <td style="text-align:center;">Delete</td>';
        html += '</tr>';
        
        if (splitTempAuthorSelected.length > 1) {
            if (ket) {
                $('#listAuthorSelected tbody').append(html); 
            }
        } else {
            $('#listAuthorSelected tbody').html(html);
        }
    });
    */
    $('#list1 tbody tr[isa=option]').live('click',function(){
        id = $(this).attr('value');
        tempSelectId = $('#tempSelectId1').val();
        $('#tempSelectId1').val(id);
        
        $('#row_' + tempSelectId).removeClass().addClass($('#row_' + tempSelectId).attr('temp'));
        $('#row_' + id).removeClass().addClass('selected');
        
        if (id != tempSelectId) {
            $.get('readDdc', {
                parent:id,
                level:2
            }, function(o){
                $('table#list2 tbody').html(o);
                $('table#list3 tbody').html('<tr><td colspan="2" class="first" style="text-align: center;">Data Not Found</td></tr>');
            }, 'json');
        } 
    });
    $('#list2 tbody tr[isa=option]').live('click',function(){
        id = $(this).attr('value');
        tempSelectId = $('#tempSelectId2').val();
        $('#tempSelectId2').val(id);
        
        $('#row_' + tempSelectId).removeClass().addClass($('#row_' + tempSelectId).attr('temp'));
        $('#row_' + id).removeClass().addClass('selected');
        
        if (id != tempSelectId) {
            $.get('readDdc', {
                parent:id,
                level:3
            }, function(o){
                $('table#list3 tbody').html(o);
            }, 'json');
        } 
    });
    $('#list3 tbody tr[isa=option]').live('click',function(){
        id = $(this).attr('value');
        callNumber = $('#row_' + id + ' td[is=call_number]').text();
        tempSelectId = $('#tempSelectId3').val();
        $('#tempSelectId3').val(id);
        
        $('#row_' + tempSelectId).removeClass().addClass($('#row_' + tempSelectId).attr('temp'));
        $('#row_' + id).removeClass().addClass('selected');
        
        if (id != tempSelectId) {
            $('#preview_call_number #print_row_1').html(callNumber);
        }
    });
    
});


