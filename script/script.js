$(document).ready(function() {
	
	$(".right-box:nth-child(1)").mouseover(function() {
	
	$("#accept-info").attr('src','/me/icon/Info.png');
});
    $(".right-box:nth-child(1)").mouseout(function() {
	
	$("#accept-info").attr('src', '/me/icon/accept.png');
});
});