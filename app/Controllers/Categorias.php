<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;


class Categorias extends BaseController
{
	protected $categorias;

	public function __construct()
    {
        $this->categorias = new CategoriasModel();
    }

	public function index($activo = 1)
	{
		$categorias = $this->categorias->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Categorias', 'datos' => $categorias];

		echo view('header');
		echo view('categorias/categorias', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$categorias = $this->categorias->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Categorias eliminadas', 'datos' => $categorias];

		echo view('header');
		echo view('categorias/eliminados', $data);
		echo view('footer');
	}

	public function nuevo(){

		$data = ['titulo' => 'Agregar categoria'];

		echo view('header');
		echo view('categorias/nuevo', $data);
		echo view('footer');

	}
	
	public function insertar(){

		$this->categorias->save(['nombre' => $this->request->getPost('nombre')]);
		return redirect()->to(base_url().'/categorias');
		
	}

	public function editar($id){

		$unidad = $this->categorias->where('id', $id)->first();
		$data = ['titulo' => 'Editar categoria', 'datos' => $unidad];

		echo view('header');
		echo view('categorias/editar', $data);
		echo view('footer');

	}
	
	public function actualizar(){

		$this->categorias->update($this->request->getPost('id'),
		['nombre' => $this->request->getPost('nombre')]);
		return redirect()->to(base_url().'/categorias');
		
	}

	public function eliminar($id){

		$this->categorias->update($id,
		['activo' => 0]);
		return redirect()->to(base_url().'/categorias');
		
	}

	public function reingresar($id){

		$this->categorias->update($id,
		['activo' => 1]);
		return redirect()->to(base_url().'/categorias');
		
	}

}
