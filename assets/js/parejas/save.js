$('.fecha_nacimiento').datetimepicker({
	format:"DD/MM/YYYY"
});
$(document).on('keydown', '.fecha_nacimiento', function(event) {
	event.preventDefault();
});
$(".dni").numeric({
  negative : false,
  decimal : false
});

$(".delete_foto").click(function(event) {
	event.preventDefault();
	btn_quitar_file = $(this);
	id = parseInt(btn_quitar_file.attr("pareja_id"));
	if(!isNaN(id))
	{
		confirmar(function(){
	      show_loader();
	        $.post(url_aplication+'parejas/delete_foto', {pareja_id: id}, function(response) {
	            hide_loader();
	            if(response.result==true){
	                alerta("Archivo Eliminado", "success");
	                btn_quitar_file.removeAttr('pareja_id');
	                btn_quitar_file.attr('data-dismiss', 'fileinput');
	                id_file_box = btn_quitar_file.closest('.fileinput').attr("id");
	                $("#"+id_file_box).fileinput('clear');
	                btn_quitar_file.removeClass('delete_foto');
	            }else{
	                alerta(response.msg, "warning");
	            }
	        },'json');
	    }, function(){}, '¿Estas seguro de eliminar la copia de dni del integrate?');		
	}else{
		id_file_box = btn_quitar_file.closest('.fileinput').attr("id");
		$("#"+id_file_box).fileinput('clear');
	}
});

$(".delete_copia_dni").click(function(event) {
	event.preventDefault();
	btn_quitar_file = $(this);
	id = parseInt(btn_quitar_file.attr("integrante_id"));
	if(!isNaN(id))
	{
		confirmar(function(){
	      show_loader();
	        $.post(url_aplication+'integrantes/delete_copia_dni', {integrante_id: id}, function(response) {
	            hide_loader();
	            if(response.result==true){
	                alerta("Archivo Eliminado", "success");
	                btn_quitar_file.removeAttr('integrante_id');
	                btn_quitar_file.attr('data-dismiss', 'fileinput');
	                id_file_box = btn_quitar_file.closest('.fileinput').attr("id");
	                $("#"+id_file_box).fileinput('clear');
	                btn_quitar_file.removeClass('delete_copia_dni');
	            }else{
	                alerta(response.msg, "warning");
	            }
	        },'json');
	    }, function(){}, '¿Estas seguro de eliminar la copia de dni del integrate?');		
	}else{
		id_file_box = btn_quitar_file.closest('.fileinput').attr("id");
		$("#"+id_file_box).fileinput('clear');
	}
});
$("#form_pareja").submit(function(event) {
	show_loader();
});