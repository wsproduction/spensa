/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){    
    
    var memberStatus = false;
    
    /* BEGIN : Borrowed List */
    var listId = '#borrow-list';
    var title = $(listId).attr('title');
    var link_c = $(listId).attr('link_c');
    var link_r = $(listId).attr('link_r');
    var link_d = $(listId).attr('link_d');
    
    var option = {
        url : link_r,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'borrowed_history_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nomor Induk Buku',
            name : 'borrowed_history_book',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Keterangan Buku',
            name : 'book_title',
            width : 400,
            sortable : true,
            align : 'left'
        }, {
            display : 'Jenis Peminjaman',
            name : 'language_status',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Waktu Peminjaman',
            name : 'language_status',
            width : 150,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Status',
            name : 'language_entry',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tanggal Pengembalian',
            name : 'language_entry_update',
            width : 150,
            sortable : true,
            align : 'center'
        }, {
            display : 'Option',
            name : 'option',
            width : 80,
            align : 'center'
        }],
        buttons : [ {
            name : 'Tambah Peminjaman ',
            bclass : 'add',
            onpress : function() {
                window.location = link_c;
            }
        }, {
            separator : true
        }, {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId + ' .trSelected td[abbr=language_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId).flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        } ],
        searchitems : [ {
            display : 'ID',
            name : 'borrowed_history_id',
            isdefault : true
        }, {
            display : 'Nama Bahasa',
            name : 'language_name'            
        } ],
        nowrap : false,
        sortname : "borrowed_history_id",
        sortorder : "asc",
        usepager : true,
        title : title,
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 350
    };
    
    $(listId).flexigrid(option);
    /* END : Borrowed List */
    
    /* BEGIN : Borrowed History List */
    var listId1 = '#borowed-history-list';
    var title1 = $(listId1).attr('title');
    var link_r1 = $(listId1).attr('link_r');
    var link_d1 = $(listId1).attr('link_d');
    
    var option1 = {
        url : link_r1,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'borrowed_history_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nomor Induk Buku',
            name : 'borrowed_history_book',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Keterangan Buku',
            name : 'book_title',
            width : 400,
            sortable : true,
            align : 'left'
        }, {
            display : 'Jenis Peminjaman',
            name : 'language_status',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Waktu Peminjaman',
            name : 'language_status',
            width : 150,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Status',
            name : 'language_entry',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tanggal Pengembalian',
            name : 'language_entry_update',
            width : 150,
            sortable : true,
            align : 'center'
        }, {
            display : 'Option',
            name : 'option',
            width : 80,
            align : 'center'
        }],
        buttons : [ {
            name : 'Peminjaman Temporer',
            bclass : 'add',
            onpress : function() {
                if (memberStatus) {
                    $('#view-cart').css('display','block');
                    $('#view-invoice').css('display','none');
                    $("#borrowed-cart").dialog('option', 'title', 'Keranjang Peminjaman Temporer');
                    $("#borrowed-cart").dialog( "open" );
                    $('#borrowedtype').val(1);
                    $('#bookregister').val('');
                    $(listId2).flexReload();
                    $('#bookregister').focus();
                }
            }
        }, {
            name : 'Peminjaman Individu',
            bclass : 'add',
            onpress : function() {
                if (memberStatus) {
                    $('#view-cart').css('display','block');
                    $('#view-invoice').css('display','none');
                    $("#borrowed-cart").dialog('option', 'title', 'Keranjang Peminjaman Individu');
                    $("#borrowed-cart").dialog( "open" );
                    $('#borrowedtype').val(2);
                    $('#bookregister').val('');
                    $(listId2).flexReload();
                    $('#bookregister').focus();
                }
            }
        }, {
            name : 'Peminjaman Klasikal',
            bclass : 'add',
            onpress : function() {
                if (memberStatus) {
                    $('#view-cart').css('display','block');
                    $('#view-invoice').css('display','none');
                    $("#borrowed-cart").dialog('option', 'title', 'Keranjang Peminjaman Kalisikal');
                    $("#borrowed-cart").dialog( "open" );
                    $('#borrowedtype').val(3);
                    $('#bookregister').val('');
                    $(listId2).flexReload();
                    $('#bookregister').focus();
                }
            }
        }, {
            separator : true
        }, {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId1 + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId1 + ' .trSelected td[abbr=borrowed_history_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d1, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId1).flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        } ],
        searchitems : [ {
            display : 'No Induk Buku',
            name : 'borrowed_history_book',
            isdefault : true
        }, {
            display : 'Judul Buku',
            name : 'book_title'            
        } ],
        nowrap : false,
        sortname : "borrowed_history_id",
        sortorder : "asc",
        usepager : true,
        title : title1,
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 550,
        onSubmit: function() {
            var dt = $('#fSearchInfoMember').serializeArray();
            $(listId1).flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $(listId1).flexigrid(option1);
      
    $('#memberid').focus().live('click',function(){
        $(this).select();
    });
    
    $('#fSearchInfoMember').live('submit',function(){
        return false;
    });
    
    $('#memberid').live('change',function(){       
        getInfoMembers();
    });
    
    function getInfoMembers() {
        frmID = $('#fSearchInfoMember');
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        
        $('#memberid').focus().select();
        
        $.post(url, data, function(o){
            var view;
            if (o[0]) {
                var profile = o[1];
                view  = '<div class="float-right">' + profile['photo'] + '</div>';
                view += '<div class="float-right members-profile">';
                view += '   <div><b>' + profile['name'] + '</b></div>';
                view += '   <div>' + profile['birthinfo'] + '</div>';
                view += '   <div>' + profile['gender'] + '</div>';
                view += '   <div>' + profile['isa'] + '</div>';
                view += '   <div>' + profile['address'] + '</div>';
                view += '</div>';
                $('#memberidtemp').val(profile['memberid']);
                memberStatus = true;
            } else {
                view = '<div class="float-right members-profile-not-found">Identias anggota tidak ditemukan.</div>';
                memberStatus = false;
            }
            
            $('.members-info').html(view).fadeIn('slow');
            
            $(listId1).flexOptions({
                newp: 1
            }).flexReload();
        }, 'json');
    }
    
    /* END : Borrowed History List */
    
    /* BEGIN : Borrowed Cart Temporer List */
    var listId2 = '#borrowed-cart-temporer-list';
    var title2 = $(listId2).attr('title');
    var link_r2 = $(listId2).attr('link_r');
    var link_d2 = $(listId2).attr('link_d');
    
    var option2 = {
        url : link_r2,
        dataType : 'xml',
        colModel : [ {
            display : 'ID',
            name : 'borrowed_temp_id',
            width : 40,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Nomor Induk Buku',
            name : 'borrowed_temp_book',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Keterangan Buku',
            name : 'book_title',
            width : 350,
            sortable : true,
            align : 'left'
        }, {
            display : 'Waktu Peminjaman',
            name : 'borrowed_temp_book',
            width : 150,
            sortable : false,
            align : 'center',
            hide : true
        }],
        buttons : [ {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId2 + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId2 + ' .trSelected td[abbr=borrowed_temp_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d2, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId2).flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        } ],
        searchitems : [ {
            display : 'No Indux Buku',
            name : 'borrowed_temp_book',
            isdefault : true
        }, {
            display : 'Nama Bahasa',
            name : 'book_title'            
        } ],
        nowrap : false,
        sortname : "borrowed_temp_id",
        sortorder : "asc",
        usepager : true,
        title : title2,
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 550,
        onSubmit: function() {
            var dt = $('#fSearchBookInfo').serializeArray();
            $(listId2).flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $(listId2).flexigrid(option2);
    
    $('#fSearchBookInfo').live('submit',function(){
                
        frmID = $(this);
        var url =  $(frmID).attr('action');
        var data =  $(frmID).serialize();
        
        $.post(url, data, function(o){
            if (o) {  
                $(listId2).flexOptions({
                    newp: 1
                }).flexReload();
            } else {
                alert('Informasi buku tidak ditemukan');
            }
            $('#bookregister').focus().select();
        }, 'json');
        return false;
    });
    
    $('#bookregister').live('click',function(){
        $(this).focus().select();
    });
    
    /* END : Borrowed Cart Temporer List */
    
    $('#borrowed-cart').dialog({
        closeOnEscape: false,
        autoOpen: false,
        height: screen.height - 200,
        width: 700,
        modal: true,
        resizable: false,
        draggable: false,
        open : function() {
            $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
        }
    });
    
    $('#bSimpanCart').live('click',function(){
        var conf =  confirm('Anda yakin akan menyimpan?');
        if (conf) {
            var url =  $(this).attr('link');
            var invoice =  $(this).attr('link_invoice');
            var memberidtemp =  $('#memberidtemp').val();
        
            $.post(url, {
                memberid : memberidtemp
            }, function(o){
                if (o) {  
                    $('#view-cart').slideUp('slow',function(){
                        $('#view-invoice').slideDown('slow');
                    });
                    $('#borrowed-cart #view-invoice iframe').attr('src', invoice + '/' + memberidtemp);
                    $('#borrowed-cart').parent().children().children('.ui-dialog-titlebar-close').show();
                } else {
                    alert('Data Peminjaman Gagal disimpan.');
                }
            }, 'json');
        }
    });
    
    $('#bCancelCart').live('click',function(){
        $('#borrowed-cart').dialog('close');
    });
    
    $('#borrowed-cart #view-invoice iframe').height(screen.height - 260);
    
    
});


