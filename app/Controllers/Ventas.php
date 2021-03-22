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
		$id_compra = $this->request->getPost('id_compra');
		$total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

		$session = session();

		$resultadoId = $this->ventas->insertarCompra($id_compra, $total, $session->id_usuario);

		$this->temporal_compra = new TemporalCompraModel();

		if ($resultadoId) {
			$resultadoCompra = $this->temporal_compra->porCompra($id_compra);

			foreach ($resultadoCompra as $row) {
				$this->detalle_venta->save([
					'id_compra' => $resultadoId,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizaStock($row['id_producto'], $row['cantidad']);
			}

			$this->temporal_compra->eliminarCompra($id_compra);
		}
		return redirect()->to(base_url() . "/ventas/muestraCompraPdf/".$resultadoId);
	}

}
