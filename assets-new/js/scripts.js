$(document).ready(function () {
  const tooltips = [
    { selector: "#dashboard", content: "Dashboard" },
    { selector: "#account", content: "Account" },
    { selector: "#notification", content: "Notification" },
    { selector: "#deposite", content: "Deposit" },
    { selector: "#withdrawal", content: "Withdrawal" },
    { selector: "#add-user", content: "Add User" },
    { selector: "#update-bulk-record", content: "Update Bulk Record" },
    { selector: "#light", content: "Light Mode" },
    { selector: "#dark", content: "Dark Mode" },
    { selector: "#logout", content: "Signout" },
    { selector: "#chat", content: "Chat" },
    { selector: "#archive-history", content: "Archive History" },
    { selector: "#statements", content: "Statements" },
    { selector: "#wifi", content: "Connection Stable" },
  ];
  tooltips.forEach(({ selector, content }) => {
    tippy(selector, {
      content,
      placement: "right",
      onCreate(instance) {
        if (selector === "#wifi") {
          const backgroundColor = "#0CB9BF";
          instance.popper.querySelector(".tippy-box").style.backgroundColor =
            backgroundColor;
          const arrow = instance.popper.querySelector(".tippy-arrow");
          if (arrow) {
            arrow.style.color = backgroundColor;
          }
        }
      },
    });
  });
  $(".passwordToggle").click(function () {
    const passwordField = $(this).siblings(".inputFile--password");
    const fieldType =
      passwordField.attr("type") === "password" ? "text" : "password";
    passwordField.attr("type", fieldType);
    $(this).toggleClass("active");
  });
  new Swiper(".loginboxSlider", {
    slidesPerView: 1,
    speed: 300,
    autoplay: true,
    loop: true,
    pagination: {
      clickable: true,
      el: ".loginboxSlider-pagination",
    },
  });
  const dataTables = [
    {
      selector: "#profitLoss-table",
      options: { searching: true, pageLength: 13 },
    },
    { selector: "#payout", options: { searching: false, pageLength: 10 } },
    {
      selector: "#all-customers",
      options: { searching: true, pageLength: 10 },
    },
    {
      selector: "#transactionTable2",
      options: { searching: true, pageLength: 10 },
    },
    {
      selector: "#withdrawalTable",
      options: { searching: true, pageLength: 10 },
    },
    {
      selector: "#all-cutomers",
      options: { searching: true, pageLength: 10 },
    },
  ];
  dataTables.forEach(({ selector, options }) => {
    $(selector).DataTable({
      ...options,
      info: false,
      ordering: false,
      lengthChange: false,
      pagingType: "simple_numbers",
    });
  });
  $(".dt-input").attr("placeholder", "Search...");
});
document.addEventListener("DOMContentLoaded", function () {
  function filterTableRows(filterSelector) {
    const filterElements = document.getElementsByClassName(filterSelector);
    if (!filterElements.length) {
      console.error(`Elements with class "${filterSelector}" not found.`);
      return;
    }
    Array.from(filterElements).forEach((filterElement) => {
      filterElement.addEventListener("change", function () {
        const filterValue = this.value;
        const rows = document.querySelectorAll(`.profitlossTable .table__row`);
        rows.forEach((row) => {
          const isProfitRow = row.classList.contains("profit-row");
          const isLossRow = row.classList.contains("loss-row");
          if (filterValue === "profit") {
            row.style.display = isProfitRow ? "table-row" : "none";
          } else if (filterValue === "loss") {
            row.style.display = isLossRow ? "table-row" : "none";
          } else {
            row.style.display = "table-row";
          }
        });
      });
    });
  }
  const rows = document.querySelectorAll(`.profitlossTable .table__row`);
  if(rows.length > 0) {
  filterTableRows("filterselect");
  }
});
function hideTradingViewContainer2() {
  const container = document.querySelector('#dark_widget');
  if (document.documentElement.classList.contains('dark')) {
      container.style.display = 'block';
  }
}
$(document).ready(function () {
  // Hide the widget on page load if dark class exists
hideTradingViewContainer2();

});

// Add event listener to the element with id="dark"
document.getElementById('dark').addEventListener('click', function() {
  const container = document.querySelector('#dark_widget');
  container.style.display = 'block';
});
// Add event listener to the element with id="dark"
document.getElementById('dark').addEventListener('click', function() {
  const container = document.querySelector('#light_widget');
  container.style.display = 'none';
});

function hideTradingViewContainer1() {
  const container = document.querySelector('#light_widget');
  if (document.documentElement.classList.contains('light')) {
      container.style.display = 'block';
  }
}
$(document).ready(function () {
  // Hide the widget on page load if dark class exists
hideTradingViewContainer1();

});

// Add event listener to the element with id="dark"
document.getElementById('light').addEventListener('click', function() {
  const container = document.querySelector('#light_widget');
  container.style.display = 'block';
});
// Add event listener to the element with id="dark"
document.getElementById('light').addEventListener('click', function() {
  const container = document.querySelector('#dark_widget');
  container.style.display = 'none';
});

