<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Administrativo;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        Role::create(['name'=>'administrador']);
        Role::create(['name'=>'tecnico']);
        Role::create(['name'=>'pasante']);
        Role::create(['name'=>'usuario']);
        */
     /*   $roles = ['administrador', 'tecnico', 'pasante', 'usuario'];
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }*/

        $this->call([RoleSeeder::class]);

        // Datos base del administrador
        $ci_admin = '123456789';
        $email_admin = 'administrador@gmail.com';

        // Crear usuario administrador
        $user = User::firstOrCreate(
            ['email' => $email_admin], // Condición de búsqueda
            [
                'name' => 'Administrador General',
                'password' => Hash::make($ci_admin), // La contraseña es su CI
            ]
        );

        // Asignar rol si no lo tiene
        if (!$user->hasRole('administrador')) {
            $user->assignRole('administrador');
        }
        // Crear registro en la tabla administrativos
        Administrativo::firstOrCreate(
            ['usuario_id' => $user->id],
            [
                'nombres' => ' SUPER ADMINISTRADOR',
                'apellidos' => 'TERRAZAS SANCHEZ',
                'ci' => $ci_admin,
                'fecha_nacimiento' => '1980-05-12',
                'telefono' => '70707070',
                'direccion' => 'Av. Blanco Galindo, km 7, Cochabamba',
                'profesion' => 'Ingeniero en Sistemas',
            ]
        );

        //  otros seeders adicionales aun no tengo jajaja esto ya es triste ahhhh 
        // $this->call(OtherSeeder::class);
    }
}
