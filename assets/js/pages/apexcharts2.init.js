(Apex.grid = {
  padding: {
    right: 0,
    left: 0,
  },
}),
  (Apex.dataLabels = {
    enabled: !1,
  });

colors = ["#f672a7"];
let base_url = $("#base_url").val();
var allData = [];
let getcalling = $.get(base_url + "/user/chartDetails", {});

getcalling.done(function (result) {
  let response = JSON.parse(result);
  // console.log(response);
  // console.log(response['amount'])

  // let options = {
  //   series: [
  //     {
  //       name: "Profit/Loss",
  //       data: response.amounts,
  //     },
  //   ],
  //     chart: {
  //         height: 450,
  //         type: "line",
  //         shadow: {
  //             enabled: !1,
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
  //     fill: {
  //         type: "gradient",
  //         gradient: {
  //             shade: "dark",
  //             gradientToColors: colors,
  //             shadeIntensity: 1,
  //             type: "horizontal",
  //             opacityFrom: 1,
  //             opacityTo: 1,
  //             stops: [0, 100, 100, 100]
  //         }
  //     },
  //     markers: {
  //         size: 4,
  //         opacity: .9,
  //         colors: ["#56c2d6"],
  //         strokeColor: "#fff",
  //         strokeWidth: 2,
  //         style: "inverted",
  //         hover: {
  //             size: 7
  //         }
  //     },
  //     yaxis: {
  //         min: response.maxLoss,
  //         max: response.maxProfit,
  //         title: {
  //             text: "Amount (Profit / Loss)",
  //             style: {
  //                 fontSize: "16px"
  //             }
  //         }
  //     },
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
  // (chart = new ApexCharts(document.querySelector("#apex-line-2"), options)).render();
  var options = {
    series: [
      {
        name: "Profit/Loss",
        data: response.amounts,
      },
    ],
    chart: {
      height: 450,
      type: "area",
      shadow: {
        enabled: !1,
        color: "#bbb",
        top: 3,
        left: 2,
        blur: 3,
        opacity: 1,
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: "smooth",
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return value.toFixed(1);
        },
      },
    },
    tooltip: {
      enabled: true,
      shared: true,
      intersect: false,
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        const profit = series[0][dataPointIndex];
        var date = response.dates[dataPointIndex].split(' ');
        date = date[0] + ' ' + date[1] + ' ' + date[2];
        
        return `<div style="padding: 5px;" class="pr-loss-abs">
            <div class="pr-loss-abs__header">${date}</div>
            <div class="pr-loss-abs__body">
              <div class="pr-loss-abs__row">
                <div class="dot pdot"></div>
                Profit/Loss: <span style="color: #0073B6">$${profit.toFixed(2)}</span>
                </div>
            </div>
          </div>`;
      },
    },
    xaxis: {
      type: "datetime",
      categories: response.dates,
      crosshairs: {
        show: false,  // Hides the leader line
      },
    },
    colors: ["#0073B6", "#1E1E2000"],
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 0,
        opacityFrom: 0.8,
        opacityTo: 0,
        stops: [0, 100],
      },
    },
    markers: {
      hover: {
        size: 7,
        show: true,
      },
    },
    grid: {
      show: false,
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

  var chart = new ApexCharts(document.querySelector("#apex-line-2"), options);
  chart.render();
});

let getcallingtransaction = $.get(base_url + "/user/transactionChart", {});

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
  // (chart = new ApexCharts(document.querySelector("#apex-pie-2"), options)).render();
});

let getcallingtransaction_new = $.get(
  base_url + "/admin/adminTransactionChart",
  {}
);

getcallingtransaction_new.done(function (result) {
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
