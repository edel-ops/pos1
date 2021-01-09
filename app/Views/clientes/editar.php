<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form action="<?php echo base_url(); ?>/clientes/actualizar" autocomplete="off" method="post">
            <?php csrf_field(); ?>

            <input type="hidden" id="id" name="id" value="<?php echo $clientes['id']; ?>" /> 
            <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $clientes['nombre']; ?>" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $clientes['direccion']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $clientes['telefono']; ?>" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Correo</label>
                            <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $clientes['correo']; ?>" />
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>



            </form>



        </div>
    </main>