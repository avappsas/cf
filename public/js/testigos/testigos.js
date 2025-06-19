let dataToken = $('meta[name="csrf-token"]').attr('content');

function selectDep(e){
    
    let idDepartameto = e.value;
    let idMunicipio = $("#municipio").val();
    $.ajax({
        url: ('/ie/public/selectList'),
        type:'get',
        data: {_token:dataToken, tipo:1, idDepartameto:idDepartameto},
        success: function(data) {
            $("#id_municipio").empty();
            $("#id_municipio").append("<option value='0'> Seleccione una opcion</option>" );
            for(i=0; i<data.length; i++){
                $("#id_municipio").append("<option value='"+data[i].Mpio+"'> "+data[i].municipio+"</option>" );
                $("#id_municipio").prop( "disabled", false );
            }
        }
    });
}

function selectMuni(e){
    
    let idDepartameto = $("#id_departamento").val();
    let idMunicipio = e.value;
    $.ajax({
        url: ('/ie/public/selectList'),
        type:'get',
        data: {_token:dataToken, tipo:2, idDepartameto:idDepartameto,idMunicipio:idMunicipio},
        success: function(data) {
            $("#id_mesa").empty();
            $("#id_mesa").append("<option value=''>Seleccione una opcion</option>" );
            for(i=0; i<data.length; i++){
                $("#id_mesa").append("<option value='"+data[i].Zona+"'> "+data[i].Zona+"</option>" );
                $("#id_mesa").prop( "disabled", false );
            }
        }
    });
}

function selectZona(e){
    
    let idDepartameto = $("#id_departamento").val();
    let idMunicipio = $("#id_municipio").val();
    let idZona = e.value;
    $.ajax({
        url: ('/ie/public/selectList'),
        type:'get',
        data: {_token:dataToken, tipo:3, idDepartameto:idDepartameto,idMunicipio:idMunicipio,idZona:idZona},
        success: function(data) {
            $("#id_puesto").empty();
            $("#id_puesto").append("<option value='0'>Seleecciona una opcion</option>" );
            for(i=0; i<data.length; i++){
                $("#id_puesto").append("<option value='"+data[i].id+"'> "+data[i].Puesto+"</option>" );
                $("#id_puesto").prop( "disabled", false );
            }
        }
        
    });
}

function getMesaVot(){
    
    let idDepartameto = $("#id_departamento").val();
    let idMunicipio = $("#id_municipio").val();
    let idZona = $("#id_mesa").val();
    let idPuesto = $("#id_puesto").val();
    $.ajax({
        url: ('/ie/public/getMesaVot'),
        type:'get',
        data: {_token:dataToken, tipo:3, idDepartameto:idDepartameto,idMunicipio:idMunicipio,idZona:idZona,idPuesto:idPuesto},
        success: function(data) {
            $("#tablaTestigos").empty().html(data.tabla);
        }
        
    });
}

function getReportes(){
    
    let idDepartameto = $("#id_departamento").val();
    let idMunicipio = $("#id_municipio").val();
    let labe = '';
    let datas = '';
    $.ajax({
        url: ('/ie/public/getReportes'),
        type:'get',
        data: {_token:dataToken, tipo:1, idDepartameto:idDepartameto,idMunicipio:idMunicipio},
        success: function(data) {
            $("#tablaTestigos").empty().html(data.tabla);
            
            // $('#monitoreoCall').empty().html(response.tabla);
            // $('#miLlamadas').empty().html(response.tabla2);
            labe = data.columnas;
            datas = data.datos;
        }
        
    });

    // const ctx = document.getElementById('myChart').getContext('2d');
    // const myChart = new Chart(ctx, {
    //     type: 'doughnut',
    //     data: {
    //         labels: labe,
    //         datasets: [{
    //             label: '# of Votes',
    //             data: datas,
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.2)',
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 206, 86, 0.2)',
    //                 'rgba(75, 192, 192, 0.2)',
    //                 'rgba(153, 102, 255, 0.2)',
    //                 'rgba(255, 159, 64, 0.2)'
    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)',
    //                 'rgba(75, 192, 192, 1)',
    //                 'rgba(153, 102, 255, 1)',
    //                 'rgba(255, 159, 64, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });
}

function getPuestDeZona(departamento,municipio,zona){
    
    $.ajax({
        url: ('/ie/public/getPuestDeZona'),
        type:'get',
        data: {_token:dataToken, tipo:1, idDepartameto:departamento,idMunicipio:municipio,idZona:zona},
        success: function(data) {            
            $('#divModal').empty().html(data.tabla);
            $('#myModal').modal('show');
            // $('#monitoreoCall').empty().html(response.tabla);
            // $('#miLlamadas').empty().html(response.tabla2);
        }
        
    });
}

function getMesasDePuesto(departamento,municipio,zona,Pto,nomPuesto){
    console.log(nomPuesto)
    $.ajax({
        url: ('/ie/public/getMesasDePuesto'),
        type:'get',
        data: {_token:dataToken, tipo:1, idDepartameto:departamento,idMunicipio:municipio,idZona:zona,Pto:Pto,nomPuesto:nomPuesto},
        success: function(data) {            
            $('#divModal2').empty().html(data.tabla);
            $('#myModal2').modal('show');
            // $('#monitoreoCall').empty().html(response.tabla);
            // $('#miLlamadas').empty().html(response.tabla2);
        }
        
    });
}