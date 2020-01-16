<template>
    <div>
        <canvas ref="grafica"></canvas>
    </div>
</template>

<script>
import Chart from "chart.js";
export default {
    data() {
        return {
            data_chart: [],
            names: []
        };
    },
    mounted() {
        this.getDataChart();
    },
    methods: {
        chartDataShow(tipe, request) {
            const ctx = this.$refs.grafica;
            ctx.height = "500";
            ctx.width = "800";
            const myChart = new Chart(ctx, {
                type: tipe,
                data: {
                    labels: request.map(item => item.name),
                    datasets: [
                        {
                            label: "Datos",
                            data: request.map(item => item.cantidad),
                            backgroundColor: request.map(
                                item => item.backgroundColor
                            ),
                            borderColor: request.map(item => item.borderColor),
                            borderWidth: 1,
                            fill: false
                            // hoverBackgroundColor: request.map(item => item.backgroundColor)
                        }
                    ]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            fontColor: "rgb(255, 99, 132)"
                        }
                    },
                    tooltips: {
                        mode: "index",
                        intersect: false
                    },
                    // tooltips: {
                    //     mode: "label"
                    // },
                    // onClick: (evt, item) => {
                    //     // let index = item[0]["_index"];
                    //     let fruit = item[0]["_chart"].data.labels[index];
                    //     let votes = item[0]["_chart"].data.datasets[0].data[index];
                    //     console.log(votes);
                    // },
                    title: {
                        display: true,
                        text: "Datos envias desde las sedes"
                    },
                    // legendCallback: function(chart) {
                    //     return "<h1>asf</h1>";
                    // },
                    scales: {
                        xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                        // yAxes: [
                        //     {
                        //         // stacked: true
                        //         ticks: {
                        //             // beginAtZero: true
                        //             // callback: function(value, index, values) {
                        //             //     return "$" + value;
                        //             // }
                        //         }
                        //     }
                        // ]
                    },
                    // layout: {
                    //     padding: {
                    //         left: 50,
                    //         right: 0,
                    //         top: 0,
                    //         bottom: 0
                    //     }
                    // },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        },
        getDataChart() {
            axios
                .get("/getCountSubmit")
                .then(response => {
                    const r = () => Math.floor(256 * Math.random());
                    for (let index = 0; index < response.data.length; index++) {
                        this.data_chart.push({
                            code: response.data[index].code,
                            name: response.data[index].name,
                            cantidad: response.data[index].cantidad,
                            backgroundColor: `rgba(${r()}, ${r()}, ${r()},0.5)`,
                            borderColor: `rgba(${r()}, ${r()}, ${r()},1)`
                        });
                    }
                    this.chartDataShow("pie", this.data_chart);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
