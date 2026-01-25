import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    // pastikan halaman ini punya chart
    const canvas = document.getElementById("omzetChart");
    if (!canvas) return;

    // pastikan data tersedia
    if (!window.reportChartData) {
        console.warn("reportChartData not found");
        return;
    }

    const labels = window.reportChartData.map((item) => item.label);
    const values = window.reportChartData.map((item) => item.total);

    new Chart(canvas, {
        type: "line",
        data: {
            labels,
            datasets: [
                {
                    label: "Omzet",
                    data: values,
                    borderWidth: 2,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: {
                        callback: (value) =>
                            "Rp " + value.toLocaleString("id-ID"),
                    },
                },
            },
        },
    });
});

document.addEventListener("DOMContentLoaded", () => {
    if (!window.topObatRawData) return;

    const ctx = document.getElementById("topObatChart");
    if (!ctx) return;

    // TRANSFORM DATA DI JS
    const labels = window.topObatRawData.map((item) => item.nama);
    const values = window.topObatRawData.map((item) => item.total_terjual);

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Unit Terjual",
                    data: values,
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                    },
                },
            },
        },
    });
});
