import './bootstrap';
import Chart from 'chart.js/auto';

const blue = '#2563eb';
const emerald = '#10b981';
const slate = '#94a3b8';

function initStockIQCharts() {
    const dashboard = window.StockIQDashboard || {};
    const profitCanvas = document.getElementById('profitOverviewChart');

    if (profitCanvas) {
        new Chart(profitCanvas, {
            type: 'line',
            data: {
                labels: dashboard.labels || [],
                datasets: [
                    {
                        label: 'Profit',
                        data: dashboard.profit || [],
                        borderColor: blue,
                        backgroundColor: 'rgba(37, 99, 235, 0.10)',
                        fill: true,
                        tension: 0.42,
                        pointRadius: 3,
                        pointBackgroundColor: blue,
                    },
                    {
                        label: 'Margin %',
                        data: dashboard.margin || [],
                        borderColor: emerald,
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        fill: false,
                        tension: 0.42,
                        pointRadius: 3,
                        pointBackgroundColor: emerald,
                        yAxisID: 'percent',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#071333',
                        padding: 12,
                        titleFont: { family: 'Inter', weight: '800' },
                        bodyFont: { family: 'Inter', weight: '700' },
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: slate, font: { family: 'Inter', weight: '700' } },
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.18)' },
                        ticks: {
                            color: slate,
                            callback: value => `${Number(value) / 1000}K`,
                            font: { family: 'Inter', weight: '700' },
                        },
                    },
                    percent: {
                        position: 'right',
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: {
                            color: slate,
                            callback: value => `${value}%`,
                            font: { family: 'Inter', weight: '700' },
                        },
                    },
                },
            },
        });
    }

    const categoryCanvas = document.getElementById('stockCategoryChart');

    if (categoryCanvas) {
        new Chart(categoryCanvas, {
            type: 'doughnut',
            data: {
                labels: dashboard.categoryLabels || [],
                datasets: [{
                    data: dashboard.categories || [],
                    backgroundColor: [blue, emerald, '#f97316', '#8b5cf6', '#cbd5e1'],
                    borderWidth: 0,
                    hoverOffset: 8,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#071333',
                        padding: 12,
                        bodyFont: { family: 'Inter', weight: '700' },
                    },
                },
            },
        });
    }
}

document.addEventListener('DOMContentLoaded', initStockIQCharts);
