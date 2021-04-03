<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;



class Ventas extends BaseController
{
	protected $ventas, $temporal_compra, $detalle_venta, $productos;

	public function __construct()
	{
		$this->ventas = new VentasModel();
		$this->detalle_venta = new DetalleVentaModel();
		helper(['form']);
	}

	public function index($activo = 1)
	{
		$ventas = $this->ventas->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Historial de ventas', 'ventas' => $ventas];

		echo view('header');
		echo view('ventas/ventas', $data);
		echo view('footer');
	}

	public function venta()
	{
		echo view('header');
		echo view('ventas/caja');
		echo view('footer');
	}

	public function insertar()
	{
		$id_venta = $this->request->getPost('id_venta');
		$total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));
		$forma_pago = $this->request->getPost('forma_pago');
		$id_cliente = $this->request->getPost('id_cliente');

		$session = session();

		$resultadoId = $this->ventas->insertarVenta($id_venta, $total, $session->id_usuario, 
		$session->id_caja, $id_cliente, $forma_pago);

		$this->temporal_compra = new TemporalCompraModel();

		if ($resultadoId) {
			$resultadoCompra = $this->temporal_compra->porCompra($id_venta);

			foreach ($resultadoCompra as $row) {
				$this->detalle_venta->save([
					'id_venta' => $resultadoId,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizaStock($row['id_producto'], $row['cantidad'], '-');
			}

			$this->temporal_compra->eliminarCompra($id_venta);
		}
		//return redirect()->to(base_url() . "/ventas/muestraCompraPdf/" . $resultadoId);
	}
}
