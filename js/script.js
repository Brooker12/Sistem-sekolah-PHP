$(document).ready(function() {

    // $("#btn-search").hide();

    $("#search").on("keyup", function() {
    //     $("#content").load(`js/search.php?key=${$("#search").val()}&page=${window.location.pathname}`);
    //     console.log("OK");

    $.get(`partials/search.php?key=${$("#search").val()}&page=${window.location.pathname}`, function(data) {
        $("#content").html(data);
        // $('#btn-search').show();
    })
    })
})