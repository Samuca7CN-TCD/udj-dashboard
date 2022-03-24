function loadDayAreaGraph(horas, valores) {
    area_chart_days = $("#areaChartDays");
    areaChartDays = new Chart(area_chart_days, {
        type: 'line',
        data: {
            labels: horas,
            datasets: [{
                label: false,
                data: valores,
                fill: {
                    target: 'origin',
                    above: 'rgb(112, 190, 116)',
                    below: 'rgb(112, 190, 116)'
                },
                borderColor: 'rgb(112, 190, 116)',
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