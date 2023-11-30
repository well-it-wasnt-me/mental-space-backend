/*=========================================================================================
    File Name: dashboard-ecommerce.js
    Description: dashboard ecommerce page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on('load', function () {
    'use strict';

    var periods = []
    var coin_in = []
    var netwin = [];
    var $textMutedColor = '#b9b9c3';
    var $revenueReportChart = document.querySelector('#revenue-report-chart');
    var revenueReportChartOptions;
    var revenueReportChart;

    $.ajax({
        url: "/statistics/dashboard",
        type: "GET",
        success: function (elem) {
            $("#lbl_gross_win").text(elem.gross_win + " €")
            $("#lbl_jugado").text(elem.coin_in + " €")
            $("#lbl_pagado").text(elem.coin_out + " €")
            $("#lbl_awp").text(elem.awp)
            // Crea array elementi per chart
            $.each(elem.chart, function (i,v) {
                periods.push(v.fecha)
                coin_in.push(v.jugado)
                netwin.push(v.netwin)
            });

            // Inizializza il chart
            revenueReportChartOptions = {
                chart: {
                    height: 230,
                    stacked: true,
                    type: 'area',
                    toolbar: { show: true }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '17%',
                        endingShape: 'rounded'
                    },
                    distributed: true
                },
                colors: [window.colors.solid.primary, window.colors.solid.warning],
                series: [
                    {
                        name: 'Coin In',
                        data: coin_in
                },
                    {
                        name: 'Coin Out',
                        data: netwin
                }
                ],
                dataLabels: {
                    enabled: true
                },
                legend: {
                    show: true
                },
                grid: {
                    padding: {
                        top: -20,
                        bottom: -10
                    },
                    yaxis: {
                        lines: { show: false }
                    }
                },
                xaxis: {
                    categories: periods,
                    labels: {
                        style: {
                            colors: $textMutedColor,
                            fontSize: '0.86rem'
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: $textMutedColor,
                            fontSize: '0.86rem'
                        }
                    }
                }
            };
            revenueReportChart = new ApexCharts($revenueReportChart, revenueReportChartOptions);
            revenueReportChart.render();



        },
        error: function (e) {
            Swal.fire('Whoops!', 'Error while retrieving stats, contact Moebius: #006', 'error');
        }
    });


});
