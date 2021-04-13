<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <br />

            <div class="row">
                <div class="col-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <?php echo $total; ?> Productos en total
                        </div>
                        <a class="card-footer text-white" href="<?php echo base_url(); ?>/productos">Ver detalles</a>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <?php echo $totalVentas; ?> Ventas del día
                        </div>
                        <a class="card-footer text-white" href="<?php echo base_url(); ?>/productos">Ver detalles</a>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <?php echo $total; ?> Productos con stock mínimo
                        </div>
                        <a class="card-footer text-white" href="<?php echo base_url(); ?>/productos">Ver detalles</a>
                    </div>
                </div>
            </div>

        </div>
    </main>