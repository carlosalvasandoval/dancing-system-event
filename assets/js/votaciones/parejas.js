in_time();
setInterval(in_time, 6000);

/*if(typeof pareja_id != 'undefined' && pareja_id==-1)
{
	send_vote(pareja_id);
}*/

function in_time()
{
	$.get(url_aplication+'votaciones/concurso_in_time/'+concurso_id, function(data) {
		if(data==0)
		{
			window.location.href = url_aplication;
		}
	},'json');	
}

$(".btn-like").click(function(){
	pareja_id = $(this).attr("pareja_id");
	send_vote(pareja_id);
});

function send_vote(pareja_id)
{
	show_loader();
	$.post(url_aplication+'votaciones/vote', {pareja_id: pareja_id}, function(response) {
		if(response.result==true)
		{
			alerta("Su voto a sido registrado con éxito!!", "success");
			parejas = JSON.parse(response.parejas);
			$.each(parejas, function(index, obj) {
				$("#progress"+obj.id).css("width", obj.porcentaje+"%");
				$("#votos"+obj.id).html(obj.votos);
			});
		}else{
			if(parseInt(response.fb_logged)==0)
			{
				link = $("#login_fb").attr('href');
				window.location.href = link;
			}else{
				alerta(response.msg, "warning");			
			}
		}
		hide_loader();
	},'json');
}