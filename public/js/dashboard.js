var area_chart_days;
var areaChartDays;
var area_chart_months;
var areaChartMonths;
var area_chart_years;
var areaChartYears;
var pie_chart_all;
var pieChartAll;
var doughnut_chart_all;
var doughnutChartAll;

function loadingState(id_period) {
    $("#percentual-" + id_period).parent().find(".preloader-wrapper").removeClass("d-none");
    $("#percentual-" + id_period).removeClass('grey-text text-lighten-1');
    $("#percentual-" + id_period).removeClass('green-text');
    $("#percentual-" + id_period).removeClass('red-text');
    $("#percentual-" + id_period).html("");
}

function setPercentualConfig(percentual) {
    let config = new Object({
        color: 'grey-text text-lighten-1',
        arrow: '',
        percentual: 0.0
    });
    if (percentual > 0) {
        config.percentual = percentual;
        config.color = 'green-text';
        config.arrow = 'keyboard_arrow_up';
    } else if (percentual < 0) {
        config.percentual = percentual * (-1);
        config.color = 'red-text';
        config.arrow = 'keyboard_arrow_down';
    }
    return config;
}

function verifyLoneness(periodo, valor) {
    const data = new Object();
    if (periodo.length == 1) {
        periodo.push(("00" + (parseInt(periodo[0]) + 1)).slice(-2));
        valor.push(valor[0]);
    }
    data.periodos = periodo;
    data.valores = valor;
    return data;
}

