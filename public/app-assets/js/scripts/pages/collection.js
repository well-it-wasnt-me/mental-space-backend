/*=========================================================================================
    File Name: collection.js
    Description: Recaudacion
    Author: Antonio D'Angelo <antonio.dangelo@wtbss.com>
    --------------------------------------------------------------------------------------
==========================================================================================*/
//let select;
let d_start, d_end;
let d_start2, d_end2, d_start3, d_end3;
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

    var rangePickr3 = $('#fp-range3');
    // Range
    if (rangePickr3.length) {
        rangePickr3.flatpickr({
            mode: 'range',
            locale: {
                "firstDayOfWeek": 1 // start week on Monday
            },
            dateFormat: "Y-m-d",
            onChange: ([start, end]) => {
                if (start && end) {
                    d_start3 = new Date(start).toLocaleDateString('en-CA');
                    d_end3 = new Date(end).toLocaleDateString('en-CA');
                    console.log(d_start3, d_end3);
                }
            }
        });
    }

    load_gaming_hall('gaming_hall_list');
    load_gaming_hall('gaming_hall_list2');
    load_gaming_hall('gaming_hall_list3');

    $("#gaming_hall_list").change(function () {
        var selectedPdv = $(this).children("option:selected").val();
        retrieveMachine('smartbox_list', selectedPdv);
    });

    $("#gaming_hall_list2").change(function () {
        var selectedPdv = $(this).children("option:selected").val();
        retrieveMachine('smartbox_list2', selectedPdv);
    });

    $("#gaming_hall_list3").change(function () {
        var selectedPdv = $(this).children("option:selected").val();
        retrieveMachine('smartbox_list3', selectedPdv);
    });
});


