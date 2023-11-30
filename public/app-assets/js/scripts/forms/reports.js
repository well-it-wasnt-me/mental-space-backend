/*=========================================================================================
    File Name: form-wizard.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    'use strict';

    var bsStepper = document.querySelectorAll('.bs-stepper'),
        select = $('.select2'),
        horizontalWizard = document.querySelector('.horizontal-wizard-example') ;

    // Adds crossed class
    if (typeof bsStepper !== undefined && bsStepper !== null) {
        for (var el = 0; el < bsStepper.length; ++el) {
            bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                var index = event.detail.indexStep;
                var numberOfSteps = $(event.target).find('.step').length - 1;
                var line = $(event.target).find('.step');

                // The first for loop is for increasing the steps,
                // the second is for turning them off when going back
                // and the third with the if statement because the last line
                // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                for (var i = 0; i < index; i++) {
                    line[i].classList.add('crossed');

                    for (var j = index; j < numberOfSteps; j++) {
                        line[j].classList.remove('crossed');
                    }
                }
                if (event.detail.to == 0) {
                    for (var k = index; k < numberOfSteps; k++) {
                        line[k].classList.remove('crossed');
                    }
                    line[0].classList.remove('crossed');
                }
            });
        }
    }

    // select2
    $('#assistiti').select2({
        minimumInputLength: 3,
        ajax: {
            url: '/api/search/patient',
            dataType: 'json',
            type: 'post'
        },
        allowClear: true,
        language: {
            inputTooShort: function () {
                return "Scrivere almeno 3 caratteri";
            }
        },
        placeholder:"Scrivi Nome o Cognome"
    });

    let scelte = {
        tables: [],
        assistiti:[],
        raggr: []
    }

    $('#assistiti').on('select2:select', function(e){
        scelte.assistiti.push(e.params.data.id);
    });

    $('#assistiti').on('select2:unselect', function(e){
        scelte.assistiti = $.grep(scelte.assistiti, function(value){
            return value !== e.params.data.id;
        });
    });

    // Horizontal Wizard
    // --------------------------------------------------------------------
    if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
        var numberedStepper = new Stepper(horizontalWizard),
            $form = $(horizontalWizard).find('form');
        $form.each(function () {
            var $this = $(this);
            $this.validate({
                rules: {
                    username: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    'confirm-password': {
                        required: true,
                        equalTo: '#password'
                    },
                    'first-name': {
                        required: true
                    },
                    'last-name': {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    landmark: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    language: {
                        required: true
                    },
                    twitter: {
                        required: true,
                        url: true
                    },
                    facebook: {
                        required: true,
                        url: true
                    },
                    google: {
                        required: true,
                        url: true
                    },
                    linkedin: {
                        required: true,
                        url: true
                    }
                }
            });
        });

        $(horizontalWizard)
            .find('.btn-next')
            .each(function () {
                $(this).on('click', function (e) {
                    var isValid = $(this).parent().siblings('form').valid();
                    if (isValid) {
                        numberedStepper.next();
                    } else {
                        e.preventDefault();
                    }
                });
            });

        $(horizontalWizard)
            .find('.btn-prev')
            .on('click', function () {
                numberedStepper.previous();
            });

        $(horizontalWizard)
            .find('.btn-submit')
            .on('click', function () {
                if(scelte.tables.length === 0){
                    $("#report_result").html("<b>Perfavore, tornare al punto 2 e selezionare la base dati</b>");
                    return;
                }

               $.post('/api/reports/generate', {
                   tables: JSON.stringify(scelte.tables),
                   raggr: JSON.stringify(scelte.raggr),
                   assistiti: JSON.stringify(scelte.assistiti)
               }).done(function(data){
                    $("#report_result").html("<b>Report Generato:</b> " + data.file_name)
               }).catch(e => $("#report_result").html("Qualcosa è andato storto. riprova o contattaci"));



            });
    }


    let last_value = "";

    $('.tables-check-input').on("click", function(){
        last_value = this.value;
        if($(this).is(':checked')){
            scelte.tables.push(this.value);
        } else {
            scelte.tables = $.grep(scelte.tables, function(value){
                return value !== last_value;
            });
        }
    });

    $('.raggr-check-input').on("click", function(){
        last_value = this.value;
        if($(this).is(':checked')){
            scelte.raggr.push(this.value);
        } else {
            scelte.raggr = $.grep(scelte.raggr, function(value){
                return value !== last_value;
            });
        }
    });




});