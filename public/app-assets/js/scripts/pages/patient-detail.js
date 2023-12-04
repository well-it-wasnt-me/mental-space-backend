$(document).ready(function () {

    retrieveMood();
    retrieveDiary();
    retrieveFileList();
    loadCharts();
    loadRelazione();
    retrieveComportamentiTest();
    retrieveEmozioniTest();
    reportVari();
    retrievePhqTest();
    loadConsult();

});

function retrieveDiary() {
    $.get('/api/patients/list/diary/' + $("#user_id").text(), function (data) {
        $.each(data, function (i, v) {
            $("#diary-holder").append(
                '<div class="card accordion-item">\n' +
                '   <h2 class="accordion-header" id="paymentOne">\n' +
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#asd' + v['diary_id'] + '" aria-expanded="false" aria-controls="asd' + v['diary_id'] + '">\n' +
                '    ' + moment(v['creation_date'], "YYYY-MM-DD hh:mm:ss").format('DD/MM/YYYY hh:mm:ss') + ' - ' + moment(v['creation_date']).locale('it').fromNow() +
                '       </button>\n' +
                '   </h2>\n' +
                '\n' +
                '   <div id="asd' + v['diary_id'] + '" class="collapse accordion-collapse" aria-labelledby="paymentOne" data-bs-parent="#faq-payment-qna">\n' +
                '       <div class="accordion-body">\n' +
                '   ' + v['content'] +
                '    </div>\n' +
                '   </div>\n' +
                '</div>'
            )
        });
    });
}

function retrieveMood() {
    $.get('/api/patients/list/last_10_mood/' + $("#user_id").text(), function (resp) {
        $.each(resp, function (i, v) {
            let color;
            if (v['value'] === 'OTTIMO') {
                color = "timeline-point-info"
            } else if (v['value'] === 'BUONO') {
                color = "timeline-point-primary"
            } else if (v['value'] === 'STABILE') {
                color = "timeline-point-secondary"
            } else if (v['value'] === 'BASSO') {
                color = "timeline-point-warning";
            } else if (v['value'] === 'MOLTO DEPRESSO') {
                color = 'timeline-point-danger';
            } else {
                color = "";
            }

            $("#list-container ul").append(
                '<li class="timeline-item">\n' +
                '   <span class="timeline-point timeline-point-indicator ' + color + '"></span>\n' +
                '   <div class="timeline-event">' +
                '       <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">' +
                '       <h6>' + v['value'] + '</h6>' +
                '       <span class="timeline-event-time me-1">' + moment(v['effective_datetime']).locale('it').fromNow() + '</span>' +
                '   </div>' +
                '   <p>' + v['warning_sign'] + '</p>' +
                '</div>' +
                '</li>');
        });

    });

}


function retrieveFileList() {
    $("#file_list").html("");

    $.get('/api/patients/file/list/' + $("#user_id").text(), function (resp) {
        console.log(resp.files);
        if (resp.files.length === 0) {
            $("#file_list").append(
                '<li class="list-group-item">\n' +
                'Ancora nessun file condiviso' +
                '</li>'
            );
        }

        $.each(resp.files, function (i, v) {
            $("#file_list").append(
                '<li class="list-group-item">\n' +
                v + ' <a class="btn btn-flat-primary" onclick="downloadFile(\'' + v + '\')">SCARICA</a>&nbsp;' +
                '<a class="btn btn-flat-danger" onclick="deleteFile(\'' + v + '\')">ELIMINA</a>' +
                '</li>'
            );
        });
    });
}

function downloadFile(file_name) {
    $.ajax({
        type: "POST",
        url: '/api/patient/file/download',
        data: {filename: file_name, user_id: $("#user_id").text()},
        xhrFields: {
            responseType: 'blob' // to avoid binary data being mangled on charset conversion
        },
        success: function (blob, status, xhr) {
            // check for a filename
            var filename = file_name;
            var disposition = xhr.getResponseHeader('Content-Disposition');
            if (disposition && disposition.indexOf('attachment') !== -1) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }

            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                window.navigator.msSaveBlob(blob, filename);
            } else {
                var URL = window.URL || window.webkitURL;
                var downloadUrl = URL.createObjectURL(blob);

                if (filename) {
                    // use HTML5 a[download] attribute to specify filename
                    var a = document.createElement("a");
                    // safari doesn't support this yet
                    if (typeof a.download === 'undefined') {
                        window.location.href = downloadUrl;
                    } else {
                        a.href = downloadUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                    }
                } else {
                    window.location.href = downloadUrl;
                }

                setTimeout(function () {
                    URL.revokeObjectURL(downloadUrl);
                }, 100); // cleanup
            }
        }
    });
}

