$('document').ready(function() {

	// MAIN MENU SELECT
	$(".main_button").live("click", function() {
		// Set variables
		$button			= this.id;
		// Hide left menu selection
		$("#left_menu_on").hide();
		// Load proper content
		if ($button == 'usuario') {
			$url    	  = '/morarte/Usuario/';
		} else if ($button == 'configuracoes') {
			$url    	  = '/morarte/Configuracoes/';
		} else if ($button == 'orcamentos') {
			$url    	  = '/morarte/Orcamentos/';
//		} else if ($button == 'sair') {
//			$url    	  = '/morarte/Sair/';
		}
		load_ajax('POST', '', $url);
	});

	// LEFT MENU SELECT / UNSELECT
	$(".left_button").live("click", function() {
		// Set variables
		$button			= this.id;
		$position		= $("#"+$button).position();
		$top			= $position.top;
		// Set clicked item
		$("#left_menu_on").hide();
		$("#left_menu_on").css({"top": $top+"px", "left": "112px"});
		$("#left_menu_on").show();
		// Load proper content
		if ($button == 'bt_portifolio') {
			$url		= '/morarte/Portifolio/';
		} else if ($button == 'bt_produtos') {
			$url		= '/morarte/Produtos/';
		} else if ($button == 'bt_personalizado') {
			$url		= '/morarte/Personalizado/';
		} else if ($button == 'bt_pdf') {
			$url		= '/morarte/PDF/';
		}
		load_ajax('POST', '', $url);
	});

	// Load Page from button
	$(".bt_background_01, .bt_background_02").live("click", function() {
		$button		= this.id;
		if ($button != 'delete_usuario') {
			$url	= '/morarte/Configuracoes/'+$button;
			load_ajax('POST', '', $url);
		}
		return false;
	});

	// Form Submit
	$("#img_form_submit").live("click", function() {
		$(this).closest('form').submit();
		return false;
	});

	// Form reset
	$("#img_form_reset").live("click", function() {
		$(this).closest('form')[0].reset();
		return false;
	});

	// Post Form Add Usuario
	$("#add_usuario").live("submit", function() {
		// Initialize variables
		$this_form				= this.id;
		$name					= $("#name").val().trim();
		$email					= $("#email").val().trim();
		$user					= $("#user").val().trim();
		$password				= $("#password").val().trim();
		$password_conf			= $("#password_conf").val().trim();
		// If passwords match
		if ((($password) && ($password_conf)) && ($password == $password_conf)) {
			// If fields are not empty
			if (($name) && ($email) && ($user)) {
				// Submit form
				$data			= 'name='+$name+'&email='+$email+'&user='+$user+'&password='+$password+'&password_conf='+$password_conf;
				$url			= '/morarte/Configuracoes/'+$this_form;
				$.ajax({
					type:		'POST',
					data:		$data,
					dataType:	"html",
					url:		$url,
					success:	function(html) {
						$html	= html.trim();
						if ($html) {
							$("#main_content").hide();
							$("#main_content").html($html);
							$("#main_content").show(600);
						} else {
							alert('Dados de formulário não enviados');
						}
						return false;
					}
				});
			// If fields are empty
			} else {
				alert('Dados de formulário incorretos');
			}
		// If passwords do not match
		} else {
			alert('Senhas incorretas');
		}
		return false;
	});

	// Post Form Edit Usuario
	$("#edit_usuario").live("submit", function() {
		// Initialize variables
		$this_form			= this.id;
		$id					= $("#user_id").val().trim();
		$name				= $("#name").val().trim();
		$email				= $("#email").val().trim();
		$user				= $("#user").val().trim();
		// If fields are not empty
		if (($name) && ($email) && ($user)) {
			// Submit form
			$data			= 'user_id='+$id+'&name='+$name+'&email='+$email+'&user='+$user;
			$url			= '/morarte/Configuracoes/'+$this_form;
			$.ajax({
				type:		'POST',
				data:		$data,
				dataType:	"html",
				url:		$url,
				success:	function(html) {
					$html	= html.trim();
					if ($html) {
						$("#main_content").hide();
						$("#main_content").html($html);
						$("#main_content").show(600);
					} else {
						alert('Dados de formulário não enviados');
					}
					return false;
				}
			});
		// If fields are empty
		} else {
			alert('Dados de formulário incorretos');
		}
		return false;
	});

	// Search
	$('.search_input').live("keypress", function(e) {
		if (e.keyCode == 13) {
			$vc_search	= $(this).val();
			$this_view	= $(this).attr('this_view');
			$vc_search	= $vc_search.trim();
			$data		= 'vc_search='+$vc_search;
			$url		= '/morarte/Configuracoes/'+$this_view;
			$type		= 'POST';
			load_ajax($type, $data, $url);
		}
	}).live("focus", function() {
		$vc_search		= $(this).val();
		if ($vc_search == ' ') {
			$(this).val('');
		}
	});

	// Delete user
	$("#delete_usuario").live("click", function() {
		$name			= $("#name").val();
		$user_id		= $("#user_id").val();
		if ($name) {
			$res		= confirm('Deseja realmente apagar este usuário?\n\n- '+$name);
			if (($user_id) && ($res)) {
				$type	= 'POST';
				$data	= 'user_id='+$user_id;
				$url	= '/morarte/Configuracoes/delete_usuario/'+$user_id;
				load_ajax($type, $data, $url);
			}
		}
	return false;
	});

	// Loads Content thru AJAX
	function load_ajax($type, $data, $url, $div) {
		if (!$div) {
			$div			= '#main_content';
		}
		if (($type) && ($url)) {
			$.ajax({
				type:		$type,
				data:		$data,
				dataType:	"html",
				url:		$url,
				success:	function(html) {
					//$html	= html.trim();
					$html	= html;
					$($div).hide();
					$($div).html($html);
					$($div).show(600);
				}
			});
		}
	}

});