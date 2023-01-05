$(document).ready(function(){
   
});


function UploadFile()
{
    debugger
    var table = $("#tbjeune").DataTable({
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher&nbsp;:",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            }
        },
        columns: [
            { "data": "NOM" },
            { "data": "PRENOMS" },
            { "data": "DOB" },
            { "data": "GENRE" },
            { "data": "BRANCHE" },
            { "data": "HABITATION" },
            { "data": "OCCUPATION" },
            { "data": "TELEPHONE" },
            { "data": "PERE" },
            { "data": "NUMPERE" },
            { "data": "MERE" },
            { "data": "NUMMERE" }
        ],
        // columnDefs: [
        //     {
        //         targets: 0,
        //         visible: false
        //     }],
        data: [],
        rowCallback: function (row, data) { },
        filter: true,
        info: true,
        ordering: false,
        processing: false,
        retrieve: true
    });
    var formData = new FormData();
    let filename = $('input[type=file]')[0].files[0];
    if(filename == undefined)
    {
        swal({
            type:"error",
            title:"Importation Fichier",
            text:"Veuillez uploader un fichier svp!"
        });
    }
    else
    {

        formData.append('file',  $('input[type=file]')[0].files[0],filename.name);
        $.ajax({
            type:"POST",
            url:"/Import",
            processData:false,
            contentType:false,
            data:formData,
            success:function(res)
            {
                debugger
                let liste = JSON.parse(res);
                $.each(liste, function(i,n){
                    table.rows.add([{
                        "NOM" :n.NOM,
                        "PRENOMS" :n.PRENOMS,
                        "DOB" :n.DOB,
                        "GENRE" :n.GENRE,
                        "BRANCHE" :n.BRANCHE,
                       "HABITATION" :n.HABITATION,
                        "OCCUPATION" :n.OCCUPATION,
                        "TELEPHONE" :n.TELEPHONE,
                       "PERE" :n.PERE,
                       "NUMPERE" :n.NUMPERE,
                       "MERE" :n.MERE,
                        "NUMMERE" :n.NUMMERE
   
                   }]).draw();
                });
               
            },
            error: function(res)
            {

            }
        });
    }
    
}


function SaveJeune()
{
    debugger
    table = $("#tbjeune").DataTable();
    var rows = table.rows().data();
    var jeunes = [];
    $.each(rows, function(n,i){
        var jeune ={
            "NOM" : i.NOM,
            "PRENOMS": i.PRENOMS,
            "DOB": i.DOB,
            "GENRE" : i.GENRE,
            "BRANCHE": i.BRANCHE,
            "OCCUPATION": i.OCCUPATION,
            "HABITATION": i.HABITATION,
            "PERE" : i.PERE,
            "NUMPERE": i.NUMPERE,
            "MERE" : i.MERE,
            "NUMMERE" : i.NUMMERE,
            "TELEPHONE": i.TELEPHONE
        };
        jeunes.push(jeune);
    });
    $.ajax({
        type: "POST",
        url :"/ImportData",
        // processData:false,
        // contentType:false,
        data: {"value" : JSON.stringify(jeunes)},
        success:function(res)
        {
            debugger
            if(res.ok)
            {
                swal({
                    type:"success",
                    title: "Importation",
                    text: res.message
                },function(){
                    window.location="ListeJeunes";
                });
            }
            else
            {
                swal({
                    type:"error",
                    title: "Importation",
                    text: res.message
                },function(){
                   // window.location="ListeJeunes";
                });
            }
        },
        error:function(res)
        {
            
        }
    });
}