function load_collection()
{
    var collectionTable = $('.colection');

    var list_collection_url = '/statistics/collection';

    if (collectionTable.length) {
        collectionTable.DataTable().destroy();
        collectionTable.DataTable({
            ajax: {
                "url": list_collection_url,
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
                { data: 'cont_entrada_total' },
                { data: 'cont_salida_total' },
                { data: null, render: function(data, b, row){
                        return row.cont_entrada_total - row.cont_salida_total;
                    }},
                { data: null, render: function(data, b, row){
                        return '<a href="mailto:add@email.here?&subject=NIVEL DE RECAUDACION&body=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+row.id_maquina+' la Maquina '+row.awp_name+ ' ID ' + row.awp_id + ' ha superado el límite de cantidad de recaudacion" class="btn btn-sm btn-primary"><img src="https://cdn0.iconfinder.com/data/icons/apple-apps/100/Apple_Mail-512.png" height="24px" width="24px"/></a>' +
                            '&nbsp;<a href="whatsapp://send?text=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+ strip_comma(row.id_maquina)+' la Maquina '+row.awp_name+ ' ID ' + row.awp_id + ' ha superado el límite de cantidad de recaudacion" class="btn btn-sm btn-primary"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" width="24px" height="24px"/></a>';
                    }},
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

function load_collection_period()
{
    var collectionTable = $('.collection-list-table');

    var list_collection_url = '/statistics/collection_period';

    if (collectionTable.length) {
        collectionTable.DataTable().destroy();
        collectionTable.DataTable({
            ajax: {
                "url": list_collection_url,
                "type": "POST",
                "data": {
                    "d_start": d_start2,
                    "d_end": d_end2,
                    "pdv": $("#gaming_hall_list").val(),
                    "sb": $("#smartbox_list").val()
                },
            },
            columns: [
                // columns according to JSON
                { data: 'smartbox_id' },
                { data: 'fecha' },
                { data: 'ref_hour' },
                { data: 'id_pdv' },
                { data: 'pdv' },
                { data: 'city' },
                { data: 'nome_macchina' },
                { data: 'vendor' },
                { data: 'cont_entrada_total' },
                { data: 'cont_salida_total' },
                { data: null, render: function(data, b, row){
                        return row.cont_entrada_total - row.cont_salida_total;
                    }},
                { data: null, render: function(data, b, row){
                        return '<a href="mailto:add@email.here?&subject=NIVEL DE RECAUDACION&body=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+row.id_maquina+' la Maquina '+row.awp_name+ ' ID ' + row.awp_id + ' ha superado el límite de cantidad de recaudacion" class="btn btn-sm btn-primary"><img src="https://cdn0.iconfinder.com/data/icons/apple-apps/100/Apple_Mail-512.png" height="24px" width="24px"/></a>' +
                            '&nbsp;<a href="whatsapp://send?text=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+ strip_comma(row.id_maquina)+' la Maquina '+row.awp_name+ ' ID ' + row.awp_id + ' ha superado el límite de cantidad de recaudacion" class="btn btn-sm btn-primary"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" width="24px" height="24px"/></a>';
                    }},
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
                        $('.user_role2').html('');
                        var label = $('<label class="form-label" for="UserRole">PDV</label>').appendTo('.user_role');
                        var select = $(
                            '<select id="UserRole" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select PDV </option></select>'
                        )
                            .appendTo('.user_role2')
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
                        $('.user_plan2').html('');
                        var label = $('<label class="form-label" for="UserPlan">City</label>').appendTo('.user_plan');
                        var select = $(
                            '<select id="UserPlan" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select City </option></select>'
                        )
                            .appendTo('.user_plan2')
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
                        $('.user_status2').html('');
                        var label = $('<label class="form-label" for="FilterTransaction">Machine Name</label>').appendTo('.user_status');
                        var select = $(
                            '<select id="FilterTransaction" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select Machine </option></select>'
                        )
                            .appendTo('.user_status2')
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

function load_collection_level()
{
    var collectionTable = $('.collection-level');

    var list_collection_url = '/statistics/collection_level';

    if (collectionTable.length) {
        collectionTable.DataTable().destroy();
        collectionTable.DataTable({
            ajax: {
                "url": list_collection_url,
                "type": "POST",
                "data": {
                    "d_start": d_start3,
                    "d_end": d_end3,
                    "pdv": $("#gaming_hall_list").val(),
                    "sb": $("#smartbox_list").val(),
                    "level": $("#level").val()
                },
            },
            columns: [
                // columns according to JSON
                { data: 'smartbox_id' },
                { data: 'fecha' },
                { data: 'ref_hour' },
                { data: 'id_pdv' },
                { data: 'pdv' },
                { data: 'city' },
                { data: 'nome_macchina' },
                { data: 'vendor' },
                { data: 'creditos_jugado' },
                { data: 'creditos_premiado' },
                { data: 'fecha_recaudacion' },
                { data: 'hora_recaudacion' },
                { data: 'new_entrada' },
                { data: 'new_salida' },
                { data: null, render: function(data, b, row){
                        return row.new_entrada - row.new_salida;
                    }},
                { data: 'entr_par_eff', render: function(data, b, row){
                        return parseFloat(data).toFixed(2);
                    }},
                { data: 'entr_sal_eff', render: function(data, b, row){
                        return parseFloat(data).toFixed(2);
                    }},
                { data: 'rec_eff', render: function(data, b, row){
                        return parseFloat(data).toFixed(2);
                    }},
                { data: null, render: function(data, b, row){
                        return '<a href="mailto:add@email.here?&subject=NIVEL DE RECAUDACION&body=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+row.id_maquina+' la Maquina '+row.awp_name+ ' ID ' + row.awp_id + ' ha superado el límite de cantidad de recaudacion" class="btn btn-sm btn-primary"><img src="https://cdn0.iconfinder.com/data/icons/apple-apps/100/Apple_Mail-512.png" height="24px" width="24px"/></a>' +
                            '&nbsp;<a href="whatsapp://send?text=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+ strip_comma(row.id_maquina)+' la Maquina '+row.awp_name+ ' ID ' + row.awp_id + ' ha superado el límite de cantidad de recaudacion" class="btn btn-sm btn-primary"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" width="24px" height="24px"/></a>';
                    }},
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
                        $('.user_role3').html('');
                        var label = $('<label class="form-label" for="UserRole">PDV</label>').appendTo('.user_role');
                        var select = $(
                            '<select id="UserRole" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select PDV </option></select>'
                        )
                            .appendTo('.user_role3')
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
                        $('.user_plan3').html('');
                        var label = $('<label class="form-label" for="UserPlan">City</label>').appendTo('.user_plan');
                        var select = $(
                            '<select id="UserPlan" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select City </option></select>'
                        )
                            .appendTo('.user_plan3')
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
                        $('.user_status3').html('');
                        var label = $('<label class="form-label" for="FilterTransaction">Machine Name</label>').appendTo('.user_status');
                        var select = $(
                            '<select id="FilterTransaction" class="select2 form-select text-capitalize mb-md-0 mb-2"><option value=""> Select Machine </option></select>'
                        )
                            .appendTo('.user_status3')
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
