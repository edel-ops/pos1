<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;


class Configuracion extends BaseController
{
	protected $configuracion;
	protected $reglas;

	public function __construct()
	{
		$this->configuracion = new ConfiguracionModel();
		helper(['form', 'upload']);

		$this->reglas = [
			'tienda_nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			],
			'tienda_ruc' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];
	}

	public function index($activo = 1)
	{
		$nombre = $this->configuracion->where('nombre', 'tienda_nombre')->first();
		$ruc = $this->configuracion->where('nombre', 'tienda_ruc')->first();
		$telefono = $this->configuracion->where('nombre', 'tienda_telefono')->first();
		$email = $this->configuracion->where('nombre', 'tienda_email')->first();
		$direccion = $this->configuracion->where('nombre', 'tienda_direccion')->first();
		$leyenda = $this->configuracion->where('nombre', 'ticket_leyenda')->first();
		$data = ['titulo' => 'Configuracion', 'nombre' => $nombre, 'ruc' => $ruc, 'telefono' => $telefono, 'email' => $email, 'direccion' => $direccion, 'leyenda' => $leyenda];

		echo view('header');
		echo view('configuracion/configuracion', $data);
		echo view('footer');
	}

	public function actualizar()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

			$this->configuracion->whereIn('nombre', ['tienda_nombre'])->set(['valor' => $this->request->getPost('tienda_nombre')])->update();
			$this->configuracion->whereIn('nombre', ['tienda_ruc'])->set(['valor' => $this->request->getPost('tienda_ruc')])->update();
			$this->configuracion->whereIn('nombre', ['tienda_telefono'])->set(['valor' => $this->request->getPost('tienda_telefono')])->update();
			$this->configuracion->whereIn('nombre', ['tienda_email'])->set(['valor' => $this->request->getPost('tienda_email')])->update();
			$this->configuracion->whereIn('nombre', ['tienda_direccion'])->set(['valor' => $this->request->getPost('tienda_direccion')])->update();
			$this->configuracion->whereIn('nombre', ['ticket_leyenda'])->set(['valor' => $this->request->getPost('ticket_leyenda')])->update();
			
			$validacion = $this->validate([
				'tienda_logo' => [
					'uploaded[tienda_logo]',
					'mime_in[tienda_logo,image/png]',
					'max_size[tienda_logo, 4096]'					
				]
			]);
			
			if ($validacion) {

				$ruta_logo = "images/logotipo.png";

				if (file_exists($ruta_logo)) {
					unlink($ruta_logo);
				}

				$img = $this->request->getFile('tienda_logo');
				$img->move('./images', 'logotipo.png');
			} else {
				echo 'Error en la validacion';
				exit;
			}

			return redirect()->to(base_url() . '/configuracion');
		}
		else {
			//return $this->editar($this->request->getPost('id'), $this->validator);
		}
	}

}
