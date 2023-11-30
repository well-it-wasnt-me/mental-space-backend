$(document).ready(function(){
    $('.js-data-example-ajax').select2({
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
        placeholder:"Scrivi nome farmaco o principio attivo"
    });

    $('#dsm_id').select2({
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
        placeholder:"Scrivi nome diagnosi"
    });
});