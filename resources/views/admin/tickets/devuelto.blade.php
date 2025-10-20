<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>romina - Ticket #{{$ticket->id}}</title>
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
            border: 2px solid #007bff;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .ticket-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        }
        
        .estado-reparado {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .estado-baja {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .problema-detalle {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .solucion-detalle {
            background: #d1ecf1;
            border: 1px solid #b6d7ff;
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
            <h1>SERVICIO TECNICO</h1>
            <p>Sistema de Seguimiento Técnico - Gobierno Autónomo Municipal de Sacaba</p>
            <p>Ticket #{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</p>
        </div>
        
        <div class="content">
            <div class="ticket-info">
                <div class="info-row">
                    <span class="label">Hospital:</span>
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
                    <span class="label">Tipo de Equipo:</span>
                    <span class="value">{{$ticket->equipo->nombre}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Descripción del Equipo:</span>
                    <span class="value">{{$ticket->descripcion_equipo}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Número de Activo:</span>
                    <span class="value"><strong>{{$ticket->numero_activo}}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de Ingreso:</span>
                    <span class="value">{{$ticket->fecha_ingreso->format('d/m/Y')}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de Entrega:</span>
                    <span class="value">{{$ticket->fecha_entrega->format('d/m/Y H:i')}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Estado Final:</span>
                    <span class="value">
                        <span class="estado-badge {{$ticket->estado == 'reparado' ? 'estado-reparado' : 'estado-baja'}}">
                            {{$ticket->estado_humano}}
                        </span>
                    </span>
                </div>
            </div>
            
            <div class="problema-detalle">
                <h4 style="margin-top: 0; color: #856404;">PROBLEMA REPORTADO:</h4>
                <p>{{$ticket->descripcion_problema}}</p>
            </div>
            
            @if($ticket->detalle_salida)
            <div class="solucion-detalle">
                <h4 style="margin-top: 0; color: #0c5460;">
                    {{$ticket->estado == 'reparado' ? 'SOLUCIÓN APLICADA:' : 'DIAGNÓSTICO FINAL:'}}
                </h4>
                <p>{{$ticket->detalle_salida}}</p>
            </div>
            @endif
            
            <div class="firma-section">
                <h4>CONFORMIDAD DE ENTREGA</h4>
                <p>Por medio de la presente, certifico que he recibido el equipo descrito anteriormente en las condiciones especificadas.</p>
                
                <div class="firma-boxes">
                    <div class="firma-box">
                        <p><strong>ENTREGADO POR:</strong></p>
                        <div class="firma-line"></div>
                        <p>{{$ticket->entregado_por}}</p>
                        <p><small>Personal Técnico</small></p>
                    </div>
                    
                    <div class="firma-box">
                        <p><strong>RECIBIDO POR:</strong></p>
                        <div class="firma-line"></div>
                        <p>{{$ticket->recibido_por}}</p>
                        <p><small>{{$ticket->hospital->nombre}}</small>
                    </div>
                </div>
                
                <div style="margin-top: 30px; text-align: center; font-size: 12px;">
                    <p><strong>Fecha y hora de entrega:</strong> {{$ticket->fecha_entrega->format('d/m/Y - H:i')}}</p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>
                Este documento certifica la entrega del equipo y debe ser conservado como comprobante. 
                Para consultas contactar al Departamento de Sistemas del Gobierno Autónomo Municipal de Sacaba.
            </p>
            <p><strong>Generado automáticamente por el Sistema de Seguimiento Técnico</strong></p>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimir Comprobante
        </button>
        <button onclick="descargarWord()" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            📥 Descargar en Word
        </button>
        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            ✖️ Cerrar
        </button>

    </div>
</body>
<script>
function descargarWord() {
    // Obtener el contenido del comprobante
    const comprobante = document.querySelector('.comprobante').outerHTML;
    
    // Crear un HTML básico compatible con Word
    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Comprobante Ticket #{{ $ticket->id }}</title>
        </head>
        <body>
            ${comprobante}
        </body>
        </html>
    `;

    // Crear un Blob y descargar
    const blob = new Blob([html], { type: 'application/msword' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'comprobante_ticket_{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT) }}.doc';
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 100);
}
</script>
</html>