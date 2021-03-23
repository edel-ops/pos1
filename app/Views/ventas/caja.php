<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <?php $idVentaTmp = uniqid(); ?>

            <br>

            <form id="form_venta" name="form_venta" class="form-horizontal" method="POST" action="<?php base_url(); ?>/ventas/insertar" autocomplete="off">

                <input type="hidden" name="id_venta" name="id_venta" value="<?php echo $idVentaTmp; ?>" />

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="ui-widget">
                                <label>Cliente:</label>
                                <input type="hidden" id="id_cliente" name="id_cliente" value="1">
                                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escribe el nombre del cliente" value="Público en general" onkeyup="agregaProducto()" autocomplete="off" required />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Forma de pago:</label>
                            <select id="forma_pago" name="forma_pago" class="form-control" required>
                                <option value="001">Efectivo</option>
                                <option value="002">Tarjeta</option>
                                <option value="003">Transferencia</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <div class="col-12 col-sm-4">
                            <input type="hidden" id="id_producto" name="id_producto" />
                            <label>Código de barras</label>

                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Escribe el código" onkeyup="buscarProducto(event, this, this.value)" autofocus />

                        </div>

                        <div class="col-sm-2">
                            <label for="codigo" id="resultado_error" style="color: red;"></label>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label for="" style="font-weight: bold; font-size: 30px; text-align: center;">Total C$</label>
                            <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;" />
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <button type="button" id="completa_venta" class="btn btn-success">Completar venta</button>
                </div>

            </form>