/*=========================================================================================
    File Name: form-wizard.js
    Description: Add AWP Page
    ----------------------------------------------------------------------------------------

==========================================================================================*/

$(function () {
    'use strict';

    var bsStepper = document.querySelectorAll('.bs-stepper'),
    select = $('.select2'),
    horizontalWizard = document.querySelector('.horizontal-wizard-example'),
    verticalWizard = document.querySelector('.vertical-wizard-example'),
    modernWizard = document.querySelector('.modern-wizard-example'),
    modernVerticalWizard = document.querySelector('.modern-vertical-wizard-example');

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
    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            placeholder: 'Select value',
            dropdownParent: $this.parent()
        });
    });

  // Horizontal Wizard
  // --------------------------------------------------------------------
    if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
        var numberedStepper = new Stepper(horizontalWizard),
        $form = $(horizontalWizard).find('form');
        /* $form.each(function () {
            var $this = $(this);
           $this.validate({
                rules: {
                    mac_address: {
                        required: true
                    },
                    awp_name: {
                        required: true
                    },
                    counter_in: {
                        required: true
                    },
                    counter_out: {
                        required: true
                    },
                    vendor: {
                        required: true
                    }
                }
            });
        });*/

        $(horizontalWizard)
        .find('.btn-next')
        .each(function () {
            $(this).on('click', function (e) {

                    numberedStepper.next();

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
            var isValid = true; //$(this).parent().siblings('form').valid();
            if (isValid) {
                Swal.fire({
                    title: 'Sei sicuro ?',
                    text: "Stai per aggiungere un nuovo Paziente, sei sicuro ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, sono sicuro !',
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var frm_data = $("form").serialize();
                        var myEditor = document.querySelector('#editor')
                        var html = myEditor.children[0].innerHTML;
                        let checkbox = $("#inlineCheckbox1").is(":checked");
                        let invito="";

                        if(checkbox){
                            invito = "checked";
                        } else {
                            invito = "NOT-checked";
                        }
                        $.ajax({
                            url: "/api/patients/add",
                            data: frm_data + "&relazione=" + html + "&invito="+invito,
                            type: "POST",
                            success: function (rsp) {
                                $('form').trigger("reset");
                                Swal.fire(
                                    'Aggiunto!',
                                    rsp.message,
                                    'success'
                                )
                            },
                            error: function (e) {
                                Swal.fire('Whoops!', 'Something went wrong, try again later', 'error');
                            }
                            });
                    }
                })
            }
        });
    }
});


$(document).ready(function () {
    $.get('/api/dsm/list',function (rsp) {
        $.each(rsp, function (i, item) {
            $('#dsm_id').append($("<option></option>")
                .attr("value", item.id)
                .text(item.descrizione));
        });
    });
});


var entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;',
    '/': '&#x2F;',
    '`': '&#x60;',
    '=': '&#x3D;'
};

var address_input = document.getElementById('address');
var address_autocomplete = new google.maps.places.Autocomplete(address_input);

address_autocomplete.addListener('place_changed', function(){
    var event_address=address_autocomplete.getPlace();
})