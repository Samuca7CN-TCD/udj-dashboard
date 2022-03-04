function loadStatusGraph(labels, values) {
    pie_chart_all = $("#pieChartAll");
    pieChartAll = new Chart(pie_chart_all, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Quantidade de Status por Assinantes',
                data: values,
                backgroundColor: [
                    'rgb(112, 190, 116)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                    'rgb(0, 128, 128)',
                    'rgb(160, 82, 45)',
                    'rgb(139, 0, 139)',
                    'rgb(224, 255, 255)',
                    'rgb(205, 92, 92)'
                ],
                hoverOffset: 4,
            }],
        },
    });
}