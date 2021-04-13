<?php namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;

class Inicio extends BaseController
{
	protected $productoModel, $ventaModel;

	public function __construct() {
		$this->productoModel = new ProductosModel();
		$this->ventaModel = new VentasModel();

	}

	public function index()
	{
		$total = $this->productoModel->totalProductos();
		$minimo = $this->productoModel->productosMinimo();
		$hoy = date('Y-m-d');
		$totalVentas = $this->ventaModel->totalDia($hoy);

		$datos = ['total' => $total, 'totalVentas' => $totalVentas, 'minimo' => $minimo];

		echo view('header');
		echo view('inicio', $datos);
		echo view('footer');
	}

	//--------------------------------------------------------------------

}
