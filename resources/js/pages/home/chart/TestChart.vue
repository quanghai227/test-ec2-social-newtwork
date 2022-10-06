<template>
    <div class="col-md-6">
        <h5>Line chart</h5>
        <hr>
        <line-chart></line-chart>
        <h5>Area chart</h5>
        <hr>
        <AreaChart />
        <h5>Bar chart</h5>
        <hr>
        <BarChart />
        <h5>Pie chart</h5>
        <hr>
        <PieChart />
        <h5>Radar chart</h5>
        <hr>
        <RadarChart />
    </div>
</template>

<script>
import LineChart from './LineChart.vue';
import AreaChart from './AreaChart.vue';
import BarChart from './BarChart.vue';
import PieChart from './PieChart.vue';
import RadarChart from './RadarChart.vue';

export default {
    name: "App",
    components: {
        LineChart,
        AreaChart,
        BarChart,
        PieChart,
        RadarChart,
    }

}
</script>
