<div class="maincontent">
    <div class="maincontentinner">

        <div style="margin: 10px 0;">
            <fieldset>
                <legend>Filter Data</legend>
                <?php Form::begin('fChartFilter', 'chart/chart', 'post'); ?>
                <table>
                    <tr>
                        <td width="150">
                            <div class="label-ina">Tahun Ajaran</div>
                            <div class="label-eng">Academic Period</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('select', 'period');
                            Form::properties(array('style' => 'width:120px;'));
                            Form::option($option_period);
                            Form::commit();
                            echo ' ';
                            Form::create('submit', 'bSubmit');
                            Form::value('Cari');
                            Form::style('action_search');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php Form::end(); ?>
            </fieldset>
        </div>

        <div id="container" style="min-width: 400px; margin: 10px 0 0 0"></div>
    </div>
</div>

<script>
    $(function() {
        $('#container').css({'height': screen.height * 0.55});

        var chart;
        $(document).ready(function() {
            var option = {
                chart: {
                    renderTo: 'container',
                    type: 'column'
                },
                title: {
                    text: 'Old Title'
                },
                subtitle: {
                    text: 'SMP NEGERI 1 SUBANG'
                },
                xAxis: {title: {
                        text: 'Bulan'
                    },
                    categories: [
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni'
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
                        return '' +
                                this.x + ': ' + this.y;
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                        name: 'Siswa'
                    }, {
                        name: 'Guru'
                    }, {
                        name: 'Karyawan'
                    }]
            };

            var getChart = function() {
                $(this).loadingProgress('start');
                $.get('chart/chart', {
                    period: $('#period').val()
                }, function(o) {
                    var title = o['title'];
                    var data = o['data'];
                    option.series[0].data = data[0];
                    option.series[1].data = data[1];
                    option.series[2].data = data[2];
                    chart = new Highcharts.Chart(option);
                    chart.setTitle({text: title});
                    $(this).loadingProgress('stop');
                }, 'json');
            };

            getChart();

            $('#fChartFilter').live('submit', function() {
                getChart();
                return false;
            });

            Highcharts.theme = {
                colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
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
        });
    });
</script>