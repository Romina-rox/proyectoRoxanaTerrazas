<?php

namespace App\Console\Commands;

use App\Models\Administrativo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class EncryptExistingAdministrativosCIs extends Command
{
    protected $signature = 'administrativos:encrypt-cis';
    protected $description = 'Cifra los CIs existentes de administrativos en texto plano';

    public function handle()
    {
        $administrativos = Administrativo::all();
        
        $this->info('Iniciando proceso de cifrado de CIs de administrativos...');
        $bar = $this->output->createProgressBar(count($administrativos));
        $cifrados = 0;
        $yaCifrados = 0;
        
        foreach ($administrativos as $administrativo) {
            try {
                // Intenta descifrar, si falla es porque está en texto plano
                Crypt::decryptString($administrativo->getRawOriginal('ci'));
                $this->newLine();
                $this->info("✓ CI de {$administrativo->nombres} ya está cifrado");
                $yaCifrados++;
            } catch (\Exception $e) {
                // Si no está cifrado, cifrarlo
                $ciPlano = $administrativo->getRawOriginal('ci');
                $administrativo->ci = $ciPlano; // El mutator lo cifrará automáticamente
                $administrativo->save();
                $this->newLine();
                $this->info("✓ CI de {$administrativo->nombres} cifrado correctamente");
                $cifrados++;
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        $this->info("¡Proceso completado!");
        $this->info("CIs cifrados: {$cifrados}");
        $this->info("CIs ya cifrados: {$yaCifrados}");
        $this->info("Total procesados: " . count($administrativos));
        
        return Command::SUCCESS;
    }
}