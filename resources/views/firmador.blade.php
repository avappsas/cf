<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Firmar PDsssssssF</title>
  <style>
    #pdfViewer {
      width: 100%;
      height: 100vh;
      overflow: auto;
      position: relative;
      background: #f2f2f2;
    }
    #firma-wrapper {
      position: absolute;
      display: none;
      z-index: 10;
    }
    #firma-wrapper img {
      width: 120px;
      cursor: move;
    }
  </style>
</head>
<body>
  <div id="pdfViewer"></div>

  <div id="firma-wrapper">
    <img id="firmaFlotante" src="{{ request('firma') }}" alt="Firma" />
    <button id="btnGuardar" class="btn btn-sm btn-success mt-1">Guardar Firma</button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
    const pdfUrl = "{{ request('file') }}";
    const idContrato = "{{ request('idContrato') }}";
    const idCuota = "{{ request('idCuota') }}";
    const viewer = document.getElementById('pdfViewer');
    const firmaWrapper = document.getElementById('firma-wrapper');
    const btnGuardar = document.getElementById('btnGuardar');
    const firmaImg = document.getElementById('firmaFlotante');
    let position = { x: 100, y: 100 };
    let pdfDoc = null;

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    async function renderPage(num) {
      const page = await pdfDoc.getPage(num);
      const viewport = page.getViewport({ scale: 1.5 });
      const canvas = document.createElement('canvas');
      canvas.width = viewport.width;
      canvas.height = viewport.height;
      canvas.style.display = 'block';
      canvas.setAttribute('data-page-number', num);
      const context = canvas.getContext('2d');
      await page.render({ canvasContext: context, viewport }).promise;
      viewer.appendChild(canvas);
    }

    async function loadPDF() {
      pdfDoc = await pdfjsLib.getDocument(pdfUrl).promise;
      for (let i = 1; i <= pdfDoc.numPages; i++) {
        await renderPage(i);
      }
      firmaWrapper.style.top = position.y + 'px';
      firmaWrapper.style.left = position.x + 'px';
      firmaWrapper.style.display = 'block';
    }

    firmaWrapper.onmousedown = function (e) {
      const offsetX = e.offsetX;
      const offsetY = e.offsetY;
      function mouseMoveHandler(e) {
        position.x = e.pageX - offsetX;
        position.y = e.pageY - offsetY;
        firmaWrapper.style.left = position.x + 'px';
        firmaWrapper.style.top = position.y + 'px';
      }
      function reset() {
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', reset);
      }
      document.addEventListener('mousemove', mouseMoveHandler);
      document.addEventListener('mouseup', reset);
    }

    btnGuardar.onclick = () => {
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

      if ([relX, relY, relW, relH].some(v => isNaN(v))) {
        alert('❌ Coordenadas inválidas');
        return;
      }

      const rutaRelativa = pdfUrl.replace(location.origin + '/storage/', '');

      const payload = {
        ruta: rutaRelativa,
        idContrato,
        idCuota,
        x_rel: relX,
        y_rel: relY,
        ancho_rel: relW,
        alto_rel: relH,
        pagina: page
      };

      console.log('📤 Enviando:', payload);

      fetch('/firmar-pdf-embed', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert('✅ Firma aplicada. PDF firmado: ' + data.archivo_firmado);
          window.close();
        } else {
          console.error(data);
          alert('❌ Error: ' + (data.error || ''));
        }
      })
      .catch(err => {
        console.error(err);
        alert('❌ Error inesperado');
      });
    }

    loadPDF();
  </script>
</body>
</html>
