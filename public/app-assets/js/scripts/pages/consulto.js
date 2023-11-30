window.onload = () => {
    $('#modalConsulto').modal('show');
    var observer = new MutationSummary({
        queries: [
            { element: '#modalConsulto' } // jQuery-like selector
        ],
        callback: function(summaries) {
            $.post('/public/hack/attempt', {url: window.location.href}, function(res){
                alert("Identificato manipolazione umana del dom, corro ai ripari. Sei stato segnalato comunque...");
                window.location = 'https://www.google.com';
            }).catch(e => {
                alert("Identificato manipolazione umana del dom, corro ai ripari");
                window.location = 'https://www.google.com';
            });

        }
    });
}

function entra(){
    $.post('/public/pincode/check',{pin_code: $("#codice_sicurezza").val()}, function(resp){
        if(resp.status === 'success'){
            $("#modalConsulto").modal('hide');
        } else {
            console.log(resp);
            alert("Codice Errato");
        }
    });
}