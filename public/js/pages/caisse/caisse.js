$(function(){
    //alert("hello");
    GetSoldeCaisse();
    loadMvt();
  // TypeMouvement();
   loadEvenement();
   loadEventSelection();
   $("#selevent").change(function(){
    debugger
    let value = $(this).val();
    selectEvent(value);
   });
  
});

function OpenModal()
{
 
  $("#modaloperation").modal({
     backdrop:false
  });
  
}

function TypeMouvement()
{
   $.get("/ListeMvt",function(res){
    if(res)
    {
        var liste = JSON.parse(res.data)
        $("#ListeMvt").empty;
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
        let mvt = {
            type : $("#selmvt").val(),
            description : $("#txtdescription").val(),
            montant : parseInt($("#txtmontant").val()),
            date: $("#seldate").val()
        }

        if(mvt.type=="D")
            mvt.montant = -mvt.montant;
        
        $.post("/SaveMvt",{"data": mvt},function(res){
            debugger
            if(res)
            {
                swal({
                    type:"success",
                    title:"Opération",
                    text: res.message
                },(function(){
                    loadMvt();
                }));
            }
        });
    }
}

function validation()
{
    debugger
    let valid = true;
    //get all input values
    let description = $("#txtdescription").val();
    let montant = $("#txtmontant").val();
    if(!description)
    {
            valid = false;
            $("#txtdescription").addClass("form-control-danger");
            $("#messagedescription").text("Veuillez entrer une description svp!");
            $("#messagedescription").addClass("text-danger");
    }
    
    if(!montant || montant == 0)
    {
        valid = false;
        $("#txtmontant").addClass("form-control-danger");
        $("#messagemontant").text("Veuillez saisir un montant correct svp!");
        $("#messagemontant").addClass("text-danger");
    }

    return valid;
}

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
     
        // columnDefs: [
        //     {
        //         targets: 0,
        //         visible: false
        //     }],
        ajax:{
            url:"/MouvementsByEvent",
            type:"get",
             success:function(res)
                {
                    debugger
                    //idFormation = res.idFormation;
                }
        },
        columns: [
            { "data": "id" },
            { "data": "description" },
            { "data": "date_mvt" },
            { "data": "montant" },
            { "data": "type" }
           
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

function GetSoldeCaisse()
{
   $.get("/Solde",function(res){
    debugger
    if(res)
    {
        debugger
        var solde = 0;
        var debit;
        const speed = 200;
        let convertedsolde = parseInt(res.solde);
        // if(convertedsolde<0)
        // {
        //     debit = true;
        //     solde = (-1)*convertedsolde;
        // }
            
        //  const counters = solde.toString();
        // // var count $("#displaysolde").val();
        //  let upto = 0;
        //  count.innerHtml=++upto;
         
         $("#displaysolde").text(convertedsolde);
    }
   });
}


function loadEvenement()
{
    debugger
    //alert("hello");
    var table = $("#tbevenements").DataTable({
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
     
        // columnDefs: [
        //     {
        //         targets: 0,
        //         visible: false
        //     }],
        ajax:{
            url:"/GetEvenements",
            type:"get",
            //  success:function(res)
            //     {
            //         debugger
            //         //idFormation = res.idFormation;
            //     }
        },
        columns: [
            { "data": "id" },
            { "data": "libelle" },
          
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


function SaveEvent()
{
    debugger
    // if(validation())
    // {
        debugger
        let event = {
            libelle : $("#txtlibelle").val(),
            
        }

        
        $.post("/SaveEvent",{"data": event},function(res){
            debugger
            if(res)
            {
                swal({
                    type:"success",
                    title:"Opération",
                    text: res.message
                },(function(){
                    loadEvenement();
                }));
            }
        });
    // }
}


function loadEventSelection()
{
    $.get("/GetEvenements",function(res)
    {
        debugger
        if(res)
        {
            $("#selevent").empty;
            $("#selevent").append("<option selected>--sélectionner un évènement--</option>");
            $.each(res.data, function(i,n){
                $("#selevent").append("<option value="+n.id+">"+n.libelle+"</option>");
            })

        }
    });
}


function selectEvent(id)
{
    debugger
    let url = "/MouvementsByEvent/"+id;
    //alert("hello");
    var table = $("#tbevenements").DataTable({
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
     
        // columnDefs: [
        //     {
        //         targets: 0,
        //         visible: false
        //     }],
        ajax:{
            url:url,
            type:"get",
            //  success:function(res)
            //     {
            //         debugger
            //         //idFormation = res.idFormation;
            //     }
        },
        columns: [
            { "data": "id" },
            { "data": "libelle" },
          
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