function uploadFile() {
    var fd = new FormData();
    var files = $('#file')[0].files[0];
    fd.append('file', files);
    fd.append('user_id', $("#user_id").text());

    $.ajax({
        url: '/api/patient/file/upload',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 0) {
                retrieveFileList();
                Swal.fire("Successo!", 'File caricato senza problemi', 'success');
            } else {
                Swal.fire("Whoops!", 'Qualcosa è andato storto. Riprova più tardi oppure contattaci', 'error');
            }
        },
    });
}

function deleteFile(file_name) {
    Swal.fire({
        title: 'Sei sicuro ?',
        text: "Ti ricordo che una volta cancellato un file non è più recuperabile",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cancella !'
    }).then((result) => {
        if (result.isConfirmed) {
            var fd = new FormData();
            fd.append('filename', file_name);
            fd.append('user_id', $("#user_id").text());

            $.ajax({
                url: '/api/patient/file/delete',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response != 0) {
                        retrieveFileList();
                        Swal.fire("Successo!", 'File eliminato senza problemi', 'success');
                    } else {
                        Swal.fire("Whoops!", 'Qualcosa è andato storto. Riprova più tardi oppure contattaci', 'error');
                    }
                },
            });
        }
    })
}

function loadCharts() {
    var chart = $('.doughnut-chart');

    if (chart.length) {
        $.get('/api/patient/mood/all/' + $("#user_id").text(), function (data) {
            const lbl = data[0].map((x) => x.x)
            const val = data[0].map((x) => x.y);
            const ctx = document.getElementById('myChart').getContext('2d');

            chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: lbl,
                    datasets: [{
                        backgroundColor: [
                            '#ffbe16',
                            '#d56964',
                            '#f6ddbd',
                            '#562b6f',
                            'rgb(122,148,176)',
                            'rgb(68,40,188)',
                        ],
                        data: val
                    }]
                },
                options: {
                    tooltips: {
                        mode: 'index'
                    }
                }
            });
        });
    }

    var barChart = $('.bar-chart');

    if (barChart.length) {
        $.get('/api/patient/depressione/all/' + $("#paz_id").text(), function (data) {
            const lbl = data[0].map((x) => x.x)
            const val = data[0].map((x) => x.y);
            const ctx = document.getElementById('myDepressionChart').getContext('2d');

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: lbl,
                    datasets: [{
                        data: val,
                        label: "Punteggio"
                    }]
                },
                options: {
                    tooltips: {
                        mode: 'index'
                    }
                }
            });
        });
    }
}


function loadRelazione() {
    $.get('/api/patients/relazione/' + $("#paz_id").text(), function (resp) {
        $("#editor").html(resp.content[0].notes);
    });
}

function salvaRelazione() {
    $.post('/api/patients/relazione/save', {
        paz_id: $("#paz_id").text(),
        content: $("#editor").html()
    }, function (resp) {
        if (resp.status === 'success') {
            Swal.fire("Successo!", "Relazione salvata", "success");
        } else {
            Swal.fire("Whoops!", "Qualcosa è andato storto, riprova o contattaci", "error");
        }
    });
}

