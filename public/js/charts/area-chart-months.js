function loadMonthAreaGraph(dias, valores) {
    area_chart_months = $("#areaChartMonths");
    areaChartMonths = new Chart(area_chart_months, {
        type: 'line',
        data: {
            labels: dias,
            datasets: [{
                label: false,
                data: valores,
                fill: {
                    target: 'origin',
                    above: 'rgb(255, 196, 0)',
                    below: 'rgb(255, 196, 0)'
                },
                borderColor: 'rgb(255, 196, 0)',
                tension: 0.5
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    ticks: {
                        display: false,
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    ticks: {
                        display: false,
                    }
                }
            },
            radius: 0,
        }
    });
}