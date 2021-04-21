<?php namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;

class Inicio extends BaseController
{
	protected $productoModel, $ventaModel, $_session;

	public function __construct() {
		$this->productoModel = new ProductosModel();
		$this->ventaModel = new VentasModel();
		$this->session = session();
	}

	public function index()
	{
		if (!isset($this->session->id_usuario)) {
			return redirect()->to(base_url());
		}
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
