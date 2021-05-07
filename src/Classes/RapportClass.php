<?php

namespace App;

use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;

class RapportClass {

    private  $em;
    function __construct(EntityManagerInterface $EM)
    {
        $this->em=$EM;
    }


    public  function GetNbreCotiseJeune($groupeid,$activeyear): ?int
    {
        $sql = "SELECT count(j) FROM App\Entity\JEUNE j, App\Entity\INSCRIPTION i, App\Entity\AnneePastorale an, App\Entity\Groupe gr, App\Entity\Cotisation c where j.id = i.Jeunes and i.Annee = an.id and j.Groupe = gr.id and c.Jeune = j.id and gr.id = :groupeid and  an.id = :aneepastorale";
        $query=$this->em->createQuery($sql);
        $query->setParameter("groupeid", $groupeid);
        $query->setParameter("aneepastorale",$activeyear);
        $res=$query->getScalarResult();
        return (int)$res[0];
    }





}