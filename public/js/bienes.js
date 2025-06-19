/* =====================  ENDPOINTS  ===================== */
const urlTipos = "https://conrisk.space/get-objetos";
const urlCarac = "https://conrisk.space/get-tipo-caracteristicas";

/* ========================================================
   1. Cambiar OBJETO  ->  llena select#tipo y limpia card
   ======================================================== */
 
function objetoSeleccionado(sel){
    $("#tipo").empty();
    $("#caracteristicasContainer").html(
       '<p class="text-muted">Seleccione un tipo…</p>');
  
    if(!sel.value) return;
  
    $.get(urlTipos,{objeto: sel.value})
     .done(r=>{
        $("#tipo").append('<option value=\"\">Seleccione el Tipo</option>');
        r.forEach(t=>{
           $("#tipo").append(`<option value=\"${t.id}\">${t.tipo}</option>`);
        });
  
        /* Si venimos de EDIT y ya existe un tipo guardado… */
        const selected = sel.dataset.selectedTipo; // lo ponemos en la vista
        if (selected) {
            $("#tipo").val(selected);          // seleccionar
            cargarCaracteristicas(document.getElementById('tipo')); // ← llama
        }
     });
  }
/* ========================================================
   2. Cambiar TIPO  ->  construye card de características
   ======================================================== */
   function cargarCaracteristicas(sel){
    const cont = $("#caracteristicasContainer");
    cont.html('<p class="text-muted mb-0">Cargando características…</p>');
    if(!sel.value){
        cont.html('<p class="text-muted mb-0">Seleccione un tipo…</p>');
        return;
    }
  
    $.get(urlCarac, { tipo_id: sel.value })
     .done(resp=>{
        cont.empty();
        if(!resp.caracteristicas){
           cont.html('<p class="text-muted">Sin características.</p>');
           return;
        }
  
        // 1) Construir las filas
        resp.caracteristicas.split(',')
            .map(c=>c.trim())
            .forEach((c,i)=>{
                cont.append(`
                   <div class="row mb-2">
                     <div class="col-md-4">
                       <input type="text" readonly class="form-control"
                              name="caracteristicas[${i}][caracteristica]"
                              value="${c}">
                     </div>
                     <div class="col-md-8">
                       <input type="text" class="form-control"
                              name="caracteristicas[${i}][valor]"
                              placeholder="Valor de ${c}">
                     </div>
                   </div>`);
            });
  
        // 2) Rellenar los valores guardados
        if (typeof caracExistentes !== 'undefined') {
            Object.entries(caracExistentes).forEach(([car,val])=>{
                const fila = [...cont.find('input[readonly]')].find(
                             inp=>inp.value.trim()===car);
                if (fila){
                    $(fila).parent().next().find('input').val(val);
                }
            });
        }
     })
     .fail(()=>cont.html('<p class="text-danger">Error cargando características.</p>'));
  }
  
  /* Pre‑carga cuando entras en editar */
  $(window).on('load', ()=>{
      const sel = document.getElementById('tipo');
      if (sel && sel.value) cargarCaracteristicas(sel);
  });
  
/* ========================================================
   3. Valoraciones dinámicas
   ======================================================== */
function addValoracion() {
  const ts = Date.now();                       // id único
  const tr = `
    <tr>
      <td>+</td>
      <td><input class="form-control form-control-sm"
                 name="valoraciones[${ts}][descripcion]"></td>
      <td><input type="number" class="form-control form-control-sm"
                 name="valoraciones[${ts}][cant]"></td>
      <td><input type="number" class="form-control form-control-sm"
                 name="valoraciones[${ts}][valor_cotizado]"></td>
      <td><input type="number" class="form-control form-control-sm"
                 name="valoraciones[${ts}][valor_aprobado]"></td>
      <td>
        <button type="button"
                class="btn btn-sm btn-danger"
                onclick="removeDynamicRow(this)">🗑️
        </button>
      </td>
    </tr>`;
  $("#valoracionesTable tbody").append(tr);
}

function removeDynamicRow(btn) {
  $(btn).closest("tr").remove();
}

function eliminarExistente(btn, id) {
  // Registra el id para borrar en BD y elimina la fila
  const hidden = $("#eliminar_valoraciones");
  const ids    = hidden.val() ? hidden.val().split(",") : [];
  ids.push(id);
  hidden.val(ids.join(","));
  $(btn).closest("tr").remove();
}

/* ========================================================
   4. Modal de imagen
   ======================================================== */
function verImagen(url) {
  $("#imgModalSrc").attr("src", url);
  new bootstrap.Modal("#imgModal").show();
}

/* ========================================================
   5. Pre‑carga en edición
   ======================================================== */
$(document).ready(() => {
  const tipoSel = document.getElementById("tipo");
  if (tipoSel && tipoSel.value) cargarCaracteristicas(tipoSel);
});


window.addEventListener('load', ()=>{
    const sel = document.getElementById('tipo');
    if(sel && sel.value) cargarCaracteristicas(sel);
});