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
        $role2 = Role::create(['name' => 'Oficina rentistica']);
        $role3 = Role::create(['name' => 'Valuador']);
        $role4 = Role::create(['name' => 'Jefe de departamento']);
        $role5 = Role::create(['name' => 'Director']);
        $role6 = Role::create(['name' => 'Convenio municipal']);
        $role7 = Role::create(['name' => 'Sistemas']);
        $role8 = Role::create(['name' => 'Fiscal']);
        $role9 = Role::create(['name' => 'Valuación']);
        $role10 = Role::create(['name' => 'Gestión Catastral']);

        Permission::create(['name' => 'Área de administración', 'area' => 'Administración'])->syncRoles([$role1]);

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
        Permission::create(['name' => 'Editar permisos', 'area' => 'Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Reestablecer contraseña', 'area' => 'Usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de certificaciones', 'area' => 'Certificaciones'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar certificación', 'area' => 'Certificaciones'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar certificación', 'area' => 'Certificaciones'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de efirmas', 'area' => 'Efirmas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear efirma', 'area' => 'Efirmas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar efirma', 'area' => 'Efirmas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar efirma', 'area' => 'Efirmas'])->syncRoles([$role1]);

        Permission::create(['name' => 'Auditoria', 'area' => 'Auditoria'])->syncRoles([$role1]);
        Permission::create(['name' => 'Logs', 'area' => 'Logs'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de servicios', 'area' => 'Servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear servicio', 'area' => 'Servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar servicio', 'area' => 'Servicios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar servicio', 'area' => 'Servicios'])->syncRoles([$role1]);

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
        Permission::create(['name' => 'Bloquear predio', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Ver predio', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Ver predio avaluo', 'area' => 'Predios'])->syncRoles([$role1]);
        Permission::create(['name' => 'Reasignar valuador', 'area' => 'Predios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de avaluos', 'area' => 'Avaluos'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de oficinas', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar oficina', 'area' => 'Oficinas'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar factor incremento', 'area' => 'Factor de incremento'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de valores unitarios', 'area' => 'Valores unitarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Ventanilla', 'area' => 'Trámites'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Trámite exento', 'area' => 'Trámites'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Reactivar trámites', 'area' => 'Trámites'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Autorizar tramite', 'area' => 'Trámites'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Trámites en línea', 'area' => 'Trámites'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'Área de valuación', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2, $role6]);
        Permission::create(['name' => 'Valuación y desglose', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2, $role6]);
        Permission::create(['name' => 'Ficha técnica', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Impresión de avaluos', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2, $role6]);
        Permission::create(['name' => 'Notificación de avaluos', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2, $role6]);
        Permission::create(['name' => 'Avaluo de predio ignorado', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);
        Permission::create(['name' => 'Ver mis avaluos', 'area' => 'Valuación'])->syncRoles([$role1, $role3, $role2]);

        Permission::create(['name' => 'Área de gestión catastral', 'area' => 'Gestión catasral'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Captura al padron', 'area' => 'Gestión catasral'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Revisar traslados', 'area' => 'Gestión catasral'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Reasignar traslados', 'area' => 'Gestión catasral'])->syncRoles([$role1, $role2, $role4]);

        Permission::create(['name' => 'Área de certificados', 'area' => 'Certificados'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Certificado de historia', 'area' => 'Certificados'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Certificado de registro', 'area' => 'Certificados'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Cedula de actualización', 'area' => 'Certificados'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Certificado negativo', 'area' => 'Certificados'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Consulta certifiación', 'area' => 'Certificados'])->syncRoles([$role1, $role2, $role4]);

        Permission::create(['name' => 'Área de anotaciones y t. a.', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Variaciones catastrales', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Crear variación', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Editar variación', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'Borrar variación', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'Predios ignorados', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Crear predio ignorado', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Editar predio ignorado', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'Borrar predio ignorado', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role4]);
        Permission::create(['name' => 'Asignar Folio', 'area' => 'Anotaciones y T. A.'])->syncRoles([$role1, $role4]);

        Permission::create(['name' => 'Área de cartografía', 'area' => 'Cartografía'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Asignación de cuentas', 'area' => 'Cartografía'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Conciliar', 'area' => 'Cartografía'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Conciliar manzanas', 'area' => 'Cartografía'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Asignar coordenadas', 'area' => 'Cartografía'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'Área de consultas', 'area' => 'Consulta'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Ver oficina', 'area' => 'Consulta'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Ver reportes', 'area' => 'Consulta'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'Consulta Padrón', 'area' => 'Consulta'])->syncRoles([$role1, $role2, $role4]);

    }

}

