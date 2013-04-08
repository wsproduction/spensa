<div id="box-content">
    <div id="view_chart"></div>
    <div class="cl">&nbsp;</div>
</div>

<script>
    $(function() {
        var y = screen.height * 0.70;
        var y2 = screen.height * 0.68;
        $('#box-content').css('min-height',  y + "px");
        $('#view_chart').css({'min-height':y2 + "px", 'margin':'12px 0 0 0'});
        
        var chart;
        $(document).ready(function() {
            var option = {
                chart: {
                    renderTo: 'view_chart',
                    type: 'column'
                },
                title: {
                    text: 'GRAFIK PENDAFTARAN PESERTA DIDIK BARU'
                },
                subtitle: {
                    text: 'SMP NEGERI 1 SUBANG'
                },
                xAxis: {title : {
                        text: 'Tahun Pelajaran'
                    },
                    categories: [
                        '2004/2005',
                        '2005/2006',
                        '2006/2007',
                        '2007/2008',
                        '2008/2009',
                        '2009/2010',
                        '2010/2011',
                        '2011/2012',
                        '2012/2013',
                        '2013/2014'
                    ]
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah'
                    }
                },
                legend: {
                    layout: 'vertical',
                    backgroundColor: '#FFFFFF',
                    align: 'left',
                    verticalAlign: 'top',
                    x: 100,
                    y: 70,
                    floating: true,
                    shadow: true
                },
                tooltip: {
                    formatter: function() {
                        return ''+
                            this.x +': '+ this.y;
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                        name: 'Laki-Laki',
                        data: [49.9, 71.5, 106.4, 49.9, 71.5, 106.4, 49.9, 71.5, 106.4, 106.4]
    
                    }, {
                        name: 'Perempuan',
                        data: [83.6, 78.8, 98.5, 49.9, 71.5, 106.4, 49.9, 71.5, 106.4, 106.4]
    
                    }]
            };
            
            
            Highcharts.theme = {
                colors: [ '#24CBE5', '#DDDF00', '#ED561B', '#058DC7', '#50B432','#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 500, 500],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(240, 240, 255)']
                        ]
                    },
                    borderWidth: 2,
                    plotBackgroundColor: 'rgba(255, 255, 255, .9)',
                    plotShadow: true,
                    plotBorderWidth: 1
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
                    }
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
                    }
                },
                xAxis: {
                    gridLineWidth: 1,
                    lineColor: '#000',
                    tickColor: '#000',
                    labels: {
                        style: {
                            color: '#000',
                            font: '11px Trebuchet MS, Verdana, sans-serif'
                        }
                    },
                    title: {
                        style: {
                            color: '#333',
                            fontWeight: 'bold',
                            fontSize: '12px',
                            fontFamily: 'Trebuchet MS, Verdana, sans-serif'

                        }
                    }
                },
                yAxis: {
                    minorTickInterval: 'auto',
                    lineColor: '#000',
                    lineWidth: 1,
                    tickWidth: 1,
                    tickColor: '#000',
                    labels: {
                        style: {
                            color: '#000',
                            font: '11px Trebuchet MS, Verdana, sans-serif'
                        }
                    },
                    title: {
                        style: {
                            color: '#333',
                            fontWeight: 'bold',
                            fontSize: '12px',
                            fontFamily: 'Trebuchet MS, Verdana, sans-serif'
                        }
                    }
                },
                legend: {
                    itemStyle: {
                        font: '9pt Trebuchet MS, Verdana, sans-serif',
                        color: 'black'

                    },
                    itemHoverStyle: {
                        color: '#039'
                    },
                    itemHiddenStyle: {
                        color: 'gray'
                    }
                },
                labels: {
                    style: {
                        color: '#99b'
                    }
                }
            };

            var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
            
            chart = new Highcharts.Chart(option);
        });
    });
</script>