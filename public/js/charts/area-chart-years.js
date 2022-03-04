function loadYearAreaGraph(meses, valores) {
    area_chart_years = $("#areaChartYears");
    areaChartYears = new Chart(area_chart_years, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: false,
                data: valores,
                fill: {
                    target: 'origin',
                    above: 'rgb(255, 64, 129)',
                    below: 'rgb(255, 64, 129)'
                },
                borderColor: 'rgb(255, 64, 129)',
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