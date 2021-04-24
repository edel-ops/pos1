<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usuario', 'password', 'nombre', 'id_caja', 'id_rol', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function obtener($usuario)
    {
        $this->select('usuarios.*, r.nombre AS rol');
        $this->join('roles AS r', 'usuarios.id_rol = r.id'); //IGUAL QUE AGREGAR UN INNER JOIN
        $where = "usuarios.activo = 1 AND  usuarios.usuario = '$usuario'"; // mi where customizado para la doble codicion 
        $this->where($where);
        $datosRol = $this->first();
        //print_r($this->getLastQuery());
        return $datosRol;
    }
}
?>
