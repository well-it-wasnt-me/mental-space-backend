$(document).ready(function () {
    $('#lista_pharm').select2({
        minimumInputLength: 3,
        ajax: {
            url: '/api/drugs/list/search',
            dataType: 'json',
            type: 'post'
        },
        allowClear: true,
        language: {
            inputTooShort: function () {
                return "Scrivere almeno 3 caratteri";
            }
        },
        placeholder:"Scrivi nome farmaco o principio attivo",
        dropdownParent: "#modals-add-pharm"
    });

    $('#modalEditUserDsm').select2({
        minimumInputLength: 3,
        ajax: {
            url: '/api/dsm/list/search',
            dataType: 'json',
            type: 'post'
        },
        allowClear: true,
        language: {
            inputTooShort: function () {
                return "Scrivere almeno 3 caratteri";
            }
        },
        placeholder:"Scrivi Diagnosi",
        dropdownParent: "#editUser"
    });

    var theText = $("#desc_dsm").text();
    console.log(theText);
    const myArray = theText.split(";");
    var obj = [];
    $.each(myArray, function(i,v){
        obj.push({id: v.split("*")[0], text: v.split("*")[1]});
    });
    console.log(obj);
    $.each(obj, function(i,v){
        var newOption = new Option(v['text'], v['id'],true, true);
        $('#modalEditUserDsm').append(newOption).trigger('change');
    });


    loadAnanotazioni();
});

var dtUserTable;

dtUserTable = $("#tbl_trattamento_farmacologico").DataTable({
        ajax: '/api/patients/pharm/list/' + $("#paz_id").text(),
        columns: [
            // columns according to JSON
            { data: 'id' },
            { data: 'principio_attivo' },
            { data: 'descrizione_gruppo' },
            { data: '' }
        ],
        columnDefs: [
            {
                // Actions
                targets: 3,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<div class="btn-group">' +
                        '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a onclick="eliminaFarmaco('+full['id']+')" class="dropdown-item delete-record">' +
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
                text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                buttons: [
                    {
                        extend: 'print',
                        text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                        className: 'dropdown-item',
                        exportOptions: { columns: [3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [3, 4, 5, 6, 7] }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [3, 4, 5, 6, 7] }
                    }
                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
            },
            {
                text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Aggiungi Farmaco',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modals-add-pharm'
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
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


function update_patient_info()
{
    let form_data = $("#editUserForm").serialize();
    Swal.fire({
        title: 'Sei Sicuro?',
        text: "Questa è un azione irreversibile, indietro non si torna",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI, Sono sicuro/a!',
        showLoaderOnConfirm: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/api/patients/update",
                data: form_data+"&paz_id=" + $("#paz_id").text(),
                type: "POST",
                success: function () {
                    Swal.fire('Successo!', 'Informazioni Aggiornate con Successo, aggiorna la pagina per vedere i cambiamenti', 'success');
                },
                error: function (e) {
                    Swal.fire('Whoops!', 'Error while updating the Patient, contact Moebius: #002', 'error');
                }
            });
        }
    })

}

function delete_patient()
{
    Swal.fire({
        title: 'Vuoi davvero farlo ?',
        text: "Questa azione è IRREVERSIBILE e perderai ogni cosa relativa al tuo Paziente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Procedi !',
        showLoaderOnConfirm: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/api/patient/delete/" + $("#paz_id").text(),
                data: "smartbox_id=" + $("#smartbox_id").text(),
                type: "POST",
                success: function () {
                    Swal.fire('Success!', 'Paziente Eliminato', 'success');
                    window.location = "/pages/home_doctor";
                },
                error: function (e) {
                    Swal.fire('Whoops!', 'Qualcosa è andato storto, riprova o contattaci', 'error');
                }
            });
        }
    })
}

function addDrug(){
    let pill_id = $("#lista_pharm").val();
    $.get('/api/patient/pills/add/'+$("#paz_id").text()+'/' + pill_id, function(data){
        if(data.status === 'success'){
            Swal.fire('Successo', 'Farmaco inserito senza problemi', 'success');
            dtUserTable.ajax.reload( null, false );
        } else {
            Swal.fire('Whoops!', 'Qualcosa è andato storto. Ritenta o contattaci', 'error');
        }
    });
}

function eliminaFarmaco(id){
    $.get('/api/patient/pills/delete/'+$("#paz_id").text()+'/' + id, function(data){
        if(data.status === 'success'){
            Swal.fire('Successo', 'Farmaco eliminato senza problemi', 'success');
            dtUserTable.ajax.reload( null, false );
        } else {
            Swal.fire('Whoops!', 'Qualcosa è andato storto. Ritenta o contattaci', 'error');
        }
    });
}

function loadAnanotazioni(){
    $("#annotazioni-holder").html("");
    $.get('/api/patients/list/annotation/' + $("#paz_id").text(), function (data){
        if(data.length === 0){
            $("#annotazioni-holder").append("Ancora nessun elemento inserito");
            return;
        }

        $.each(data, function(i,v){
            $("#annotazioni-holder").append(
                '<div class="card accordion-item">\n' +
                '   <h2 class="accordion-header" id="paymentTwo">\n' +
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#dsa'+ v['ann_id'] +'" aria-expanded="false" aria-controls="dsa'+ v['ann_id'] +'">\n' +
                '    ' + moment(v['creation_date'], "YYYY-MM-DD hh:mm:ss").format('DD/MM/YYYY hh:mm:ss') + ' - ' + moment(v['creation_date']).locale('it').fromNow() +
                '       </button>\n' +
                '   </h2>\n' +
                '\n' +
                '   <div id="dsa'+ v['ann_id'] +'" class="collapse accordion-collapse" aria-labelledby="paymentTwo" data-bs-parent="#faq-payment-ana">\n' +
                '       <div class="accordion-body">\n' +
                '   ' + v['annotazione'] +
                '    </div>\n' +
                '<a onclick="eliminaAnnotazione('+v['ann_id']+')" class="btn btn-danger">Elimina</a>'+
                '   </div>\n' +
                '</div>'
            )
        });
    });
}

function salvaAnnotazione(){
    let annotazione = $("#nuova_annotazione").val();
    if( annotazione.length === 0 ) {
        Swal.fire("Whoops!", "Hai dimenticato di scrivere cosa vuoi annotare", 'error');
        $("#nuova_annotazione").focus();
        return;
    }

    $.post('/api/patients/add/annotation', {paz_id: $("#paz_id").text(), annotazione: $("#nuova_annotazione").val()}, function(resp){
        if(resp.status === 'success'){
            Swal.fire("Successo!", "Annotazione inserita", 'success');
            $("#nuova_annotazione").val("");
            loadAnanotazioni();
        } else {
            Swal.fire("Whoops!", "Qualcosa è andato storto, riprova o contattaci", 'error');
        }
    });
}

function aggiornaAnnotazione(){}

function eliminaAnnotazione(ann_id){
    Swal.fire({
        title: 'Vuoi davvero farlo ?',
        text: "Questa azione è IRREVERSIBILE",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Procedi !',
        showLoaderOnConfirm: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/api/patients/delete/annotation/" + ann_id,
                type: "GET",
                success: function () {
                    Swal.fire('Successo!', 'Annotazione cancellata', 'success');
                    loadAnanotazioni();
                },
                error: function (e) {
                    Swal.fire('Whoops!', 'Qualcosa è andato storto, riprova o contattaci', 'error');
                }
            });
        }
    })
}