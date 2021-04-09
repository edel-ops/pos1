// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    //CAMBIAR EL LENGUAJE INGLES POR DEFECTO
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },
    //ALTERAR EL ORDEN EN QUE SE MUESTRA LA TABLA
    //"ordering": false //EN FALSE ORDERNA DESDE MI FUNCION/CONSULTA
    //order: [0, 'asc']

  });
});
