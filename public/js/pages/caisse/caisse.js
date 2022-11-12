$(function(){
   // OpenModal();
   TypeMouvement();
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
            $("#selmvt").append("<option value="+n.id+">"+n.Libelle+"</option>");
        });
    }
   });
}

function SaveMvt()
{
    debugger
    if(validation())
    {
        let mvt = {
            type : $("#selmvt").val(),
            description : $("#txtdescription").val(),
            montant : $("#txtmontant").val(),
            date: $("#seldate").val()
        }

        $.post("/SaveMvt",{"data": mvt},function(res){});
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