/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
    ('use strict');

    var dtUserTable = $('.user-list-table'),
    newUserSidebar = $('.new-user-modal'),
    newUserForm = $('.add-new-user'),
    select = $('.select2'),
    dtContact = $('.dt-contact'),
    statusObj = {
        0: { title: 'In Attesa', class: 'badge-light-warning' },
        1: { title: 'Attivo', class: 'badge-light-success' },
        2: { title: 'Inattivo', class: 'badge-light-secondary' },
        3: { title: 'Cancellato', class: 'badge-light-secondary' },
        4: { title: 'App NON installata', class: 'badge-light-secondary' }
    };

    var assetPath = '../../../app-assets/',
    userView = '/pages/patients/detail/',
    dataUrl = '/api/patients/list';

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

  // Users List datatable
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: dataUrl,
            columns: [
            // columns according to JSON
            { data: '' },
            { data: 'name' },
            { data: 'surname' },
            { data: 'email' },
            { data: 'data_inizio_cure' },
            { data: 'account_status' },
            { data: '' }
            ],
            columnDefs: [
            {
              // For Responsive
                className: 'control',
                orderable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
            {
              // User full name and username
                targets: 1,
                responsivePriority: 4,
                render: function (data, type, full, meta) {
                    var $name = full['name'] + " " + full['surname'],
                    $email = full['email'] ?? 'Non registrato su mental space',
                    $image = full['photo'];
                    if ($image) {
                      // For Avatar image
                        var $output =
                        '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
                    } else {
                  // For Avatar badge
                        var stateNum = Math.floor(Math.random() * 6) + 1;
                        var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                        var $state = states[stateNum],
                        $name = full['name'] + " " + full['surname'],
                        $initials = $name.match(/\b\w/g) || [];
                        $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                        $output = '<span class="avatar-content">' + $initials + '</span>';
                    }
                    var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                // Creates full output for row
                    var $row_output =
                    '<div class="d-flex justify-content-left align-items-center">' +
                    '<div class="avatar-wrapper">' +
                    '<div class="avatar ' +
                    colorClass +
                    ' me-1">' +
                    $output +
                    '</div>' +
                    '</div>' +
                    '<div class="d-flex flex-column">' +
                    '<a href="' +
                    userView + full['paz_id'] +
                    '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                    $name +
                    '</span></a>' +
                    '<small class="emp_post text-muted">' +
                    $email +
                    '</small>' +
                    '</div>' +
                    '</div>';
                    return $row_output;
                }
            },
            {
              // User Role
                targets: 2,
                render: function (data, type, full, meta) {
                    var $icd = full['descrizione'];
                    return  $icd ;
                }
            },{
              // User Role
                targets: 3,
                render: function (data, type, full, meta) {
                    var $date = full['data_inizio_cure'] ?? 'Data inizio cura non settata';
                    return "<span class='text-truncate align-middle'>" + $date + '</span>';
                }
            },
            {
                targets: 4,
                render: function (data, type, full, meta) {
                    var $billing = moment(full['dob']).format('DD/MM/YYYY') ?? 'Data di Nascita non inserita';

                    return '<span class="text-nowrap">' + $billing + '</span>';
                }
            },
            {
              // User Status
                targets: 5,
                render: function (data, type, full, meta) {
                    var $status = full['account_status'] ?? 4;

                    return (
                    '<span class="badge rounded-pill ' +
                    statusObj[$status].class +
                    '" text-capitalized>' +
                    statusObj[$status].title +
                    '</span>'
                    );
                }
            },
            {
              // Actions
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                    '<div class="btn-group">' +
                    '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                    feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                    '</a>' +
                    '<div class="dropdown-menu dropdown-menu-end">' +
                    '<a href="' +
                    userView + full['paz_id'] +
                    '" class="dropdown-item">' +
                    feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                    'Dettaglio</a>' +
                    '<a href="javascript:;" class="dropdown-item delete-record">' +
                    feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                    'Elimina</a></div>' +
                    '</div>' +
                    '</div>'
                    );
                }
            }
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
                    exportOptions: { columns: [1, 2, 3, 4, 5] }
                },
                {
                    extend: 'csv',
                    text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1, 2, 3, 4, 5] }
                },
                {
                    extend: 'excel',
                    text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1, 2, 3, 4, 5] }
                },
                {
                    extend: 'pdf',
                    text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1, 2, 3, 4, 5] }
                },
                {
                    extend: 'copy',
                    text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                    className: 'dropdown-item',
                    exportOptions: { columns: [1, 2, 3, 4, 5] }
                }
                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                    }, 50);
                }
            }
            ],
          // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Dettaglio su ' + data['name'] + " " + data['surname'];
                        }
                    }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.columnIndex !== 6 // ? Do not show row in modal popup if title is blank (for check box)
                        ? '<tr data-dt-row="' +
                        col.rowIdx +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                        : '';
                    }).join('');
                    return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                }
                }
            },
            "language": {
                "lengthMenu": "Mostrando _MENU_ record per pagina",
                "zeroRecords": "Spiacente, trovato nulla",
                "info": "Mostrando pagina _PAGE_ di _PAGES_",
                "infoEmpty": "Nessun record disponibile",
                "infoFiltered": "(filtrati da _MAX_ record totali)",
                "search": "Cerca:",
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },

        });
    }

  // Form Validation
    if (newUserForm.length) {
        newUserForm.validate({
            errorClass: 'error',
            rules: {
                'user-fullname': {
                    required: true
                },
                'user-name': {
                    required: true
                },
                'user-email': {
                    required: true
                }
            }
        });

        newUserForm.on('submit', function (e) {
            var isValid = newUserForm.valid();
            e.preventDefault();
            if (isValid) {
                newUserSidebar.modal('hide');
            }
        });
    }

  // Phone Number
    if (dtContact.length) {
        dtContact.each(function () {
            new Cleave($(this), {
                phone: true,
                phoneRegionCode: 'IT'
            });
        });
    }


    $.get('/api/doctor/stat', function(resp){
        $("#lbl_tot_paz").text(resp.tot_paz);
        $("#lbl_appointments").text(resp.tot_appm);
        $("#lbl_money").text(resp.tot_money + " €");
        $("#lbl_unread_msg").text(resp.unread_msg);
    });

});
