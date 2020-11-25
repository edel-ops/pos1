<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>
            <?php \Config\Services::validation()->listErrors(); ?>
            <form action="<?php echo base_url(); ?>/unidades/insertar" autocomplete="off" method="post">
            <?php csrf_field(); ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre corto</label>
                            <input type="text" class="form-control" id="nombre corto" name="nombre corto" required />
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>



            </form>



        </div>
    </main>