function loadDayData(date) {
    loadingState('dia');
    const plano = $("#day-area-card #form-day-plain input[name='plano-dia']:checked").val();
    const url = 'api/' + 'day-data/' + plano + '/' + date;
    $.getJSON(url, function(data) {
        const per_config = setPercentualConfig(data.percentual);
        $("#total-dia").html(data.total_hoje.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $("#percentual-dia").html(
            "<i class='material-icons tiny'>" + per_config.arrow + "</i> " + per_config.percentual.toFixed(1) + "%"
        );
        $("#percentual-dia").addClass(per_config.color);
        $("#percentual-dia").attr('data-tooltip', 'Ontem: ' + data.total_ontem.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $("#percentual-dia").parent().find(".preloader-wrapper").addClass("d-none");
        let vars = verifyLoneness(data.data_hoje['periods'], data.data_hoje['values']);
        loadDayAreaGraph(vars.periodos, vars.valores);
    });
}

function loadMonthData(date) {
    loadingState('mes');
    const plano = $("#month-area-card #form-month-plain input[name='plano-mes']:checked").val();
    const url = 'api/' + 'month-data/' + plano + '/' + date;
    $.getJSON(url, function(data) {
        const per_config = setPercentualConfig(data.percentual);
        $("#total-mes").html(data.total_este_mes.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $("#percentual-mes").html(
            "<i class='material-icons tiny'>" + per_config.arrow + "</i> " + per_config.percentual.toFixed(1) + "%"
        );
        $("#percentual-mes").addClass(per_config.color);
        $("#percentual-mes").attr('data-tooltip', 'Mês passado: ' + data.total_mes_passado.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $("#percentual-mes").parent().find(".preloader-wrapper").addClass("d-none");
        let vars = verifyLoneness(data.data_este_mes['periods'], data.data_este_mes['values']);
        loadMonthAreaGraph(vars.periodos, vars.valores);
    });
}

function loadYearData(date) {
    loadingState('ano');
    const plano = $("#year-area-card #form-year-plain input[name='plano-ano']:checked").val();
    const url = 'api/' + 'year-data/' + plano + '/' + date;
    $.getJSON(url, function(data) {
        const per_config = setPercentualConfig(data.percentual);
        $("#total-ano").html(data.total_este_ano.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $("#percentual-ano").html(
            "<i class='material-icons tiny'>" + per_config.arrow + "</i> " + per_config.percentual.toFixed(1) + "%"
        );
        $("#percentual-ano").addClass(per_config.color);
        $("#percentual-ano").attr('data-tooltip', 'Ano passado: ' + data.total_ano_passado.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $("#percentual-ano").parent().find(".preloader-wrapper").addClass("d-none");
        let vars = verifyLoneness(data.data_este_ano['periods'], data.data_este_ano['values']);
        loadYearAreaGraph(vars.periodos, vars.valores);
    });
}

function loadMonthDataVS(date) {
    $.getJSON('api/month-data/todos/' + date + '/2', function(data) {
        const days = data.data_este_mes['periods'].length > data.data_mes_passado['periods'].length ? data.data_este_mes['periods'] : data.data_mes_passado['periods'];
        loadMonthLineGraph(data.data_este_mes['values'], data.data_mes_passado['values'], days);
        $("#vs-meses").find(".preloader").addClass('d-none');
    });
}

function loadMonthlyRecurring(date) {
    $.getJSON('api/monthly-recurring/' + date, function(data) {
        $("#recorrente-mensal").html("Recorrente mensal (" + date.substr(0, 4) + "): " + data.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
    });
}

function loadChurn(date_m) {
    const url = 'api/churn/' + date_m;
    $.getJSON(url, function(data) {
        $("#churn-value").html(
            data.toFixed(1) + '%'
        );
    });
}

function loadLtv(date_i, date_f) {
    const plano = $("#form-ltv-plain input[name='ltv-plain']:checked").val();
    const url = 'api/' + 'ltv/' + plano + '/' + date_i + '/' + date_f;
    $.getJSON(url, function(data) {
        $("#ltv-value").html(
            data.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })
        );
    });
}

function loadTta(date_i, date_f) {
    const plano = $("#form-tta-plain input[name='tta-plain']:checked").val();
    const url = 'api/' + 'trial-to-active/' + plano + '/' + date_i + '/' + date_f;
    $.getJSON(url, function(data) {
        $("#tta-value").html(
            data.tta + " pessoas"
        );
        $("#tta-perspective").html(
            "de " + data.act + " pessoas"
        );
    });
}

function cardHeightConfig() {
    let height = 0;
    $('.same-height').each(function() {
        if ($(this).height() > height) {
            height = $(this).height();
        }
    });
    $('.same-height').height(height);
}

function loadDataStatus(date_i, date_f) {
    const plano = $("#form-status-plain input[name='status-plain']:checked").val();
    const url = 'api/' + 'data-status/' + plano + '/' + date_i + '/' + date_f;
    $.getJSON(url, function(data) {
        let soma = 0;
        for (let i = 0; i < data['values'].length; i++) {
            soma += data['values'][i];
        }
        if (soma > 0) {
            $(".status-card").find(".no-data").addClass('d-none');
            $(".status-card").find(".status-chart").removeClass('d-none');
            loadStatusGraph(data['labels'], data['values']);
        } else {
            $(".status-card").find(".no-data").removeClass('d-none');
            $(".status-card").find(".status-chart").addClass('d-none');
        }
    });
}

function loadDataPaymentMethods(date_i, date_f) {
    const plano = $("#form-mpagamento-plain input[name='mpagamento-plain']:checked").val();
    const url = 'api/' + 'data-payment-methods/' + plano + '/' + date_i + '/' + date_f;
    $.getJSON(url, function(data) {
        if (data['values'].length > 0) {
            $(".mpagamento-card").find(".no-data").addClass('d-none');
            $(".mpagamento-card").find(".mpagamento-chart").removeClass('d-none');
            loadPaymentMethodsGraph(data['labels'], data['values']);
        } else {
            $(".mpagamento-card").find(".no-data").removeClass('d-none');
            $(".mpagamento-card").find(".mpagamento-chart").addClass('d-none');
        }
    });
}

$(function() {
    loadDayData(today);
    loadMonthData(today);
    loadYearData(today);
    loadMonthDataVS(today);

    loadChurn(today);
    loadLtv(first_day, today);
    loadTta(first_day, today);
    cardHeightConfig();

    loadMonthlyRecurring(today);
    loadDataStatus(first_day, today);
    loadDataPaymentMethods(first_day, today);

    $("#form-day-plain").on("change", function() {
        areaChartDays.destroy();
        loadDayData(today);
    });

    $("#form-month-plain").on("change", function() {
        areaChartMonths.destroy();
        loadMonthData(today);
    });

    $("#form-year-plain").on("change", function() {
        areaChartYears.destroy();
        loadYearData(today);
    });

    $("#form-churn-plain, .churn-datepicker").on("change", function() {
        let data_m = $("#churn-dataM").val();
        data_m = data_m.substr(3) + '-' + data_m.substr(0, 2) + '-28';
        loadChurn(data_m);
    });

    $("#form-ltv-plain, .ltv-datepicker").on("change", function() {
        let data_i = $("#ltv-dataI").val();
        let data_f = $("#ltv-dataF").val();
        data_i = data_i.substr(6) + '-' + data_i.substr(3, 2) + '-' + data_i.substr(0, 2);
        data_f = data_f.substr(6) + '-' + data_f.substr(3, 2) + '-' + data_f.substr(0, 2);
        loadLtv(data_i, data_f);
    });

    $("#form-tta-plain, .tta-datepicker").on("change", function() {
        let data_i = $("#tta-dataI").val();
        let data_f = $("#tta-dataF").val();
        console.log(data_i);
        console.log(data_f);
        data_i = data_i.substr(6) + '-' + data_i.substr(3, 2) + '-' + data_i.substr(0, 2);
        data_f = data_f.substr(6) + '-' + data_f.substr(3, 2) + '-' + data_f.substr(0, 2);
        loadTta(data_i, data_f);
    });

    $(window).on('resize', function() {
        $('.same-height').height('auto');
        cardHeightConfig();
    });

    $("#form-status-plain, .status-datepicker").on("change", function() {
        let data_i = $("#status-dataI").val();
        let data_f = $("#status-dataF").val();
        data_i = data_i.substr(6) + '-' + data_i.substr(3, 2) + '-' + data_i.substr(0, 2);
        data_f = data_f.substr(6) + '-' + data_f.substr(3, 2) + '-' + data_f.substr(0, 2);
        pieChartAll.destroy();
        loadDataStatus(data_i, data_f);
    });

    $("#form-mpagamento-plain, .mpagamento-datepicker").on("change", function() {
        let data_i = $("#mpagamento-dataI").val();
        let data_f = $("#mpagamento-dataF").val();
        data_i = data_i.substr(6) + '-' + data_i.substr(3, 2) + '-' + data_i.substr(0, 2);
        data_f = data_f.substr(6) + '-' + data_f.substr(3, 2) + '-' + data_f.substr(0, 2);
        doughnutChartAll.destroy();
        loadDataPaymentMethods(data_i, data_f);
    });
});