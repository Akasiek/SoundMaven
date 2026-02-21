<script setup lang="ts">
import { Line } from "vue-chartjs";
import { CategoryScale, Chart as ChartJS, Legend, LinearScale, LineElement, PointElement, Title, Tooltip } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, LineElement, PointElement);

const { ratingsForDistributionChart } = defineProps<{ ratingsForDistributionChart: { rating: number, count: number }[] }>();

const data = Array(11).fill(0);
ratingsForDistributionChart.forEach(({ rating, count }) => {
  if (rating >= 0 && rating <= 100) data[Math.floor(rating / 10)] += count;
});

const chartData = {
  labels: Array.from({ length: 11 }, (_, i) => i * 10),
  datasets: [{ data, fill: false, borderColor: '#4FFEA4', tension: 0.2 }]
};

const chartOptions = {
  responsive: true,
  plugins: { legend: { display: false } },
  scales: {
    x: {
      title: { display: true, text: 'Rating', color: '#FAFAFA', font: { size: 14, weight: 'bold' } },
      ticks: { color: '#FAFAFA', font: { size: 12 } },
      grid: { color: '#333333' }
    },
    y: {
      min: 0,
      title: { display: true, text: 'Count', color: '#FAFAFA', font: { size: 14, weight: 'bold' } },
      ticks: { color: '#FAFAFA', font: { size: 12 }, stepSize: 1 },
      grid: { color: '#333333' }
    }
  }
};
</script>

<template>
  <div class="bg-zinc-800 rounded-md p-4">
    <h3 class="text-center mb-4">Rating distribution</h3>
    <Line id="user-rating-distribution-chart" :options="chartOptions" :data="chartData"/>
  </div>
</template>
