import Chart from 'chart.js/auto';

const dashboardData = window.adminDashboardData;

if (dashboardData) {
    const salesCanvas = document.getElementById('sales7DaysChart');

    if (salesCanvas) {
        new Chart(salesCanvas, {
            type: 'line',
            data: {
                labels: dashboardData.sales.map((item) => item.date),
                datasets: [{
                    label: 'Total Penjualan',
                    data: dashboardData.sales.map((item) => item.total),
                    borderWidth: 2,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true },
                },
            },
        });
    }

    const topMedicinesCanvas = document.getElementById('topMedicinesChart');

    if (topMedicinesCanvas) {
        new Chart(topMedicinesCanvas, {
            type: 'bar',
            data: {
                labels: dashboardData.topMedicines.map(
                    (item) => `${item.nama} (${item.kategori})`,
                ),
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: dashboardData.topMedicines.map((item) => item.total_terjual),
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(255, 99, 132, 0.4)',
                    ],
                    borderColor: [
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 159, 64)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 99, 132)',
                    ],
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                    },
                },
            },
        });
    }
}
