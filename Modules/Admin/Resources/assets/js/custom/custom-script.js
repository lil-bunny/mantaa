/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */
$.get("header.html", function (data) {
    $("#header").html(data);
});
$.get("sidebar.html", function (data) {
    $("#sidebar").html(data);
});

function showSessionDuration(val)
{
    if(val=='free')
    {
        $('#showSessionDurationText').html('Free');
    }else{
        $('#showSessionDurationText').html('Premium');
    }

}