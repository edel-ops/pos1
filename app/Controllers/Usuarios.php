<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;
use App\Models\LogsModel;


class Usuarios extends BaseController
{
	protected $usuarios, $cajas, $roles, $logs;
	protected $reglas, $reglasLogin, $reglasCambiar;

	public function __construct()
	{
		$this->usuarios = new UsuariosModel();
		$this->cajas = new CajasModel();
		$this->roles = new RolesModel();
		$this->logs = new LogsModel();

		helper(['form']);

		$this->reglas = [
			'usuario' => [
				'rules' => 'required|is_unique[usuarios.usuario]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'is_unique' => 'El campo {field} debe ser unico.'

				]
			],
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'repassword' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'matches' => 'Las contraseñas no coinciden.'
				]
			],
			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'id_caja' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'id_rol' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];

		$this->reglasEditar = [
			'usuario' => [
				'rules' => 'required|is_unique[usuarios.usuario,id,{id}]', // UPDATE ignorará la fila en la base de datos que tiene id = {id} cuando verifique que el usuario es único. 
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'is_unique' => 'El campo {field} debe ser unico.'

				]
			],
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'repassword' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'matches' => 'Las contraseñas no coinciden.'
				]
			],
			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'id_caja' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'id_rol' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];

		$this->reglasLogin = [
			'usuario' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];

		$this->reglasCambiar = [
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'repassword' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'matches' => 'Las contraseñas no coinciden.'
				]
			]
		];
	}

	public function index($activo = 1)
	{
		$usuarios = $this->usuarios->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

		echo view('header');
		echo view('usuarios/usuarios', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0)
	{
		$usuarios = $this->usuarios->where('activo', $activo)->findAll();
		$data = ['titulo' => 'Usuarios eliminadas', 'datos' => $usuarios];

		echo view('header');
		echo view('usuarios/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		$cajas = $this->cajas->where('activo', 1)->findAll();
		$roles = $this->roles->where('activo', 1)->findAll();
		$data = ['titulo' => 'Agregar usuario', 'cajas' => $cajas, 'roles' => $roles];

		echo view('header');
		echo view('usuarios/nuevo', $data);
		echo view('footer');
	}

	public function insertar()
	{

		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

			$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

			$this->usuarios->save([
				'usuario' => $this->request->getPost('usuario'),
				'password' => $hash,
				'nombre' => $this->request->getPost('nombre'),
				'id_caja' => $this->request->getPost('id_caja'),
				'id_rol' => $this->request->getPost('id_rol'),
				'activo' => 1
			]);
			return redirect()->to(base_url() . '/usuarios');
		} else {

			$cajas = $this->cajas->where('activo', 1)->findAll();
			$roles = $this->roles->where('activo', 1)->findAll();
			$data = ['titulo' => 'Agregar usuario', 'cajas' => $cajas, 'roles' => $roles, 'validation' => $this->validator];

			echo view('header');
			echo view('usuarios/nuevo', $data);
			echo view('footer');
		}
	}

	public function editar($id, $valid = null)
	{

		$usuario = $this->usuarios->where('id', $id)->first();
		$cajas = $this->cajas->where('activo', 1)->findAll();
		$roles = $this->roles->where('activo', 1)->findAll();

		if ($valid != null) {
			$data = ['titulo' => 'Editar usuario', 'datos' => $usuario, 'cajas' => $cajas, 'roles' => $roles, 'validation' => $valid];
		} else {
			$data = ['titulo' => 'Editar usuario', 'datos' => $usuario, 'cajas' => $cajas, 'roles' => $roles];
		}



		echo view('header');
		echo view('usuarios/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglasEditar)) {

			$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

			$this->usuarios->update(
				$this->request->getPost('id'),
				[
					'usuario' => $this->request->getPost('usuario'),
					'password' => $hash,
					'nombre' => $this->request->getPost('nombre'),
					'id_caja' => $this->request->getPost('id_caja'),
					'id_rol' => $this->request->getPost('id_rol'),
					'activo' => 1
				]
			);
			return redirect()->to(base_url() . '/usuarios');
		} else {
			return $this->editar($this->request->getPost('id'), $this->validator);
		}
	}

	public function eliminar($id)
	{

		$this->usuarios->update(
			$id,
			['activo' => 0]
		);
		return redirect()->to(base_url() . '/usuarios');
	}

	public function reingresar($id)
	{

		$this->usuarios->update(
			$id,
			['activo' => 1]
		);
		return redirect()->to(base_url() . '/usuarios');
	}

	public function login()
	{
		echo view('login');
	}

	public function valida()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglasLogin)) {
			$usuario = $this->request->getPost('usuario'); // Recoger datos de la vista login
			$password = $this->request->getPost('password'); // Recoger datos de la vista login
			$datosUsuario = $this->usuarios->obtener($usuario); // Le envio el dato usuario a la funcion

			if ($datosUsuario != null) {
				if (password_verify($password, $datosUsuario['password'])) { // La funcion me devuelve los demas datos de ese usuario
					$datosSesion = [
						'id_usuario' => $datosUsuario['id'],
						'nombre' => $datosUsuario['nombre'],
						'id_caja' => $datosUsuario['id_caja'],
						'id_rol' => $datosUsuario['id_rol'],
						'rol' => $datosUsuario['rol']
					];

					$ip = $_SERVER['REMOTE_ADDR'];
					$detalles = $_SERVER['HTTP_USER_AGENT'];

					$this->logs->save([
						'id_usuario' => $datosUsuario['id'],
						'evento' => 'Inicio de sesión',
						'ip' => $ip,
						'detalles' => $detalles
					]);

					$session = session();
					$session->set($datosSesion);
					return redirect()->to(base_url() . '/inicio');
				} else {
					$data['error'] = "Contraseña incorrecta";
					echo view('login', $data);
				}
			} else {
				$data['error'] = "El usuario no existe";
				echo view('login', $data);
			}
		} else {
			$data = ['validation' => $this->validator];
			echo view('login', $data);
		}
	}

	public function logout()
	{
		$session = session();

		$ip = $_SERVER['REMOTE_ADDR'];
		$detalles = $_SERVER['HTTP_USER_AGENT'];

		$this->logs->save([
			'id_usuario' => $session->id_usuario,
			'evento' => 'Cierre de sesión',
			'ip' => $ip,
			'detalles' => $detalles
		]);

		$session->destroy();
		return redirect()->to(base_url());
	}

	public function cambiaPassword()
	{
		$session = session();
		$usuario = $this->usuarios->where('id', $session->id_usuario)->first();
		$data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario];

		echo view('header');
		echo view('usuarios/cambiaPassword', $data);
		echo view('footer');
	}

	public function actualizar_password()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglasCambiar)) {

			$session = session();
			$idUsuario = $session->id_usuario;
			$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

			$this->usuarios->update($idUsuario, ['password' => $hash]);

			$usuario = $this->usuarios->where('id', $session->id_usuario)->first();
			$data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario, 'mensaje' => 'Contraseña actualizada'];

			echo view('header');
			echo view('usuarios/cambiaPassword', $data);
			echo view('footer');
		} else {

			$session = session();
			$usuario = $this->usuarios->where('id', $session->id_usuario)->first();
			$data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario, 'validation' => $this->validator];

			echo view('header');
			echo view('usuarios/cambiaPassword', $data);
			echo view('footer');
		}
	}
}