function retrieveComportamentiTest() {
    $.get('/api/patient/test/comportamento/' + $("#user_id").text(), function (resp) {
        if(resp.length === 0){
            $("#comportamenti-holder").html("Ancora Nulla");
            return;
        }

        $("#comportamenti-holder").html("");
        $.each(resp, function (i, v) {
            $("#comportamenti-holder").append(
                '<div class="card accordion-item">\n' +
                '   <h2 class="accordion-header" id="paymentNone">\n' +
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#cmp' + v['cmp_id'] + '" aria-expanded="false" aria-controls="cmp' + v['cmp_id'] + '">\n' +
                '    ' + moment(v['submission_date'], "YYYY-MM-DD hh:mm:ss").format('DD/MM/YYYY hh:mm:ss') + ' - ' + moment(v['submission_date']).locale('it').fromNow() +
                '       </button>\n' +
                '   </h2>\n' +
                '\n' +
                '   <div id="cmp' + v['cmp_id'] + '" class="collapse accordion-collapse" aria-labelledby="paymentNone" data-bs-parent="#faq-payment-qna">\n' +
                '       <div class="accordion-body">\n' +
                '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://cdn-icons-png.flaticon.com/512/1686/1686491.png" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Gesti Autolesivi</p>\n' +
                '                                                    <span>Intenzione: ' + intenzioneConverter(JSON.parse(v['selfharm_acts']).intenzione) + '</span><br>\n' +
                '                                                    <span>Azione: ' + azioneConverter(JSON.parse(v['selfharm_acts']).azione) + '</span>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' +
                '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://cdn-icons-png.flaticon.com/512/2303/2303282.png" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Tentativi di Suicidio</p>\n' +
                '                                                    <span>Intenzione: ' + intenzioneConverter(JSON.parse(v['suicidal_attempts']).pensiero) + '</span><br>\n' +
                '                                                    <span>Azione: ' + azioneConverter(JSON.parse(v['suicidal_attempts']).azione) + '</span>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' +
                '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://www.almaphysio.com/wp-content/uploads/recettesalcool4.webp" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Assunzione Alcool</p>\n' +
                '                                                    <span>Intenzione: ' + intenzioneConverter(JSON.parse(v['alcohol_use']).intenzione) + '</span><br>\n' +
                '                                                    <span>Azione: ' + azioneConverter(JSON.parse(v['alcohol_use']).uso) + '</span>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' + '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://ind.obsan.admin.ch/assets/img/1CAN.png" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Assunzione Droghe</p>\n' +
                '                                                    <span>Intenzione: ' + intenzioneConverter(JSON.parse(v['illegal_drug_use']).intenzione) + '</span><br>\n' +
                '                                                    <span>Azione: ' + azioneConverter(JSON.parse(v['illegal_drug_use']).uso) + '</span>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' + '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://png.pngtree.com/png-vector/20190615/ourlarge/pngtree-drug-icon-png-image_1501182.jpg" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Assunzione Farmaci con Prescrizione</p>\n' +
                '                                                    <span>Azione: ' + azioneConverter(JSON.parse(v['illegal_drug_use']).assunzione) + '</span>\n' +
                '                                                </div>\n' +
                '    </div>\n' +
                '</div>' +
                '                                       <div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://www.trainingalimentare.it/wp-content/uploads/2015/11/digiunare.png" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Abbuffate</p>\n' +
                '                                                    <span>Intenzione: ' + intenzioneConverter(JSON.parse(v['binge_eating']).intenzione) + '</span>\n' +
                '                                                    <br><span>Azione: ' + azioneConverter(JSON.parse(v['binge_eating']).azione) + '</span>\n' +
                '                                                </div>\n' +
                '   </div>\n' +
                '</div>' +
                '                                       <div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://cdn-icons-png.flaticon.com/512/1754/1754091.png" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Vomito</p>\n' +
                '                                                    <span>Intenzione: ' + intenzioneConverter(JSON.parse(v['puking']).intenzione) + '</span>\n' +
                '                                                    <br><span>Azione: ' + azioneConverter(JSON.parse(v['puking']).azione) + '</span>\n' +
                '                                                </div>\n' +
                '   </div>\n' +
                '</div>'
            )
        });

    });

}

