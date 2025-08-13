@extends('layouts.app')

@section('content')
<input type="hidden" name="firma_path" value="{{ $rutaFirma }}">

<div class="container">
    <h4>📄 Posicionar Firma en el PDF</h4>

    <div id="pdf-container" style="position: relative;">
        <canvas id="pdf-canvas" style="border: 1px solid #ccc;"></canvas>

        <!-- Imagen de la firma -->
        <img src="{{ asset($rutaFirma) }}"
            id="firma"
            style="position: absolute; top: 100px; left: 100px; width: 120px; cursor: move; z-index: 10;" />
    </div>

    <form id="formFirmar" method="POST" action="{{ route('pdf.firmar') }}">
        @csrf
        <input type="hidden" name="x" id="firmaX">
        <input type="hidden" name="y" id="firmaY">
        <input type="hidden" name="pagina" value="1">
        <input type="hidden" name="pdf_id" value="{{ $pdf_id }}">

        <button class="btn btn-success mt-3">✅ Firmar y Descargar</button>
    </form>
</div>
@endsection

@section('scripts')
<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<script>
const url = "{{ asset('storage/pdfs/' . $pdf_id . '.pdf') }}"; // PDF almacenado
const canvas = document.getElementById("pdf-canvas");
const ctx = canvas.getContext("2d");
const firma = document.getElementById("firma");

let pdfDoc = null;

pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
    pdfDoc = pdfDoc_;
    return pdfDoc.getPage(1); // solo primera página
}).then(page => {
    const scale = 1.5;
    const viewport = page.getViewport({ scale: scale });

    canvas.height = viewport.height;
    canvas.width = viewport.width;

    const renderContext = {
        canvasContext: ctx,
        viewport: viewport,
    };

    page.render(renderContext);
});

// Hacer arrastrable la firma
let offsetX = 0, offsetY = 0;

firma.onmousedown = function(e) {
    e.preventDefault();
    offsetX = e.offsetX;
    offsetY = e.offsetY;

    document.onmousemove = function(ev) {
        firma.style.left = (ev.pageX - offsetX - canvas.offsetLeft) + "px";
        firma.style.top = (ev.pageY - offsetY - canvas.offsetTop) + "px";
    };

    document.onmouseup = function() {
        document.onmousemove = null;
        document.onmouseup = null;
    };
};

// Al enviar formulario, capturar posición
document.getElementById("formFirmar").onsubmit = function () {
    const rectCanvas = canvas.getBoundingClientRect();
    const rectFirma = firma.getBoundingClientRect();

    const x = rectFirma.left - rectCanvas.left;
    const y = rectFirma.top - rectCanvas.top;

    document.getElementById("firmaX").value = parseInt(x);
    document.getElementById("firmaY").value = parseInt(y);
};
</script>
@endsection