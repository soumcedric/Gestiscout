var idSession = null;
$(function(){

    $("#spanlieu").hide();

    GetFormation();
    ListeSessions();
    //charger la liste des formations
    function GetFormation(){
        $.get("/GetListeFormation",function(res){
           
            $("#selstage").empty();
            var defaultline="<option value=0 selected>---Choisir une formation---</option>";
            $("#selstage").append(defaultline);

            var liste = JSON.parse(res.data);
            $.each(liste,function(i,n) {
                debugger
                var option = "<option value="+n.id+">"+n.libelle+"</option>";
                $("#selstage").append(option);
            });
        });
    }


    $("#btnsave").click(function(){
        debugger
        $("#spanlieu").hide(); $("#spanlieu").text("");
        $("#spandatedebut").hide(); $("#spandatedebut").text(""); 
        $("#spandatefin").hide(); $("#spandatefin").text(""); 
        $("#spanstage").hide(); $("#spanstage").text(""); 
      

        var sessionFormation = {
            DateDebut : $("#txtdatedebut").val(),
            DateFin : $("#txtdatefin").val(),
            Lieu : $("#txtlieu").val(),
            DirecteurStage : $("#txtdirecteurstage").val(),
            SelectedStage : $("#selstage").val()
            }

        if(sessionFormation.Lieu == "" || sessionFormation.Lieu == null || sessionFormation.Lieu == 'undefined' ) { $("#spanlieu").show(); $("#spanlieu").text("* Veuillez renseigner le lieu du stage"); }
        if(sessionFormation.DateDebut == "" || sessionFormation.DateDebut == null || sessionFormation.DateDebut == 'undefined' ) { $("#spandatedebut").show(); $("#spandatedebut").text("* Veuillez renseigner la date debut"); }
        if(sessionFormation.DateFin == "" || sessionFormation.DateFin == null || sessionFormation.DateFin == 'undefined' ) { $("#spandatefin").show(); $("#spandatefin").text("* Veuillez renseigner la date de fin"); }
        //if(sessionFormation.DateFin == "" || sessionFormation.DateFin == null || sessionFormation.DateFin == 'undefined' ) { $("#spanstage").show(); $("#spanstage").text("* Veuillez sélectionner un stage valide"); }
        if(sessionFormation.SelectedStage == 0 ) { $("#spanstage").show(); $("#spanstage").text("* Veuillez sélectionner un stage valide"); }


        $.post("/SaveSession",{"value": sessionFormation},function(res){
            if(res.ok)
            {
                swal({
                    type:"success",
                    title:"Session Formation",
                    text:res.message

                },function (){
                //    loadingClose();
                //     reset();
                idSession = res.idFormation;
                window.location.reload();
                });
            }
            else{
                swal({
                    type:"error",
                    title:"Session Formation",
                    text:res.message

                },function (){
                //    loadingClose();
                //     reset();

                });
            }
        });

        
    });

    function convertDate(dateToConvert){
        var dateAr = dateToConvert.split('-');
      
       var newDate =  dateAr[2].substring(0,2)  + '-' + dateAr[1]+ '-' + dateAr[0];
       return newDate;
    }

    //liste des sessions crées
    function ListeSessions()
    {
        debugger
        var table = $("#tbsessionstage").DataTable({
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
                { "data": "ID" },
                { "data": "STAGE" },
                { "data": "DATEDEBUT" },
                { "data": "DATEFIN" },
                { "data": "LIEU" },
                { "data": "DIRECTEUR" },
                { "data": "ACTION" }
            ],
            columnDefs: [
                {
                    targets: 0,
                    visible: false
                }],
            data: [],
            rowCallback: function (row, data) { },
            filter: true,
            info: true,
            ordering: false,
            processing: false,
            retrieve: true
        });



        var tablelistedefinitive = $("#tblistedefinitive").DataTable({
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
                { "data": "ID" },
                { "data": "STAGE" },
                { "data": "DATEDEBUT" },
                { "data": "DATEFIN" },
                { "data": "LIEU" },
                { "data": "DIRECTEUR" },
                { "data": "ACTION" }
            ],
            columnDefs: [
                {
                    targets: 0,
                    visible: false
                }],
            data: [],
            rowCallback: function (row, data) { },
            filter: true,
            info: true,
            ordering: false,
            processing: false,
            retrieve: true
        });
        $.get("/Sessions",function(res){
            debugger
            if(res.ok){
                debugger;
                $("#selformation").empty();
                $("#selformation").append("<option value=0 selected>---sélectionner une session de formation---</option>");

                var liste = JSON.parse(res.data);
                table.clear().draw();
                $.each(liste,function(i,n){
                    $("#selformation").append("<option value="+n.id+">"+n.Stage+"</option>");
                    table.rows.add([{
                        "ID":n.id,
                        "STAGE":n.Stage,
                        "DATEDEBUT":convertDate(n.DateDebut),
                        "DATEFIN":convertDate(n.DateFin),
                        "LIEU":n.Lieu,
                        "DIRECTEUR":n.DirecteurStage,
                        "ACTION":"<a><i class='fa fa-pencil fa-1x'></i></a> <a><i class='fa fa-trash-o fa-1x'></i></a> <a id='liste_prepa' title='Préparer liste'><i class='fa-solid fa-clipboard-list fa-1x'></i></i></a>"
                    }]).draw();
                    
                    tablelistedefinitive.rows.add([{
                        "ID":n.id,
                        "STAGE":n.Stage,
                        "DATEDEBUT":convertDate(n.DateDebut),
                        "DATEFIN":convertDate(n.DateFin),
                        "LIEU":n.Lieu,
                        "DIRECTEUR":n.DirecteurStage,
                        "ACTION":"<a onclick='DownloadList("+n.id+");'><i class='fa fa-solid fa-download fa-1x'></i></a>"
                    }]).draw();
                });
            }
            else
            {
                swal({
                    type:"error",
                    title:"Session Formation",
                    text:res.message

                });
            }
        });
    }
    
    $("#tbsessionstage tbody").on('click', 'tr > td > a[id="liste_prepa"]',function(){
        debugger
        var table = $("#tbsessionstage").DataTable();
        var row = table.row( $(this).parents('tr') ).data();
        var formation = row.STAGE;
        var datedebut = row.DATEDEBUT;
        var datefin = row.DATEFIN;
        var message = formation + ' du ' + datedebut + ' au ' + datefin;
        $("#titre").text(message) ;
        var ID = row.ID;
        $("#idsession").val(ID);
        var table = $("#tbparticipant").DataTable({
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
            ajax:{
                "url": "/ListePreparatoire",
                "type":"POST",
                "data": {"value":ID},
                // success:function(res)
                // {
                //     debugger
                //     idFormation = res.idFormation;
                // }
                
            },
            columns: [
               
                { "data": "id" },
                { "data": "nom" }  , 
                 { "data": "prenoms" },
                 { "data": "fonction" },
                 { "data": "groupe" },
                 
              
            ],
            columnDefs: [
                // {
                //     targets: 1,
                //     visible: false
                // },
                // {
                //     targets: 5,
                //     visible: true
                // },
                {
                    targets: 4,
                    visible: false
                },
                {
                    targets:0,
                    //visible:false,
                    searchable: false,
                    orderable: false,
                    //className: 'dt-body-center',
                    render:function(data,type,full,meta){
                        return '<input type="checkbox" class="check" name value='+data+' />';
                    }
                }
            ],
             order: [[4, 'asc']],
            rowGroup:{
                dataSrc:'groupe'
            },
           // data: [],
         
            // rowCallback: function (row, data) { },
            // filter: true,
            // info: true,
            // ordering: false,
            // processing: false,
            // retrieve: true
        });
        $(".preparationliste").modal({
            backdrop:false
        });
        // $.post("/ListePreparatoire",{"value": ID},function(res){
        //     debugger
        //     if(res.ok)
        //     {
        //         var liste = JSON.parse(res.data);
        //         table.clear().draw();
        //         $.each(liste,function(i,n){
                    
        //             table.rows.add([{
        //                 "ID":n.id,
        //                 "NOM":n.nom,
        //                 "PRENOMS":n.prenoms,
        //                 "FONCTION":n.fonction,
        //                 "GROUPE":n.groupe,
                       
        //             }]).draw();
        //         });
        //     }
        // });
    });

    $("#btncancel").click(function(){
        $(".preparationliste").modal('hide');
    });



   
});



