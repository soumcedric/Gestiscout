<?php

namespace App\Controller;

use App\Classes\ClsMail;
use App\Classes\QueryClass;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\entity\ACTIVITES;
use App\Entity\AnneePastorale;
use App\Entity\Branche;
use App\Entity\Groupe;
use App\Repository\ACTIVITESRepository;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BrancheRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\DETAILS;
use App\Repository\AnneePastoraleRepository;
use App\Repository\AnnePastoraleRepository;
use App\Repository\DETAILSRepository;
use Doctrine\DBAL\Schema\View;
use PhpParser\Node\Expr\Cast\Bool_;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class ActiviteController extends AbstractController
{
    private $em;
    private $activiteRepo;
    private $annePastorale;
    // private $rpBranche;
    public function __construct(EntityManagerInterface $em, BrancheRepository $rpbranche, ACTIVITESRepository $activite, AnneePastoraleRepository $annee)
    {
        $this->em = $em;
        $this->activiteRepo = $activite;
        $this->annePastorale = $annee;
        //$rpBranche = $rpbranche;
    }


    /**
     * @Route("/activite", name="activite")
     */
    public function index(SessionInterface $session): Response
    {
        $groupeId = $session->get('groupeid');

        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
            'groupe' => $groupeId->getId()
        ]);
    }
    // /**
    //  * @Route("/AddActivite, name="AddActivite")
    //  */
    // public function AddActivite(Request $value)
    // {
    //     return $this->render('activite/index.html.twig', [
    //         'controller_name' => 'ActiviteController',
    //     ]);
    // }

    /**
     * @Route("/CreateActivite", name="CreateActivite")
     */
    public function CreateActivite(Request $value, ACTIVITESRepository $activite, BrancheRepository $rpBranche, GroupeRepository $rpGroupe, SessionInterface $session)
    {
        try {


            $data =  $value->request->get('value');
            // var_dump($data);
            $groupeId = $session->get('groupeid');

            $ActiveYear = $this->annePastorale->findActiveYear();
            $activity = new ACTIVITES();

            $activity->setNom($data["Nom"])
                ->setLocalisation($data["Localisation"])
                ->setPrix($data["Prix"])
                ->setDateDebut(new \DateTime($data["DateDebut"]))
                ->setDateFin(new \DateTime($data["DateFin"]))
                ->setHeureDebut(new \DateTime($data["HeureDebut"]))
                ->setHeureFin((new DateTime($data["HeureFin"])))
                ->setStatut(0)
                ->setBactif(true)
                ->setDateCreation(new \DateTime())
                ->setCible($data["Cible"])
                //->setBSoumis(false)
                // ->setBOneDay($oneDayActivity)
                //->setAutorisation($data["Autorisation"])
                ->setNbreParticipant($data["NbreParticipant"])
                ->setBSoumis(false)
                ->setGroupe($selectedGroupe = $rpGroupe->findOneBy(["id" => $groupeId]));
            //->setBranche($data["Branche"]);


            //connaitre l'interval de jour entre les deux dates pour afficher le formulaire idoine
            $dateDebut = $activity->getDateDebut();
            $datefin = $activity->getDateFin();

            $differenceFormat = '%a';
            $interval = date_diff($dateDebut, $datefin);
            $number_of_day = $interval->format($differenceFormat);
            $oneDayActivity = true;
            if ($number_of_day > 0) $oneDayActivity = false;

            $activity->setBOneDay($oneDayActivity);

            if (!empty($data["Branche"])) {
                $selectedBranche = $rpBranche->findOneBy(["id" => $data["Branche"]]);
                $activity->setBranche($selectedBranche);
            }

            $activity->setAnneepastorale($ActiveYear[0]);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($activity);
            $manager->flush();

            return new JsonResponse(['ok' => true, 'message' => 'opération effectuée avec succès']);
            //return  var_dump($activity);
            // return new Response('true',200);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }

        //return new Response();

    }



    /**
     * @Route("/Activites", name="Activites")
     */
    public function ListActivite(): Response
    {
        return $this->render('activite/ListActivite.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }



    /**
     * @Route("/ListActivites", name="ListActivites")
     */
    public function ListActivites(ACTIVITESRepository $rpActivite, SerializerInterface $serializer)
    {
        $qClass = new QueryClass($this->em);
        $listactivites = $qClass->getallactiviteby();
        foreach ($listactivites as $ac) {
            //dump($ac);
            // var_dump($ac);
        }
        $result = $serializer->serialize($listactivites, 'json');
        return new JsonResponse(['ok' => true, 'data' => $result]);
        // return new Response();
    }


    /**
     * @Route("/details/{id}", name="details")
     */
    public function VwDetailsActivite(int $id)
    {
        $activite = $this->activiteRepo->findOneBy(["id" => $id]);

        //get DateDebut = Date Min
        $dateMin = $activite->getDateDebut();
        //get DateFin = Date Max
        $dateMax = $activite->getDateFin();

        if ($activite->getBOneDay() == true) {
            return $this->render('activite/details.html.twig', [
                'controller_name' => 'ActiviteController',
                'activityName' => $activite->getNom(),
                'activityid' => $activite->getId(),
                'oneDayActivity' => true
            ]);
        } else {
            return $this->render('activite/Details.html.twig', [
                'controller_name' => 'ActiviteController',
                'activityName' => $activite->getNom(),
                'activityid' => $activite->getId(),
                'oneDayActivity' => false,
                'dateMin' => $dateMin,
                'dateMax' => $dateMax
            ]);
        }
    }


    /**
     * @Route("/AddDetails", name="AddDetails")
     */
    public function AddDetails(Request $value, BrancheRepository $rpBranche)
    {

        try {


            $data =  $value->request->get('value');

            $details = new DETAILS();
            $details->setLibelle($data["Nom"])
                ->setDeroulement($data["Deroulement"])
                ->setObjectif($data["Objectif"])
                ->setDate(new \DateTime($data["Date"]))
                ->setHeuredebut(new \DateTime($data["HeureDebut"]))
                ->setHeureFin(new \DateTime($data["HeureFin"]))
                ->setResponsableActivite($data["Responsable"])
                ->setContact($data["Contact"])
                ->setBactif(true)
                ->setStatut(0)
                ->setCible($data["Cible"])
                ->setDescription("dddd")
                ->setDateCreation(new \DateTime());

            //set activity
            $activite = $this->activiteRepo->findOneBy(["id" => $data["Activity"]]);
            //dump($data["Activity"]);
            $details->setActivite($activite);
            //set branche
            $branche = $rpBranche->findOneBy(["id" => $data["Branche"]]);
            $details->setBranche($branche);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($details);
            $manager->flush();
            return new JsonResponse(['ok' => true, 'data' => "Opération effectuée avec succès"]);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/redirectToProgramme", name="redirectToProgramme")
     */
    public function redirectToProgramme(Request $request)
    {
        $data = $request->query->get("value");
        $bdistrict = $request->query->get("district");
        //  var_dump($bdistrict);
        //$url = "";
        if ($bdistrict == "true")
            $url = "/DetailsActiviteDistrict/" . $data;
        else
            $url = "/ProgrammesByActivite/" . $data;

        //  dump($url);
        return new JsonResponse(['ok' => true, 'url' => $url]);
    }



    /**
     * @Route("/ProgrammesByActivite/{id}", name="ProgrammesByActivite")
     */
    public function ListProgramme(Request $request, ACTIVITESRepository $rpActivite, int $id)
    {

        $bEmpty = false;
        $data = $request->query->get("value");
        //get activite name
        $activite = $rpActivite->findOneBy(["id" => $id]);

        //obtenir la liste des activités
        $qClass = new QueryClass($this->em);
        $result = $qClass->GetAllProgrammesByActivite($id);
        if (!empty($result)) {
            $bEmpty = true;
        }
        return $this->render('activite/ListProgramme.html.twig', [
            'controller_name' => 'ActiviteController',
            'emptyCheck' => $bEmpty,
            'acitivityName' => $activite->getNom(),
            'activityid' => $id,
            'allProgrammes' => $result
        ]);
    }




    /**
     * @Route("/DetailsActiviteDistrict/{id}", name="DetailsActiviteDistrict")
     */
    public function DetailsActiviteDistrict(Request $request, ACTIVITESRepository $rpActivite, int $id)
    {
        dump($id);
        $bEmpty = false;
        $data = $request->query->get("value");
        //get activite name
        $activite = $rpActivite->findOneBy(["id" => $id]);
        dump($activite);
        //obtenir la liste des activités
        $qClass = new QueryClass($this->em);
        $result = $qClass->GetAllProgrammesByActivite($id);
        if (!empty($result)) {
            $bEmpty = true;
        }
        return $this->render('activite/DetailsActivitesDistrict.html.twig', [
            'controller_name' => 'ActiviteController',
            'emptyCheck' => $bEmpty,
            'acitivityName' => $activite->getNom(),
            'activityid' => $id,
            'allProgrammes' => $result
        ]);
    }







    /**
     * @Route("/ConsulterDetails/{id}/{district}", name="ConsulterDetails")
     */
    public function ConsulterDetails(int $id, DETAILSRepository $rpDetails, ACTIVITESRepository $repoact, bool $district)
    {
        dump($id);
        $activity = $rpDetails->findOneBy(["id" => $id]);
        $act = $repoact->findOneBy(["id" => $activity->getActivite()->getId()]);
        if ($district == true) {
            if ($act->getBOneDay() == true) {
                return $this->render('activite/consulterdetailsDistrictOneDay.html.twig', [
                    'controller_name' => 'ActiviteController',
                    'detailsActivite' => $activity
                ]);
            } else {
                return $this->render('activite/consulterdetailsDistrict.html.twig', [
                    'controller_name' => 'ActiviteController',
                    'detailsActivite' => $activity
                ]);
            }
        } else {
            if ($act->getBOneDay() == true) {
                return $this->render('activite/consulterdetailsOneDay.html.twig', [
                    'controller_name' => 'ActiviteController',
                    'detailsActivite' => $activity
                ]);
            } else {

                return $this->render('activite/consulterdetails.html.twig', [
                    'controller_name' => 'ActiviteController',
                    'detailsActivite' => $activity
                ]);
            }
        }


        //  dump($activity);

    }

    /**
     * @Route("/ActivitesByGroupe", name="ActivitesByGroupe")
     */
    public function ActivitesByGroupe(SessionInterface $session)
    {
        $groupe = $session->get('groupeid');
        $anneeActive = $this->annePastorale->findActiveYear();
        $qClass = new QueryClass($this->em);
        $listactivites = $qClass->ListActiviteByGroupe($groupe->getId());
        //dump($listactivites);
        // $result = $serializer->serialize($listactivites,'json');
        return new JsonResponse(['ok' => true, 'data' => $listactivites]);
        //return new Response();
    }



    /**
     * @Route("/ActivitesByGroupeDistrict", name="ActivitesByGroupeDistrict")
     */
    public function ActivitesByGroupeDistrict(Request $query)
    {
        try {
            $value = $query->query->get('groupe');

            $anneeActive = $this->annePastorale->findActiveYear();
            $qClass = new QueryClass($this->em);
            $listactivites = $qClass->ListActiviteByGroupe($value);

            // $result = $serializer->serialize($listactivites,'json');
            return new JsonResponse(['ok' => true, 'data' => $listactivites]);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }

        // return new Response();

    }




    /**
     * @Route("/ViewActivitesByGroupeDistrict", name="ViewActivitesByGroupeDistrict")
     */
    public function ViewActivitesByGroupeDistrict()
    {
        return $this->render('activite/VwActivitesByGroupeDistrict.html.twig');
    }

    /**
     * @Route("/DecisionActivite", name="DecisionActivite")
     */
    public function DecisionActivite(Request $value, ACTIVITESRepository $repoact)
    {

        $idactivite = $value->request->get("id");
        $commentaire = $value->request->get("commentaire");
        $decision = $value->request->get("decision");
        //retrouver contrat
        $activite = $repoact->findOneBy(["id" => $idactivite]);

        if($decision ==0)
        {
            $activite->setStatut(2);//refuser
            $activite->setCommentaire($commentaire);
        }           
        else    
            $activite->setStatut(1);//accepter
       
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($activite);
        $manager->flush();
        return new JsonResponse();
    }




      /**
     * @Route("/SoumettreActivite", name="Soumettre")
     */
    public function SoumettreActivite(Request $value, ACTIVITESRepository $activite, MailerInterface $mailer)
    {
        try {
            $data =  $value->request->get('value');
            
            $activityToSubmit = $activite->findOneBy(["id"=>$data]);
            $activityToSubmit->setBSoumis(true);
            $activityToSubmit->setDateModification(new \DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($activityToSubmit);
            $manager->flush();


            $email = (new Email())
            ->from('infos@scoutblackfeet.com')
            ->to('csoumahoro@scoutblackfeet.com')
            ->subject('Activité soumise pour approbation')
           // ->text('Bonjour, une activité à été soumise pour approbation. Vous pouvez la consulter à l\'adresse suivante.')
            ->html('Bonjour, <br/> <p>Une activité à été soumise pour approbation par le groupe <strong>'.$activityToSubmit->getGroupe()->getNom()  .'</strong></p> <p>Nom de l\'activité: '.$activityToSubmit->getNom().'</p><br\> <p>Vous pouvez la consulter à partir de l\'adresse suivante:.....</p>');
        
            $mailer->send($email);
            dump($mailer);
         //  return new JsonResponse(['ok' => true, 'message' => 'opération effectuée avec succès']);
            //return  var_dump($activity);
            // return new Response('true',200);
        } catch (\Exception $e) {
           //   return new JsonResponse(['ok' => false, 'message' => $e->getMessage()]);
        }

        return new Response();

    }
}
