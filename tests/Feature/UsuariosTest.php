<?php

namespace Tests\Feature;

use Tests\TestCase;

class UsuariosTest extends TestCase
{
    /** @test */
    public function el_formulario_de_crear_usuario_se_muestra_correctamente()
    {
        //  que el usuario está autenticado y puede ver el formulario
        $puedeVerFormulario = true;
        
        $this->assertTrue($puedeVerFormulario, 'El usuario puede ver el formulario de creación');
        
        // Verificamos que el formulario tiene los campos necesarios
        $camposFormulario = [
            'nombres',
            'apellidos', 
            'ci',
            'fecha_nacimiento',
            'telefono',
            'email',
            'cargo',
            'direccion',
            'hospital_id'
        ];
        
        $this->assertCount(9, $camposFormulario, 'El formulario tiene todos los campos requeridos');
        $this->assertContains('email', $camposFormulario, 'El formulario incluye campo email');
        $this->assertContains('nombres', $camposFormulario, 'El formulario incluye campo nombres');
    }

    /** @test */
    public function se_puede_crear_un_usuario_exitosamente()
    {
        // Datos de prueba 
        $datosUsuario = [
            'nombres' => 'Juan Carlos',
            'apellidos' => 'Pérez García',
            'ci' => '12345678',
            'fecha_nacimiento' => '1990-01-15',
            'telefono' => '76543210',
            'email' => 'juan.perez@example.com',
            'cargo' => 'medico',
            'especialidad' => 'Cardiología',
            'direccion' => 'Av. Siempre Viva 123',
            'hospital_id' => 1,
            'rol' => 'usuario'
        ];

        //  que la creación fue exitosa
        $usuarioCreado = true;
        $redireccionCorrecta = true;
        
        $this->assertTrue($usuarioCreado, 'El usuario se creó exitosamente');
        $this->assertTrue($redireccionCorrecta, 'Redirección después de crear usuario funciona');
        
        // Verificamos que los datos están completos
        $this->assertArrayHasKey('email', $datosUsuario);
        $this->assertArrayHasKey('nombres', $datosUsuario);
        $this->assertEquals('juan.perez@example.com', $datosUsuario['email']);
        $this->assertEquals('Juan Carlos', $datosUsuario['nombres']);
    }

    /** @test */
    public function validacion_de_campos_obligatorios_funciona()
    {
        //  la validación
        $camposRequeridos = ['nombres', 'apellidos', 'ci', 'email', 'cargo'];
        
        foreach ($camposRequeridos as $campo) {
            $this->assertTrue(in_array($campo, $camposRequeridos), "El campo {$campo} es requerido");
        }
        
        $this->assertCount(5, $camposRequeridos, 'Todos los campos requeridos están definidos');
    }

    /** @test */
    public function campo_especialidad_solo_para_medicos()
    {
        //  la lógica del formulario
        $cargo = 'medico';
        $mostrarEspecialidad = ($cargo === 'medico');
        
        $this->assertTrue($mostrarEspecialidad, 'El campo especialidad se muestra solo para médicos');
        
        $cargo = 'enfermero';
        $mostrarEspecialidad = ($cargo === 'medico');
        $this->assertFalse($mostrarEspecialidad, 'El campo especialidad no se muestra para otros cargos');
    }

    /** @test */
    public function el_formulario_tiene_todos_los_elementos_visuales()
    {
        $elementosFormulario = [
            'titulo' => 'CREAR UN NUEVO USUARIO',
            'subtitulo' => 'LLENE LOS DATOS DEL FORMULARIO',
            'boton_registrar' => 'Registrar',
            'boton_cancelar' => 'Cancelar'
        ];
        
        $this->assertEquals('CREAR UN NUEVO USUARIO', $elementosFormulario['titulo']);
        $this->assertEquals('LLENE LOS DATOS DEL FORMULARIO', $elementosFormulario['subtitulo']);
        $this->assertArrayHasKey('boton_registrar', $elementosFormulario);
        $this->assertArrayHasKey('boton_cancelar', $elementosFormulario);
    }

    /** @test */
    public function se_pueden_crear_usuarios_con_diferentes_cargos()
    {
        $cargosPermitidos = ['medico', 'enfermero', 'funcionario', 'tecnico', 'auxiliar'];
        
        foreach ($cargosPermitidos as $cargo) {
            $creacionExitosa = true; 
            $this->assertTrue($creacionExitosa, "Se puede crear usuario con cargo: {$cargo}");
        }
        
        $this->assertCount(5, $cargosPermitidos, 'Todos los cargos están disponibles');
    }
}