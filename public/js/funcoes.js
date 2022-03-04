$(function() {
    var today_x = new Date();
    var first_day_x = new Date(today_x.getFullYear(), today_x.getMonth(), 1);
    var month_x = new Date(today_x.getFullYear(), today_x.getMonth());
    const csrf_token = $('meta[name="csrf-token"]').attr('content');
    const token = $('meta[name="token"]').attr('content');

    var first_day = first_day_x.toISOString().split('T')[0];
    var today = today_x.toISOString().split('T')[0];
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
        maxDate: today_x,
        i18n: {
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            weekdays: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            weekdaysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            weekdaysAbbrev: ["D", "S", "T", "Q", "Q", "S", "S"]
        }
    });
    $('.month-date').datepicker({
        defaultDate: first_day_x,
        setDefaultDate: true,
        autoClose: true,
        format: 'mm/yyyy',
        maxDate: today_x,
        i18n: {
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            weekdays: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            weekdaysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            weekdaysAbbrev: ["D", "S", "T", "Q", "Q", "S", "S"]
        }
    });
    $('.initial-date').datepicker({
        defaultDate: first_day_x,
        setDefaultDate: true,
        autoClose: true,
        format: 'dd/mm/yyyy',
        maxDate: today_x,
        i18n: {
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            weekdays: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            weekdaysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            weekdaysAbbrev: ["D", "S", "T", "Q", "Q", "S", "S"]
        }
    });
    $('.final-date').datepicker({
        defaultDate: today_x,
        setDefaultDate: true,
        autoClose: true,
        format: 'dd/mm/yyyy',
        maxDate: today_x,
        i18n: {
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            weekdays: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            weekdaysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            weekdaysAbbrev: ["D", "S", "T", "Q", "Q", "S", "S"]
        }
    });
});