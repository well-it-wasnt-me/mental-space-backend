/*=========================================================================================
    File Name: statistic-machine-status.js
    Description: Machine Status
    --------------------------------------------------------------------------------------
==========================================================================================*/
var statusTable = $('.event-table');

$(function () {
    ('use strict');

    var list_status_url = '/statistics/machine_status';

    // Users List datatable
    if (statusTable.length) {
        statusTable.DataTable().destroy();
        statusTable.DataTable({
            ajax: {
                "url": list_status_url,
                "type": "GET",
                "cache": true
            },
            columns: [
                // columns according to JSON
                { "data": "id" },
                { "data": "smartbox_id"},
                { "data": "nome_macchina"},
                { "data": "tamper", render:function (row) {
                    switch (row) {
                        case '1':
                            return 'Estado Puerta Principal';
                        case '2':
                            return 'Estado Puerta Inferior';
                        case '3':
                            return 'Pago Manual Pendiente';
                        case '4':
                            return 'Stato Hopper Izq';
                        case '5':
                            return 'Stato Hopper Central';
                        case '6':
                            return 'Stato Hopper Der';
                        case '7':
                            return 'Stato de Servicio';
                        case 'P0':
                            return 'Estado Puerta Principal';
                        case 'P1':
                            return 'Estado Puerta Principal';
                        default:
                            return row;
                    }
                }},
                {"data": "msg", render: function (data, b, row) {
                    if ( row.tamper === 'P0') {
                        data = 'Puerta Cerrada';
                    }

                    if (row.tamper === 'P1') {
                        data = 'Puerta Abierta';
                    }

                        return data;
                }},
                { "data": "ts"},
                { "data": null, render:function (data, type, row) {
                        var msg = row.tamper;
                        console.log(row);
                    if ( row.tamper === 'P0') {
                        msg = "PUERTA CERRADA";
                    }

                    if ( row.tamper === 'P1') {
                        msg = "PUERTA ABIERTA";
                    }
                        return '<a href="whatsapp://send?text=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+row.id_maquina+' la Maquina '+row.awp_name+ ' ID ' + row.smartbox_id + ' en data '+row.ts+' envió la siguiente alarma: '+msg+'" class="btn btn-sm btn-success"><img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" width="24px" height="24px"/> </a>' +
                            '&nbsp;<a href="mailto:add@email.here?&subject=AWP ALARM&body=Buenos Dias en el PDV '+ row.pdv +' localidad: '+row.localidad+' direccion '+ strip_comma(row.id_maquina)+' la Maquina '+row.awp_name+ ' ID ' + row.smartbox_id + ' en data '+row.ts+' envió la siguiente alarma: '+msg+'" class="btn btn-sm btn-primary"><img src="https://cdn0.iconfinder.com/data/icons/apple-apps/100/Apple_Mail-512.png" height="24px" width="24px"/></a>';
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
        });
    }

});


setInterval(function () {
    statusTable.ajax.reload(null,false);
}, 5000);