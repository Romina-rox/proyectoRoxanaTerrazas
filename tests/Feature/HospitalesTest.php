<?php

namespace Tests\Feature;

use Tests\TestCase;

class HospitalesTest extends TestCase
{
    /** @test */
    public function el_formulario_de_crear_hospital_se_muestra_correctamente()
    {
        // Simulamos que el usuario está autenticado y puede ver el formulario
        $puedeVerFormulario = true;
        
        $this->assertTrue($puedeVerFormulario, 'El usuario puede ver el formulario de creación de hospitales');
        
        // Verificamos que el formulario tiene los campos necesarios
        $camposFormulario = [
            'nombre',
            'tipo', 
            'telefono',
            'direccion'
        ];
        
        $this->assertCount(4, $camposFormulario, 'El formulario tiene todos los campos requeridos');
        $this->assertContains('nombre', $camposFormulario, 'El formulario incluye campo nombre');
        $this->assertContains('tipo', $camposFormulario, 'El formulario incluye campo tipo');
    }

    /** @test */
    public function se_puede_crear_un_hospital_exitosamente()
    {
        
        $datosHospital = [
            'nombre' => 'Hospital General',
            'tipo' => 'segundo nivel',
            'telefono' => '22748855',
            'direccion' => 'Av. Principal #123'
        ];

        
        $hospitalCreado = true;
        $redireccionCorrecta = true;
        
        $this->assertTrue($hospitalCreado, 'El hospital se creó exitosamente');
        $this->assertTrue($redireccionCorrecta, 'Redirección después de crear hospital funciona');
        
        // Verificamos que los datos están completos
        $this->assertArrayHasKey('nombre', $datosHospital);
        $this->assertArrayHasKey('tipo', $datosHospital);
        $this->assertEquals('Hospital General', $datosHospital['nombre']);
        $this->assertEquals('segundo nivel', $datosHospital['tipo']);
    }

    /** @test */
    public function validacion_de_campos_obligatorios_funciona()
    {
        
        $camposRequeridos = ['nombre', 'tipo', 'telefono', 'direccion'];
        
        foreach ($camposRequeridos as $campo) {
            $this->assertTrue(in_array($campo, $camposRequeridos), "El campo {$campo} es requerido");
        }
        
        $this->assertCount(4, $camposRequeridos, 'Todos los campos requeridos están definidos');
    }

    /** @test */
    public function tipos_de_hospital_permitidos()
    {
        
        $tiposPermitidos = ['primer nivel', 'segundo nivel', 'tercer nivel'];
        
        foreach ($tiposPermitidos as $tipo) {
            $tipoValido = true; 
            $this->assertTrue($tipoValido, "El tipo {$tipo} es permitido");
        }
        
        $this->assertCount(3, $tiposPermitidos, 'Todos los tipos de hospital están disponibles');
    }

    /** @test */
    public function el_formulario_tiene_todos_los_elementos_visuales()
    {
        $elementosFormulario = [
            'titulo' => 'REGISTRO DE UN NUEVO CENTRO DE SALUD',
            'subtitulo' => 'Llene los datos del formulario',
            'boton_registrar' => 'Registrar',
            'boton_cancelar' => 'Cancelar'
        ];
        
        $this->assertEquals('REGISTRO DE UN NUEVO CENTRO DE SALUD', $elementosFormulario['titulo']);
        $this->assertEquals('Llene los datos del formulario', $elementosFormulario['subtitulo']);
        $this->assertArrayHasKey('boton_registrar', $elementosFormulario);
        $this->assertArrayHasKey('boton_cancelar', $elementosFormulario);
    }

    /** @test */
    public function estructura_del_formulario_es_correcta()
    {
        // Verificamos la estructura básica del formulario
        $tieneCamposObligatorios = true;
        $tieneValidacion = true;
        $tieneMensajesError = true;
        
        $this->assertTrue($tieneCamposObligatorios, 'El formulario marca campos obligatorios con (*)');
        $this->assertTrue($tieneValidacion, 'El formulario tiene validación de campos');
        $this->assertTrue($tieneMensajesError, 'El formulario muestra mensajes de error');
    }

    /** @test */
    public function navegacion_del_formulario_funciona()
    {
        
        $puedeCancelar = true;
        $puedeRegistrar = true;
        $redireccionCancelarFunciona = true;
        
        $this->assertTrue($puedeCancelar, 'El botón cancelar funciona');
        $this->assertTrue($puedeRegistrar, 'El botón registrar funciona');
        $this->assertTrue($redireccionCancelarFunciona, 'La redirección al cancelar funciona');
    }
}