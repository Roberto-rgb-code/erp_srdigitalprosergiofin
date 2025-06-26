<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYUsuariosSeeder extends Seeder
{
    public function run()
    {
        // 1. Permisos
        $permisos = [
            'ver', 'crear', 'editar', 'eliminar', 'exportar', 'aprobar', 'configurar'
        ];

        // Módulos del sidebar + módulos nuevos
        $modulos = [
            'clientes',
            'ventas',
            'cableado estructurado',
            'desarrollo de software',
            'finanzas',
            'taller',
            'control de vehiculos',
            'recursos humanos',
            'servicios empresariales',
            'cuentas x cobrar',
            'cuentas x pagar',
            'contabilidad',
            // Agregados
            'personal',
            'compras',
            'punto_venta',
            'creditos',
        ];

        foreach ($modulos as $modulo) {
            foreach ($permisos as $permiso) {
                Permission::firstOrCreate(['name' => "{$permiso} {$modulo}"]);
            }
        }

        // 2. Roles y módulos a los que tienen acceso (agrega roles según tu estructura)
        $roles = [
            'Administrador General' => ['todos'],
            'Tesorería' => ['finanzas', 'cuentas x cobrar', 'cuentas x pagar'],
            'Contador' => ['contabilidad', 'finanzas', 'cuentas x pagar', 'cuentas x cobrar'],
            'Auxiliar Administrativo' => ['cuentas x cobrar', 'cuentas x pagar'],
            'Supervisor de Área Servicios' => ['servicios empresariales', 'taller'],
            'Supervisor de Área Ventas' => ['ventas'],
            'Supervisor de Área Servicio Empresarial' => ['servicios empresariales'],
            'Supervisor de Área Desarrollo de Software' => ['desarrollo de software'],
            'Supervisor de Área Instalaciones' => ['cableado estructurado'],
            'Capturista Servicio Empresarial' => ['servicios empresariales'],
            'Capturista Desarrollo de Software' => ['desarrollo de software'],
            'Capturista Instalaciones' => ['cableado estructurado'],
            // Nuevos ejemplos de roles para módulos agregados:
            'Supervisor de Personal' => ['personal'],
            'Compras' => ['compras'],
            'Punto de Venta' => ['punto_venta'],
            'Créditos' => ['creditos'],
            'Comodín' => ['comodin'],
        ];

        foreach ($roles as $rol => $modulos_rol) {
            $role = Role::firstOrCreate(['name' => $rol]);
            if ($modulos_rol[0] == 'todos') {
                $role->syncPermissions(Permission::all());
            } else {
                $perms = [];
                foreach ($modulos_rol as $modulo) {
                    foreach ($permisos as $permiso) {
                        $permiso_full = "{$permiso} {$modulo}";
                        if (Permission::where('name', $permiso_full)->exists()) {
                            $perms[] = $permiso_full;
                        }
                    }
                }
                $role->syncPermissions($perms);
            }
        }

        // 3. Usuarios con contraseñas únicas por usuario (agrega si tienes roles nuevos)
        $users = [
            ['name' => 'Kevin Dirección',      'email' => 'direccion@erp.com',       'password' => 'kd123456', 'role' => 'Administrador General'],
            ['name' => 'Tesorera',             'email' => 'tesoreria@erp.com',       'password' => 'teso456',  'role' => 'Tesorería'],
            ['name' => 'Contador',             'email' => 'contabilidad@erp.com',    'password' => 'conta456', 'role' => 'Contador'],
            ['name' => 'Auxiliar',             'email' => 'recepcion@erp.com',       'password' => 'aux1234',  'role' => 'Auxiliar Administrativo'],
            ['name' => 'Supervisor Servicios', 'email' => 'taller@erp.com',          'password' => 'serv123',  'role' => 'Supervisor de Área Servicios'],
            ['name' => 'Supervisor Ventas',    'email' => 'ventas@erp.com',          'password' => 'ventas123','role' => 'Supervisor de Área Ventas'],
            ['name' => 'Supervisor SEmp',      'email' => 'servicioemp@erp.com',     'password' => 'semp123',  'role' => 'Supervisor de Área Servicio Empresarial'],
            ['name' => 'Supervisor Soft',      'email' => 'devsoft@erp.com',         'password' => 'soft1234', 'role' => 'Supervisor de Área Desarrollo de Software'],
            ['name' => 'Supervisor Inst',      'email' => 'instalaciones@erp.com',   'password' => 'instal123','role' => 'Supervisor de Área Instalaciones'],
            ['name' => 'Capturista SEmp',      'email' => 'capturistaemp@erp.com',   'password' => 'csemp123', 'role' => 'Capturista Servicio Empresarial'],
            ['name' => 'Capturista Soft',      'email' => 'capturistadev@erp.com',   'password' => 'csoft123', 'role' => 'Capturista Desarrollo de Software'],
            ['name' => 'Capturista Inst',      'email' => 'capturistainst@erp.com',  'password' => 'cinst123', 'role' => 'Capturista Instalaciones'],
            // Nuevos usuarios ejemplo (puedes quitar/modificar según tu necesidad)
            ['name' => 'Supervisor Personal',  'email' => 'personal@erp.com',        'password' => 'pers123',  'role' => 'Supervisor de Personal'],
            ['name' => 'Compras',              'email' => 'compras@erp.com',         'password' => 'compras1', 'role' => 'Compras'],
            ['name' => 'Punto de Venta',       'email' => 'pos@erp.com',             'password' => 'pos12345', 'role' => 'Punto de Venta'],
            ['name' => 'Créditos',             'email' => 'creditos@erp.com',        'password' => 'cred123',  'role' => 'Créditos'],
            ['name' => 'Comodín',              'email' => 'comodin@erp.com',         'password' => 'comodin77','role' => 'Comodín'],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => bcrypt($userData['password']),
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}
