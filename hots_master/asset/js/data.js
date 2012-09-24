/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    var option = {
        url : $('.flexme3').attr('link'),
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'question_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Periode',
            name : 'periode',
            width : 150,
            sortable : true,
            align : 'center'
        }, {
            display : 'Question',
            name : 'question_title',
            width : 400,
            sortable : true,
            align : 'left'
        }, {
            display : 'Follower',
            name : 'follower',
            width : 130,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Status',
            name : 'question_status',
            width : 80,
            sortable : true,
            align : 'center'
        }, {
            display : 'Entry Date',
            name : 'question_entry',
            width : 80,
            sortable : true,
            align : 'center'
        }, {
            display : 'Option',
            name : 'option',
            width : 80,
            align : 'center'
        }],
        buttons : [ {
            name : 'Add',
            bclass : 'add',
            onpress : function() {
                window.location = 'data/add'
            }
        }, {
            name : 'Delete',
            bclass : 'delete',
            onpress : function() {
                var leng = $('.flexme3 .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $('.flexme3 .trSelected td[abbr=question_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post('data/delete', {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(".flexme3").flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }, {
            separator : true
        } ],
        searchitems : [ {
            display : 'ID',
            name : 'question_id'
        }, {
            display : 'Question',
            name : 'question_description',
            isdefault : true
        } ],
        nowrap : false,
        sortname : "question_id",
        sortorder : "asc",
        usepager : true,
        title : 'Question',
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : 260,
        onSubmit: function() {
            var dt = $('#frmFilter').serializeArray();
            $(".flexme3").flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $(".flexme3").flexigrid(option);
    
    $('#frmFilter').live('submit',function(){
        $(".flexme3").flexOptions({
            newp: 1
        }).flexReload();
        return false;
    });
    
    var option2 = {
        url : $('.flexme4').attr('link'),
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'question_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Student Name',
            name : 'periode',
            width : 300,
            sortable : true,
            align : 'left'
        }, {
            display : 'Grade',
            name : 'question_title',
            width : 100,
            sortable : true,
            align : 'left'
        }, {
            display : 'Entry Date',
            name : 'follower',
            width : 130,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Status',
            name : 'question_status',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Score',
            name : 'question_entry',
            width : 100,
            sortable : true,
            align : 'center'
        }, {
            display : 'Option',
            name : 'option',
            width : 100,
            align : 'center'
        }],
        buttons : [ {
            name : 'Delete',
            bclass : 'delete',
            onpress : function() {
                var leng = $('.flexme4 .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $('.flexme4 .trSelected td[abbr=question_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post('data/delete', {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(".flexme4").flexReload();
                            } else {
                                alert('Process delete failed.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }, {
            separator : true
        } ],
        searchitems : [ {
            display : 'ID',
            name : 'question_id'
        }, {
            display : 'Student Name',
            name : 'question_description',
            isdefault : true
        } ],
        nowrap : false,
        sortname : "question_id",
        sortorder : "asc",
        usepager : true,
        title : 'Follower',
        useRp : true,
        rp : 15,
        showTableToggleBtn : false,
        resizable : false,
        width : '100%',
        height : 260,
        onSubmit: function() {
            var dt = $('#frmFilter').serializeArray();
            $(".flexme4").flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $(".flexme4").flexigrid(option2);
});

