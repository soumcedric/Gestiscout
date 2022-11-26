$(function () {
    GetListAnneePastorale();
    GetListPeriode();
    GetListeRubrique();
    GetListeRubriqueJson();
    GetListeSousRubrique();
});

function GetListAnneePastorale()
{
   // alert("hello");
    $.get("/GetListeAnnee",function(res){
        debugger
        if(res){
            let defaultoption = "<option selected>---sélectionner une année pastorale---</option>";
            $("#selanneepastorale").empty;
            $("#selanneepastorale").append(defaultoption);
            let liste = JSON.parse(res.data);
            $.each(liste, function(i,n){
                $("#selanneepastorale").append("<option value="+n.id+">"+n.CodeAnnee+"</option>");
            });
        }
    });
}

function SavePeriode(){
    let periode = {
        datedebut : $("#datedebut").val(),
        datefin : $("#datefin").val(),
        code : $("#code").val(),
        anneepastorale : $("#selanneepastorale").val()
    };

    $.post("/SavePeriode",{"data": periode}, function(res){
        if(res)
        {
            swal({
                type:"success",
                title:"Période",
                text: res.message
            },function(){
                GetListPeriode();
            });
        }
    });
}

function GetListPeriode()
{
    debugger
    //alert("hello");
    var table = $("#tbPeriode").DataTable({
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
            url:"/GetListPeriode",
            type:"get",
            //  success:function(res)
            //     {
            //         debugger
            //        // idFormation = res.idFormation;
            //     }
        },
        columns: [
            { "data": "id" },
            { "data": "code" },
            { "data": "datedebut" },
            { "data": "datefin" },
            { "data": "etat" },
            { "data": "codeannee" }
           
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

function SaveRubrique(){
    let rubrique = {
        libelle : $("#txtlibelle").val(),
        code: $("#txtCode").val()
        
    };

    $.post("/SaveRubrique",{"data": rubrique}, function(res){
        if(res)
        {
            swal({
                type:"success",
                title:"Rubrique",
                text: res.message
            },function(){
                GetListeRubrique();
            });
        }
    });
}

function GetListeRubrique()
{
    debugger
    //alert("hello");
    var table = $("#tbRubrique").DataTable({
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
            url:"/GetRubriques",
            type:"get",
            //  success:function(res)
            //     {
            //         debugger
            //        // idFormation = res.idFormation;
            //     }
        },
        columns: [
            { "data": "id" },
            { "data": "code" },
            { "data": "libelle" },
            { "data": "type" },
            // { "data": "etat" },
            // { "data": "codeannee" }
           
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


function GetListeSousRubrique()
{
    debugger
    //alert("hello");
    var table = $("#tbSousRubrique").DataTable({
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
            url:"/GetSousRubriques",
            type:"get",
            //  success:function(res)
            //     {
            //         debugger
            //        // idFormation = res.idFormation;
            //     }
        },
        columns: [
            { "data": "id" },
            { "data": "code" },
            { "data": "libelle" },
            { "data": "rubrique" },
            // { "data": "etat" },
            // { "data": "codeannee" }
           
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

function GetListeRubriqueJson()
{
    $.get("/GetRubriques",function(res){
        $("#selrubrique").empty;
        let defaultoption = "<option selected>----sélectionner une rubrique---</option>";
        $("#selrubrique").append(defaultoption);
        $.each(res.data,function(i,n){
            $("#selrubrique").append("<option value="+n.id+">"+n.libelle+"</option>");
        });

    });
}


function SaveSousRubrique(){
    let rubrique = {
        libelle : $("#txtlibelle").val(),
        code: $("#txtCode").val(),
        rubrique: $("#selrubrique").val()
        
    };

    $.post("/SaveSousRubrique",{"data": rubrique}, function(res){
        if(res)
        {
            swal({
                type:"success",
                title:"Sous Rubrique",
                text: res.message
            },function(){
                GetListeSousRubrique();
            });
        }
    });
}