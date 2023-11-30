/*=========================================================================================
    File Name: statistic-counter-value.period.js
    Description: Electronic Counter by Time period
    Author: Antonio D'Angelo <antonio.dangelo@wtbss.com>
    --------------------------------------------------------------------------------------
==========================================================================================*/
//let select;
//let d_start, d_end;
let d_start2, d_end2, chart;
$(function () {
    ('use strict');

    var options = {
        chart: {
            height: 400,
            type: 'bar',
            stacked: false
        },
        series: [],
        yaxis: [{
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: true,
                color: '#008FFB'
            },
            labels: {
                style: {
                    color: '#008FFB',
                }
            }
        }]
    }

    chart = new ApexCharts(document.querySelector("#usage-report-chart"), options);
    chart.render();

    select = $('.select2');
    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent()
        });
    });

    /*******  Flatpickr *****/
    var rangePickr = $('.flatpickr-range');

    // Range
    if (rangePickr.length) {
        rangePickr.flatpickr({
            mode: 'range',
            locale: {
                "firstDayOfWeek": 1 // start week on Monday
            },
            dateFormat: "Y-m-d",
            onChange: ([start, end]) => {
                if (start && end) {
                    d_start = new Date(start).toLocaleDateString('en-CA');
                    d_end = new Date(end).toLocaleDateString('en-CA');
                    console.log(d_start, d_end);
                }
            }
        });
    }

    var rangePickr2 = $('#fp-range2');
    // Range
    if (rangePickr2.length) {
        rangePickr2.flatpickr({
            mode: 'range',
            locale: {
                "firstDayOfWeek": 1 // start week on Monday
            },
            dateFormat: "Y-m-d",
            onChange: ([start, end]) => {
                if (start && end) {
                    d_start2 = new Date(start).toLocaleDateString('en-CA');
                    d_end2 = new Date(end).toLocaleDateString('en-CA');
                    console.log(d_start2, d_end2);
                }
            }
        });
    }

    load_gaming_hall('gaming_hall_list');
    load_gaming_hall('gaming_hall_list2');

    $("#gaming_hall_list").change(function () {
        var selectedPdv = $(this).children("option:selected").val();
        retrieveMachine('smartbox_list', selectedPdv);
    });

    $("#gaming_hall_list2").change(function () {
        var selectedPdv = $(this).children("option:selected").val();
        retrieveMachine('smartbox_list2', selectedPdv);
    });
});


function load_counter_period()
{
    var counterTable = $('.counter-list-table');

    var list_counter_url = '/statistics/counters_value_period';

    if (counterTable.length) {
        counterTable.DataTable().destroy();
        counterTable.DataTable({
            ajax: {
                "url": list_counter_url,
                "type": "POST",
                "data": {
                    "d_start": d_start,
                    "d_end": d_end,
                    "pdv": $("#gaming_hall_list").val(),
                    "sb": $("#smartbox_list").val()
                },
            },
            columns: [
                // columns according to JSON
                { data: 'smartbox_id' },
                { data: 'id_pdv' },
                { data: 'pdv' },
                { data: 'city' },
                { data: 'nome_macchina' },
                { data: 'last_update' },
                { data: 'ref_hour' },
                { data: 'uptime' },
                { data: 'session_time' },
                { data: "creditos_jugado"},
                { data: "creditos_premiado"},
                { data: "total_de_partidas_jugadas"},
                { data: "partidas_1_creditos"},
                { data: "partidas_3_creditos"},
                { data: "partidas_5_creditos"},
                { data: "e_10c"},
                { data: "e_20c"},
                { data: "e_50c"},
                { data: "e_1e"},
                { data: "e_2e"},
                { data: "e_5e"},
                { data: "e_10e"},
                { data: "e_20e"},
                { data: "e_50e"},
                { data: "s_10c"},
                { data: "s_20c"},
                { data: "s_50c"},
                { data: "s_1e"},
                { data: "s_2e"},
                { data: "s_5e"},
                { data: "s_10e"},
                { data: "s_20e"},
                { data: "s_50e"},
            ],
            order: [[1, 'desc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-2',
                    text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                    buttons: [
                        {
                            extend: 'print',
                            text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                            className: 'dropdown-item',
                    },
                        {
                            extend: 'csv',
                            text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                            className: 'dropdown-item',
                    },
                        {
                            extend: 'excel',
                            text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                            className: 'dropdown-item',
                    },
                        {
                            extend: 'pdf',
                            text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                            className: 'dropdown-item',
                    },
                        {
                            extend: 'copy',
                            text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                            className: 'dropdown-item',
                    }
                    ],
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).parent().removeClass('btn-group');
                        setTimeout(function () {
                            $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                        }, 50);
                    }
            },
            ],
            // For responsive popup
            responsive: false,
            scrollX: true,
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            initComplete: function () {
                // Adding role filter once table initialized
                this.api()
                    .columns(2)
                    .every(function () {
                        var column = this;
                        $('.user_role').html('');
                        var label = $('<label class="form-label" for="UserRole">PDV</label>').appendTo('.user_role');
                        var select = $(
                            '<select id="UserRole" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select PDV </option></select>'
                        )
                            .appendTo('.user_role')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
                // Adding plan filter once table initialized
                this.api()
                    .columns(3)
                    .every(function () {
                        var column = this;
                        $('.user_plan').html('');
                        var label = $('<label class="form-label" for="UserPlan">City</label>').appendTo('.user_plan');
                        var select = $(
                            '<select id="UserPlan" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select City </option></select>'
                        )
                            .appendTo('.user_plan')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
                // Adding status filter once table initialized
                this.api()
                    .columns(4)
                    .every(function () {
                        var column = this;
                        $('.user_status').html('');
                        var label = $('<label class="form-label" for="FilterTransaction">Machine Name</label>').appendTo('.user_status');
                        var select = $(
                            '<select id="FilterTransaction" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select Machine </option></select>'
                        )
                            .appendTo('.user_status')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
            }
        });
    }
}

function load_graph()
{
    var pdv = $("#gaming_hall_list2").val();
    var sb = $("#smartbox_list2").val();
    var periods = []
    var coin_in = []
    var $textMutedColor = '#b9b9c3';
    var $revenueReportChart = document.querySelector('#usage-report-chart');
    var revenueReportChartOptions;
    var revenueReportChart;

    $.ajax({
        url: "/statistics/graph_period",
        type: "POST",
        data: 'd_start=' + d_start2 + '&d_end='+d_end2 + '&pdv='+pdv+'&sb='+sb,
        success: function (elem) {
            $.each(elem.chart, function (i,v) {
                periods.push(v.ref_hour)
                coin_in.push(v.creditos_jugado)
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

            chart.destroy();
            chart = new ApexCharts(document.querySelector("#usage-report-chart"), revenueReportChartOptions);
            chart.render();

        },
        error: function (e) {
            Swal.fire('Whoops!', 'Error while retrieving stats, contact Moebius: #007', 'error');
        }
    });
}
