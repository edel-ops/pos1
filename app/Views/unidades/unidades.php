<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <div>
                <p>
                    <a href="<?php echo base_url() ?>/unidades/nuevo" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url() ?>/unidades/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Nombre corto</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($datos as $datos) { ?>

                            <tr>
                                <td><?php echo $datos['id']; ?></td>
                                <td><?php echo $datos['nombre']; ?></td>
                                <td><?php echo $datos['nombre_corto']; ?></td>

                                <td><a href="<?php echo base_url(). '/unidades/editar/'. $datos['id']; ?>" class="btn btn-warning"><i class="far fa-edit"></i></a></td>

                                <td><a href="<?php echo base_url(). '/unidades/eliminar/'. $datos['id']; ?>" class="btn btn-danger"><i class="fas fa-eraser"></i></a></td>
                                
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>