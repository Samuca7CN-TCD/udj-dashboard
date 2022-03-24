function loadMonthLineGraph(valores, valores_passados, dias) {
    const line_chart_months = $("#lineChartMonths");
    const lineChartMonths = new Chart(line_chart_months, {
        data: {
            datasets: [{
                type: 'line',
                label: 'Mês Atual',
                data: valores,
                borderColor: 'rgb(255, 184, 28)',
            }, {
                type: 'line',
                label: 'Mês anterior',
                data: valores_passados,
                borderColor: 'rgb(206, 217, 229)',
            }],
            labels: dias,
        },
        options: {
            radius: 3,
        }
    });
}