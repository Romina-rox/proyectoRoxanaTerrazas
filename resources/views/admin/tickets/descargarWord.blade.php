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