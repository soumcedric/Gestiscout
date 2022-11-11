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