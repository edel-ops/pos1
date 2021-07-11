<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\PermisosModel;



class Roles extends BaseController
{
	protected $roles, $permisos;

	public function __construct()
	{
		$this->roles = new RolesModel();
		$this->permisos = new PermisosModel();

	}

	public function index($activo = 1)
	{
		$roles = $this->roles->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Roles', 'datos' => $roles];

		echo view('header');
		echo view('roles/roles', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$roles = $this->roles->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Roles eliminadas', 'datos' => $roles];

		echo view('header');
		echo view('roles/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		$data = ['titulo' => 'Agregar Rol'];

		echo view('header');
		echo view('roles/nuevo', $data);
		echo view('footer');
	}

	public function insertar()
	{

		if ($this->request->getMethod() == "post") {

			$this->roles->save([
				'nombre' => $this->request->getPost('nombre'),
				'activo' => 1
			]);
			return redirect()->to(base_url() . '/roles');
		}
	}

	public function editar($id, $valid = null)
	{

		$rol = $this->roles->where('id', $id)->first();

		$data = ['titulo' => 'Editar Rol', 'datos' => $rol];

		echo view('header');
		echo view('roles/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{
		if ($this->request->getMethod() == "post") {
			$this->roles->update(
				$this->request->getPost('id'),
				[
					'nombre' => $this->request->getPost('nombre')
				]
			);
			return redirect()->to(base_url() . '/roles');
		}
	}

	public function eliminar($id)
	{

		$this->roles->update(
			$id,
			['activo' => 0]
		);
		return redirect()->to(base_url() . '/roles');
	}

	public function reingresar($id)
	{

		$this->roles->update(
			$id,
			['activo' => 1]
		);
		return redirect()->to(base_url() . '/roles');
	}

	public function permisos($idRol)
	{
		$permisos = $this->permisos->findAll();

		$data = ['titulo' => 'Permisos de rol', 'permisos' => $permisos, 'id_rol' => $idRol];

		echo view('header');
		echo view('roles/permisos', $data);
		echo view('footer'); 
	}
}