function SaveParticipant()
{
    debugger
    var idsession = $("#idsession").val();
    swal({
        type:"warning",
        title:"STAGE DE FORMATION",
        text:"Etes vous sûr de vouloir confirmer cette liste de participants ?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Non',
        confirmButtonText: 'Oui, Créer!'
    },(function (res){
        debugger
        if (res==false)return;
        else{
           
            var checkedValue = $('.check:checkbox:checked');
            var arrayParticipant = [];
            checkedValue.each(function(){
                debugger
                arrayParticipant.push(this.value);
            });


            $.post("/CreerListeParticipant",{"value":arrayParticipant,"idsession":idsession}, function(res){
                debugger
                if(res.ok)
                {
                    swal({
                        type:"success",
                        title:"STAGE DE FORMATION",
                        text: res.data
                    },function(){
                        $(".preparationliste").modal("hide");
                    });
                }
                else{

                }
            });

             
        }
    }));


  
}


function GetChefPar_NextStage()
{
    let selectedFormation = $("#selformation").val();
    if(selectedFormation == 0)
    {
        swal({
            type:"error",
            title:"Prévision Formation",
            text:"Sélection invalide"
        });
    }
    else{
        $.post("/ListResponsableNextSession",{"sessionid":selectedFormation},function(res){
            if(res.ok)
            {
                debugger
                var table = $("#tbchef").DataTable({
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
                    columns: [
                        { "data": "ID" },
                        { "data": "NOM" },
                        { "data": "GROUPE" },
                      //  { "data": "STAGE" },
                     //{ "data": "ACTION" }
                    ],
                    columnDefs: [
                        {
                            targets:0,
                            //visible:false,
                            searchable: false,
                            orderable: false,
                            //className: 'dt-body-center',
                            render:function(data,type,full,meta){
                                return '<input type="checkbox" class="form-control checkconfirm" name="chk[]" value='+data+' onclick="CheckList();" />';
                            }
                        }],
                    data: [],
                    rowCallback: function (row, data) { },
                    filter: true,
                    info: true,
                    ordering: false,
                    processing: true,
                    retrieve: true
                });
                table.clear().draw();
                let liste = JSON.parse(res.data);
                $.each(liste,function(i,n){
                    debugger
                table.rows.add([{
                    "ID": n.Id,
                    "NOM":n.Nom+" "+n.Prenoms ,
                    "GROUPE" : n.Groupe,
                    // "ACTION" : "<a title='Confirmer participation' onclick='confirmParticipation();'><i class='fa fa-solid fa-check fa-1x' style='color:green;'></i></a> <a><i class='fa fa-trash-o fa-1x'></i></a> <a id='liste_prepa'><i class='fa-solid fa-clipboard-list fa-1x'></i></i></a>"
                   // "ACTION" : "<a title='Confirmer participation' onclick='confirmParticipation();'><i class='fa fa-solid fa-check fa-1x' style='color:green;'></i></a> <a><i class='fa fa-trash-o fa-1x'></i></a> <a id='liste_prepa'><i class='fa-solid fa-clipboard-list fa-1x'></i></i></a>"
       				}]).draw();
                });
          
            }
            else{

            }
        })
    }
}


function checkAll()
{
    debugger
    var checkedValue = $('.checkall').is(':checked');
    $('input:checkbox').not(this).prop('checked', checkedValue);
    var checkedValue = $('.checkconfirm:checkbox:checked');
    checkedValue.each(function(){
        debugger
        arrayParticipant.push(this.value);
    });
}
var arrayParticipant = [];
function CheckList()
{
    var checkedValue = $('.checkconfirm:checkbox:checked');
    checkedValue.each(function(){
        debugger
        arrayParticipant.push(this.value);
    });
}

function confirmParticipation()
{
    debugger
    if(arrayParticipant.length > 0)
    {
        $.post("/ConfirmerParticipation",{"value":arrayParticipant},function(res)
        {
            if(res.ok){
                swal({
                    type:"success",
                    title:"Session de formation",
                    text: res.message
                },function(){
                    window.location.reload();
                });
            }
        });
    }
    else{
        swal({
            type:"warning",
            title:"Session de formation",
            text:"Aucun participant sélectionné"
        });
    }
  
}

function DownloadList(id)
{
    debugger
    window.location.href = "/ExportListeDefinitiveStages/"+id;
}

