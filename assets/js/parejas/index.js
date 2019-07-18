url_controller = url_aplication+"parejas/";
param.sAjaxSource = url_controller+"grid";
rol = $("#rol").val();
param.fnServerData = function( sUrl, aoData, fnCallback ){
   $.ajax( {
      "url": sUrl,
      "data": aoData,
      "success": function(response){
      	data = response.aaData;
      	DOMActionButton = $("#crud_buttons_parejas");
        DOMState = $("#state_pareja");
        DOMCheckIn = $("#checkin");
        $(".checkin_dom").bootstrapToggle('destroy');
      	$.each(data, function (key, obj){
          DOMActionButton.find(".validar").attr("href", url_controller+"validar/"+obj.DT_RowId);
      		DOMActionButton.find(".edit").attr("href", url_controller+"save/"+obj.DT_RowId);
          DOMActionButton.find(".ver").attr("onclick", "see_pareja("+obj.DT_RowId+")"); 
          DOMActionButton.find(".delete").attr("onclick", "del_pareja("+obj.DT_RowId+")");      
      		DOMState.find("span").removeClass('label-success').removeClass('label-danger').removeClass('label-warning');
          if(obj[1]==0)
          {
            DOMState.find('span').html("RECHAZADA").addClass('label-danger');
          }else if(obj[1]==1){
            DOMState.find('span').html("POR VALIDAR").addClass('label-warning');
          }else{
            DOMState.find('span').html("VALIDADA").addClass('label-success');
          }
          obj[1] = DOMState.html();
          DOMCheckIn.find(".checkin_dom").removeAttr('checked');
          if(obj[2]==1)
          {
            DOMCheckIn.find(".checkin_dom").attr("checked", true);                
          }
          obj[2] = DOMCheckIn.html();
          if(rol != 2)
          {
            place_botton = 4;
          }else{
            place_botton = 1;
          }
          obj[place_botton] = DOMActionButton.html();
      	});
      	fnCallback(response);
      },
      "dataType": "jsonp",
      "cache": false
   });
};
param.fnDrawCallback = function(){
  $(".checkin_dom").bootstrapToggle();
  $(".checkin_dom").change(function(event) {
    ObjDOMToggleCheckin = $(this);
    checkin_value = (ObjDOMToggleCheckin.prop('checked')) ? 1 : 0;
    div_tr = ObjDOMToggleCheckin.closest('tr');
    data = tbl_parejas.row(div_tr).data();
    pareja_id = data.DT_RowId;
    datos = {
      id : pareja_id,
      checkin:checkin_value
    };
    change_checkin(datos, ObjDOMToggleCheckin);
  });
};

var tbl_parejas = $('#tbl_parejas').DataTable(param);

function del_pareja(id)
{
    confirmar(function(){
      show_loader();
        $.post(url_controller+'delete', {id: id}, function(response) {
            hide_loader();
            if(response.result==true){
                alerta("Registro Eliminado", "success");
                tbl_parejas.ajax.reload();
            }else{
                alerta(response.msg, "warning");
            }
        },'json');
    }, function(){});
}

function change_checkin(data, DOM)
{
  show_loader();
  $.post(url_controller+'checkin', data, function(response) {
    if(response.result==true)
    {
      alerta("Checkin Realizado", "success");
      tbl_parejas.ajax.reload();
    }else{
      alerta(response.msg, "warning");
      ObjDOMToggleCheckin.bootstrapToggle('destroy');
      turn_toogle = (checkin_value==1)?false:true;
      DOM.prop("checked", turn_toogle);
      ObjDOMToggleCheckin.bootstrapToggle();
    }
    hide_loader();
  },'json');
}

function see_pareja(id)
{
  show_loader();
  $.get(url_controller+'see/'+id, function(pareja) {
    $("#nombre_pareja").html(pareja.nombre);
    link_foto = (pareja.foto!=null)?pareja.foto:"pareja.jpg";
    $("#foto_pareja").attr("src", url_aplication+"assets/files/"+link_foto);

    $.each(pareja.integrantes, function(index, integrante) {

      link_copia = (integrante.copia_dni!=null)?integrante.copia_dni:"integrante.png";
      $("#copia_dni_integrante"+index).attr("src", url_aplication+"assets/files/"+link_copia);
      $("#nombre_integrante"+index).html(integrante.nombres+" "+integrante.apellidos);
    });

    $("#modal_ver").modal("show");
    hide_loader();
  },'json');
}