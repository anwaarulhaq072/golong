Apex.grid = {
    padding: {
        right: 0,
        left: 0
    }
}, Apex.dataLabels = {
    enabled: !1
};

colors = ["#f672a7"];
let base_url = $('#base_url').val();
var allData = [];
let getcalling = $.get(base_url + "/user/chartDetails_Overview", {});
console.log("Check") ;

getcalling.done(function (result) {
    let response = JSON.parse(result);
    // console.log("Check") ;
    // console.log(response);
    // console.log(response['amount'])


    let options = {
        chart: {
            height: 450,
            type: "line",
            shadow: {
                enabled: !1,
                color: "#bbb",
                top: 3,
                left: 2,
                blur: 3,
                opacity: 1
            }
        },
        stroke: {
            width: 4,
            curve: "smooth"
        },
        series: [{
            name: "Profit/Loss",
            data: response.amounts,
        }],
        xaxis: {
            type: "datetime",
            categories: response.dates,
            title: {
                text: "Date",
                style: {
                    fontSize: "18px"
                }
            }
        },
        title: {
            text: "Transaction Chart",
            align: "left",
            style: {
                fontSize: "14px",
                color: "#666"
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "dark",
                gradientToColors: colors,
                shadeIntensity: 1,
                type: "horizontal",
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            }
        },
        markers: {
            size: 4,
            opacity: .9,
            colors: ["#56c2d6"],
            strokeColor: "#fff",
            strokeWidth: 2,
            style: "inverted",
            hover: {
                size: 7
            }
        },
        yaxis: {
            min: response.maxLoss,
            max: response.maxProfit,
            title: {
                text: "Amount (Profit/Loss)",
                style: {
                    fontSize: "16px"
                }
            }
        },
        grid: {
            row: {
                colors: ["transparent", "transparent"],
                opacity: .2
            },
            borderColor: "#185a9d"
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    toolbar: {
                        show: !1
                    }
                },
                legend: {
                    show: !1
                }
            }
        }]

    };
    (chart = new ApexCharts(document.querySelector("#apex-line-2"), options)).render();

});

let getcallingtransaction = $.get(base_url + "/user/transactionChart_Overview", {});

getcallingtransaction.done(function (result) {
    let response = JSON.parse(result);
    colors = ["#1ABC9C", "#BC1D1E"];
    let options = {
        chart: {
            height: 350,
            type: "radialBar"
        },
        series: response.profitLoss,
        legend: {
            show: !0,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "16px",
            offsetX: 0,
            offsetY: 7
        },
        plotOptions: {
            radialBar: {
                dataLabels: {
                    name: {
                        fontSize: "22px"
                    },
                    value: {
                        fontSize: "16px"
                    },
                    total: {
                        show: !0,
                        label: "Total",
                        formatter: function (e) {
                            return '100%'
                        }
                    }
                }
            }
        },
        labels: ["Profit", "Loss"],
        colors: colors,
        fill: {
            type: "gradient"
        }
    };
    // (chart = new ApexCharts(document.querySelector("#apex-pie-2"), options)).render();
});