function retrievePhqTest() {
    $.get('/api/patient/test/phq9/' + $("#user_id").text(), function (resp) {
        if(resp.length === 0){
            $("#phq9-holder").html("Ancora Nulla");
            return;
        }

        $("#phq9-holder").html("");
        var score = 0;
        $.each(resp, function (i, v) {
           score = parseInt(v['interest']) +
               parseInt(v['depressed']) +
               parseInt(v['sleep_difficulty']) +
               parseInt(v['tired']) +
               parseInt(v['notso_hungry']) +
               parseInt(v['sense_of_guilt']) +
               parseInt(v['trouble_concentrating']) +
               parseInt(v['movement']) +
               parseInt(v['better_dead']) +
               parseInt(v['propblems_difficulty']);


               $("#phq9-holder").append(
                '<div class="card accordion-item">\n' +
                '   <h2 class="accordion-header" id="paymentNoness">\n' +
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#ph' + v['ph_id'] + '" aria-expanded="false" aria-controls="ph' + v['ph_id'] + '">\n' +
                '    ' + moment(v['submission_date'], "YYYY-MM-DD hh:mm:ss").format('DD/MM/YYYY hh:mm:ss') + ' - ' + moment(v['submission_date']).locale('it').fromNow() +
                '       </button>\n' +
                '   </h2>\n' +
                '\n' +
                '   <div id="ph' + v['ph_id'] + '" class="collapse accordion-collapse" aria-labelledby="paymentNoness" data-bs-parent="#faq-payment-qna">\n' +
                '       <div class="accordion-body">' +
                '<ul>' +
                '<li>Scarso interesse o piacere nel fare le cose: '+convertPh9Result(v['interesse'])+'</li>' +
                '<li>Sentirsi giù, depresso o disperato: '+convertPh9Result(v['depresso'])+'</li>' +
                '<li>Difficoltà ad addormentarsi o mantenere il sonno, o dormire troppo: '+convertPh9Result(v['difficolta_sonno'])+'</li>' +
                '<li>Sentirsi stanco o avere poca energia: '+convertPh9Result(v['stanco'])+'</li>' +
                '<li>Scarso appetito o mangiare troppo: '+convertPh9Result(v['poca_fame'])+'</li>' +
                '<li>Sentirsi in colpa o di essere un fallito o di aver danneggiato se stesso o la sua famiglia: '+convertPh9Result(v['sensi_di_colpa'])+'</li>' +
                '<li>Difficoltà a concentrarsi sulle cose, come leggere il giornale o guardare la televisine: '+convertPh9Result(v['difficolta_concentrazione'])+'</li>' +
                '<li>Muoversi o parlare così lentamente tanto che anche gli altri\n' +
                'se ne accorgevano o, al contrario, essere così irrequieto o\n' +
                'agitato da doversi muovere da ogni parte molto più del\n' +
                'solito: '+convertPh9Result(v['movimento'])+'</li>' +
                '<li>Pensare che sarebbe meglio essere morto o di farsi del male in qualche modo: '+convertPh9Result(v['meglio_morte'])+'</li>'+
                '<li>Se ha riscontrato la presenza di qualcuno dei problemi indicati nel presente questionario, in che misura\n' +
                'quei problemi le hanno creato difficoltà nel suo lavoro, nel prendersi cura delle cose a casa o nello\n' +
                'stare insieme agli altri?: '+convertPh9ResultProb(v['difficolta_problemi'])+'</li>'+
                '<li>Punteggio: '+ score + ' - ' + convertScore(score) + '</li>' +
                '</ul>' +
                '       </div></div></div>'
            )
        });

    });

}

function convertPh9Result(item){
    switch (item){
        case '0':
            return '<b>Mai</b>';
        case '1':
            return '<b>Molti Giorni</b>';
        case '2':
            return '<b>Più della metà dei giorni</b>';
        case '3':
            return '<b>Quasi tutti i giorni</b>';
        default:
            return "<b>Fuori Scala...</b>";
    }
}
function convertPh9ResultProb(item){
    switch (item){
        case '0':
            return 'Nessuna Difficoltà';
        case '1':
            return 'Qualche Difficoltà';
        case '2':
            return 'Notevole Difficoltà';
        case '3':
            return 'Estrema Difficoltà';
        default:
            return "Fuori Scala...";
    }
}

