<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <div>
                <p>
                    
                    <a href="<?php echo base_url() ?>/unidades" class="btn btn-warning">Unidades</a>
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
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($datos as $datos) { ?>

                            <tr>
                                <td><?php echo $datos['id']; ?></td>
                                <td><?php echo $datos['nombre']; ?></td>
                                <td><?php echo $datos['nombre_corto']; ?></td>

                                <td><a href="<?php echo base_url(). '/unidades/reingresar/'. $datos['id']; ?>" class="btn btn-dark"><i class="fas fa-trash-restore-alt"></i></a></td>

                                
                                
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>