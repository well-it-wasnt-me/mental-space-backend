/*=========================================================================================
    File Name: statistic-counter.js
    Description: Electronic Counter
    --------------------------------------------------------------------------------------
==========================================================================================*/
let select;
let d_start, d_end;

$(function () {
    ('use strict');

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

    load_gaming_hall('gaming_hall_list');

    $("#gaming_hall_list").change(function(){
        var selectedPdv = $(this).children("option:selected").val();
        retrieveMachine('smartbox_list', selectedPdv);
    });
});


function load_counter()
{
    let dateRange = $("#fp-range").val();
    let pdv = $("#gaming_hall_list").val();
    let sb = $("#smartbox_list").val();

    var counterTable = $('.counter-list-table');

    var list_counter_url = '/statistics/counters';

    // Users List datatable
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
                { data: 'fecha' },
                { data: 'id_pdv' },
                { data: 'pdv' },
                { data: 'city' },
                { data: 'nome_macchina' },
                { data: 'vendor' },
                { data: "cont_entrada_total"},
                { data: "cont_salida_total"},
                { data: "jugadas_total"},
                { data: null, render: function (a,b,c) {
                        return parseFloat(( c.cont_salida_total / c.cont_entrada_total) * 100).toFixed(2) + " %";
                }}
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