function convertScore(score){
    if( score < 5 ){
        return '<b>Depressione non rilevata</b>';
    } else if (score >= 5 && score <= 9 ){
        return '<b>Sintomi depressivi minimi / Depressione sottosoglia</b>';
    } else if (score >= 10 && score <= 14){
        return '<b>Depressione minore / Depressione maggiore lieve</b>';
    } else if (score >= 15 && score <= 19){
        return '<b>Depressione maggiore moderata</b>'
    } else if (score >= 20) {
        return '<b>Depressione maggiore severa</b>';
    } else {
        return 'Sconosciuto';
    }
}
function retrieveEmozioniTest(){
    $.get('/api/patient/test/emozioni/' + $("#user_id").text(), function (resp) {
        if(resp.length === 0){
            $("#emozioni-holder").html("Ancora Nulla");
            return;
        }

        $("#emozioni-holder").html("");
        $.each(resp, function (i, v) {
            $("#emozioni-holder").append(
                '<div class="card accordion-item">\n' +
                '   <h2 class="accordion-header" id="paymentNones">\n' +
                '       <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#em' + v['em_id'] + '" aria-expanded="false" aria-controls="em' + v['em_id'] + '">\n' +
                '    ' + moment(v['submission_date'], "YYYY-MM-DD hh:mm:ss").format('DD/MM/YYYY hh:mm:ss') + ' - ' + moment(v['submission_date']).locale('it').fromNow() +
                '       </button>\n' +
                '   </h2>\n' +
                '\n' +
                '   <div id="em' + v['em_id'] + '" class="collapse accordion-collapse" aria-labelledby="paymentNones" data-bs-parent="#faq-payment-qna">\n' +
                '       <div class="accordion-body">\n' +
                '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://banner2.cleanpng.com/20180605/cou/kisspng-smiley-emoticon-computer-icons-anger-angry-icon-5b16a5e45114e3.0864046715282109163321.jpg" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Rabbia</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['rabbia']) + '</span><br>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' +
                '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="data:image/png;base64,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" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Paura</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['paura']) + '</span><br>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' +
                '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="data:image/png;base64,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" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Gioia</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['gioia'])+ '</span><br>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' + '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="data:image/jpeg;base64,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" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Sensi di Colpa</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['colpa']) + '</span><br>\n' +
                '                                                </div>\n' +
                '                                                \n' +
                '    </div>\n' +
                '</div>' + '<div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="data:image/jpeg;base64,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" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Tristezza</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['tristezza']) + '</span>\n' +
                '                                                </div>\n' +
                '    </div>\n' +
                '</div>' +
                '                                       <div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://icon2.cleanpng.com/20210215/vhq/transparent-ashamed-icon-sweat-icon-users-icon-602a245b6ca073.7827416216133745554449.jpg" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Vergogna</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['vergogna']) + '</span>\n' +
                '                                                </div>\n' +
                '   </div>\n' +
                '</div>' +
                '                                       <div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="data:image/jpeg;base64,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" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Sofferenza fisica ed Emotiva</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['sofferenza_fisica_emotiva']) + '</span>\n' +
                '                                                </div>\n' +
                '   </div>\n' +
                '</div>' +
            '                                       <div class="d-flex mt-2">\n' +
            '                                            <div class="flex-shrink-0">\n' +
            '                                                <img src="https://media.istockphoto.com/id/1280758523/it/vettoriale/icona-abilit%C3%A0-aggiuntive-in-stile-linea-simbolo-delle-abilit%C3%A0-aziendali.jpg?s=1024x1024&w=is&k=20&c=OF6A4ykJ6aO74A678rWQ9jdAZ9mFclhMu41JvgTIldc=" class="me-1" height="38" width="38">\n' +
            '                                            </div>\n' +
            '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
            '                                                <div class="me-1">\n' +
            '                                                    <p class="fw-bolder mb-0">Abilit&agrave; messe in pratica</p>\n' +
            '                                                    <span>' + abilitaConverter(v['abilita_messe_in_pratica']) + '</span>\n' +
            '                                                </div>\n' +
            '   </div>\n' +
            '</div>' +
            '                                       <div class="d-flex mt-2">\n' +
            '                                            <div class="flex-shrink-0">\n' +
            '                                                <img src="data:image/jpeg;base64,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" class="me-1" height="38" width="38">\n' +
            '                                            </div>\n' +
            '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
            '                                                <div class="me-1">\n' +
            '                                                    <p class="fw-bolder mb-0">Intenzione ad Abbandondare terapia</p>\n' +
            '                                                    <span>' + intenzioneConverter(v['intenzione_abbandono_terapia']) + '</span>\n' +
            '                                                </div>\n' +
            '   </div>\n' +
            '</div>' +
                '                                       <div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="https://e7.pngegg.com/pngimages/264/130/png-clipart-computer-icons-icon-design-encapsulated-postscript-trust-symbols-orange-area.png" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Fiducia nel cambiamento</p>\n' +
                '                                                    <span>' + intenzioneConverter(v['intenzione_abbandono_terapia']) + '</span>\n' +
                '                                                </div>\n' +
                '   </div>\n' +
                '</div>' +
                '                                       <div class="d-flex mt-2">\n' +
                '                                            <div class="flex-shrink-0">\n' +
                '                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARMAAAC3CAMAAAAGjUrGAAAAb1BMVEX///8AAADv7+/q6uri4uIfHx/S0tKioqJNTU3z8/P39/ff39+AgIAvLy+2trZhYWFHR0erq6ttbW3ExMRbW1vMzMxmZmYRERGzs7Ofn59WVlaKiopAQECSkpIqKiqQkJB7e3s4ODhycnIiIiIZGRn7DhMrAAAEUklEQVR4nO2d25aiMBBFieAF0Qa0VVSwvf3/N44EJcFyhl6LSrfUnP12RjqGvRwTpEI8DwAAAAAAAAAAAAAAAAAA/xthmoaNf/gYB4282o4aOdouG9lPs6mbrv0Wg4NSc1vKTillS9jfcmrl5S2frRxslMplSSlup6i2Jq/KvLAOKLOycl7myORZmTPX3fxR9CnNTC4/BurTZP/ZybzMK5MXZR477+dPAicUOKHACQVOKHBCKacfam+yHotjk8OXTqwJzFk9TWB6TLjcL+J4rU9xvo7vrCdlvpj8qZ3UOY43ZZ6YAw5lzm95Uaz6PXULZ/rcmBkWPbby4UCIZrNqf/P3pHClRPX2q2XsUIlSy/YOvB/RvfNxkaZZeRmsdln6QI/NeR3TrT7UvJ4Oy7yvY5aUeXE74Gt3bzds78LboYcWlVfXti/HYmt+8r2xuJqfjPQY1Liq7gkj3fHJPfHO2fSLqvmbVB846n4/Bk1eJ9XR1s8xPSFvdJt5bq+F75z02yGDa+PjzexE//nJSccdEuiTHDwisxN9+KVvI88rJ9a48+xk8Ozk0O5kOPD6xZOT1dPQ6jdO0as+F5YjPXhfrcsafZkQNf687068LEk+7NdHk7yws7/Oz43/C7N81xhsx8nETF1lOOEFTihwQoETCpxQ4IQCJxQ4ocAJBU4ocEKBEwqcUGQ4CdNxV6y6RxFOBhfVHVP3KMIJz23Suu5RhJM9ixNZvz1G/zzX71I3J8KJF53jrhz9ujUZTniBEwqcUOCEAicUOKHACUWIEz/qit2YCCcxwzT2WLcmwknKoMSq/xThZMbiRNY14JLFSV3AIsIJR1H1xhSwyHDCC5xQ4IQCJxQ4ocAJBU4oUpxMu2K1JcNJepp3JRc2Z+OZ28uqLee5BqyXA4lwgt8KPPp9smZQcqxbk+HE87tjNSbDCStwQoETCpxQ4IQCJxQ4ochwEs06szfrSEU4Yanx28iq8eOpBa0fGCTCyReLE1k1w4Mhg5KTrNpyL0y3HZcgbKWtQWAGTihwQoETCpxQ4IQCJxQhTpYfXbGeeinCSXhgmMcmdesinGwZlChV3zAW4QT1sR5xMmJxUt/1EuHEW30mXVmbbVZkOOEFTihwQoETCpxQ4IQCJxQhTvygK+LWSB4ZprHmIbwinGQMSqznU4twgvpYjzjh2YlH2BrJovuGTVez544MJ9407Iq1MEOIE1bghAInFDihwAkFTihwQoETCpxQ4IQCJxQ4ocAJBU4ocEKBE0o/nfhOnWjjh77tij593giSFf34g9xR4+7Q21GvHTVe7XrtqHF3VA/uc7NreeqwbZdUu6rae4yyUd0YuTpo2TX35W7HgPercBotqoaz9mPfj0eZ8CWZ8JE8FtFN2jvwhvjdb3P9nUPfNnS+E3BsuvOavKdKPJ4Ki1d8/faJdSHYz9mFnAq//Y3fm2DES9D+lgAAAAAAAAAAAAAAAAAAEMMflUFaF3pyHTsAAAAASUVORK5CYII=" class="me-1" height="38" width="38">\n' +
                '                                            </div>\n' +
                '                                            <div class="d-flex justify-content-between flex-grow-1">\n' +
                '                                                <div class="me-1">\n' +
                '                                                    <p class="fw-bolder mb-0">Note</p>\n' +
                '                                                    <span>' + v['note'] ?? "" + '</span>\n' +
                '                                                </div>\n' +
                '   </div>\n' +
                '</div>'
            )
        });

    });
}
function intenzioneConverter(intenzione) {
    switch (intenzione) {
        case "0":
            return 'Per Niente';
        case "1":
            return 'Un Poco';
        case "2":
            return 'Alquanto';
        case "3":
            return 'Piuttosto forte';
        case "4":
            return 'Molto Forte';
        case "5":
            return 'Fortissimo'
        default:
            return 'Valore fuori scala: ' + intenzione;
    }
}

