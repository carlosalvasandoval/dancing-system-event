var param = {
  "scrollCollapse": false,
  "scrollY":        "",
  "lengthMenu": [[10, 30, 60, 100], [10, 30, 60, 100]],
  "language": {
    "sProcessing":     "<span>... <i class='fa fa-refresh fa-spin'></i> Cargando ...</span>",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst":    "<i class='fa fa-angle-double-left'></i>",
      "sLast":     "<i class='fa fa-angle-double-right'></i>",
      "sNext":     "<i class='fa fa-angle-right'></i>",
      "sPrevious": "<i class='fa fa-angle-left'></i>"
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  },
  "bProcessing": true,
  "bServerSide": true,
  "sAjaxSource": "",
  "sPaginationType": "full_numbers",
  "fnServerData" : "",
  "ordering" : false
};

$(".modal").modal({"show": false, backdrop: 'static', keyboard: false});

function alerta(text, typ){
  $.toast({
    text: text,
    showHideTransition: 'slide',
    position: 'top-right',
    hideAfter: 6000, 
    icon: typ
  });
}

function confirmar(fnAcept, fnCancel, text = '') {
  text_title = ( text == '' ) ? '¿Estas seguro de eliminar?' : text;
  swal({
    title: text_title,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result)=>{
    if (result.value) {
      if (typeof (fnAcept) == 'function')
      {
        fnAcept();
      }
    }else{
      if (typeof (fnC) == 'function')
      {
        fnCancel();
      }
    }    
  });
}

(function ($) {
  $.fn.sololetras = function () {
    letras = /[a-zA-ZñÑáéíóúÁÉÍÓÚ]/;
    return this.each(function () {
      $(this).keypress(function (e) {
        if(e.which!=32 && e.which!=13)
        {
          if (!e.charCode){
            k = String.fromCharCode(e.which);
          }else{
            k = String.fromCharCode(e.charCode);
          }
          if(!letras.test(k) || e.which==95 || (e.ctrlKey && k == 'v')){
            e.preventDefault();
          }
        }
      });
    });
  };
})(jQuery);

(function ($) {
  $.fn.solofecha = function () {
    this.datepicker({
      autoclose: true,
      language : 'es',
      format: 'dd/mm/yyyy',
      clearBtn:true
    });
    return this.each(function() {
       $(this).keypress(function (e) {
          e.preventDefault();
       });
    });
  };
})(jQuery);

function show_loader()
{
  $("#loader").show();
}
function hide_loader()
{
  $("#loader").fadeOut();
}