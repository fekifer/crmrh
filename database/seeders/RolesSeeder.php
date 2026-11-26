
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seguridad\Roles;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Administrador',
            'Recursos Humanos',
            'Reclutador',
            'Supervisor',
            'Consulta'
        ];

        foreach ($roles as $nombre) {
            Roles::firstOrCreate(
                [
                    'name' => $nombre,
                    'guard_name' => 'web'
                ],
                [
                    'status' => 1,
                    'visible' => 1
                ]
            );
        }
    }
}