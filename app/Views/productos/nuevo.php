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
            <form action="<?php echo base_url(); ?>/productos/insertar" autocomplete="off" method="post" enctype="multipart/form-data">
            
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Codigo</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo set_value('nombre'); ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Unidad</label>
                            <select class="form-control" name="id_unidad" id="id_unidad" required>
                                <option value="">Seleccionar unidad</option>
                                <?php foreach($unidades as $unidad) { ?>
                                <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre']; ?></option><?php } ?>
                            </select>                            
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Categoria</label>
                            <select class="form-control" name="id_categoria" id="id_categoria" required>
                                <option value="">Seleccionar categoria</option>
                                <?php foreach($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option><?php } ?>
                            </select>                            
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Precio de venta</label>
                            <input type="text" class="form-control" id="precio_venta" name="precio_venta" value="<?php echo set_value('precio_venta'); ?>" required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Precio de compra</label>
                            <input type="text" class="form-control" id="precio_compra" name="precio_compra" value="<?php echo set_value('precio_compra'); ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Stock minimo</label>
                            <input type="text" class="form-control" id="stock_minimo" name="stock_minimo" value="<?php echo set_value('stock_minimo'); ?>" required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Es inventariable</label>
                            <select name="inventariable" id="inventariable" class="form-control">
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Imagen</label><br />
                            <input type="file" id="img_producto" name="img_producto" accept="image/jpeg" />
                            <p class="text-info">Cargar imagen en formato jpeg de 150x150 pixeles</p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/productos" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>



            </form>



        </div>
    </main>