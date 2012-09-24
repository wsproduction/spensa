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
    
    
    
});

