<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnidadesModel;


class Unidades extends BaseController
{
	protected $unidades;

	public function __construct()
    {
        $this->unidades = new UnidadesModel();
    }

	public function index($activo = 1)
	{
		$unidades = $this->unidades->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Unidades', 'datos' => $unidades];

		echo view('header');
		echo view('unidades/unidades', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$unidades = $this->unidades->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Unidades eliminadas', 'datos' => $unidades];

		echo view('header');
		echo view('unidades/eliminados', $data);
		echo view('footer');
	}

	public function nuevo(){

		$data = ['titulo' => 'Agregar unidad'];

		echo view('header');
		echo view('unidades/nuevo', $data);
		echo view('footer');

	}
	
	public function insertar(){

		if ($this->request->getMethod() == "post" && $this->validate(['nombre' => 'required', 'nombre_corto' => 'required'])) {			
		
		$this->unidades->save(['nombre' => $this->request->getPost('nombre'), 
		'nombre_corto' => $this->request->getPost('nombre_corto')]);		
		return redirect()->to(base_url().'/unidades');

		}
		else {
			$data = ['titulo' => 'Agregar unidad', 'validation' => $this->validator];

		echo view('header');
		echo view('unidades/nuevo', $data);
		echo view('footer');
		}
		
	}

	public function editar($id){

		$unidad = $this->unidades->where('id', $id)->first();
		$data = ['titulo' => 'Editar unidad', 'datos' => $unidad];

		echo view('header');
		echo view('unidades/editar', $data);
		echo view('footer');

	}
	
	public function actualizar(){

		$this->unidades->update($this->request->getPost('id'),
		['nombre' => $this->request->getPost('nombre'), 
		'nombre_corto' => $this->request->getPost('nombre_corto')]);
		return redirect()->to(base_url().'/unidades');
		
	}

	public function eliminar($id){

		$this->unidades->update($id,
		['activo' => 0]);
		return redirect()->to(base_url().'/unidades');
		
	}

	public function reingresar($id){

		$this->unidades->update($id,
		['activo' => 1]);
		return redirect()->to(base_url().'/unidades');
		
	}

}
