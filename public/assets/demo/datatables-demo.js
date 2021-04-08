// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },
    //ALTERAR EL ORDEN EN QUE SE MUESTRA LA TABLA
    //"ordering": false //ORDERNAR DESDE MI FUNCION
    //order: [0, 'asc']

  });
});
