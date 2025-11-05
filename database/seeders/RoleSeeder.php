<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
     $admin=  Role::create(['name'=>'administrador']);//no olvidadar el admin es el unico administrativo
     $tecnico= Role::create(['name'=>'tecnico']);
     $pasante=   Role::create(['name'=>'pasante']);
     $usuario=  Role::create(['name'=>'usuario']);

     //roles   
     Permission::create(['name'=>'admin.roles.index'])->syncRoles($admin);
     Permission::create(['name'=>'admin.roles.create'])->syncRoles($admin);
     Permission::create(['name'=>'admin.roles.store'])->syncRoles($admin);
     Permission::create(['name'=>'admin.roles.permisos'])->syncRoles($admin);
    Permission::create(['name'=>'admin.roles.update_permisos'])->syncRoles($admin);
     Permission::create(['name'=>'admin.roles.edit'])->syncRoles($admin);
     Permission::create(['name'=>'admin.roles.update'])->syncRoles($admin);
     Permission::create(['name'=>'admin.roles.destroy'])->syncRoles($admin);
    //administrador
     Permission::create(['name'=>'admin.administrativos.index'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.create'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.store'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.permisos'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.show'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.edit'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.update'])->syncRoles($admin);
     Permission::create(['name'=>'admin.administrativos.destroy'])->syncRoles($admin);
     //HOSPITALES   
     Permission::create(['name'=>'admin.hospitales.index'])->syncRoles($admin);
     Permission::create(['name'=>'admin.hospitales.create'])->syncRoles($admin);
     Permission::create(['name'=>'admin.hospitales.store'])->syncRoles($admin);
     Permission::create(['name'=>'admin.hospitales.edit'])->syncRoles($admin);
     Permission::create(['name'=>'admin.hospitales.update'])->syncRoles($admin);
     Permission::create(['name'=>'admin.hospitales.destroy'])->syncRoles($admin);

    //EQUIPOS   
     Permission::create(['name'=>'admin.equipos.index'])->syncRoles($admin);
     Permission::create(['name'=>'admin.equipos.create'])->syncRoles($admin);
     Permission::create(['name'=>'admin.equipos.store'])->syncRoles($admin);
     Permission::create(['name'=>'admin.equipos.edit'])->syncRoles($admin);
     Permission::create(['name'=>'admin.equipos.update'])->syncRoles($admin);
     Permission::create(['name'=>'admin.equipos.destroy'])->syncRoles($admin);

    //usuarios   
     Permission::create(['name'=>'admin.usuarios.index'])->syncRoles($admin,$tecnico,$pasante);
     Permission::create(['name'=>'admin.usuarios.create'])->syncRoles($admin,$tecnico,$pasante);
     Permission::create(['name'=>'admin.usuarios.store'])->syncRoles($admin,$tecnico,$pasante);
      Permission::create(['name'=>'admin.usuarios.show'])->syncRoles($admin,$tecnico,$pasante);
     Permission::create(['name'=>'admin.usuarios.edit'])->syncRoles($admin,$tecnico);
     Permission::create(['name'=>'admin.usuarios.update'])->syncRoles($admin);
     Permission::create(['name'=>'admin.usuarios.destroy'])->syncRoles($admin);

    }
}
