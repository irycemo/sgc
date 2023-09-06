<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Receptor de rentas']);
        $role3 = Role::create(['name' => 'Valuador']);
        $role4 = Role::create(['name' => 'Jefe de departamento']);
        $role5 = Role::create(['name' => 'Director']);
        $role6 = Role::create(['name' => 'Convenio municipal']);

        Permission::create(['name' => 'Lista de roles', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar rol', 'area' => 'Roles'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de permisos', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de usuarios', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Auditoria', 'area' => 'Auditoria'])->syncRoles([$role1]);
        Permission::create(['name' => 'Logs', 'area' => 'Logs'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de servicios', 'area' => 'Servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear servicio', 'area' => 'Servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar servicio', 'area' => 'Servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar servicio', 'area' => 'Servicios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de subconceptos', 'area' => 'Subconceptos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear subconcepto', 'area' => 'Subconceptos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar subconcepto', 'area' => 'Subconceptos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar subconcepto', 'area' => 'Subconceptos'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de categorías', 'area' => 'Categorías de servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear categoría', 'area' => 'Categorías de servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar categoría', 'area' => 'Categorías de servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar categoría', 'area' => 'Categorías de servicios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de umas', 'area' => 'Umas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear uma', 'area' => 'Umas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar uma', 'area' => 'Umas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar uma', 'area' => 'Umas'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de trámites', 'area' => 'Trámites'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar trámite', 'area' => 'Trámites'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar trámite', 'area' => 'Trámites'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de predios', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Lista de predios avaluos', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Lista de predios asignados', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Ver predio', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Reasignar valuador', 'area' => 'Predios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de oficinas', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de valores unitarios', 'area' => 'Valores unitarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Ventanilla', 'area' => 'Trámites y servicios'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Trámite excento', 'area' => 'Trámites y servicios'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'Área de valuación', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Valuación y desglose', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Ficha técnica', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Impresión', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Notificación', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Topografía', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Asignación de manzanas', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Asignación de cuentas', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Avaluos de predios ignorados', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Asignacion de cuenta', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Impresión de avaluos', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Notificación de avaluos', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Avaluos de predio ignorado', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);

    }

}
