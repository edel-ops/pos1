<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codigo', 'nombre', 'precio_venta', 'precio_compra', 'existencia', 
    'stock_minimo', 'inventariable', 'id_unidad', 'id_categoria', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function actualizaStock($id_producto, $cantidad)
    {
        $this->set('existencia', "existencia + $cantidad", FALSE);
        $this->where('id', $id_producto);
        $this->update();        
    }
}
