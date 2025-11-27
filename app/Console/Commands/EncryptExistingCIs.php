<?php

namespace App\Console\Commands;

use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class EncryptExistingCIs extends Command
{
    protected $signature = 'usuarios:encrypt-cis';
    protected $description = 'Cifra los CIs existentes en texto plano';

    public function handle()
    {
        $usuarios = Usuario::all();
        
        foreach ($usuarios as $usuario) {
            try {
                
                Crypt::decryptString($usuario->getRawOriginal('ci'));
                $this->info("CI de {$usuario->nombres} ya está cifrado");
            } catch (\Exception $e) {
                
                $ciPlano = $usuario->getRawOriginal('ci');
                $usuario->ci = $ciPlano; 
                $usuario->save();
                $this->info("CI de {$usuario->nombres} cifrado correctamente");
            }
        }
        
        $this->info('¡Proceso completado!');
    }
}