tippy("#dashboard", {
  content: "Dashboard",
  placement: "right",
});
tippy("#account", {
  content: "Account",
  placement: "right",
});
tippy("#notification", {
  content: "Notification",
  placement: "right",
});
tippy("#deposite", {
  content: "Deposite",
  placement: "right",
});
tippy("#withdrawal", {
  content: "Withdrawal",
  placement: "right",
});
tippy("#chat", {
  content: "Chat",
  placement: "right",
});
tippy("#archive_history", {
  content: "Archive History",
  placement: "right",
});
tippy("#statements", {
  content: "Statements",
  placement: "right",
});
tippy("#add-user", {
  content: "Add User",
  placement: "right",
});
tippy("#update-bulk-record", {
  content: "Update Bulk Record",
  placement: "right",
});
tippy("#light", {
  content: "Light Mode",
  placement: "right",
});
tippy("#dark", {
  content: "Dark Mode",
  placement: "right",
});
tippy("#logout", {
  content: "Signout",
  placement: "right",
});
$("#profitLoss-table").DataTable({
  searching: true,
  info: false,
  ordering: false,
  lengthChange: false,
  pageLength: 10,
  pagingType: "simple_numbers",
});
$("#all-cutomers").DataTable({
  searching: true,
  info: false,
  ordering: false,
  lengthChange: false,
  pageLength: 10,
  pagingType: "simple_numbers",
});
$(".dt-input").attr("placeholder", "Search...");
$(".dt-paging-button.previous").html(
  '<i class="fa-solid fa-chevron-left"></i>'
);
$(".dt-paging-button.next").html('<i class="fa-solid fa-chevron-right"></i>');

$(document).ready(function () {
  $(".passwordToggle").click(function () {
    const passwordField = $(this).siblings(".inputFile--password");
    const fieldType =
      passwordField.attr("type") === "password" ? "text" : "password";
    passwordField.attr("type", fieldType);
    $(this).toggleClass("active");
  });

  document.getElementById("filterSelect").addEventListener("change", function () {
    const filterValue = this.value;
    const rows = document.querySelectorAll("#profitLoss-table .table__row");
  
    rows.forEach((row) => {
      row.style.display = "table-row"; // Show all rows by default
  
      if (filterValue === "profit" && !row.classList.contains("profit-row")) {
        row.style.display = "none"; // Hide non-profit rows
      } else if (filterValue === "loss" && !row.classList.contains("loss-row")) {
        row.style.display = "none"; // Hide non-loss rows
      }
    });
  });

});
