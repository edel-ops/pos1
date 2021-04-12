<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;


class Productos extends BaseController
{
	protected $productos;
	protected $reglas;

	public function __construct()
	{
		$this->productos = new ProductosModel();
		$this->unidades = new UnidadesModel();
		$this->categorias = new CategoriasModel();

		helper(['form', 'upload']);

		$this->reglas = [
			'codigo' => [
				'rules' => 'required|is_unique[productos.codigo]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'is_unique' => 'El campo {field} debe ser unico.'

				]
			],
			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];
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

	public function nuevo()
	{

		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();

		$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias];

		echo view('header');
		echo view('productos/nuevo', $data);
		echo view('footer');
	}

	public function insertar()
	{

		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

			$this->productos->save([
				'codigo' => $this->request->getPost('codigo'),
				'nombre' => $this->request->getPost('nombre'),
				'precio_venta' => $this->request->getPost('precio_venta'),
				'precio_compra' => $this->request->getPost('precio_compra'),
				'stock_minimo' => $this->request->getPost('stock_minimo'),
				'inventariable' => $this->request->getPost('inventariable'),
				'id_unidad' => $this->request->getPost('id_unidad'),
				'id_categoria' => $this->request->getPost('id_categoria')
			]);

			$id = $this->productos->insertID();

			$validacion = $this->validate([
				'img_producto' => [
					'uploaded[img_producto]',
					'mime_in[img_producto,image/jpg,image/jpeg]',
					'max_size[img_producto, 4096]'
				]
			]);

			if ($validacion) {

				$ruta_logo = "images/productos/" . $id . ".jpg";

				if (file_exists($ruta_logo)) {
					unlink($ruta_logo);
				}

				$img = $this->request->getFile('img_producto');
				$img->move('./images/productos/', $id . '.jpg');
			} else {
				echo 'Error en la validacion';
				exit;
			}

			return redirect()->to(base_url() . '/productos');
		} else {
			$unidades = $this->unidades->where('activo', 1)->findAll();
			$categorias = $this->categorias->where('activo', 1)->findAll();
			$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $this->validator];

			echo view('header');
			echo view('productos/nuevo', $data);
			echo view('footer');
		}
	}

	public function editar($id)
	{

		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();
		$productos = $this->productos->where('id', $id)->first();

		$data = ['titulo' => 'Editar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'productos' => $productos];
		echo view('header');
		echo view('productos/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{

		$this->productos->update($this->request->getPost('id'), [
			'codigo' => $this->request->getPost('codigo'),
			'nombre' => $this->request->getPost('nombre'),
			'precio_venta' => $this->request->getPost('precio_venta'),
			'precio_compra' => $this->request->getPost('precio_compra'),
			'stock_minimo' => $this->request->getPost('stock_minimo'),
			'inventariable' => $this->request->getPost('inventariable'),
			'id_unidad' => $this->request->getPost('id_unidad'),
			'id_categoria' => $this->request->getPost('id_categoria')
		]);

		$id = $this->request->getPost('id');

		$validacion = $this->validate([
			'img_producto' => [
				'uploaded[img_producto]',
				'mime_in[img_producto,image/jpg,image/jpeg]',
				'max_size[img_producto, 4096]'
			]
		]);

		if ($validacion) {

			$ruta_logo = "images/productos/" . $id . ".jpg";

			if (file_exists($ruta_logo)) {
				unlink($ruta_logo);
			}

			$img = $this->request->getFile('img_producto');
			$img->move('./images/productos/', $id . '.jpg');
		} else {
			echo 'Error en la validacion';
			exit;
		}

		return redirect()->to(base_url() . '/productos');
	}

	public function eliminar($id)
	{

		$this->productos->update(
			$id,
			['activo' => 0]
		);
		return redirect()->to(base_url() . '/productos');
	}

	public function reingresar($id)
	{

		$this->productos->update(
			$id,
			['activo' => 1]
		);
		return redirect()->to(base_url() . '/productos');
	}

	public function buscarPorCodigo($codigo)
	{
		$this->productos->select('*');
		$this->productos->where('codigo', $codigo);
		$this->productos->where('activo', 1);
		$datos = $this->productos->get()->getRow();

		$res['existe'] = false;
		$res['datos'] = '';
		$res['error'] = '';

		if ($datos) {
			$res['datos'] = $datos;
			$res['existe'] = true;
		} else {
			$res['error'] = 'No existe el producto';
			$res['existe'] = false;
		}

		echo json_encode($res);
	}

	public function autocompleteData()
	{
		$returnData = array();
		$valor = $this->request->getGet('term');

		$productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
		if (!empty($productos)) {
			foreach ($productos as $row) {
				$data['id'] = $row['id'];
				$data['value'] = $row['codigo'];
				$data['label'] = $row['codigo'] . ' - ' . $row['nombre'];

				array_push($returnData, $data);
			}
		}

		echo json_encode($returnData);
	}
}
