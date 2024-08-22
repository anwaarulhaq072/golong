(Apex.grid = {
  padding: {
    right: 0,
    left: 0,
  },
}),
  (Apex.dataLabels = {
    enabled: !1,
  });

// colors = ["#f672a7"];
let base_url = $("#base_url").val();
let userId = $("#forChartUserId").val();
console.log(userId);

var allData = [];
let getcalling = $.get(
  base_url + "/admin/adminchartDetails?userid=" + userId,
  {}
);

getcalling.done(function (result) {
  let response = JSON.parse(result);
  // console.log(response);
  // console.log(response['amount'])

  // let options = {
  //     chart: {
  //         height: 450,
  //         type: "line",
  //         background: "transparent", // Make the chart background transparent
  //         shadow: {
  //             enabled: false,
  //             color: "#bbb",
  //             top: 3,
  //             left: 2,
  //             blur: 3,
  //             opacity: 1
  //         }
  //     },
  //     stroke: {
  //         width: 4,
  //         curve: "smooth"
  //     },
  //     series: [{
  //         name: "Profit/Loss",
  //         data: response.amounts
  //     }],
  //     xaxis: {
  //         type: "datetime",
  //         categories: response.dates,
  //         title: {
  //             text: "Date",
  //             style: {
  //                 fontSize: "18px"
  //             }
  //         }
  //     },

  //     title: {
  //         text: "Transaction Chart",
  //         align: "left",
  //         style: {
  //             fontSize: "14px",
  //             color: "#666"
  //         }
  //     },
  //     colors: ["#1ABC9C"],
  //     fill: {
  //         type: "gradient",
  //         gradient: {
  //         shadeIntensity: 1,
  //         opacityFrom: 0.3,
  //         opacityTo: 0.5,
  //         stops: [0, 90, 100],
  //         },
  //     },
  //      markers: {
  //             size: 5,
  //             colors: ["#1ABC9C"],
  //             strokeColors: "#fff",
  //             strokeWidth: 2,
  //             hover: {
  //               size: 7,
  //             },
  //           },
  //     yaxis: {
  //         min: response.maxLoss,
  //         max: response.maxProfit,
  //         title: {
  //             text: "Amount (Profit/Loss)",
  //             style: {
  //                 fontSize: "16px"
  //             }
  //         }
  //     },
  //     legend: {
  //             position: "top",
  //             horizontalAlign: "left",
  //             labels: {
  //               colors: ["#1ABC9C"],
  //             },
  //             markers: {
  //               width: 12,
  //               height: 12,
  //               radius: 12,
  //               offsetX: -4,
  //             },
  //           },
  //     grid: {
  //         show: false, // Completely hides the grid lines
  //       },
  //     responsive: [{
  //         breakpoint: 600,
  //         options: {
  //             chart: {
  //                 toolbar: {
  //                     show: !1
  //                 }
  //             },
  //             legend: {
  //                 show: !1
  //             }
  //         }
  //     }]

  // };
  var options = {
    series: [
      {
        name: "Profit",
        data: response.amounts,
      },
    ],
    chart: {
      type: "area",
      height: 350,
      toolbar: {
        show: false,
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: "smooth",
    },
    xaxis: {
      type: "datetime",
      categories: response.dates,
      title: {
        text: "Date",
        // style: {
        //     fontSize: "16px"
        //     font-family:  sans-serif
        // }
      },
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return value.toFixed(1);
        },
      },
    },
    tooltip: {
      shared: true,
      intersect: false,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        const profit = series[0][dataPointIndex];
        const date = w.globals.labels[dataPointIndex];

        return `<div style="padding: 5px;" class="pr-loss-abs">
            <div class="pr-loss-abs__header">9 sep</div>
            <div class="pr-loss-abs__body">
              <div class="pr-loss-abs__row">
                <div class="dot pdot"></div>
                Profit/Loss: <span style="color: #1ABC9C">$${profit.toFixed(
                  2
                )}</span>
                </div>
            </div>
          </div>`;
      },
    },
    colors: ["#1ABC9C"],
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.3,
        opacityTo: 0.5,
        stops: [0, 90, 100],
      },
    },
    markers: {
      size: 5,
      colors: ["#1ABC9C"],
      strokeColors: "#fff",
      strokeWidth: 2,
      hover: {
        size: 7,
      },
    },
    grid: {
      show: false, // Completely hides the grid lines
    },
    legend: {
      position: "top",
      horizontalAlign: "left",
      labels: {
        colors: ["#1ABC9C"],
      },
      markers: {
        width: 12,
        height: 12,
        radius: 12,
        offsetX: -4,
      },
    },
  };
  (chart = new ApexCharts(
    document.querySelector("#apex-line-2"),
    options
  )).render();
});

let getcallingtransaction = $.get(
  base_url + "/admin/adminTransactionChart?userid=" + userId,
  {}
);

getcallingtransaction.done(function (result) {
  let response = JSON.parse(result);
  colors = ["#1ABC9C", "#BC1D1E"];
  let options = {
    chart: {
      height: 350,
      type: "radialBar",
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
      offsetY: 7,
    },
    plotOptions: {
      radialBar: {
        dataLabels: {
          name: {
            fontSize: "22px",
          },
          value: {
            fontSize: "16px",
          },
          total: {
            show: !0,
            label: "Total",
            formatter: function (e) {
              return "100%";
            },
          },
        },
      },
    },
    labels: ["Profit", "Loss"],
    colors: colors,
    fill: {
      type: "gradient",
    },
  };
  const ctx1 = document.getElementById("progressChart1").getContext("2d");
  // const value1 = 20; // Value for the progress chart
  const progressChart1 = new Chart(ctx1, {
    type: "doughnut",
    data: {
      datasets: [
        {
          data: [value1, 100 - value1],
          backgroundColor: ["#0073B6", "#59595933"],
          borderWidth: 0, // Remove the white border
          borderRadius: 10, // Round the corners
        },
      ],
    },
    options: {
      cutout: "90%",
      rotation: 140,
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  
  document.getElementById("chartValue1").textContent = value1;
  //
  const ctx2 = document.getElementById("progressChart2").getContext("2d");
  // const value2 = 76.6; // Value for the progress chart
  const progressChart2 = new Chart(ctx2, {
    type: "doughnut",
    data: {
      datasets: [
        {
          data: [value2, 100 - value2],
          backgroundColor: ["#1ABC9C", "#59595933"],
          borderWidth: 0, // Remove the white border
          borderRadius: 10, // Round the corners
        },
      ],
    },
    options: {
      cutout: "90%",
      rotation: 140,
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  // console.log(profitable);
  
  // Update the text value inside the chart
  document.getElementById("chartValue2").textContent = value2 + "%";
  const ctx3 = document.getElementById("progressChart3").getContext("2d");
  //  const value3 = 30; // Value for the progress chart
  const progressChart3 = new Chart(ctx3, {
    type: "doughnut",
    data: {
      datasets: [
        {
          data: [value3, 100 - value3],
          backgroundColor: ["#BC1D1E", "#59595933"],
          borderWidth: 0, // Remove the white border
          borderRadius: 10, // Round the corners
        },
      ],
    },
    options: {
      cutout: "90%",
      rotation: 220,
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          enabled: false,
        },
      },
    },
  });
  
  // Update the text value inside the chart
  document.getElementById("chartValue3").textContent = value3 + "%";
  // (chart = new ApexCharts(document.querySelector("#apex-pie-2"), options)).render();
});
