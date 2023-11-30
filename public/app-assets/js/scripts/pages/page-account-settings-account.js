$(function () {
    ('use strict');

  // variables
    var form = $('.validate-form'),
    accountUploadImg = $('#account-upload-img'),
    accountUploadBtn = $('#account-upload'),
    accountUserImage = $('.uploadedAvatar'),
    accountResetBtn = $('#account-reset'),
    accountNumberMask = $('.account-number-mask'),
    accountZipCode = $('.account-zip-code'),
    select2 = $('.select2'),
    deactivateAcc = document.querySelector('#formAccountDeactivation'),
    deactivateButton = deactivateAcc.querySelector('.deactivate-account');

  // Update user photo on click of button

    if (accountUserImage) {
        var resetImage = accountUserImage.attr('src');
        accountUploadBtn.on('change', function (e) {
            var reader = new FileReader(),
            files = e.target.files;
            reader.onload = function () {
                if (accountUploadImg) {
                    accountUploadImg.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });

        accountResetBtn.on('click', function () {
            accountUserImage.attr('src', resetImage);
        });
    }

  // jQuery Validation for all forms
  // --------------------------------------------------------------------
    if (form.length) {
        form.each(function () {
            var $this = $(this);

            $this.validate({
                rules: {
                    firstName: {
                        required: true
                    },
                    lastName: {
                        required: true
                    },
                    accountActivation: {
                        required: true
                    }
                }
            });
            $this.on('submit', function (e) {

            });
        });
    }

  // disabled submit button on checkbox unselect
    if (deactivateAcc) {
        $(document).on('click', '#accountActivation', function () {
            if (accountActivation.checked == true) {
                deactivateButton.removeAttribute('disabled');
            } else {
                deactivateButton.setAttribute('disabled', 'disabled');
            }
        });
    }

  // Deactivate account alert
    const accountActivation = document.querySelector('#accountActivation');

  // Alert With Functional Confirm Button
    if (deactivateButton) {
        deactivateButton.onclick = function () {
            if (accountActivation.checked == true) {
                Swal.fire({
                    text: 'Sei sicuro di quello che stai facendo ? Perderai ogni cosa, dall\'abbonamento all\'elenco dei tuoi pazienti',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, sono sicuro',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-2'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.get('/api/account/delete', function (resp) {
                            if (resp.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Account Eliminato!',
                                    text: 'è stato bello averti con noi.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });

                                window.location = '/public/register_doc'
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Whoops!',
                                    text: 'Qualcosa è andato storto, contattaci pure',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            }
                        })
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Annullato',
                            text: 'Azione Annullata !',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        };
    }

  //phone
    if (accountNumberMask.length) {
        accountNumberMask.each(function () {
            new Cleave($(this), {
                phone: true,
                phoneRegionCode: 'IT'
            });
        });
    }
});

function updateAccount()
{
    let form = $("#doc_data_frm").serialize();
    $.post('/api/doctor/update', form, function (response) {
        if (response.status == 'success') {
            Swal.fire('OK!', 'Dati aggiornati con successo', 'success')
        } else {
            Swal.fire('Whoops!', 'Qualcosa è andato storto, sicuro di aver inserito dati corretti ?', 'error')
        }
    }).fail(function (e) {
        Swal.fire('Whoops!', 'Qualcosa è andato storto per colpa nostra, team gia allertato', 'error')
    });
}


$(document).ready(function () {
    $.get("/api/login/history", function (resp) {
        if (resp.history.length === 0) {
            return;
        }

        $.each(resp.history, function (i,v) {
            $('#tbl_accessi tr:last').after('<tr>' +
                '<td class="text-start">\n' +
                '<span class="fw-bolder">'+ v['browser'] +'</span>\n' +
                '</td>\n' +
                '<td>'+ v['ip'] +'</td>'+
                '<td>'+ v['os'] +'</td>\n' +
                '<td>'+ v['location'] +'</td>\n' +
                '<td>'+ v['ts'] +'</td>' +
                '</tr>');
        });
    });


    $(".invoice-list-table").DataTable({
        ajax: {
            url: '/api/invoices/list',
            cache: true
        },
        columns: [
            { data: 'inv_id' },
            { data: 'amount' },
            { data: 'data_issue' },
            { data: '', render: function (data, type, full) {
                    var date = new Date(full['data_issue']);
                    date.setDate(date.getDate() + 30);
                    var dateString = date.toISOString().split('T')[0];
                return dateString;
            } },
            { data: 'amount' },
            { data: 'inv_status', render: function (data, type, full) {
                switch (data) {
                    case 0:
                        return 'Non Pagata';
                    case 1:
                        return 'Scoperto';
                    case 2:
                        return 'Pagata in Parte';
                    case 3:
                        return 'Pagata';
                    default:
                        return 'Stato sconosciuto';
                }
            } },
            { data: '', render: function (data, type, full) {
                return (
                        '<div class="btn-group">' +
                        '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a href="/api/invoice/download/' + full['inv_id'] +'" class="dropdown-item">' +
                        feather.icons['download'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Scarica</a>' +
                        '<a href="/pages/invoice/view/' + full['inv_id'] +'" class="dropdown-item delete-record">' +
                        feather.icons['search'].toSvg({ class: 'font-small-4 me-50' }) +
                        'Elimina</a></div>' +
                        '</div>' +
                        '</div>'
                    );
            } }
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
        language: {
            paginate: {
                // remove previous & next text from pagination
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },

    });
});


function passwordUpdate()
{
    let old_pwd = $("#account-old-password").val();
    let new_pwd = $("#account-new-password").val();
    let conf_pwd = $("#account-retype-new-password").val();

    if ( new_pwd !== conf_pwd ) {
        Swal.fire(
            'Whoops!',
            'Spiacente ma le password non combaciano',
            'error'
        );
        return;
    }
    if ( new_pwd.length === 0 || conf_pwd.length === 0 || old_pwd.length === 0 ) {
        Swal.fire(
            'Whoops!',
            'Devi Inserire la password prima',
            'error'
        );
        return;
    }

    $.post('/api/password/update', {
        old_password: old_pwd,
        password: new_pwd
    }, function (resp) {
        Swal.fire('Attenzione', resp.message, 'info');
    });


}