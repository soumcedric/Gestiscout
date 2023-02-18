$(function(){
    loadEvenement();
})

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
            if(res.ok)
            {
                $("#modaloperation").modal('hide');
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
     
        columnDefs: [
            {
                targets: 0,
                visible: true
            },
            {
                targets:2,
                visible:true,
                render:function(data,type,full,meta){
                    //debugger
                   if(data=="0")
                        return '<a title="cloturer évènement" style="text-decoration:none; color:green;" onclick="cloturerEvenement('+full.id+');"><i class="fa fa-unlock"></i></a>';
                   else
                        return '<a title="évènement cloturé" style="text-decoration:none; color:red;"><span class="fa fa-lock"></span></a>';
                    
                },
            }],
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
            { "data": "statut" },
          
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



function OpenModal()
{
 
  $("#modaloperation").modal({
     backdrop:false
  });
  
}

let id = 0;
function cloturerEvenement(id)
{
    let choice = false;
    $("#closemodal").prop('disabled',true);
   
    swal({
        type: "warning",
        title : "Clôturer évènement",
        text: "Voulez-vous vraiment clôturer cet évènement ?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, clôturer!',
        cancelButtonText: "Annuler",
      //  onClose:()=>{ DeclencherCloture }
    },function(r){
        debugger
        if(r==true)choice = true; 
        $("#modalproressbar").modal("show");
        cloturerevenement(id);
        BilanEven(id);
       
    });

}

function cloturerevenement(id)
{
    $.get("/CloturerEvent/" + id, function (res) {
        debugger;
        if(res.ok)
        {$("#percent").text(res.percent);
         $('.progress-bar').css('width', res.percent+'%').attr('aria-valuenow', res.percent); 
      //  $('.progress-bar').attr('aria-valuenow', res.percent); 
    }
    });
}


function BilanEven(id)
{
    $.get("/BilanEvent/" + id, function (res) {
       // debugger;
        if(res.ok)
        {$("#percent").text(res.percent);
         $('.progress-bar').css('width', res.percent+'%').attr('aria-valuenow', res.percent); 
         
        $("#closemodal").prop('disabled',false);
    }
    });
}

function closemodal()
{
    $("#modalproressbar").modal("hide");
    loadEvenement();
}

