<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <div>
                <p>
                    
                    <a href="<?php echo base_url() ?>/productos" class="btn btn-warning">Productos</a>
                </p>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>existencias</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($datos as $datos) { ?>

                            <tr>
                            <td><?php echo $datos['id']; ?></td>
                                <td><?php echo $datos['codigo']; ?></td>
                                <td><?php echo $datos['nombre']; ?></td>
                                <td><?php echo $datos['precio_venta']; ?></td>
                                <td><?php echo $datos['existencia']; ?></td>                                
                                
                                <td><a href="#" data-href="<?php echo base_url() . '/productos/reingresar/' . $datos['id']; ?>" 
                                data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Reingresar Registro" 
                                class="btn btn-dark"><i class="fas fa-trash-restore-alt"></i></a></td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Reingresar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Desea reingresar este registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ligth" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-ligth" data-dismiss="modal">No</button>
                    <a class="btn btn-danger btn-ok">Si</a>
                </div>
            </div>
        </div>
    </div>