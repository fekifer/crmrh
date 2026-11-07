<?php
namespace App\Http\Managers\Seguridad;

use Illuminate\Support\Facades\DB;
use App\Models\Seguridad\Roles;
use App\Models\Seguridad\TiposSesion;
use Yajra\DataTables\Facades\DataTables;

class RolesManager{
    private $params;
    /**
     * @var int
     */
    private $visible;
    private $status;
    //private $status;
    
    public function __construct($params = null){
        $this->params = $params;
    }
    public function buscarTodos(){
        $data = Roles::select('id', 'name', 'guard_name', 'status', 'visible', 'created_at', 'updated_at')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {

                $status = $row->status == 1 ? 'Inactivar' : 'Activar';
                $estatus = $row->status == 1 ? 'x-circle' : 'check-circle';
                $visible = $row->visible == 1 ? 'eye-slash' : 'eye';
                $textoVisible = $row->visible == 1 ? 'Ocultar' : 'Mostrar';

                $rutaEstado = route('seguridad.roles.activar-inactivar',$row->id);
                $rutaVisible = route('seguridad.roles.ver-roles',$row->id);
                $rutaEditar = route('seguridad.roles.edit',$row->id);

                $actionBtn = "<div class='dropdown d-inline-block'> 
                                <button class='btn btn-soft-secondary btn-sm dropdown' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <i class='ri-more-fill align-middle'></i>
                                </button>
                                <ul class='dropdown-menu dropdown-menu-end'>
                                    <li>
                                        <a href='{$rutaVisible}' class='dropdown-item'>
                                            <i class='bi bi-{$visible}-fill me-2'></i> {$textoVisible}
                                        </a>
                                    </li>
                                    <li>
                                        <a href='{$rutaEstado}' class='dropdown-item'>
                                            <i class='bi bi-{$estatus}-fill me-2'></i> {$status}
                                        </a>
                                    </li>
                                    <li>
                                        <a href='#' class='dropdown-item btn-editar-rol' data-id='{$row->id}' data-name='{$row->name}'>
                                            <i class='bi bi-pencil-fill me-2'></i> Editar
                                        </a>
                                    </li>
                                </ul>
                            </div>";
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

        public function cambiarVisibilidad()
    {
        $this->visible = ($this->params["visible"] == 1 ? 2 :  1);
        $data = ['visible' => $this->visible];
        $this->params->update($data);
    }

    public function activarInactivarRol()
    {
        $this->status = ($this->params["status"] == 1 ? 2 :  1);
        $data = ['status' => $this->status];
        $this->params->update($data);
    }
    public function eliminarRol()
    {
        $data = ['status' => 3];
        $this->params->update($data);
    }

    public function obtenerGuard(){
        return TiposSesion::all();
    }

}
