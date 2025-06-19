function ramoSeleccionado(e) {
    var slcchangedpt = e.value;

    // Limpiar los select antes de llenarlos con los nuevos datos
    $("#aseguradora").empty();
    $("#causa").empty();

    $.get("https://conrisk.space/get-aseguradoras?ramo_id=" + slcchangedpt, function(response, state) {
        // Recorrer y actualizar el select de aseguradoras
        for (var i = 0; i < response.aseguradoras.length; i++) {
            $("#aseguradora").append(
                "<option value='" + response.aseguradoras[i].id + "'>" +
                response.aseguradoras[i].aseguradora +
                "</option>"
            );
        }

        // Recorrer y actualizar el select de causas
        for (var j = 0; j < response.casuas.length; j++) {
            $("#causa").append(
                "<option value='" + response.casuas[j].id + "'>" +
                response.casuas[j].causa +
                "</option>"
            );
        }
    });
}

// function ramoSeleccionado(sel) { 
 
//     const card  = $('#roboCard');                // jQuery
//     const ramoId = Number(sel.value.trim());     // 4

//     if (ramoId === 4){
//         card.removeClass('d-none').show();       // quita clase y quita display:none
//     } else {
//         card.addClass('d-none').hide();          // la oculta de nuevo
//     }


//     /* ========= 2. Limpiar selects ========= */
//     $('#aseguradora').empty();
//     $('#causa').empty();

//     if (!ramoId) return;   // nada seleccionado

//     /* ========= 3. Cargar aseguradoras y causas vía AJAX ========= */
//     $.get('https://conrisk.space/get-aseguradoras', { ramo_id: ramoId })
//       .done(resp => {
//           // Aseguradoras
//           if (resp.aseguradoras) {
//               resp.aseguradoras.forEach(a => {
//                   $('#aseguradora').append(
//                       `<option value="${a.id}">${a.aseguradora}</option>`
//                   );
//               });
//           }

//           // Causas
//           if (resp.causas) {                       // <- arreglo corregido
//               resp.causas.forEach(c => {
//                   $('#causa').append(
//                       `<option value="${c.id}">${c.causa}</option>`
//                   );
//               });
//           }
//       })
//       .fail(() => console.error('Error cargando aseguradoras/causas'));
// }

// /* ========= 4. Ejecutar al cargar la página (modo editar) ========= */
 
 
// $(window).on('load', () => {
//     const sel = document.getElementById('ramo');
//     if (sel) ramoSeleccionado(sel);
// });