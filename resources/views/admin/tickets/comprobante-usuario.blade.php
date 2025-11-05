<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprobante de Entrega - Usuario - Ticket #{{$ticket->id}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .comprobante {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 2px solid #28a745;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        
        .alert-reparado {
            background: #d4edda;
            border: 2px solid #28a745;
            border-radius: 5px;
            padding: 15px;
            margin: 20px;
            text-align: center;
        }
        
        .alert-reparado h3 {
            margin: 0 0 10px 0;
            color: #155724;
        }
        
        .content {
            padding: 30px;
        }
        
        .ticket-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .label {
            font-weight: bold;
            color: #495057;
        }
        
        .value {
            color: #212529;
        }
        
        .estado-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .problema-detalle {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .solucion-detalle {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .firma-section {
            margin-top: 40px;
            border-top: 2px solid #dee2e6;
            padding-top: 30px;
        }
        
        .firma-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .firma-box {
            width: 45%;
            text-align: center;
        }
        
        .firma-line {
            border-bottom: 2px solid #000;
            margin: 40px 0 10px 0;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 15px 30px;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            border-top: 2px solid #28a745;
        }
        
        .success-box {
            background: #d4edda;
            border: 2px dashed #28a745;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .success-box h4 {
            color: #155724;
            margin-top: 0;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .comprobante {
                border: none;
                box-shadow: none;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="comprobante">
        <div class="header">
            <h1>✅ COMPROBANTE DE DEVOLUCIÓN AL USUARIO</h1>
            <p>Sistema de Seguimiento Técnico - Gobierno Autónomo Municipal de Sacaba</p>
            <p>Ticket #{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</p>
        </div>
        
        <div class="alert-reparado">
            <h3>✓ EQUIPO REPARADO EXITOSAMENTE</h3>
            <p><strong>Este equipo ha sido reparado y está listo para su uso</strong></p>
        </div>
        
        <div class="content">
            <div class="ticket-info">
                <h4 style="margin-top: 0; color: #155724; border-bottom: 2px solid #28a745; padding-bottom: 10px;">
                    INFORMACIÓN DEL EQUIPO
                </h4>
                <div class="info-row">
                    <span class="label">Hospital/Centro de Salud:</span>
                    <span class="value">{{$ticket->hospital->nombre}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Usuario Solicitante:</span>
                    <span class="value">{{$ticket->usuario->nombre_completo}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Cargo:</span>
                    <span class="value">{{ucfirst($ticket->usuario->cargo)}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Contacto:</span>
                    <span class="value">{{$ticket->usuario->user->email}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tipo de Equipo:</span>
                    <span class="value">{{$ticket->equipo->nombre}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Descripción del Equipo:</span>
                    <span class="value">{{$ticket->descripcion_equipo}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Número de Activo:</span>
                    <span class="value"><strong style="font-size: 1.2rem; color: #28a745;">{{$ticket->numero_activo}}</strong></span>
                </div>
            </div>

            <div class="ticket-info">
                <h4 style="margin-top: 0; color: #155724; border-bottom: 2px solid #28a745; padding-bottom: 10px;">
                    FECHAS Y TIEMPOS
                </h4>
                <div class="info-row">
                    <span class="label">Fecha de Ingreso:</span>
                    <span class="value">{{$ticket->fecha_ingreso->format('d/m/Y')}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de Reparación:</span>
                    <span class="value">{{$ticket->fecha_finalizacion ? $ticket->fecha_finalizacion->format('d/m/Y H:i') : '-'}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de Devolución:</span>
                    <span class="value">{{$ticket->fecha_devolucion_usuario->format('d/m/Y H:i')}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tiempo Total de Reparación:</span>
                    <span class="value">
                        @if($ticket->dias_transcurridos > 0)
                            {{$ticket->dias_transcurridos}} día{{$ticket->dias_transcurridos != 1 ? 's' : ''}}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Estado Final:</span>
                    <span class="value">
                        <span class="estado-badge">REPARADO</span>
                    </span>
                </div>
            </div>
            
            <div class="problema-detalle">
                <h4 style="margin-top: 0; color: #856404;">PROBLEMA REPORTADO:</h4>
                <p>{{$ticket->descripcion_problema}}</p>
            </div>
            
            @if($ticket->detalle_salida)
            <div class="solucion-detalle">
                <h4 style="margin-top: 0; color: #155724;">SOLUCIÓN APLICADA:</h4>
                <p>{{$ticket->detalle_salida}}</p>
            </div>
            @endif

            <div class="success-box">
                <h4>📋 RECOMENDACIONES PARA EL USUARIO</h4>
                <ul style="text-align: left; margin: 10px 0;">
                    <li>Verifique que el equipo funcione correctamente antes de firmar</li>
                    <li>Conserve este comprobante como respaldo de la entrega</li>
                    <li>Si presenta algún problema, comuníquese con el Departamento de Sistemas</li>
                    <li>Realice un uso adecuado del equipo para prolongar su vida útil</li>
                </ul>
            </div>
            
            <div class="firma-section">
                <h4 style="text-align: center;">CONFORMIDAD DE ENTREGA</h4>
                <p style="text-align: center;">Por medio de la presente, certifico que he recibido el equipo descrito en las condiciones especificadas y en perfecto funcionamiento.</p>
                
                <div class="firma-boxes">
                    <div class="firma-box">
                        <p><strong>ENTREGADO POR:</strong></p>
                        <p><small>Servicio Técnico</small></p>
                        <div class="firma-line"></div>
                        <p>{{auth()->user()->name ?? 'Personal Técnico'}}</p>
                        <p><small>Departamento de Sistemas</small></p>
                    </div>
                    
                    <div class="firma-box">
                        <p><strong>RECIBIDO POR:</strong></p>
                        <p><small>Usuario del Equipo</small></p>
                        <div class="firma-line"></div>
                        <p>{{$ticket->usuario->nombre_completo}}</p>
                        <p><small>{{$ticket->hospital->nombre}}</small></p>
                    </div>
                </div>
                
                <div style="margin-top: 30px; text-align: center; font-size: 12px; background: #d4edda; padding: 15px; border-radius: 5px;">
                    <p><strong>Fecha y hora de entrega:</strong> {{$ticket->fecha_devolucion_usuario->format('d/m/Y - H:i')}}</p>
                    <p><strong>Lugar de entrega:</strong> {{$ticket->hospital->nombre}}</p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>
                <strong>IMPORTANTE:</strong> Este documento certifica que el equipo ha sido reparado satisfactoriamente y devuelto al usuario en perfectas condiciones de funcionamiento.
                Conserve este comprobante como respaldo de la transacción.
            </p>
            <p style="margin-top: 10px;">
                Para consultas o soporte técnico, contacte al Departamento de Sistemas del Gobierno Autónomo Municipal de Sacaba.
            </p>
            <p style="margin-top: 10px;"><strong>Generado automáticamente por el Sistema de Seguimiento Técnico</strong></p>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
            🖨️ Imprimir Comprobante
        </button>
        <button onclick="descargarWord()" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 10px; font-weight: bold;">
            📥 Descargar en Word
        </button>
        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 10px; font-weight: bold;">
            ✖️ Cerrar
        </button>
    </div>
</body>
<script>
function descargarWord() {
    const comprobante = document.querySelector('.comprobante').outerHTML;
    
    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Comprobante Usuario - Ticket #{{ $ticket->id }}</title>
        </head>
        <body>
            ${comprobante}
        </body>
        </html>
    `;

    const blob = new Blob([html], { type: 'application/msword' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'comprobante_usuario_ticket_{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT) }}.doc';
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 100);
}
</script>
</html>