<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;


class Compras extends BaseController
{
	protected $compras;
	protected $reglas;

	public function __construct()
	{
		$this->compras = new ComprasModel();
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

		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

			$this->compras->save([
				'nombre' => $this->request->getPost('nombre'),
				'nombre_corto' => $this->request->getPost('nombre_corto')
			]);
			return redirect()->to(base_url() . '/compras');
		} else {
			$data = ['titulo' => 'Agregar compra', 'validation' => $this->validator];

			echo view('header');
			echo view('compras/nuevo', $data);
			echo view('footer');
		}
	}

	public function editar($id, $valid = null)
	{

		$compra = $this->compras->where('id', $id)->first();

		if ($valid != null) {
			$data = ['titulo' => 'Editar compra', 'datos' => $compra, 'validation' => $valid];
		} else {
			$data = ['titulo' => 'Editar compra', 'datos' => $compra];
		}



		echo view('header');
		echo view('compras/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
			$this->compras->update(
				$this->request->getPost('id'),
				[
					'nombre' => $this->request->getPost('nombre'),
					'nombre_corto' => $this->request->getPost('nombre_corto')
				]
			);
			return redirect()->to(base_url() . '/compras');
		}
		else {
			return $this->editar($this->request->getPost('id'), $this->validator);
		}
	}

	public function eliminar($id)
	{

		$this->compras->update(
			$id,
			['activo' => 0]
		);
		return redirect()->to(base_url() . '/compras');
	}

	public function reingresar($id)
	{

		$this->compras->update(
			$id,
			['activo' => 1]
		);
		return redirect()->to(base_url() . '/compras');
	}
}
