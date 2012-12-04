/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    var form_requaired_validation = function(id,status) {
        $(id).rules("add",{
            required : status
        });
    };
    
    /* FLEXYGRID INDEX*/
    var listId = '#list';
    var title = $(listId).attr('title');
    var link_r = $(listId).attr('link_r');
    var link_c = $(listId).attr('link_c');
    var link_d = $(listId).attr('link_d');
    
    var option = {
        url : link_r,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'book_id', 
            width : 70,
            sortable : true,
            align : 'center'
        }, {
            display : 'Call Number',
            name : 'classification_number',
            width : 100,
            sortable : true,
            align : 'left'
        }, {
            display : 'Keterangan Buku',
            name : 'book_title',
            width : 450,
            sortable : true,
            align : 'left'
        }, {
            display : 'Asal',
            name : 'resource_name',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Sumber',
            name : 'fund_name',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Eksemplar',
            name : 'book_quantity',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Stok',
            name : 'length_borrowed',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Tanggal',
            name : 'book_entry_date',
            width : 100,
            sortable : true,
            align : 'center',
            hide : true
        }, {
            display : 'Option',
            name : 'option',
            width : 80,
            align : 'center'
        }],
        buttons : [ {
            name : 'Tambah',
            bclass : 'add',
            onpress : function() {
                window.location = link_c
            }
        }, {
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId + ' .trSelected td[abbr=book_id] div').each(function() {
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
        }, {
            separator : true
        } ],
        searchitems : [ {
            display : 'ID',
            name : 'book_id',
            isdefault : true
        }, {
            display : 'Judul Buku',
            name : 'book_title'
        }, {
            display : 'Pengarang',
            name : 'ddc_title'
        }, {
            display : 'Penerbit',
            name : 'ddc_title'
        }, {
            display : 'Asal',
            name : 'ddc_title'
        }, {
            display : 'Sumber',
            name : 'ddc_level'
        } ],
        nowrap : false,
        sortname : "book_id",
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
    
    /* FLEXYGRID LANGUAGE*/
    var listId2 = '#language-list';
    var title2 = $(listId2).attr('title');
    var link_r2 = $(listId2).attr('link_r');
    var link_d2 = $(listId2).attr('link_d');
    
    var option2 = {
        url : link_r2,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'book_language_temp_id', 
            width : 70,
            sortable : true,
            align : 'center'
        }, {
            display : 'Bahasa',
            name : 'language_name',
            width : 440,
            sortable : true,
            align : 'left'
        }],
        buttons : [{
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId2 + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId2 + ' .trSelected td[abbr=book_language_temp_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d2, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId2).flexReload();
                            } else {
                                alert('Proses delete gagal.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }],
        nowrap : false,
        sortname : "book_language_temp_id",
        sortorder : "asc",
        usepager : false,
        title : title2,
        useRp : false,
        rp : 15,
        showTableToggleBtn : true,
        resizable : false,
        width : 540,
        height : 100
    };
    
    $(listId2).flexigrid(option2);
    
    /* ADD LANGUAGE */
    $('#btnAddLanguage').live('click',function(){
        
        var language = $('#language').val();
        
        if (language == -1) {
            // Enabled Validation
            $("#language").rules("add",{
                required : true
            });
            $("#otherlanguage").rules("add",{
                required : true
            });
            
            // Validation Check
            if ($('#language').valid() && $('#otherlanguage').valid()) {
                language = $('#otherlanguage').val();
                $.post('addlanguagetemp', {
                    other : 'yes',
                    val: language
                }, function(o){
                    if (o) {
                        $('#language-list').flexReload();
                    } else {
                        alert('Proses Gagal.');
                    }
                }, 'json');
                
            }   
            
            // Disabled Validation
            $("#language").rules("add",{
                required : false
            });
            $("#otherlanguage").rules("add",{
                required : false
            });
        } else {
            // Enabled Validation
            $("#language").rules("add",{
                required : true
            });
            
            // Validation Check
            if ($('#language').valid()) {
                $.post('addlanguagetemp', {
                    other : 'no',
                    val: language
                }, function(o){
                    if (o) {
                        $('#language-list').flexReload();
                    } else {
                        alert('Proses Gagal.');
                    }
                }, 'json');
                
            } 
            
            // Disabled Validation
            $("#language").rules("add",{
                required : false
            });
        }
        
    });
    
    /* LIVE PUBLISHER */
    $('#language').live('change',function(){
        if ($(this).val()==-1) 
            $('#otherlanguage').fadeIn('fast').val('').focus();
        else 
            $('#otherlanguage').fadeOut('fast');
    });
    
    /* FLEXYGRID LANGUAGE*/
    var listId3 = '#publisher-list';
    var title3 = $(listId3).attr('title');
    var link_r3 = $(listId3).attr('link_r');
    
    var option3 = {
        url : link_r3,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'publisher_office_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama Penerbit',
            name : 'publisher_name',
            width : 200,
            sortable : true,
            align : 'left'
        }, {
            display : 'Keterangan',
            name : 'publisher_description',
            width : 300,
            align : 'left'
        }, {
            display : 'Alamat',
            name : 'publisher_office_address',
            width : 400,
            align : 'left'
        }, {
            display : 'Kantor',
            name : 'publisher_office_department_name',
            width : 60,
            sortable : true,
            align : 'left'
        } ],
        nowrap : false,
        sortname : "publisher_office_id",
        sortorder : "asc",
        usepager : true,
        title : title3,
        useRp : false,
        rp : 15,
        showTableToggleBtn : true,
        resizable : false,
        singleSelect: true,
        width : 700,
        height : 150,
        onSubmit: function() {
            var dt = $('#fAdd').serializeArray();
            $(listId3).flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $(listId3).flexigrid(option3);
    
    /* PUBLISHER FILTER */
    $('#country').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $('#province').html('<option>Loading...</option>');
        $.get(url, {
            id:id
        }, function(o){
            $('#province').html(o);
        }, 'json');
    });
    $('#province').live('change',function(){
        var url = $(this).attr('link');
        var id = $(this).val();
        $('#city').html('<option>Loading...</option>');
        $.get(url, {
            id:id
        }, function(o){
            $('#city').html(o);
        }, 'json');
    });
    $('#city').live('change',function(){
        $('#publisher-list').flexOptions({
            newp: 1
        }).flexReload();
    });
    $('#publisher-list tbody tr[id*="row"]').live('click', function(){
        var id = '';
        var status = $(this).attr('class');
        if (status == 'trSelected' || status == 'erow trSelected') {
            id = $(this).attr('id').substr(3);
        }
        $('#publisher').val(id);
    });
    
    /* AUTHOR FILTER */
    $('#form-add-author').css('display','none');
    $('#description_author').live('change', function() {
        var url = $(this).attr('link');
        var id = $(this).val();
        $('#option_author').html('<option>Loading...</option>');
        $.get(url, {
            id:id
        }, function(o){
            $('#option_author').html(o);
        }, 'json');
    });
    $('#option_author').live('change', function() {
        var id = $(this).val();
        if (id == "-1") {
            $('#form-add-author').fadeIn('slow');
        } else {
            $('#form-add-author').fadeOut('slow');
        }
    });
    $('#btnAddAuthor').live('click',function(){
        var id = $('#option_author').val();
        form_requaired_validation('#description_author', true);
        form_requaired_validation('#option_author', true);
        
        if (id == '-1') {
            form_requaired_validation('#first_name_author', true);
            if ($('#description_author').valid() && $('#option_author').valid() && $('#first_name_author').valid()) {
                
                var desc_author = $('#description_author').val();
                var first_name = $('#first_name_author').val();
                var last_name = $('#last_name_author').val();
                var front_degree = $('#front_degree_author').val();
                var back_degree = $('#back_degree_author').val();
                
                $.post('addauthortemp', {
                    other : 'yes',
                    desc_author : desc_author,
                    first_name : first_name,
                    last_name : last_name,
                    front_degree : front_degree,
                    back_degree : back_degree
                }, function(o){
                    if (o) {
                        $('#list-author-selected').flexReload();
                    } else {
                        alert('Proses Gagal.');
                    }
                }, 'json');
            }
        } else {
            if ($('#description_author').valid() && $('#option_author').valid()) {
                $.post('addauthortemp', {
                    other : 'no',
                    val: id
                }, function(o){
                    if (o) {
                        $('#list-author-selected').flexReload();
                    } else {
                        alert('Proses Gagal.');
                    }
                }, 'json');
            }
        }
        form_requaired_validation('#description_author', false);
        form_requaired_validation('#option_author', false);
        form_requaired_validation('#first_name_author', false);
    });
    $('#list-author-selected a[href=#setprimary]').live('click',function(){
        var id = $(this).attr('rel');
        $.post('setprimaryauthor', {
            val: id
        }, function(o){
            if (o) {
                $('#list-author-selected').flexReload();
            } else {
                alert('Proses Gagal.');
            }
        }, 'json');
        return false;
    });
    
    /* FLEXYGRID AUTHOR*/
    var listId4 = '#list-author-selected';
    var title4 = $(listId4).attr('title');
    var link_r4 = $(listId4).attr('link_r');
    var link_d4 = $(listId4).attr('link_d');
    
    var option4 = {
        url : link_r4,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'book_author_temp_id', 
            width : 40,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nama',
            name : 'author_name',
            width : 250,
            sortable : true,
            align : 'left'
        }, {
            display : 'Keterangan',
            name : 'author_description_title',
            width : 150,
            sortable : true,
            align : 'center'
        }, {
            display : 'Status',
            name : 'publisher_description',
            width : 100,
            align : 'center'
        }, {
            display : 'Option',
            width : 120,
            align : 'center'
        } ],
        buttons : [{
            name : 'Hapus',
            bclass : 'delete',
            onpress : function() {
                var leng = $(listId4 + ' .trSelected').length;
                var conf = confirm('Delete ' + leng + ' items?');
                
                if (conf) {
                    if (leng > 0) {
                        var tempId = [];
                        $(listId4 + ' .trSelected td[abbr=book_author_temp_id] div').each(function() {
                            tempId.push(parseInt($(this).text()));
                        });
                        
                        $.post(link_d4, {
                            id : tempId.join(',')
                        }, function(o){
                            if (o) {
                                $(listId4).flexReload();
                            } else {
                                alert('Proses delete gagal.');
                            }                            
                        }, 'json');
                    }
                }
            }
        }],
        nowrap : false,
        sortname : "book_author_temp_id",
        sortorder : "asc",
        usepager : true,
        title : title4,
        useRp : false,
        rp : 15,
        showTableToggleBtn : true,
        resizable : false,
        width : 700,
        height : 150
    };
    
    $(listId4).flexigrid(option4);
    
    
    /* FLEXYGRID DDC*/
    var listId5 = '#list-ddc';
    var title5 = $(listId5).attr('title');
    var link_r5 = $(listId5).attr('link_r');
    
    var option5 = {
        url : link_r5,
        dataType : 'xml',
        colModel : [ {
            display : 'ID', 
            name : 'ddc_id', 
            width : 80,
            sortable : true,
            align : 'center'
        }, {
            display : 'Nomor Klasifikasi',
            name : 'ddc_classification_number',
            width : 150,
            sortable : true,
            align : 'center'
        }, {
            display : 'Keterangan',
            name : 'ddc_title',
            width : 700,
            align : 'left'
        }],
        nowrap : false,
        sortname : "ddc_id",
        sortorder : "asc",
        usepager : true,
        title : title5,
        useRp : false,
        rp : 15,
        showTableToggleBtn : true,
        resizable : false,
        singleSelect: true,
        width : '100%',
        height : 300,
        onSubmit: function() {
            var dt = $('#fAdd').serializeArray();
            $(listId5).flexOptions({
                params: dt
            });
            return true;
        }
    };
    
    $(listId5).flexigrid(option5);
    
    /* FILTER DDC */
    $('#ddcLevel1').live('change',function(){
        var id = $(this).val();
        var url = $(this).attr('link');
        $('#ddcLevel2').html('<option>Loading...</option>');
        $.get(url, {
            id:id
        }, function(o){
            $('#ddcLevel2').html(o);
        }, 'json');
    });
    $('#btnFilterDdc').live('click',function(){
        $('#list-ddc').flexOptions({
            newp: 1
        }).flexReload();
    });
    $('#list-ddc tbody tr[id*="row"]').live('click', function(){
        var id = '';
        var class_number = '';
        var status = $(this).attr('class');
        if (status == 'trSelected' || status == 'erow trSelected') {
            id = $(this).attr('id').substr(3);
            class_number = $('#row' + id + ' td[abbr=ddc_classification_number] div').html();
        }
        $('#ddcid').val(id);
        $('#preview_call_number .print_row_1').html(class_number);
    });
    
    /* TABS INPUT*/
    var $tabs = $('#tabs').tabs();
    $tabs.tabs('enable', 0)
    .tabs('select', 0)
    .tabs("option","disabled", [0, 1, 2, 3, 4])
    .tabs('enable', 0);
    
    var tabnavigator = function(tabIndex) {
        $tabs.tabs('enable', tabIndex)
        .tabs('select', tabIndex)
        .tabs("option","disabled", [0, 1, 2, 3, 4]).tabs('enable', tabIndex);
    }
    
    $('#detailTab').tabs();
    
    
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
        height   : 400,
        width    : 800,
        toolbar  : 'web2pyToolbar',
        cssfiles : ['css/elrte-inner.css']
    }
    
    $('#reviews').elrte(opts);
    
    $('#price').autoNumeric({
        aPad: false
    });
    
    /* ADD ACTIONS */    
    $('#fAdd').live('submit',function(){
        
        var stepStatus = $('#stepStatus').val();
        var curentTab = 0 ;
         
        if (stepStatus == '1') {
            var publisher = $('#publisher').val();
            if (publisher == '') {
                curentTab = 1;
                alert('Silahkan pilih penerbit buku!');
            } else {
                curentTab = parseInt(stepStatus) + 1;
            }
        } else if (stepStatus == '2') {
            var ddcid = $('#ddcid').val();
            if (ddcid == '') {
                curentTab = 2;
                alert('Silahkan tentukan nomor klasifikasi!');
            } else {
                curentTab = parseInt(stepStatus) + 1;
            }
        } else if (stepStatus == '4') {
            frmID = $(this);
            msgID = $('#message');
            $(frmID).ajaxSubmit({
                success : function(o) {
                    var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                    //console.log(parOut);
                    if (parOut) {
                        var obj = eval('(' + parOut +')');
                        //console.log(obj.html); 
                        $(msgID).html($.base64.decode(obj.html)).fadeIn('slow');
                        $(frmID)[0].reset();     
                        $('#language-list').flexReload();
                        $('#publisher-list').flexReload();
                        $('#list-author-selected').flexReload();
                        $('#list-ddc').flexReload();
                    }
                }
            });
            
        /*$.post($(this).attr('action'), $(this).serialize(), function(o){
                alert(o);                          
            }, 'json');*/
        } else {
            curentTab = parseInt(stepStatus) + 1;
        }
        
        tabnavigator(curentTab);
        $('#stepStatus').val(curentTab);
        
        return false;
    });
    
    // TAB ACTION
    $('#btnPrev').live('click',function(){
        var stepStatus = $('#stepStatus').val();
        var curentTab = parseInt(stepStatus) - 1;
        tabnavigator(curentTab);
        $('#stepStatus').val(curentTab);
    });
        
    /* BUTTON ACTION */
    $('#btnBack').live('click',function(){
        window.location = $(this).attr('link');
    });
    $('#btnPrintBarcode').live('click',function(){
        window.open($(this).attr('link'),'_blank');
    });
    $('#btnPrintLabel').live('click',function(){
        window.open($(this).attr('link'),'_blank');
    });
    
    
});


