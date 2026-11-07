<?php
namespace App\Models\Seguridad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TiposSesion extends Model{
    use HasFactory;

    public $timestamps = false;     

    protected $table = "CTS_TIPOS_SESION";

    protected $fillable = [
        'ID_TIPO_SESION',
        'TIPO_SESION',
        'FECHA_CREACION',
        'FECHA_MODIFICACION',
        'ID_USUARIO'
    ];
    protected $primaryKey = 'ID_TIPO_SESION';
}