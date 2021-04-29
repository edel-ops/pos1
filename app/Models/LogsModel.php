<?php

namespace App\Models;
use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $table      = 'logs';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'evento', 'ip', 'detalles'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function obtener()
    {
        $this->select('logs.*, u.usuario AS usuario');
        $this->join('usuarios AS u', 'logs.id_usuario = u.id'); //IGUAL QUE AGREGAR UN INNER JOIN
        $datos = $this->findAll();
        //print_r($this->getLastQuery());
        return $datos;
    }
}
?>