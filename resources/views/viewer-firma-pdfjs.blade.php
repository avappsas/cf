{{-- resources/views/viewer-firma-pdfjs.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firmar PDF</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
  #pdfViewer {
    width: 100%;
    height: 100vh;
    overflow: auto;
    background: #f2f2f2;
    display: flex;
    flex-direction: column;
    align-items: center; /* ⬅️ Centra horizontalmente */
    position: relative;
  }

  #pdfViewer canvas {
    margin: 20px auto;
    display: block;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
  }

  #firma-wrapper {
    position: absolute;
    display: none;
    z-index: 10;
  }

  #firma-wrapper img {
    width: 180px;
    cursor: grab;
    transition: width 0.2s ease;
  }

  #firma-handle {
  position: absolute;
  top: -20px;
  right: 0;
  background: #444;
  color: white;
  font-size: 12px;
  padding: 2px 6px;
  border-radius: 4px;
  cursor: grab;
  z-index: 15;
  user-select: none;
  }

</style>
</head>
<body>
  <div id="pdfViewer"></div> 
    <div id="firma-wrapper" style="text-align: center;">
      <div id="firma-handle" title="Arrastrar Firma"  >🖐️</div>
      <img id="firmaFlotante" src="{{ asset('storage/' . $firma) }}" style="width: 200px; display: block; margin: 0 auto;" /> <!-- Imagen de firma --> 
      <input type="range" id="firmaZoom" min="50" max="400" value="200" style="width: 200px; margin: 5px auto; display: block;" /><!-- Slider de zoom debajo --> 
      <button id="btnGuardar" class="btn btn-sm btn-success mt-2"> Guardar Firma </button>  <!-- Botón de guardar debajo del slider -->
    </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
    // (Tu código JavaScript aquí...)
  </script>
</body>
</html>



<script>
   // Variables
const urlParams = new URLSearchParams(window.location.search);
const pdfUrl = urlParams.get('file');
const idContrato = urlParams.get('idContrato');
const idCuota = urlParams.get('idCuota'); 
const idCargue = urlParams.get('idCargue');
const firmaSrc = "{{ $firma }}"; 
const viewer = document.getElementById('pdfViewer');
const firmaWrapper = document.getElementById('firma-wrapper');
const firmaImg = document.getElementById('firmaFlotante');
const zoomSlider = document.getElementById('firmaZoom');
const btnGuardar = document.getElementById('btnGuardar');

let position = { x: 100, y: 100 };
let pdfDoc = null;
let scale = 1.5;

// PDF.js config
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

// Cargar cada página del PDF
async function renderPage(num) {
  const page = await pdfDoc.getPage(num);
  const viewport = page.getViewport({ scale });

  const canvas = document.createElement('canvas');
  canvas.width = viewport.width;
  canvas.height = viewport.height;
  canvas.style.display = 'block';
  canvas.setAttribute('data-page-number', num);

  const context = canvas.getContext('2d');
  const renderContext = { canvasContext: context, viewport };

  await page.render(renderContext).promise;
  viewer.appendChild(canvas);
}

// Cargar PDF y mostrar firma
async function loadPDF() {
  if (!pdfUrl) {
    alert('❌ No se proporcionó un archivo PDF válido');
    return;
  }

  pdfDoc = await pdfjsLib.getDocument(pdfUrl).promise;
  for (let i = 1; i <= pdfDoc.numPages; i++) {
    await renderPage(i);
  }

  firmaWrapper.style.top = position.y + 'px';
  firmaWrapper.style.left = position.x + 'px';
  firmaWrapper.style.display = 'block';
}

// Zoom dinámico
zoomSlider.addEventListener('input', function () {
  firmaImg.style.width = `${this.value}px`;
});

// Arrastrar firma con clic sostenido
const firmaHandle = document.getElementById('firma-handle');

firmaHandle.addEventListener('mousedown', function (e) {
  e.preventDefault();

  const rect = firmaWrapper.getBoundingClientRect();
  const offsetX = e.clientX - rect.left;
  const offsetY = e.clientY - rect.top;

  function mover(ev) {
    position.x = ev.clientX - offsetX;
    position.y = ev.clientY - offsetY;
    firmaWrapper.style.left = position.x + 'px';
    firmaWrapper.style.top = position.y + 'px';
  }

  function soltar() {
    document.removeEventListener('mousemove', mover);
    document.removeEventListener('mouseup', soltar);
  }

  document.addEventListener('mousemove', mover);
  document.addEventListener('mouseup', soltar);
});

// Guardar posición de la firma
btnGuardar.onclick = function () {
  const canvasList = viewer.querySelectorAll('canvas');
  let targetCanvas = null;

  for (const canvas of canvasList) {
    const rect = canvas.getBoundingClientRect();
    const centerY = position.y + (firmaWrapper.offsetHeight / 2);

    if (centerY >= rect.top + window.scrollY && centerY <= rect.bottom + window.scrollY) {
      targetCanvas = canvas;
      break;
    }
  }

  if (!targetCanvas) {
    alert('❌ No se pudo determinar la página para firmar.');
    return;
  }

  const page = parseInt(targetCanvas.dataset.pageNumber);
  const rect = targetCanvas.getBoundingClientRect();

  const relX = (position.x - rect.left) / targetCanvas.width;
  const relY = (position.y - rect.top) / targetCanvas.height;
  const relW = firmaWrapper.offsetWidth / targetCanvas.width;
  const relH = firmaWrapper.offsetHeight / targetCanvas.height;

  fetch('/firmar-pdf-embed', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      ruta: pdfUrl.replace(location.origin + '/storage/', ''),
      idContrato,
      idCuota,
      idCargue,
      x_rel: relX,
      y_rel: relY,
      ancho_rel: relW,
      alto_rel: relH,
      pagina: page
    })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Cierra el modal del firmador (desde el iframe)
        const modalFirmador = window.parent.bootstrap.Modal.getInstance(window.parent.document.getElementById('modalPosicionarFirma'));
        if (modalFirmador) modalFirmador.hide();

        // Refresca el PDF del visor principal (modalDocUploadCuota)
        const pdfEmbed = window.parent.document.getElementById('pdfEmbed');
        if (pdfEmbed) {
          const srcBase = pdfEmbed.getAttribute('data-src-base') || pdfEmbed.getAttribute('src');
          pdfEmbed.setAttribute('src', srcBase.split('?')[0] + '?t=' + new Date().getTime());
        }
 
        // Mostrar notificación elegante
        window.parent.Swal.fire({
          icon: 'success',
          title: 'Firma aplicada',
          text: 'El documento ha sido firmado correctamente.',
          timer: 2500,
          showConfirmButton: false
        });
            setTimeout(() => {
            window.parent.location.reload(); // 🔁 Forzar recarga total
          }, 1600); // espera al mensaje

      } else {
        window.parent.Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo aplicar la firma.'
        });
      }
    })
    .catch(err => {
      console.error(err);
      alert('❌ Error inesperado');
    });
};

// Inicializar
loadPDF();

</script>