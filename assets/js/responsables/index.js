url_controller = url_aplication+"responsables/";
param.sAjaxSource = url_controller+"grid/"+$("#concurso_id").val()+"/"+$("#rol").val();
param.fnServerData = function( sUrl, aoData, fnCallback ){
   $.ajax( {
      "url": sUrl,
      "data": aoData,
      "success": function(response){
      	data = response.aaData;
      	DOMActionButton = $("#crud_buttons_responsables");
      	$.each(data, function (key, obj){
          DOMActionButton.find(".delete").attr("href", url_controller+"delete/"+obj.DT_RowId+"/"+$("#concurso_id").val()+"/"+$("#rol").val());      
      		obj[2] = DOMActionButton.html();
      	});
      	fnCallback(response);
      },
      "dataType": "jsonp",
      "cache": false
   });
};
var tbl_responsables = $('#tbl_responsables').DataTable(param);

$(document).on('click', '.delete', function(event) {
  event.preventDefault();
  link = $(this).attr("href")
  confirmar(function(){
    show_loader();
    window.location.href = link; 
  }, function(){}, "¿Estas seguro de desasignar?");
});

$("#user_id").select2();

$("form").submit(function(event) {
  show_loader();
});