$(function () {
    var chart;
    $(document).ready(function() {
        var option = {
            chart: {
                renderTo: 'view_statistic',
                type: 'column',
                marginBottom: 50
            },
            title: {
                text: 'HOTS CHART YEARS 2012 - 2013'
            },
            subtitle: {
                text: 'SMP NEGERI 1 SUBANG'
            },
            xAxis: {
                title : {
                    text: 'Month'
                },
                categories: [
                'Jul',
                'Aug',
                'Sep',
                'Okt',
                'Nov',
                'Des',
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Participant'
                }
            },
            legend: {
                layout: 'horizontal',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'bottom',
                y: 15,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                    this.x +': '+ this.y;// +' mm';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Grade VII'
            }, {
                name: 'Grade VIII'
            }, {
                name: 'Grade IX'
            }]
        };
        
        $.get('index/chart', function (o){
            option.series[0].data = o[0];
            option.series[1].data = o[1];
            option.series[2].data = o[2];
            chart = new Highcharts.Chart(option);
        }, 'json');
        
    });
    
    myTimer = setTimeout("showNext()", 3000);
    showNext(); //loads first image
    $('#thumbs li').bind('click',function(e){
        var count = $(this).attr('rel');
        showImage(parseInt(count)-1);
    });
    
});


var currentImage;
var currentIndex = -1;
var interval;
function showImage(index){
    if(index < $('#bigPic img').length){
        var indexImage = $('#bigPic img')[index]
        if(currentImage){   
            if(currentImage != indexImage ){
                $(currentImage).css('z-index',2);
                clearTimeout(myTimer);
                $(currentImage).fadeOut(250, function() {
                    myTimer = setTimeout("showNext()", 5000);
                    $(this).css({
                        'display':'none',
                        'z-index':1
                    })
                });
            }
        }
        $(indexImage).css({
            'display':'block', 
            'opacity':1
        });
        
        var infoSlide = $(indexImage).attr('title');
        $('#bigPic #info-slide').text(infoSlide);
        
        currentImage = indexImage;
        currentIndex = index;
        $('#thumbs li').removeClass('active');
        $($('#thumbs li')[index]).addClass('active');
    }
}
    
function showNext(){
    var len = $('#bigPic img').length;
    var next = currentIndex < (len-1) ? currentIndex + 1 : 0;
    showImage(next);
}
    
var myTimer;
