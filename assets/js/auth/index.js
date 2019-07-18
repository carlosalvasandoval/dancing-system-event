url_controller = url_aplication+"auth/";
param.sAjaxSource = url_controller+"grid";
param.fnServerData = function( sUrl, aoData, fnCallback ){
   $.ajax( {
      "url": sUrl,
      "data": aoData,
      "success": function(response){
      	data = response.aaData;
      	DOMActionButton = $("#crud_buttons_usuarios");
      	DOMStateUser = $("#state_user");
         DOMRolUser = $("#rol_user");
         $.each(data, function (key, obj){
            DOMActionButton.find(".edit").attr("href", url_aplication+"auth/create_user/"+obj[4]+"/"+obj.DT_RowId);      
            if(parseInt(obj[4])==1){
               DOMStateUser.find("a").attr("href", url_aplication+"auth/deactivate/"+ obj.DT_RowId).removeClass('label-danger').addClass('label-success').html("ACTIVO");
            }else{
               DOMStateUser.find("a").attr("href", url_aplication+"auth/activate/"+ obj.DT_RowId).removeClass('label-success').addClass('label-danger').html("DESACTIVO");
            }

            text_rol = obj[3].toUpperCase();
            DOMRolUser.find('span').html(text_rol);
            obj[3] = DOMRolUser.html();
            obj[4] = DOMStateUser.html();
            obj[5] = DOMActionButton.html();
      	});
      	fnCallback(response);
      },
      "dataType": "jsonp",
      "cache": false
   });
};
var tbl_usuarios = $('#tbl_usuarios').DataTable(param);