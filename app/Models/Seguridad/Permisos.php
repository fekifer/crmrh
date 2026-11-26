<?php
namespace App\Models\Seguridad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permisos extends Model{
    use HasFactory;

    public $timestamps = false;     

    protected $table = "permissions";

    protected $fillable = [
        'id', 
        'name', 
        'guard_name', 
        'status',
        'created_at', 
        'updated_at'
    ];
    protected $primaryKey = 'id';
}