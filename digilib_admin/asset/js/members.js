/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    // START : Index Grid
    var listId = '#list';
    var title = $(listId).attr('title');
    var link_r = $(listId).attr('link_r');
    var link_c = $(listId).attr('link_c');
    var link_d = $(listId).attr('link_d');
    var link_pl = $(listId).attr('link_pl');
    var link_apl = $(listId).attr('link_apl');
    
    var option = {
        url : link_r,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'members_id', 
            width : 60,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama Lengkap',
            name : 'members_name',
            width : 180,
            sortable : true,
            align : 'left'
        }, {
            display : 'Alamat',
            name : 'members_address',
            width : 400,
            sortable : true,
            align : 'left'
        }, {
            display : 'Kunjungan',
            name : 'publisher_description',
            width : 60,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Peminjaman',
            name : 'publisher_description',
            width : 60,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Kunjungan Terakhir',
            name : 'publisher_description',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Peminjaman Terakhir',
            name : 'publisher_description',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Status',
            name : 'publisher_description',
            width : 60,
            sortable : true,
            align : 'center',
            hide : true
        },  {
            display : 'Option',
            name : 'option',
            width : 80,
            align : 'center'
        }],
        buttons : [ {
            name : 'Add',
            bclass : 'add',
            onpress : function() {
                window.location = link_c
            }
        }, {
            name : 'Delete',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId + ' .trSelected td[abbr=members_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                alert(leng + ' Item has deleted.');
                                $(listId).flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }, {
            separator : true
        }, {
            name : 'Add Print List',
            bclass : 'issue',
            onpress : function() {
                var leng = $(listId + ' .trSelected').length;
                var conf = confirm('Add Print List ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId + ' .trSelected td[abbr=members_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_apl, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                alert(leng + ' Item has saved.');
                                $(listId).flexReload();
                            } else {
                                alert('No Item Saved.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }, {
            name : 'Print List Preview',
            bclass : 'card',
            onpress : function() {
                window.location = link_pl
            }
        }],
        searchitems : [ {
            display : 'ID',
            name : 'members_id',
            isdefault : true
        }, {
            display : 'Nama Anggota',
            name : 'members_name'            
        } ],
        nowrap : false,
        sortname : "members_id",
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
    // END : Index Grid    
    
    // START : Print List Grid
    var listId2 = '#printlist';
    var title2 = $(listId2).attr('title');
    var link_r2 = $(listId2).attr('link_r');
    var link_p2 = $(listId2).attr('link_p');
    var link_d2 = $(listId2).attr('link_d');
    
    var option2 = {
        url : link_r2,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'members_id', 
            width : 60,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama Lengkap',
            name : 'members_name',
            width : 180,
            sortable : true,
            align : 'left'
        }, {
            display : 'Jenis Kelamin',
            name : 'gender_title',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Tempat/Tgl. Lahir',
            name : 'members_birthplace',
            width : 150,
            sortable : true,
            align : 'left'
        }, {
            display : 'Alamat',
            name : 'members_address',
            width : 350,
            sortable : true,
            align : 'left'
        }, {
            display : 'Golongan',
            name : 'members_isa',
            width : 100,
            sortable : true,
            align : 'left'
        }, {
            display : 'Keterangan',
            name : 'members_desc',
            width : 120,
            sortable : true,
            align : 'left'
        }, {
            display : 'Option',
            name : 'members_desc',
            width : 80,
            sortable : true,
            align : 'center'
        }],
        buttons : [ {
            name : 'Delete',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId2 + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId2 + ' .trSelected td[abbr=members_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d2, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                alert(leng + ' Item has deleted.');
                                $(listId2).flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }, {
            name : 'Delete All',
            bclass : 'earse',
            onpress : function() {
                var conf = confirm('Are you delete all items?');
                if (conf) {
                    $.post(link_d2, {
                        action : 'all'
                    }, function(o){
                        if (o) {
                            alert('All Item has deleted.');
                            $(listId2).flexReload();
                        } else {
                            alert('Process delete failed.');
                        }                            
                    }, 'json');
                }
            }
        }, {
            separator : true
        }, {
            name : 'Print Card',
            bclass : 'print',
            onpress : function() {
                window.location = link_p2
            }
        }],
        searchitems : [ {
            display : 'ID',
            name : 'members_id',
            isdefault : true
        }, {
            display : 'Nama Anggota',
            name : 'members_name'            
        } ],
        nowrap : false,
        sortname : "members_id",
        sortorder : "asc",
        usepager : true,
        title : title2,
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : screen.height - 350
    };
    $(listId2).flexigrid(option2);
    // END : Print List Grid  
    
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
        frmID = $(this);
        msgID = $('#message');
        $(frmID).ajaxSubmit({
            success : function(o) {
                var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                if (parOut) {
                    var obj = eval('(' + parOut +')');
                    if (obj[0]) {
                        if (obj[1]) {
                            $(frmID)[0].reset();
                        }
                        
                        if (obj[3]!='') {
                            $('#photopreview').html($.base64.decode(obj[3]));
                        }
                        
                    }
                    $(msgID).html($.base64.decode(obj[2])).fadeIn('slow');
                }
            }
        });
        return false;
    });
    
    /* BUTTON ACTION */
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    
});


