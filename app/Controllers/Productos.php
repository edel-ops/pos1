<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;


class Productos extends BaseController
{
	protected $productos;

	public function __construct()
    {
		$this->productos = new ProductosModel();
		$this->unidades = new UnidadesModel();
		$this->categorias = new CategoriasModel();
    }

	public function index($activo = 1)
	{
		$productos = $this->productos->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Productos', 'datos' => $productos];

		echo view('header');
		echo view('productos/productos', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$productos = $this->productos->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Productos eliminadas', 'datos' => $productos];

		echo view('header');
		echo view('productos/eliminados', $data);
		echo view('footer');
	}

	public function nuevo(){

		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();

		$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias];

		echo view('header');
		echo view('productos/nuevo', $data);
		echo view('footer');

	}
	
	public function insertar(){

		if ($this->request->getMethod() == "post") {			
		
		$this->productos->save(['codigo' => $this->request->getPost('codigo'), 
			'nombre' => $this->request->getPost('nombre'), 
			'precio_venta' => $this->request->getPost('precio_venta'), 
			'precio_compra' => $this->request->getPost('precio_compra'), 
			'stock_minimo' => $this->request->getPost('stock_minimo'), 
			'inventariable' => $this->request->getPost('inventariable'), 
			'id_unidad' => $this->request->getPost('id_unidad'), 
			'id_categoria' => $this->request->getPost('id_categoria')]);		
		return redirect()->to(base_url().'/productos');

		}
		else {
			$data = ['titulo' => 'Agregar producto', 'validation' => $this->validator];

		echo view('header');
		echo view('productos/nuevo', $data);
		echo view('footer');
		}
		
	}

	public function editar($id){

		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();
		$productos = $this->productos->where('id', $id)->first();

		$data = ['titulo' => 'Editar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'productos' => $productos];
		echo view('header');
		echo view('productos/editar', $data);
		echo view('footer');

	}
	
	public function actualizar(){

		$this->productos->update($this->request->getPost('id'),[
			'codigo' => $this->request->getPost('codigo'), 
			'nombre' => $this->request->getPost('nombre'), 
			'precio_venta' => $this->request->getPost('precio_venta'), 
			'precio_compra' => $this->request->getPost('precio_compra'), 
			'stock_minimo' => $this->request->getPost('stock_minimo'), 
			'inventariable' => $this->request->getPost('inventariable'), 
			'id_unidad' => $this->request->getPost('id_unidad'), 
			'id_categoria' => $this->request->getPost('id_categoria')]);		
		return redirect()->to(base_url().'/productos');
	
	}

	public function eliminar($id){

		$this->productos->update($id,
		['activo' => 0]);
		return redirect()->to(base_url().'/productos');
		
	}

	public function reingresar($id){

		$this->productos->update($id,
		['activo' => 1]);
		return redirect()->to(base_url().'/productos');
		
	}

}
