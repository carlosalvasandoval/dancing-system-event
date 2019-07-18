param.bServerSide = false;
param.ordering = true;
param.order = [[2, "desc"]];
param.columnDefs = [{
  "targets"  : [0,1,3],
  "orderable": false,
}]
var tbl_estadisticas = $('#tbl_estadisticas').DataTable(param);