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
            padding: 10px;
            background-color: #f8f9fa;
        }
        
        .comprobante {
            max-width: 750px;
            margin: 0 auto;
            background: white;
            border: 2px solid #6495ED;
            border-radius: 10px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #6495ED, #87CEEB);
            color: white;
            padding: 10px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 12px;
        }

        .alert-reparado {
            background: #E3F2FD;
            border: 2px solid #6495ED;
            border-radius: 5px;
            padding: 8px;
            margin: 10px;
            text-align: center;
        }

        .alert-reparado h3 {
            margin: 0;
            color: #1565C0;
            font-size: 15px;
        }

        .content {
            padding: 15px;
        }

        /* === Diseño compacto en 2 columnas === */
        .info-container {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .ticket-info {
            flex: 1;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 4px solid #6495ED;
        }

        .ticket-info h4 {
            margin-top: 0;
            color: #1565C0;
            border-bottom: 2px solid #6495ED;
            padding-bottom: 5px;
            font-size: 14px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 2px;
            font-size: 12px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label { font-weight: bold; color: #495057; }
        .value { color: #212529; }

        .estado-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            background: #E3F2FD;
            color: #1565C0;
            border: 1px solid #BBDEFB;
        }

        .problema-detalle, .solucion-detalle {
            border-radius: 5px;
            padding: 8px 12px;
            margin: 8px 0;
            font-size: 12px;
        }

        .problema-detalle {
            background: #FFF9C4;
            border: 1px solid #FFEB3B;
        }

        .solucion-detalle {
            background: #E3F2FD;
            border: 1px solid #BBDEFB;
        }

        .success-box {
            background: #E3F2FD;
            border: 2px dashed #6495ED;
            border-radius: 10px;
            padding: 8px 12px;
            margin: 12px 0;
            font-size: 12px;
        }

        .success-box h4 {
            color: #1565C0;
            margin: 0 0 4px 0;
            font-size: 13px;
        }

        .firma-section {
            margin-top: 20px;
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
        }

        .firma-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .firma-box {
            width: 45%;
            text-align: center;
            font-size: 12px;
        }

        .firma-line {
            border-bottom: 1px solid #000;
            margin: 25px 0 6px 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 8px 20px;
            font-size: 10px;
            color: #6c757d;
            text-align: center;
            border-top: 2px solid #6495ED;
        }

        @media print {
            body { background: white; padding: 0; }
            .comprobante { border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="comprobante">
    <div class="header">
        <h1> COMPROBANTE DE DEVOLUCIÓN AL USUARIO</h1>
        <p>Ticket #{{ str_pad($ticket->id, 6) }}</p>
    </div>

    <div class="alert-reparado">
        <h3>EQUIPO REPARADO EXITOSAMENTE</h3>
        <p style="margin:0; font-size:12px;">El equipo ha sido revisado y entregado en funcionamiento.</p>
    </div>

    <div class="content">
        <div class="info-container">
            <!-- Columna izquierda -->
            <div class="ticket-info">
                <h4>INFORMACIÓN DEL EQUIPO</h4>
                <div class="info-row"><span class="label">Hospital:</span><span class="value">{{$ticket->hospital->nombre}}</span></div>
                <div class="info-row"><span class="label">Usuario:</span><span class="value">{{$ticket->usuario->nombre_completo}}</span></div>
                <div class="info-row"><span class="label">Cargo:</span><span class="value">{{ucfirst($ticket->usuario->cargo)}}</span></div>
                <div class="info-row"><span class="label">Equipo:</span><span class="value">{{$ticket->equipo->nombre}}</span></div>
                <div class="info-row"><span class="label">Descripción:</span><span class="value">{{$ticket->descripcion_equipo}}</span></div>
                <div class="info-row"><span class="label">Activo Nº:</span><span class="value" style="font-weight:bold;color:#6495ED;">{{$ticket->numero_activo}}</span></div>
            </div>

            <!-- Columna derecha -->
            <div class="ticket-info">
                <h4>FECHAS Y ESTADO</h4>
                <div class="info-row"><span class="label">Ingreso:</span><span class="value">{{$ticket->fecha_ingreso->format('d/m/Y')}}</span></div>
                <div class="info-row"><span class="label">Reparación:</span><span class="value">{{$ticket->fecha_finalizacion? $ticket->fecha_finalizacion->format('d/m/Y H:i'):'-'}}</span></div>
                <div class="info-row"><span class="label">Devolución:</span><span class="value">{{$ticket->fecha_devolucion_usuario->format('d/m/Y H:i')}}</span></div>
                <div class="info-row"><span class="label">Duración:</span>
                    <span class="value">
                        @if($ticket->dias_transcurridos > 0)
                            {{$ticket->dias_transcurridos}} día{{$ticket->dias_transcurridos!=1?'s':''}}
                        @else - @endif
                    </span>
                </div>
                <div class="info-row"><span class="label">Estado:</span><span class="value"><span class="estado-badge">REPARADO</span></span></div>
            </div>
        </div>

        <div class="problema-detalle">
            <h4>PROBLEMA REPORTADO:</h4>
            <p>{{$ticket->descripcion_problema}}</p>
        </div>

        @if($ticket->detalle_salida)
        <div class="solucion-detalle">
            <h4>SOLUCIÓN APLICADA:</h4>
            <p>{{$ticket->detalle_salida}}</p>
        </div>
        @endif

        <div class="firma-section">
            <h4 style="text-align:center;margin-bottom:8px;">CONFORMIDAD DE ENTREGA</h4>
            <p style="text-align:center;font-size:12px;">Certifico haber recibido el equipo descrito en condiciones óptimas.</p>

            <div class="firma-boxes">
                <div class="firma-box">
                    <p><strong>ENTREGADO POR</strong></p>
                    <div class="firma-line"></div>
                    <p>{{ auth()->user()->name ?? 'Personal Técnico' }}</p>
                    <p><small>Depto. de Sistemas</small></p>
                </div>
                <div class="firma-box">
                    <p><strong>RECIBIDO POR</strong></p>
                    <div class="firma-line"></div>
                    <p>{{$ticket->usuario->nombre_completo}}</p>
                    <p><small>{{$ticket->hospital->nombre}}</small></p>
                </div>
            </div>

            <div style="margin-top:12px; text-align:center; font-size:11px; background:#E3F2FD; padding:8px; border-radius:5px;">
                <small><strong>Fecha y hora de entrega:</strong> {{$ticket->fecha_devolucion_usuario->format('d/m/Y - H:i')}}</small>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>IMPORTANTE:</strong> Este documento certifica que el equipo ha sido reparado y entregado en perfectas condiciones.</p>
        <small>Departamento de Sistemas - Gobierno Autónomo Municipal de Sacaba</small>
    </div>
</div>

<div class="no-print" style="text-align:center;margin-top:12px;">
    <button onclick="window.print()" style="background:#6495ED;color:white;border:none;padding:7px 16px;border-radius:5px;font-weight:bold;cursor:pointer;">🖨️ Imprimir</button>
 <!--   <button onclick="descargarWord()" style="background:#007bff;color:white;border:none;padding:7px 16px;border-radius:5px;font-weight:bold;margin-left:6px;cursor:pointer;">📥 Word</button>  -->
    <button onclick="window.close()" style="background:#6c757d;color:white;border:none;padding:7px 16px;border-radius:5px;font-weight:bold;margin-left:6px;cursor:pointer;">✖️ Cerrar</button>
</div>

<script>
function descargarWord() {
    const comprobante = document.querySelector('.comprobante').outerHTML;
    const html = `<!DOCTYPE html><html><head><meta charset='utf-8'><title>Comprobante Usuario - Ticket #{{$ticket->id}}</title></head><body>${comprobante}</body></html>`;
    const blob = new Blob([html], {type: 'application/msword'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'comprobante_usuario_ticket_{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT) }}.doc';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script>
</body>
</html>
