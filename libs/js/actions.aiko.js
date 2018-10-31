$(document).ready(function (a) {
jQuery("#jqGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:"cn"});
$(".glyphicon-backward").addClass("glyphicon-chevron-left");
$(".glyphicon-chevron-left").removeClass("glyphicon-backward");

$(".glyphicon-forward").addClass("glyphicon-chevron-right");
$(".glyphicon-chevron-right").removeClass("glyphicon-forward");

$(".ui-pg-selbox").removeClass("ui-pg-selbox");

$(".ui-search-clear").text("");

});