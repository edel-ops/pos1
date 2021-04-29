<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Actividad</th>                            
                            <th>Fecha</th>
                            <th>IP</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($datos as $datos) { ?>

                            <tr>
                                <td><?php echo $datos['usuario']; ?></td>
                                <td><?php echo $datos['evento']; ?></td> 
                                <td><?php echo $datos['fecha']; ?></td>
                                <td><?php echo $datos['ip']; ?></td>                                
                                <td><?php echo $datos['detalles']; ?></td>                                
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>