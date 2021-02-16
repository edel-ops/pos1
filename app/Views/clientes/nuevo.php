<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <?php \Config\Services::validation()->listErrors(); ?>
            <form action="<?php echo base_url(); ?>/clientes/insertar" autocomplete="off" method="post">
            
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo set_value('direccion'); ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo set_value('telefono'); ?>" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Correo</label>
                            <input type="text" class="form-control" id="correo" name="correo" value="<?php echo set_value('correo'); ?>" />
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>



            </form>



        </div>
    </main>