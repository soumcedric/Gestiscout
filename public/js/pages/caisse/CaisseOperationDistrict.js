$(function(){

    loadMvt();

//     let eventId;
//     let EventTitre;
//     GetRubrique();
   
  
//    TypeMouvement();

//    loadEventSelection();
//    $("#selevent").change(function(){
//     debugger
//     let value = $(this).val();
//     eventId = value;
//     $("#eventid").val(eventId);
//     EventTitre = $("#selevent option:selected").text();
//     $("#spantitre").text(EventTitre);
//     loadMvt(eventId);
//     GetSoldeCaisse(eventId);
//    });

//    $("#selrubrique").change(function(){
//     debugger
//         let value = $(this).val();
//         GetSousRubriqueByRubrique(value);
//    });
  
});

function OpenModal()
{
  
  $("#modaloperation").modal({
     backdrop:false
  });
  
}

function CloseModal()
{
  
  $("#modaloperation").modal('hide');
  
}

function TypeMouvement()
{
    debugger
   $.get("/ListeMvt",function(res){
    if(res)
    {
        var liste = JSON.parse(res.data)
        $("#ListeMvt").empty;
        $("#selmvt").append("<option value=0 selected>---sélectionner un type mouvement---</option>");
        $.each(liste, function(i,n){
            $("#selmvt").append("<option value="+n.Code+">"+n.Libelle+"</option>");
        });
    }
   });
}

function SaveMvt()
{
    debugger
    if(validation())
    {
        debugger
        let id = $("#eventid").val();
        let url="/SaveMvtEvent/"+id;
        let mvt = {
            type : $("#selmvt").val(),
            description : $("#txtdescription").val(),
            montant : parseInt($("#txtmontant").val()),
            date: $("#seldate").val(),
            sousrubriqueid : $("#selsousribrique").val()
        }

        if(mvt.type=="D")
            mvt.montant = -mvt.montant;
        
        $.post(url,{"data": mvt},function(res){
            debugger
            if(res.ok)
            {
                swal({
                    type:"success",
                    title:"Opération",
                    text: res.message
                },(function(){
                    loadMvt($("#eventid").val());
                    CloseModal();
                }));
            }
            else{
                swal({
                    type:"error",
                    title:"Opération",
                    text: res.message
                },(function(){
                  //  loadMvt();
                  CloseModal();
                }));
            }
        });
    }
}

// function validation()
// {
//     debugger
//     let valid = true;
//     //get all input values
//     let description = $("#txtdescription").val();
//     let montant = $("#txtmontant").val();
//     if(!description)
//     {
//             valid = false;
//             $("#txtdescription").addClass("form-control-danger");
//             $("#messagedescription").text("Veuillez entrer une description svp!");
//             $("#messagedescription").addClass("text-danger");
//     }
    
//     if(!montant || montant == 0)
//     {
//         valid = false;
//         $("#txtmontant").addClass("form-control-danger");
//         $("#messagemontant").text("Veuillez saisir un montant correct svp!");
//         $("#messagemontant").addClass("text-danger");
//     }

//     return valid;
// }

function loadMvt()
{
    debugger
    //alert("hello");
    var table = $("#tboperations").DataTable({
        destroy:true,
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
     
        columnDefs: [
            {
                targets: 0,
                visible: false
            }],
        ajax:{
            url:"/GetMouvementCaisse",
            type:"get",
            //  success:function(res)
            //     {
            //         debugger
            //         //idFormation = res.idFormation;
            //     }
        },
        columns: [
            { "data": "ID" },
            { "data": "SOUSRUBRIQUE" },
            { "data": "COMMENTAIRE" },
            { "data": "DATE_MOUVEMENT" },
            { "data": "MONTANT" }
            // { "data": "type" }
           
        ],
        // data: [],
        // rowCallback: function (row, data) { },
        // filter: true,
        // info: true,
        // ordering: false,
        // processing: false,
        // retrieve: true
    });

}

// function GetSoldeCaisse(id)
// {
//    $.get("/SoldeByEvent/"+id,function(res){
//     debugger
//     if(res.ok)
//     {
//         debugger
//         var solde = 0;
//         var debit;
//         const speed = 200;
//         let convertedsolde = parseInt(res.data);
       
//          $("#displaysolde").text(convertedsolde);
//     }
//    });
// }


// function loadEventSelection()
// {
//     debugger
//     $.get("/GetEvenements",function(res)
//     {
//         debugger
//         if(res)
//         {
//             $("#selevent").empty;
//             $("#selevent").append("<option selected>--sélectionner un évènement--</option>");
//             $.each(res.data, function(i,n){
//                 debugger
//                 $("#selevent").append("<option value="+n.id+">"+n.libelle+"</option>");
//             })

//         }
//     });
// }


// function selectEvent(id)
// {
//     debugger
//     let url = "/MouvementsByEvent/"+id;
//     //alert("hello");
//     var table = $("#tbevenements").DataTable({
//         destroy:true,
//         language: {
//             processing: "Traitement en cours...",
//             search: "Rechercher&nbsp;:",
//             lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
//             info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
//             infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
//             infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
//             infoPostFix: "",
//             loadingRecords: "Chargement en cours...",
//             zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
//             emptyTable: "Aucune donnée disponible dans le tableau",
//             paginate: {
//                 first: "Premier",
//                 previous: "Pr&eacute;c&eacute;dent",
//                 next: "Suivant",
//                 last: "Dernier"
//             }
//         },
     
//         // columnDefs: [
//         //     {
//         //         targets: 0,
//         //         visible: false
//         //     }],
//         ajax:{
//             url:url,
//             type:"get",
//             //  success:function(res)
//             //     {
//             //         debugger
//             //         //idFormation = res.idFormation;
//             //     }
//         },
//         columns: [
//             { "data": "id" },
//             { "data": "libelle" },
          
//         ],
//         // data: [],
//         // rowCallback: function (row, data) { },
//         // filter: true,
//         // info: true,
//         // ordering: false,
//         // processing: false,
//         // retrieve: true
//     });
// }

// function GetRubrique()
// {
//     debugger
//     $.get("/ListeRubrique",function(res){
//         if(res.ok)
//         {
//             $("#selrubrique").empty();
//             $("#selrubrique").append("<option value=0 selected>---Choisir une rubrique---</option>");
//             let liste = JSON.parse(res.data);
//             $.each(liste, function(i,n){
//                 debugger
//                 $("#selrubrique").append("<option value="+n.id+">"+n.Libelle+"</option>");
//             })
//         }
//     });
// }

// function GetSousRubriqueByRubrique(id)
// {
//     debugger
//     $.get("/ListeSousRubrique/"+id,function(res){
//         if(res.ok)
//         {
//             $("#selsousribrique").empty();
//             $("#selsousribrique").append("<option selected value=0>---Choisir une sous rubrique---</option>");
//             let liste = JSON.parse(res.data);
//             $.each(liste, function(i,n){
//                 debugger
//                 $("#selsousribrique").append("<option value="+n.id+">"+n.libelle+"</option>");
//             })
//         }
//     });
// }

// function GetStatutCaisse(id)
// {
//     $.get("StatutEvent/"+id,function(res){
//         if(res==1)
//         {
//             //cloture
//         }
//         else
//         {
//             //ouvert
//         }
//     });
// }