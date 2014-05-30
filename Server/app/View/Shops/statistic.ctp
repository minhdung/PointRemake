<?php
echo $this->Html->script('jquery.1.8.2.min');
echo $this->Html->script('highcharts');
?>
<script>
    $(function() {
        $('#statistic').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Statistic Charge'
            },
            subtitle: {
                text: <?php echo '"'.$subtitle.'"';?>
            },
            xAxis: [{
                    categories: [
                        <?php
                        foreach($categories as $category){
                            echo $category.', ';
                        }
                        ?>
                    ]
                }],
            yAxis: [{// Primary yAxis
                    title: {
                        text: 'Sales',
                        style: {
                            color: '#4572A7'
                        }
                    },
                    labels: {
                        format: '{value} ポイント',
                        style: {
                            color: '#4572A7'
                        }
                    },
                    allowDecimals: false
                }, {// Secondary yAxis
                    labels: {
                        format: '{value} 人',
                        style: {
                            color: '#89A54E'
                        }
                    },
                    title: {
                        text: 'User Transactions',
                        style: {
                            color: '#89A54E'
                        }
                    },
                    min: 0,
                    allowDecimals: false,
                    opposite: true
                }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                    name: 'Sales',
                    color: '#4572A7',
                    type: 'column',
                    data: [
                        <?php
                        foreach($sales as $sale){
                            echo $sale.', ';
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' ポイント'
                    }

                }, {
                    name: 'User transactions',
                    color: '#89A54E',
                    type: 'spline',
                    yAxis: 1,
                    data: [
                        <?php
                        foreach($user_trans as $user_tran){
                            echo count(array_unique($user_tran)).', ';
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' 人'
                    }
                }]
        });
    });
</script>
<div>
    <?php
    echo $this->Form->create('Statistic');
    foreach($all_years as $year){
        $year_options[$year] = $year.'年';
    }
    echo $this->Form->input('year', array('label' => FALSE, 'div' => FALSE, 'options' => $year_options, 'default' => $nowYear,'onChange' => 'javascript:this.form.submit()'));
    $month_options[0] = '全月';
    for($month = 1; $month <= 12; $month++){
        $month_options[$month] = $month.'月';
    }
    echo $this->Form->input('month', array('label' => FALSE, 'div' => FALSE, 'options' => $month_options, 'onChange' => 'javascript:this.form.submit()'));
    echo $this->Form->end();?>
</div>
<div id="statistic" style="min-width: 310px; height: 400px; margin: 100px auto">
</div>