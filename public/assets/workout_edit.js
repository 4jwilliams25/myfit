$(document).ready(function () {
    const statusAlert = $("#status_alert");
    const closeStatusAlert = $(".close_status_alert");

    closeStatusAlert.click(function () {
        statusAlert.addClass("invisible");
    });
});