function abilitaConverter(intenzione) {
    switch (intenzione) {
        case "0":
            return 'non ci ho pensato';
        case "1":
            return 'ci ho pensato,non le ho usate e non volevo farlo';
        case "2":
            return 'ci ho pensato, non le ho usate , ma volevo farlo,';
        case "3":
            return '= ho tentato, ma non sono\n' +
                'riuscito a usarle';
        case "4":
            return 'ho tentato, sono riuscito a usarle, ma non mi hanno aiutato';
        case "5":
            return 'ho tentato, sono riuscito a usarle e mi hanno aiutato'
        case "6":
            return 'le ho usate, ma non mi hanno aiutato'
        case "7":
            return ' le\n' +
                'ho usate e mi hanno aiutato'
        default:
            return 'Valore fuori scala: ' + intenzione;
    }
}

function azioneConverter(azione) {
    return azione === 'false' ? 'No' : 'Si';
}

function reportVari(){
    let diarioStat = "";
    let comportamentoStat = "";
    let emozioniStat = "";
    let emozioniAvg = "";
    let phq9 = "";

    $.get('/api/patient/report/' + $("#user_id").text(), function(data){
        $.each(data.diario, function(i,v){
           diarioStat += 'Data: ' + moment(v['post_ts']).format('DD/MM/YYYY') + "<br>";
           diarioStat += 'Post Inseriti: ' + v['tot_post'] + "<br>";
        });

        diarioStat += "<hr>";

        if(data.diario.length === 0){
            diarioStat += "Ancora Nulla";
        }



        $.each(data.comportamento, function(i,v){
            comportamentoStat += 'Data: ' + moment(v['compilazione_ts']).format('DD/MM/YYYY') + "<br>";
            comportamentoStat += 'Test Immessi: ' + v['tot_test'] + "<br>";
        });


        $.each(data.emozioni.stat, function(i,v){
            emozioniStat += 'Data: ' + moment(v['compilazione_ts']).format('DD/MM/YYYY') + "<br>";
            emozioniStat += 'Test Immessi: ' + v['tot_test'] + "<br>";
        });

        emozioniAvg = "<h5>Clicca su un tag per avere la scala dei valori</h5>"
        $.each(data.emozioni.average, function(i,v){
            emozioniAvg += '<a class="badge badge-light-danger" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Rabbia:</a> ' + v['rabbia'] + "<br>";
            emozioniAvg += '<a class="badge badge-light-dark" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Paura:</a> ' + v['paura'] + "<br>";
            emozioniAvg += '<a class="badge badge-light-warning" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Gioia:</a> ' + v['gioia'] + "<br>";
            emozioniAvg += '<a class="badge badge-light-primary" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Colpa:</a> ' + v['colpa'] + "<br>";
            emozioniAvg += '<a class="badge badge-light-secondary" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Tristezza:</a> ' + v['tristezza'] + "<br>";
            emozioniAvg += '<a style="color: white;" class="badge bg-primary" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Vergogna:</a> ' + v['vergogna'] + "<br>";
            emozioniAvg += '<a class="badge bg-secondary" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Sofferenza fisica/emotiva:</a> ' + v['sofferenza_fisica_emotiva'] + "<br>";
            emozioniAvg += '<a class="badge bg-warning" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0= non ci ho pensato, 1= ci ho pensato,non le ho usate e non volevo farlo, 2= ci ho pensato, non le ho usate , ma volevo farlo, 3= ho tentato, ma non sono\n' +
                'riuscito a usarle, 4= ho tentato, sono riuscito a usarle, ma non mi hanno aiutato, 5= ho tentato, sono riuscito a usarle e mi hanno aiutato, 6= le ho usate, ma non mi hanno aiutato, 7= le ho usate e mi hanno aiutato">Abilit&agrave; messe in pratica:</a> ' + v['abilita_messe_in_pratica'] + "<br>";
            emozioniAvg += '<a class="badge bg-success" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Intenzione ad abbandonare terapia:</a> ' + v['intenzione_abbandono_terapia'] + "<br>";
            emozioniAvg += '<a class="badge bg-light-success" data-bs-toggle="popover" data-bs-placement="top" data-bs-container="body" title="Scala Valori" data-bs-content="0 = per niente, 1 = un poco, 2 = alquanto, 3 = piuttosto forte, 4 = molto forte, 5 = fortissimo">Fiducia nel cambiamento:</a> ' + v['fiducia_cambiamento'] + "<br>";
        });

        if(data.comportamento.length === 0) {
            comportamentoStat = "Ancora Nulla";
        }

        if(data.emozioni.stat.length === 0){
            emozioniStat = "Ancora Nulla";
        }

        if(data.emozioni.average.length === 0){
            emozioniAvg = "Ancora Nulla";
        }

        $("#stat_patient").html(
            "<h4>Statistiche Diario</h4>" +
            diarioStat + '<hr>'+
            "<h4>Statistiche Comportamento</h4>" +
            comportamentoStat + '<hr>'+
            "<h4>Statistiche Emozioni</h4>" +
            emozioniStat + '<hr>'+
            "<h4>Media delle Emozioni</h4>" +
            emozioniAvg + '<hr>'
        );

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
}

function richiediConsulto(){
    $.post('/api/consulto/create', {
        email: $("#consultoMail").val(),
        paz_id: $("#paz_id").text()
    }, function(resp){
        if(resp.status === 'error'){
            Swal.fire('Whoops!', resp.message, 'error');
            loadConsult();
        } else {
            Swal.fire('Successo!', resp.message, 'success');
            loadConsult();
        }
    });
}

function loadConsult() {
    $("#currentConsult").html("Caricamento in corso...");
    $.get('/api/consulto/list/' + $("#paz_id").text(), function(data){
        $("#currentConsult").html("");
        $.each(data, function(i,v){
            $("#currentConsult").append('<li>Dest: ' + v['destinatario'] + ' | <a class="btn btn-sm btn-primary" onclick="clipboardMe(this);" value="'+v['full_link']+'">COPIA LINK</a> | <a class="btn btn-sm btn-primary" onclick="clipboardMe(this);" value="'+v['pin_code']+'">COPIA CODICE PIN</a></li>');
        });
    });
}


function clipboardMe(el){
    var copyText = $(el).attr('value');

    document.addEventListener('copy', function(e) {
        e.clipboardData.setData('text/plain', copyText);
        e.preventDefault();
    }, true);

    document.execCommand('copy');
    alert('Copiato con successo, fai tasto destro mouse -> incolla oppure ctrl+v');
}