<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprobante de Entrega - Activos Fijos - Ticket #{{$ticket->id}}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            line-height: 1.6;
        }
        
        .comprobante {
            max-width: 850px;
            margin: 0 auto;
            background: white;
            border: 3px solid #ffc107;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #212529;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 4px solid #ff9800;
        }
        
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        
        .header p {
            margin: 5px 0;
            opacity: 0.95;
            font-size: 14px;
        }
        
        .header .ticket-number {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            padding: 8px 15px;
            background: rgba(255,255,255,0.3);
            border-radius: 5px;
            display: inline-block;
        }
        
        .alert-baja {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
            border: 3px dashed #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 25px;
            text-align: center;
        }
        
        .alert-baja h3 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 22px;
            text-transform: uppercase;
        }
        
        .alert-baja p {
            margin: 0;
            color: #856404;
            font-size: 16px;
            font-weight: 600;
        }
        
        .content {
            padding: 30px;
        }
        
        .section-title {
            color: #856404;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 3px solid #ffc107;
            padding-bottom: 10px;
            margin: 25px 0 15px 0;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title::before {
            content: '▶';
            color: #ffc107;
        }
        
        .ticket-info {
            background: linear-gradient(to right, #fff9e6, #ffffff);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #ffc107;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px dotted #dee2e6;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .label {
            font-weight: bold;
            color: #495057;
            flex: 0 0 250px;
        }
        
        .value {
            color: #212529;
            flex: 1;
            text-align: right;
        }
        
        .highlight-value {
            font-size: 20px;
            font-weight: bold;
            color: #dc3545;
            background: #fff3cd;
            padding: 5px 15px;
            border-radius: 5px;
            display: inline-block;
        }
        
        .estado-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .problema-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .problema-box h4 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 16px;
        }
        
        .problema-box p {
            margin: 0;
            color: #212529;
            line-height: 1.8;
        }
        
        .diagnostico-box {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .diagnostico-box h4 {
            margin: 0 0 10px 0;
            color: #721c24;
            font-size: 16px;
        }
        
        .diagnostico-box p {
            margin: 0;
            color: #212529;
            line-height: 1.8;
        }
        
        .warning-box {
            background: linear-gradient(to right, #fff3cd, #ffe69c);
            border: 3px dashed #ffc107;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .warning-box h4 {
            color: #856404;
            margin: 0 0 15px 0;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .warning-box ul {
            margin: 10px 0 0 20px;
            color: #212529;
        }
        
        .warning-box li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .firma-section {
            margin-top: 40px;
            border-top: 3px solid #ffc107;
            padding-top: 30px;
        }
        
        .firma-section h4 {
            text-align: center;
            color: #856404;
            font-size: 18px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .firma-section > p {
            text-align: center;
            color: #6c757d;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .firma-boxes {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-top: 30px;
        }
        
        .firma-box {
            flex: 1;
            text-align: center;
        }
        
        .firma-box p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .firma-box strong {
            font-size: 16px;
            color: #212529;
        }
        
        .firma-box small {
            color: #6c757d;
            display: block;
            margin-top: 5px;
        }
        
        .firma-line {
            border-bottom: 2px solid #212529;
            margin: 50px 20px 10px 20px;
        }
        
        .entrega-info {
            background: linear-gradient(to right, #fff9e6, #fff3cd);
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }
        
        .entrega-info p {
            margin: 8px 0;
            font-size: 14px;
        }
        
        .entrega-info strong {
            color: #856404;
            font-size: 15px;
        }
        
        .footer {
            background: linear-gradient(to right, #f8f9fa, #fff3cd);
            padding: 20px 30px;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            border-top: 3px solid #ffc107;
        }
        
        .footer p {
            margin: 8px 0;
            line-height: 1.6;
        }
        
        .footer strong {
            color: #856404;
        }
        
        .no-print {
            text-align: center;
            margin-top: 30px;
            padding-bottom: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 8px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .btn-print {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: #212529;
        }
        
        .btn-word {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-close {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .comprobante {
                border: none;
                box-shadow: none;
                max-width: 100%;
            }
            
            .no-print {
                display: none;
            }
            
            .header {
                background: #ffc107 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="comprobante">
        <div class="header">
            <div class="icon">📦</div>
            <h1>Comprobante de Entrega a Activos Fijos</h1>
            <p>Sistema de Seguimiento Técnico</p>
            <p>Gobierno Autónomo Municipal de Sacaba</p>
            <div class="ticket-number">Ticket #{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</div>
        </div>
        
        <div class="alert-baja">
            <h3>⚠️ EQUIPO DADO DE BAJA - NO REPARABLE</h3>
            <p>Este equipo ha sido evaluado técnicamente y se determina que NO es factible su reparación</p>
        </div>
        
        <div class="content">
            <!-- INFORMACIÓN DEL EQUIPO -->
            <h3 class="section-title">Información del Equipo</h3>
            <div class="ticket-info">
                <div class="info-row">
                    <span class="label">Hospital/Centro de Salud:</span>
                    <span class="value"><strong>{{$ticket->hospital->nombre}}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Tipo de Centro:</span>
                    <span class="value">{{ucfirst($ticket->hospital->tipo)}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Usuario Solicitante:</span>
                    <span class="value"><strong>{{$ticket->usuario->nombre_completo}}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Cargo del Usuario:</span>
                    <span class="value">{{ucfirst($ticket->usuario->cargo)}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Contacto:</span>
                    <span class="value">{{$ticket->usuario->user->email}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tipo de Equipo:</span>
                    <span class="value"><strong>{{$ticket->equipo->nombre}}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Descripción del Equipo:</span>
                    <span class="value">{{$ticket->descripcion_equipo}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Número de Activo:</span>
                    <span class="value"><span class="highlight-value">{{$ticket->numero_activo}}</span></span>
                </div>
            </div>

            <!-- FECHAS Y TIEMPOS -->
            <h3 class="section-title">Fechas y Tiempos de Procesamiento</h3>
            <div class="ticket-info">
                <div class="info-row">
                    <span class="label">Fecha de Ingreso al Servicio Técnico:</span>
                    <span class="value">{{$ticket->fecha_ingreso->format('d/m/Y')}}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de Evaluación/Baja:</span>
                    <span class="value">
                        @if($ticket->fecha_finalizacion)
                            {{$ticket->fecha_finalizacion->format('d/m/Y H:i')}}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de Entrega a Activos Fijos:</span>
                    <span class="value"><strong>{{$ticket->fecha_entrega->format('d/m/Y H:i')}}</strong></span>
                </div>
                <div class="info-row">
                    <span class="label">Tiempo Total de Evaluación:</span>
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
                        <span class="estado-badge">DADO DE BAJA</span>
                    </span>
                </div>
            </div>
            
            <!-- PROBLEMA REPORTADO -->
            <h3 class="section-title">Problema Reportado</h3>
            <div class="problema-box">
                <h4>🔧 Descripción del problema inicial:</h4>
                <p>{{$ticket->descripcion_problema}}</p>
            </div>
            
            <!-- DIAGNÓSTICO Y MOTIVO DE BAJA -->
            @if($ticket->detalle_salida)
            <h3 class="section-title">Diagnóstico y Motivo de Baja</h3>
            <div class="diagnostico-box">
                <h4>⚠️ Evaluación técnica y justificación:</h4>
                <p>{{$ticket->detalle_salida}}</p>
            </div>
            @endif

            <!-- INSTRUCCIONES PARA ACTIVOS FIJOS -->
            <h3 class="section-title">Instrucciones para Activos Fijos</h3>
            <div class="warning-box">
                <h4>📋 Procedimientos a seguir:</h4>
                <ul>
                    <li><strong>Registro administrativo:</strong> Actualizar el estado del equipo en el sistema de inventario</li>
                    <li><strong>Documentación:</strong> Archivar este comprobante junto con el expediente del equipo</li>
                    <li><strong>Actualización de inventario:</strong> Modificar registros del hospital de origen</li>
                    <li><strong>Opciones de disposición:</strong> Evaluar venta como chatarra, donación o disposición final según normativa</li>
                    <li><strong>Notificación:</strong> Informar al hospital correspondiente sobre la baja del equipo</li>
                    <li><strong>Seguimiento:</strong> Generar reporte de equipos dados de baja para control administrativo</li>
                </ul>
            </div>
            
            <!-- FIRMAS -->
            <div class="firma-section">
                <h4>✍️ Conformidad de Entrega a Activos Fijos</h4>
                <p>Por medio de la presente, se hace entrega formal del equipo descrito para su gestión administrativa correspondiente.</p>
                
                <div class="firma-boxes">
                    <div class="firma-box">
                        <p><strong>ENTREGADO POR:</strong></p>
                        <small>Servicio Técnico - Sistemas</small>
                        <div class="firma-line"></div>
                        <p>{{auth()->user()->name ?? 'Personal Técnico'}}</p>
                        <small>Departamento de Sistemas<br>Gobierno Autónomo Municipal de Sacaba</small>
                    </div>
                    
                    <div class="firma-box">
                        <p><strong>RECIBIDO POR:</strong></p>
                        <small>Departamento de Activos Fijos</small>
                        <div class="firma-line"></div>
                        <p>Nombre y Firma</p>
                        <small>Responsable de Activos Fijos<br>Gobierno Autónomo Municipal de Sacaba</small>
                    </div>
                </div>
                
                <div class="entrega-info">
                    <p><strong>Fecha y hora de entrega:</strong> {{$ticket->fecha_entrega->format('d/m/Y - H:i')}}</p>
                    <p><strong>Lugar de entrega:</strong> Departamento de Activos Fijos - GAMS</p>
                    <p><strong>Hospital de origen:</strong> {{$ticket->hospital->nombre}}</p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>
                <strong>IMPORTANTE:</strong> Este documento certifica que el equipo ha sido evaluado técnicamente por el Departamento de Sistemas 
                y se determina su condición de NO REPARABLE. El equipo debe ser gestionado administrativamente por el Departamento de Activos Fijos 
                del Gobierno Autónomo Municipal de Sacaba conforme a los procedimientos establecidos.
            </p>
            <p style="margin-top: 12px;">
                Para consultas técnicas contactar al Departamento de Sistemas. 
                Para consultas administrativas contactar al Departamento de Activos Fijos.
            </p>
            <p style="margin-top: 12px;"><strong>Generado automáticamente por el Sistema de Seguimiento Técnico - GAMS</strong></p>
        </div>
    </div>
    
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">
            🖨️ Imprimir Comprobante
        </button>
        <button onclick="descargarWord()" class="btn btn-word">
            📥 Descargar en Word
        </button>
        <button onclick="window.close()" class="btn btn-close">
            ✖️ Cerrar Ventana
        </button>
    </div>

<script>
function descargarWord() {
    const comprobante = document.querySelector('.comprobante').outerHTML;
    
    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Comprobante Activos Fijos - Ticket #{{ $ticket->id }}</title>
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
    a.download = 'comprobante_activos_fijos_ticket_{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT) }}.doc';
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 100);
}
</script>
</body>
</html>