<?php

namespace App\Controller;

use App\Classes\QueryClass;
use App\Repository\GenreRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ResponsableRepository;
use App\Repository\ExercerFonctionRepository;
use App\Repository\AnneePastoraleRepository;
use App\Repository\FONCTIONRepository;
use App\Entity\Responsable;
use App\Entity\ExercerFonction;
use App\Entity\AnneePastorale;
use App\Repository\FormationRepository;
use App\Repository\ResponsableFormationRepository;
use App\Entity\ResponsableFormation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class ResponsableController extends AbstractController
{
    private $em;
    private $AnneeLayer;
    function  __construct(EntityManagerInterface $em, AnneePastoraleRepository $annee, private GroupeRepository  $groupeRepo)
    {
        $this->em = $em;
        $this->AnneeLayer = $annee;
    }

    #[Route('/responsable', name: 'responsable')]
    public function index(): Response
    {
        return $this->render('responsable/index.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }

    #[Route('/AjouterRespoView', name: 'AjouterRespoView')]
    public function AjouterRespoView(): Response
    {
        return $this->render('responsable/AddResponsable.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }

    #[Route('/GetListResponsable', name: 'GetListResponsable')]
    public function GetListResponsable(SessionInterface $session, ExercerFonctionRepository  $exercerRepo, ResponsableRepository  $repoResponsable, SerializerInterface $serializer, AnneePastoraleRepository $anneerepo, FONCTIONRepository $fonctionrepo)
    {
        try {
            $groupe = $session->get('groupeid');
            if (!$groupe || !method_exists($groupe, 'getId')) {
                return new JsonResponse(['ok' => false, 'message' => 'Groupe introuvable en session'], 400);
            }

            $qCls = new QueryClass($this->em);
            $id = $groupe->getId();
            $listResponsable = $qCls->GetResponsableActifByGroupe($id) ?: [];

            // Normalize date strings for client consumption
           
            foreach ($listResponsable as $respo) {
                dump($respo);
                 $normalizedDateOfBirth = null;
                if(is_array($respo)) {

                     $dateOfBirth = $respo['dob'];
                if ($dateOfBirth instanceof \DateTimeInterface) {
                    $normalizedDateOfBirth = $dateOfBirth->format('d-m-Y');
                    $respo['dob'] = $normalizedDateOfBirth;
                }
               
                }
              
            }
            dump($listResponsable);
            $data = $serializer->normalize($listResponsable, null, ['groups' => 'show_chef']);
            return new JsonResponse(['ok' => true, 'data' => $data], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }



    #[Route('/GetListResponsableDistrict', name: 'GetListResponsableDistrict')]
    public function GetListResponsableDistrictActif(SessionInterface $session, ExercerFonctionRepository  $exercerRepo, ResponsableRepository  $repoResponsable, SerializerInterface $serializer, AnneePastoraleRepository $anneerepo, FONCTIONRepository $fonctionrepo)
    {
        $Idgroupe = $session->get('groupeid');
        $ActiveYear = $this->AnneeLayer->findActiveYear();
        $qCls = new QueryClass($this->em);
        $ListResponsable = $qCls->GetListResponsableDistrictActif("", $ActiveYear[0]->getId());
        foreach ($ListResponsable as $respo) {
            dump($respo);
            $dateOfBirth = $respo->getDob();
            $respo->setDateNaiss($dateOfBirth->format('d-m-Y'));
        }




        $result = $serializer->serialize($ListResponsable, 'json',   ['groups' => 'show_chef']);
        return new Response($result, 200);
    }



    #[Route('/AddResponsable', name: 'AddResponsable')]
    public function AddResponsable(GenreRepository $genrerepo,
                                             SessionInterface $session,
                                              Request $request, 
                                              ResponsableRepository $repoRespo, 
                                              FONCTIONRepository $repoFonction, 
                                              AnneePastoraleRepository $repoAnnee, 
                                              GroupeRepository  $groupeRepo, 
                                              FormationRepository $formrepo, 
                                              ResponsableFormationRepository $rfrepo)
    {
         
        try {
        
            
            //get formation
            $responsableformation = new ResponsableFormation();
            if (!empty($request->request->get("formation"))) {
                $formation = $formrepo->findOneBy(['id' => $request->request->get("formation")]);
                //new responsable formation

                $responsableformation->setFormationId($formation)
                    ->setDatecreation(new \DateTime());
            }

                dump($request);
                //get concerned group
                if (!empty($request->request->get("groupe"))) {
                    $groupeId = $request->request->get("groupe");
                } else {
                    $groupeId = $session->get('groupeid')->getId();
                }
              
                $chosenGroup = $groupeRepo->findOneBy(["id" => $groupeId]);
                if (!$chosenGroup) {
                    return new JsonResponse(['ok' => false, 'message' => 'Groupe introuvable'], 400);
                }
                dump($chosenGroup);
                $responsable = new Responsable();
                $ExerciceFonction = new ExercerFonction();
                $idFonction = $request->request->get("fonction");
                $genre =  $genrerepo->findOneBy(["id" => $request->request->get("genre")]);

                
                $date = new \DateTime($request->request->get("dob"));
                $responsable->setNom($request->request->get("nom"))
                    ->setPrenoms($request->request->get("prenoms"))
                    ->setHabitation($request->request->get("habitation"))
                    ->setOccupation($request->request->get("occupation"))
                    ->setTelephone($request->request->get("telephone"))
                    ->setEmail($request->request->get("email"))
                    ->setDateCreation(new \DateTime())
                    ->setDob($date)
                    ->setGenre($genre)
                    ->setUserCreation("Admin")
                    ->setUserModification("Admin")
                    ->setStatut(1)            
                    ->setGroupe($chosenGroup);
                
               $responsableformation->setResponsableId($responsable);
               $responsable->addResponsableFormation($responsableformation);      


                $fonction = $repoFonction->findById($idFonction);
                $anneePastorale = $repoAnnee->findActiveYear();
                $ExerciceFonction->setFonction($fonction[0])
                    ->setAnneePastorale($anneePastorale[0])
                    ->setDateCreation(new \DateTime())
                    ->setDateDebut(new \DateTime())
                    ->setDateFin(new \DateTime())
                    ->setUserModification("Admin")
                    ->setUserCreation("Admin");

               $responsable->addExercerFonction($ExerciceFonction);              
                dump($responsable);
                $this->em->persist($responsable);
                $this->em->flush();
                return  new JsonResponse(["ok"=>true, "message"=>"Opération réussie"]);
         // }

              
        } catch (\Exception $e) {
            
            return  new JsonResponse(["ok"=>false, "message"=>$e->getMessage()]);
        }
       
    }


    #[Route('/supprimerResponsable', name: 'supprimerResponsable')]
    public function supprimerResponsable(ResponsableRepository  $repoResponsable, Request $request)
    {
        
        $id = $request->query->get('id');
        //rechercher le responsable dont l'id est celui en parametre
        $responsable = $repoResponsable->findOneByID($id);
        $responsable->setStatut(0);
        //$manager = $this->getDoctrine()->getManager();
        $this->em->persist($responsable);
        $this->em->flush();


        return new Response("succes", 200);
    }
    #[Route('/GetRespoUnique', name: 'GetRespoUnique')]
    public function GetRespoUnique(ResponsableRepository $repo, ExercerFonctionRepository $repoExercer, Request $request, SerializerInterface $serializer, AnneePastoraleRepository $repoAnnee)
    {
        $id = $request->query->get("value");
        $qClass = new QueryClass($this->em);
        $ResponsableUnique = $qClass->GetResponsableUnique($id);
        dump($ResponsableUnique);
        $result = $serializer->serialize($ResponsableUnique, 'json',   ['groups' => 'show_chef']);
        return new Response($result, 200);
    }


    #[Route('/ModifierResponsable', name: 'ModifierResponsable')]
    public function UpdateResponsable(ResponsableRepository $repo, ExercerFonctionRepository $repoExercer, 
                                      Request $request, SerializerInterface $serializer, AnneePastoraleRepository $repoAnnee, 
                                      FONCTIONRepository $repofonction, FormationRepository $repoformation)
    {

        try {
            $qClass = new QueryClass($this->em);

            
            $input =  $request->request->all();
            if(empty($input)) {
                return new JsonResponse(["ok" => false, "data" => "Données manquantes"]);
            }
            
            $id = $input['id'];

            //get responsable to update
            $ResponsableToUpdate = $repo->findOneBy(["id" => $id]);

                // parse input (supports form-data or raw JSON)
                $input = $request->request->all();
                if (empty($input)) {
                    $content = $request->getContent();
                    if ($content) {
                        $decoded = json_decode($content, true);
                        if (is_array($decoded)) {
                            $input = $decoded;
                        }
                    }
                }

                if (empty($input) || !isset($input['id'])) {
                    return new JsonResponse(['ok' => false, 'message' => 'Données manquantes ou id absent'], 400);
                }

                $id = $input['id'];
                $ResponsableToUpdate = $repo->find($id);
                if (!$ResponsableToUpdate) {
                    return new JsonResponse(['ok' => false, 'message' => 'Responsable introuvable'], 404);
                }

                // Update simple fields only if provided
                $updatable = ['nom' => 'setNom', 'prenoms' => 'setPrenoms', 'habitation' => 'setHabitation',
                              'occupation' => 'setOccupation', 'telephone' => 'setTelephone', 'email' => 'setEmail'];
                foreach ($updatable as $key => $setter) {
                    if (array_key_exists($key, $input) && $input[$key] !== null && $input[$key] !== '') {
                        $ResponsableToUpdate->{$setter}((string)$input[$key]);
                    }
                }

                dump($ResponsableToUpdate);
               // DOB
                if (!empty($input['dob'])) {
                    try {
                        $dob = new \DateTime($input['dob']);
                        $ResponsableToUpdate->setDob($dob);
                    } catch (\Exception $ex) {
                        return new JsonResponse(['ok' => false, 'message' => 'Format de date invalide'], 400);
                    }
                }

                // Update fonction if provided
                if (!empty($input['fonction'])) {
                    $fonctionEntity = $repofonction->find($input['fonction']);
                    if ($fonctionEntity) {
                        $exercerId = $qClass->GetExercerfonction($ResponsableToUpdate->getId());
                        
                        $exofonction = null;
                        if ($exercerId) {
                            $exofonction = $repoExercer->find($exercerId);
                        }
                        if ($exofonction) {
                            $exofonction->setFonction($fonctionEntity);
                            $this->em->persist($exofonction);
                        }
                    }
                }
 
                // Update formation if provided
                if (!empty($input['formation'])) {
                    $selectedFormation = $repoformation->find($input['formation']);
                    $formationToUpdate = $ResponsableToUpdate->getResponsableFormations();
                    
                    if ($formationToUpdate && count($formationToUpdate) > 0 && $selectedFormation) {
                        $formationToUpdate[0]->setformationId($selectedFormation);
                        $this->em->persist($formationToUpdate[0]);
                    }
                }

                // metadata
                $ResponsableToUpdate->setUserModification('Admin');
                $ResponsableToUpdate->setDateModification((new \DateTime())->format('Y-m-d H:i:s'));

                $this->em->persist($ResponsableToUpdate);
                $this->em->flush();

                return new JsonResponse(['ok' => true, 'message' => 'Opération effectuée avec succès', 'data' => ['id' => $ResponsableToUpdate->getId()]]);
          
            } catch (\Exception $e) {
                
                return new JsonResponse(['ok' => false, 'message' => $e->getMessage()], 500);
            }
    }
    
    #[Route('/ListeRespoCg', name: 'ListeRespoCg')]
    public function ListeRespoCg(): Response
    {
        return $this->render('responsable/indexrespoGroupe.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }



    
}