function generateCatalogue() {
    var contentRow1 = '';
    var contentRow2 = '';
    var contentRow3 = '';
    
    var tempJudul = $('#title').val();
    var tempAnakJudul = $('#sub_title').val();
    var tempJudulBahasaLain = $('#foreign_title').val();
    var tempEdisi = $('#edition').val();
    var tempCetakan = $('#print_out').val();
    var tempKota = $('#city option:selected').text();
    var tempPenerbit = $('#publisher option:selected').text();
    var tempTahun = $('#year option:selected').text();
    
    var tempHalamanRomawi = $('#roman_count').val();
    var tempHalamanAngka = $('#page_count').val();
    var tempIlustrasi = $('#ilustration').is(':checked');
    var tempLebar = $('#width').val();
    
    var tempBiblliografi = $('#bibliography').val();
    var tempIndex = $('#ilustration').is(':checked');
    var tempISBN = $('#isbn').val();
    
    var judul = tempJudul;
    var anakJudul = '';
    var judulBahasaLain = '';
    var author = '<span class="viewListAuthorTemp"></span>';
    var edisi = '';
    var cetakan = '';
    var penerbit = '';
    
    var halamanRomawi = '';
    var halamanAngka = '';
    var ilustrasi = '';
    var lebar = '';
    
    var biblliografi = '';
    var index = '';
    var ISBN = '';
    
    var sparator1 = '';
    var sparator2 = '';
    
    if (tempAnakJudul != '')
        anakJudul = ' : ' + tempAnakJudul;
    
    if (tempJudulBahasaLain != '')
        judulBahasaLain = ' = ' + tempJudulBahasaLain;
    
    if (tempEdisi != '')
        edisi = '.&HorizontalLine; Ed. ' + tempEdisi;
    
    if (tempEdisi != '' && tempCetakan != '')
        sparator1 = ',';
    
    if (tempCetakan != '')
        cetakan = ' cet. ' + tempCetakan;
    
    if (tempHalamanRomawi != '')
        halamanRomawi = tempHalamanRomawi;
    
    if (tempHalamanRomawi != '' && tempHalamanAngka != '')
        sparator2 = ',';
    
    if (tempHalamanAngka != '')
        halamanAngka = ' ' + tempHalamanAngka + ' hlm.';
    
    if (tempIlustrasi)
        ilustrasi = ' : ilus.';
    
    if (tempLebar != '')
        lebar = ' ; ' + tempLebar + ' cm&DiacriticalAcute;';
    
    if (tempBiblliografi != '')
        biblliografi = 'Biblliografi : ' + tempBiblliografi + ' <br>';
    
    if (tempIndex)
        index = 'Indeks <br>';
    
    if (tempISBN != '')
        ISBN = 'ISBN ' + tempISBN + ' <br>';
    
    penerbit = '.&HorizontalLine; ' + tempKota + ' : ' + tempPenerbit + ', ' + tempTahun + '. ';
    
    contentRow1 = judul + anakJudul + judulBahasaLain + author + edisi + sparator1 + cetakan + penerbit;
    
    contentRow2 = halamanRomawi + sparator2 + halamanAngka + ilustrasi + lebar;
    
    contentRow3 = biblliografi + index + ISBN;
    
    $('.contentRow1').html(contentRow1);
    $('.contentRow2').html(contentRow2);
    $('.contentRow3').html(contentRow3);
    
    $.get('getAuhtorTemp', {
        sa : $('#sessionAuthor').val()
    }, function(o){
        $('.viewListAuthorTemp').html(o) ;
    }, 'json');
}