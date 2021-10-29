// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    //CAMBIAR EL LENGUAJE INGLES POR DEFECTO
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },
    //ALTERAR EL ORDEN EN QUE SE MUESTRA LA TABLA
    //"ordering": false //EN FALSE ORDERNA DESDE MI FUNCION/CONSULTA
    //order: [0, 'desc'],
    //"ordering": false //elimina el sort en todas las columnas
    //elimina el sort de las columnas indicadas en targets
    // columnDefs: [
    //   { orderable: false, targets: [2, 3, 4] }
    // ]
  });
});
