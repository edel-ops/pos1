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

            </form>