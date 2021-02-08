<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;


class Compras extends BaseController
{
	protected $compras, $temporal_compra, $detalle_compra, $productos;
	protected $reglas;

	public function __construct()
	{
		$this->compras = new ComprasModel();
		$this->detalle_compra = new DetalleCompraModel();
		helper(['form']);
	}

	public function index($activo = 1)
	{
		$compras = $this->compras->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Compras', 'datos' => $compras];

		echo view('header');
		echo view('compras/compras', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$compras = $this->compras->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Compras eliminadas', 'datos' => $compras];

		echo view('header');
		echo view('compras/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		echo view('header');
		echo view('compras/nuevo');
		echo view('footer');
	}

	public function insertar()
	{
		$id_compra = $this->request->getPost('id_compra');
		$total = $this->request->getPost('total');

		$session = session();

		$resultadoId = $this->compras->insertarCompra($id_compra, $total, $session->id_usuario);

		$this->temporal_compra = new TemporalCompraModel();

		if ($resultadoId) {
			$resultadoCompra = $this->temporal_compra->porCompra($id_compra);

			foreach ($resultadoCompra as $row) {
				$this->detalle_compra->save([
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
		return redirect()->to(base_url() . "/productos");
	}
}