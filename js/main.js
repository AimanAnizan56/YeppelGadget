$(document).ready(function () {
    // add side navigation method from jquery
    $('.sidenav').sidenav();
    // add modal method from jquery
    $(".modal").modal();
    // add dropdodwn method from jquery
    $(".dropdown-trigger").dropdown();
    // add tooltip method from jquery
    $('.tooltipped').tooltip();
    // add tabs method from jquery
    $('.tabs').tabs();
    // add select option method from jquery
    $('select').formSelect();
    // add event listener for term and condition checkbox
    // -- if check, sign up button will enabled, by default its disabled
    $("#agreement").click(() => {
        if ($("#agreement").prop("checked")) {
            $("#create-acc").prop('disabled', false);
        } else {
            $("#create-acc").prop('disabled', true);
        }
    });
    $("#search-icon").click(() => {
        $("#search-box").modal("open");
    });
})