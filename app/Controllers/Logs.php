<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogsModel;
use App\Models\UsuariosModel;


class Logs extends BaseController
{
	protected $logs, $usuarios;

	public function __construct()
    {
        $this->logs = new LogsModel();
        $this->usuarios = new UsuariosModel();

    }

	public function index()
	{
		$logs = $this->logs->obtener();
		$data = ['titulo' => 'Registro de actividad', 'datos' => $logs];

		echo view('header');
		echo view('logs', $data);
		echo view('footer');
	}
}