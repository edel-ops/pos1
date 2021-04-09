<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form action="<?php echo base_url(); ?>/configuracion/actualizar" autocomplete="off" method="post" enctype="multipart/form-data">
                <?php csrf_field(); ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre de la tienda</label>
                            <input type="text" class="form-control" id="tienda_nombre" name="tienda_nombre" value="<?php echo $nombre['valor']; ?>" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>RUC</label>
                            <input type="text" class="form-control" id="tienda_ruc" name="tienda_ruc" value="<?php echo $ruc['valor']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Telefono</label>
                            <input type="text" class="form-control" id="tienda_telefono" name="tienda_telefono" value="<?php echo $telefono['valor']; ?>" required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Correo</label>
                            <input type="text" class="form-control" id="tienda_email" name="tienda_email" value="<?php echo $email['valor']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Direccion</label>
                            <textarea class="form-control" name="tienda_direccion" id="tienda_direccion" cols="30" rows="5" required><?php echo $direccion['valor']; ?></textarea>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Leyenda del ticket</label>
                            <textarea class="form-control" name="ticket_leyenda" id="ticket_leyenda" cols="30" rows="5" required><?php echo $leyenda['valor']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Logotipo</label>
                            <img src="" class="img-responsive" width="200" />

                            <input type="file" id="tienda_logo" name="tienda_logo" accept="image/png" />
                            <p class="text-info">Cargar imagen en formato PNG de 150x150 pixeles</p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>

            </form>


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