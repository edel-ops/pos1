<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <div>
                <p>
                    <a href="<?php echo base_url() ?>/unidades/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Folio</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($compras as $compra) { ?>

                            <tr>
                                <td><?php echo $compra['id']; ?></td>
                                <td><?php echo $compra['folio']; ?></td>
                                <td><?php echo $compra['total']; ?></td>
                                <td><?php echo $compra['fecha_alta']; ?></td>

                                <td><a href="<?php echo base_url() . '/compras/muestraCompraPdf/' . $compra['id']; ?>" class="btn btn-primary"><i class="fas fa-print"></i></a></td>

                    

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar este registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ligth" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-ligth" data-dismiss="modal">No</button>
                    <a class="btn btn-danger btn-ok">Si</a>
                </div>
            </div>
        </div>
    </div>