url_controller = url_aplication+"concursos/";
param.sAjaxSource = url_controller+"grid";
rol = $("#rol").val();
param.fnServerData = function( sUrl, aoData, fnCallback ){
   $.ajax( {
      "url": sUrl,
      "data": aoData,
      "success": function(response){
      	data = response.aaData;
      	DOMActionButton = $("#crud_buttons_concursos");
        option_place = ( rol == 1 ) ? 7 : 6;
      	$.each(data, function (key, obj){
          DOMActionButton.find(".estadistica").attr("href", url_aplication+"estadisticas/index/"+obj.DT_RowId);
          DOMActionButton.find(".recepcion").attr("href", url_aplication+"responsables/index/"+obj.DT_RowId+"/3");
          DOMActionButton.find(".teacher").attr("href", url_aplication+"responsables/index/"+obj.DT_RowId+"/2");
          DOMActionButton.find(".edit").attr("href", url_controller+"save/"+obj.DT_RowId);
          DOMActionButton.find(".delete").attr("onclick", "del_curso("+obj.DT_RowId+")");            
          DOMActionButton.find(".parejas").attr("href", url_aplication+"parejas/index/"+obj.DT_RowId);
      		obj[option_place] = DOMActionButton.html();
      	});
      	fnCallback(response);
      },
      "dataType": "jsonp",
      "cache": false
   });
};
var tbl_concursos = $('#tbl_concursos').DataTable(param);

function del_curso(id)
{
    confirmar(function(){
      show_loader();
        $.post(url_controller+'delete', {id: id}, function(response) {
            hide_loader();
            if(response.result==true){
                alerta("Registro Eliminado", "success");
                tbl_concursos.ajax.reload();
            }else{
                alerta(response.msg, "warning");
            }
        },'json');
    }, function(){});
}