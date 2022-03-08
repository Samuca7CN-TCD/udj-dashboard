$(function() {
    var today = new Date();
    const csrf_token = $('meta[name="csrf-token"]').attr('content');
    const token = $('meta[name="token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf_token,
            'Authorization': "Bearer " + token,
            'Accept': 'application/json'
        }
    });

    $('.tooltipped').tooltip();
    $('select').formSelect();
    $('.datepicker').datepicker({
        autoClose: true,
        format: 'dd/mm/yyyy',
        defaultDate: today,
        setDefaultDate: true,
        maxDate: today,
        i18n: {
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            weekdays: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            weekdaysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            weekdaysAbbrev: ["D", "S", "T", "Q", "Q", "S", "S"]
        }
    });
});