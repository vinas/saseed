$(document).on("ready", function() {

	$("#LogMeIn").on("click", function() {
		params = $("#loginForm").serialize();
		$.post("/teste/Login/in", params, function(res) {
			res = $.parseJSON(res);
			if (res.response == 0) {
				$("#messageBox").html(res.message);
			}
		});
	});

});