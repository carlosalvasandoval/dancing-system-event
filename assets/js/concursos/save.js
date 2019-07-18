$("#parejas_profesor").numeric({
  negative : false,
  decimal : false
});
$('#fecha_ini_inscripcion, #fecha_fin_inscripcion, #fecha_ini_votacion, #fecha_fin_votacion').datetimepicker({
	format:"DD/MM/YYYY LT",
	sideBySide:true
});
$(document).on('keydown', '#fecha_ini_inscripcion, #fecha_fin_inscripcion, #fecha_ini_votacion, #fecha_fin_votacion', function(event) {
	event.preventDefault();
});