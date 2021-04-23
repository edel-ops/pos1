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
}
?>