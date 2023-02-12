
function OpenModal()
{
  
  $("#modalcompte").modal({
     backdrop:false
  });
  
}

function CloseModal()
{
  
  $("#modaloperation").modal('hide');
  
}

  
function convertDate(datetoformat){
    var formattedDate = new Date(datetoformat);
    var d = formattedDate.getDate();
    var m =  formattedDate.getMonth();
    m += 1;
    if(m<=10) m='0'+m;  // JavaScript months are 0-11
    var y = formattedDate.getFullYear();

    return d+"-"+m+"-"+y;
}
function rechercher()
{
    debugger
    let datedebut = $("#datedebut").val();
    let datefin = $("#datefin").val();
    var data ={
            "datedebut":datedebut,
            "datefin": datefin
    };
    const money = new Intl.NumberFormat('fr-FR',
    {
      style: 'currency',
      currency: 'CFA',
      minimumFractionDigits:0
    });


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
            loadingRecords: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
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
            },
            {
                targets: 4,
                render:function(data,type,full,meta){
                   
                    return money.format(data).replace("CFA","")+"F CFA";
                    
                },
                createdCell:function(td,cellData, rowData, row, col)
                {
                     let montant = 0;
                    montant = parseInt(cellData);
                    $(td).addClass('text-white');
                    if(montant > 0) $(td).addClass('bg-success');
                    else $(td).addClass('bg-danger');
                  //  else return {money.format(data).replace("CFA","")+"F CFA";}
                }

            }


        ],
        ajax:{
            url:"/rechercheoperation",
            data:{"value":data},
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

function print()
{
    debugger
    let datedebut = $("#datedebut").val();
    let datefin = $("#datefin").val();
    let Uri = /DonwloadOperationPdf/;
    let Url = Uri+datedebut+"/"+datefin;
    if(datedebut == "" || datefin =="")
       alert("Attention, veuillez renseigner les champs");
    else
       window.location.href = Url;
}