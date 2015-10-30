$(document).on("ready", function() {

	$(".jsonResponse").on("click", function() {
		$.post(
			$(".form").attr("action"),
			$(".form").serialize(),
			function(res) {
				$.displayTimedAlert($("#message"), res.message, 2000);
				$(".form")[0].reset();
		}, "json");
		return false;
	});

});

$.displayTimedAlert = function(obj, content, msecs) {
	$.displayAnimatedAlert(obj, content);
	setTimeout(function() {
		obj.slideUp(200);
	}, msecs);
};

$.displayAnimatedAlert = function(obj, content, msecs) {
	if (!msecs) msecs = 400;
	obj.hide(200);
	setTimeout(function() {
		obj.html(content).show(msecs);
	}, 200);
};
