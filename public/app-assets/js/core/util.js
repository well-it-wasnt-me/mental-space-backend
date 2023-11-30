/*
 * Mental Space Project - Creative Commons License
 */

function load_gaming_hall(el)
{
    $.get('/api/gaming_hall/list',function (rsp) {
        $.each(rsp, function (i, item) {
            $('#'+el).append($("<option></option>")
                .attr("value", item.gaming_hall_id)
                .text(item.pdv));
        });
    });
}

function retrieveMachine(el, pdv)
{
    $('#'+el).html($("<option></option>")
        .attr("value", 0)
        .text("-- SELECT AWP --"));
    $('#'+el).append($("<option></option>")
        .attr("value", 'TODOS')
        .text("TODOS"));
    $.post('/api/smartbox/list_by_pdv', { gaming_hall_id:pdv },function (rsp) {
        //console.log(rsp);
        $.each(rsp, function (i, item) {
            //console.log ( item.smartbox_id, item.nome_macchina);
            $('#'+el).append($("<option></option>")
                .attr("value", item.smartbox_id)
                .text(item.smartbox_id + " - " + item.nome_macchina));
        });
    });
}

function strip_comma(txt){
    if( txt != null ) {
        const search = ',';
        const replaceWith = '';
        const result = txt.replaceAll(search, replaceWith);
        return result;
    } else {
        return 'NOT SETTED';
    }
}