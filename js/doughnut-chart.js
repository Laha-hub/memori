examChart();

function examChart() {
    const $chart = document.querySelector("#chart");

    if(!$chart) {
        return;
    }

    const ctx = $chart.getContext("2d");

    const corrects = $chart.dataset.corrects;
    const incorrects = $chart.dataset.incorrects;

    let data;

    if(corrects == 0 && incorrects == 0) {
        data = {
            labels: ["テスト未回答です。"],
            datasets: [{
                data: [1],
                backgroundColor: ["#9ca3af"],
            }],
        }
    } else {
        data = {
            labels: ["正解", "不正解"],
            datasets: [{
                data: [corrects, incorrects],
                backgroundColor: ["#D7E6FD", "#FFD9D7"],
            }],
        }
    }

    new Chart(ctx, {
        type: "doughnut",
        data: data,
        options: {
            responsive: true,
            legend: {
                display: false,
                position: 'bottom',
                labels: {
                    fontSize: 14
                }
            }
        },
    });
}
