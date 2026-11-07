<?php
namespace App\Models\Seguridad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model{
    use HasFactory;

    public $timestamps = false;     

    protected $table = "roles";

    protected $fillable = [
        'id', 
        'name', 
        'guard_name', 
        'status',
        'visible',
        'created_at', 
        'updated_at'
    ];
    protected $primaryKey = 'id';
}