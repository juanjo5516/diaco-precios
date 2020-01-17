<template>
    <div>
        <div ref="leyends"></div>
        <div>
            <canvas ref="grafica"></canvas>
        </div>
    </div>
        <!-- <div>
        <ul>
            <li v-for="(index,x) in data_chart" :key="x">{{ index.name }}</li>
        </ul>

        </div> -->
</template>

<style scoped>
    .cuadro{
        width: 13px;
        height: 13px;
        border-radius: 0.1em;
        border: 1px solid gray;
    }
</style>>

</style>

<script>
import Chart from "chart.js";
export default {
    data() {
        return {
            data_chart: [],
            names: [],
            tableChart: []
        };
    },
    mounted() {
        this.getDataChart();
    },
    methods: {
        showInfo(data) {
            let index = data[0]["_index"];
            let name = data[0]["_model"]["label"];
            console.log(name);
            // console.log(data)
            console.log(
                data[0]["_chart"]["data"]["datasets"][0]["data"][index]
            );
        },

        chartDataShow(tipe, request) {
            const ctx = this.$refs.grafica;
            const legends = this.$refs.leyends
            
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
                    onClick: (e, legendItem) => {
                        var index = legendItem.index;
                        var chart = this.chart;
                        var i, ilen, meta;
                        this.showInfo(legendItem);
                    },

                    legend: {
                        display: false,
                        rtl: true,
                        labels: {
                            // fontColor: "rgb(255, 99, 132)"
                            boxWidth: 20,
                            fontSize: 14,
                            padding: 8,
                            usePointStyle: false

                            //fin
                        },
                        align: "center"
                    },
                    tooltips: {
                        mode: "label",

                        callbacks: {
                            // label: function(tooltipItem, data) {
                            //     console.log(data)
                            //     var label = data.datasets[tooltipItem.datasetIndex].label || '';
                            //     label = data.labels[tooltipItem[0]]

                            //     return label;

                            // },
                            labelColor: function(tooltipItem, chart) {
                                return {
                                    borderColor: "rgb(255, 0, 0)",
                                    backgroundColor: "rgb(255, 0, 0)"
                                };
                            },
                            labelTextColor: function(tooltipItem, chart) {
                                return "#fff";
                            }
                        },
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
                        display: false,
                        text: "Datos envias desde las sedes"
                    },
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul class="0-legend">');
                        var ds = chart.data.datasets[0];
                        console.log(ds)
                        var sum = ds.data.reduce(function add(a, b) {
                            return a + b;
                        }, 0);
                        for (var i = 0; i < ds.data.length; i++) {
                            text.push("<li>");
                            // var perc = Math.round((100 * ds.data[i]) / sum, 0);
                            text.push(
                                '<span class="cuadro" style="background-color:' +
                                    ds.backgroundColor[0] +
                                    '">1' +
                                    "</span>" +
                                    chart.data.labels[i] +
                                    " (" +
                                    ds.data[i] +
                                    ")"
                            );
                            text.push("</li>");
                        }
                        text.push("</ul>");
                        
                        return text.join("");
                    },

                    scales: {
                        xAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true
                                    // labelString: 'Month'
                                }
                            }
                        ],
                        yAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true
                                    // labelString: 'Value'
                                }
                            }
                        ]
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
            legends.innerHTML = myChart.generateLegend();
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
                    // console.log(this.data_chart)
                    this.chartDataShow("bar", this.data_chart);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
