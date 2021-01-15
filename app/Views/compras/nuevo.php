<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <form action="<?php echo base_url(); ?>/compras/insertar" autocomplete="off" method="post">
                <div class="form-group">
                    <div class="row">

                        <div class="col-12 col-sm-4">
                            <label>Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Escribe el codigo" autofocus />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Nombre del producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" disabled />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" />
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Precio de compra</label>
                            <input type="text" class="form-control" id="precio_compra" name="precio_compra" />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Sub Total</label>
                            <input type="text" class="form-control" id="subtotal" name="subtotal" disabled />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label><br>&nbsp;</label>
                            <button id="agregar_producto" name="agregar_producto" type="button" class="btn btn-primary">Agregar producto</button>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos" width="100%">
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th width="1%"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 offset-md-6">
                        <label for="" style="font-weight: bold; font-size: 30px; text-align: center;">Total C$</label>
                        <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;" />
                        <button type="button" id="completa_compra" class="btn btn-success">Completar compra</button>
                    </div>
                </div>

            </form>



        </div>
    </main>