<?php

namespace App\Controller;

use App\Classes\QueryClass;
use App\Repository\BrancheRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\JEUNERepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;

class RapportController extends AbstractController
{
    private $JeuneLayerData;
    public  function __construct(JEUNERepository $jeune)
    {
        $this->JeuneLayerData = $jeune;
    }


    #[Route('/rapport', name: 'rapport')]
    public function index(): Response
    {
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
        ]);
    }


    #[Route('/TotalJeuneByGroupe', name: 'TotalJeuneByGroupe')]
    public function GetTotalJeune(): array
    {

        $totalJeune = $this->JeuneLayerData->GetTotalJeuneByGroup();

    }


    #[Route('/TotalJeuneByGroupe', name: 'TotalJeuneByGroupe')]
    public function GetTotalJeuneByGroupe(JEUNERepository $jeuneData): Response
    {
        $result = $jeuneData->GetTotalJeuneByGroup();
        // $totalJeune = $jeuneData->GetTotalJeune();
        return $this->render('rapport/index.html.twig', [
            'totalJeune' => $result[0],
        ]);
    }

    #[Route('/ExportToExcel', name: 'ExportToExcel')]
    public function ExportToExcel()
    {
        $spreadsheet = new Spreadsheet();

        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',"hello");
        $sheet->setTitle("My First Worksheet");

        //create the sheet in xlsx format
        $writer = new Xlsx($spreadsheet);

        //wrtie the file in public directory
        $publicdirectory = "D:/myfirst.xlsx";
        $writer->save($publicdirectory);
        return new Response("success");
    }


    #[Route('/ExportToExcelAttachment', name: 'ExportToExcelAttachment')]
    public function ExportToExcelAttachment()
    {
        $spreadsheet = new Spreadsheet();

        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',"hello");
        $sheet->setTitle("My First Worksheet");

        //create the sheet in xlsx format
        $writer = new Xlsx($spreadsheet);

        //create temporary file
        $filename = "my_first_attachement.xlsx";
        $temp_file = tempnam(sys_get_temp_dir(),$filename);

        //create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        //return the excell file in attachment
        return $this->file($temp_file,$filename,ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }


    #[Route('/ExportJeuneByGroupeToExcelAttachment', name: 'ExportJeuneByGroupeToExcelAttachment')]
    public function ExportJeuneByGroupeToExcelAttachment(SessionInterface $session, EntityManagerInterface $em, GroupeRepository $repgroupe)
    {

        /*get connected user and connected groupe*/
        $id = $session->get('id');
        $Idgroupe = $session->get('groupeid');
        $groupe = $repgroupe->findOneBy(["id"=>$Idgroupe]);
      
        $query = new QueryClass($em);

        $spreadsheet = new Spreadsheet();

        //localisatio of the file (fr, en ,ru)
        $validatelocale = \PhpOffice\PhpSpreadsheet\Settings::setlocale('fr');
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',"LISTE DES JEUNES - ".$groupe->getNom());
        $sheet->setCellValue('A3',"ID");
        $sheet->setCellValue('B3',"NOM");
        $sheet->setCellValue('C3',"PRENOMS");
        $sheet->setCellValue('D3',"DATE DE NAISSANCE");
        $sheet->setCellValue('E3',"OCCUPATION");
        $sheet->setCellValue('F3',"LIEU D'HABITATION");
        $sheet->setCellValue('G3',"BRANCHE");
        $sheet->setCellValue('H3',"GROUPE");
        $sheet->setCellValue('I3',"TELEPHONE");

        $sheet->setTitle("LISTE DES JEUNES");

        $sheet->mergeCells("A1:I1");
        $sheet->setAutoFilter("A3:I3");
        //format of title
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_FILL);
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")
                    ->getBorders()->getTop(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")
                    ->getBorders()->getBottom(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")
                    ->getBorders()->getLeft(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")
                    ->getBorders()->getRight(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                    $styleArray = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];
                    $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray); 
                    
                    




                    $styleheader = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];

                    $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($styleheader); 
                   // $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($styleArray); 
                    
                    

                    //DIMENSION
                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                    $sheet->getColumnDimension('I')->setAutoSize(true);
                   // $sheet->getColumnDimension('A')->setAutoSize(true);
                    //DIMENSION
















        //format of title
        //write in spreadsheet
        
        //get jeune par groupe
        $jeunes = $query->GetJeunesActifByGroupe($Idgroupe->getId());
        $row = 4;
        for ($i=0; $i < count($jeunes); $i++) {
           // var_dump($jeunes[$i]);
            // for($t=1; $t < count($jeunes[$i]); $t++){
            //     var_dump($jeunes[$i][$t]);
            // }
            $column=1;
            foreach($jeunes[$i] as $k => $jeune){
                
              $sheet->setCellValueByColumnAndRow($column,$row,$jeune);
              $column++;
            }
            $row++;

           
          }




        //create the sheet in xlsx format
        $writer = new Xlsx($spreadsheet);

        //create temporary file
        $filename = "LISTE_JEUNES".$groupe->getNom().".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(),$filename);

        //create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        //return the excell file in attachment
        return $this->file($temp_file,$filename,ResponseHeaderBag::DISPOSITION_ATTACHMENT);
     // return new Response("success");
    }







    #[Route('/ExportResponsableByGroupeToExcelAttachment', name: 'ExportResponsableByGroupeToExcelAttachment')]
    public function ExportResponsableByGroupeToExcelAttachment(SessionInterface $session, EntityManagerInterface $em, GroupeRepository $repgroupe)
    {

        /*get connected user and connected groupe*/
        $id = $session->get('id');
        $Idgroupe = $session->get('groupeid');
        $groupe = $repgroupe->findOneBy(["id"=>$Idgroupe]);
      
        $query = new QueryClass($em);

        $spreadsheet = new Spreadsheet();

        //localisatio of the file (fr, en ,ru)
        $validatelocale = \PhpOffice\PhpSpreadsheet\Settings::setlocale('fr');
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',"LISTE DES CHEFS - ".$groupe->getNom());
        $sheet->setCellValue('A3',"ID");
        $sheet->setCellValue('B3',"NOM");
        $sheet->setCellValue('C3',"PRENOMS");
        $sheet->setCellValue('D3',"DATE DE NAISSANCE");
        $sheet->setCellValue('E3',"OCCUPATION");
        $sheet->setCellValue('F3',"LIEU D'HABITATION");
        $sheet->setCellValue('G3',"FONCTION");
        $sheet->setCellValue('H3',"TELEPHONE");
       // $sheet->setCellValue('I3',"TELEPHONE");

        $sheet->setTitle("LISTE DES CHEFS");

        $sheet->mergeCells("A1:H1");
        $sheet->setAutoFilter("A3:H3");
        //format of title
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_FILL);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getTop(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getBottom(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getLeft(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getRight(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                    $styleArray = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];
                    $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray); 
                    
                    




                    $styleheader = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];

                    $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($styleheader); 
                   // $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($styleheader); 
                   // $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($styleArray); 
                    
                    

                    //DIMENSION
                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                  //  $sheet->getColumnDimension('I')->setAutoSize(true);
                   // $sheet->getColumnDimension('A')->setAutoSize(true);
                    //DIMENSION
















        //format of title
        //write in spreadsheet
        
        //get jeune par groupe
        $chefs = $query->GetResponsableActifByGroupe($Idgroupe->getId());
      
        $row = 4;
        for ($i=0; $i < count($chefs); $i++) {
           // var_dump($jeunes[$i]);
            // for($t=1; $t < count($jeunes[$i]); $t++){
            //     var_dump($jeunes[$i][$t]);
            // }
            $column=1;
            foreach($chefs[$i] as $k => $jeune){
                
              $sheet->setCellValueByColumnAndRow($column,$row,$jeune);
              $column++;
            }
            $row++;

           
          }




        //create the sheet in xlsx format
        $writer = new Xlsx($spreadsheet);

        //create temporary file
        $filename = "LISTE CHEFS ".$groupe->getNom().".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(),$filename);

        //create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        //return the excell file in attachment
        return $this->file($temp_file,$filename,ResponseHeaderBag::DISPOSITION_ATTACHMENT);
     // return new Response("success");
    }


    #[Route('/ExportJeuneDistrict/{groupe}/{branche}', name: 'ExportJeuneDistrict')]
    public function ExportJeuneDistrict(SessionInterface $session, EntityManagerInterface $em, GroupeRepository $repgroupe, Request $value, string $groupe, string $branche, BrancheRepository $rpBranche)
    {

       
        // var_dump($branche);
        // var_dump($groupe);
     
        $groupe = $repgroupe->findOneBy(["id"=>$groupe]);
        $selectedBranche =$rpBranche->findOneBy(["id"=>$branche]);
        $query = new QueryClass($em);

        $spreadsheet = new Spreadsheet();

        //localisatio of the file (fr, en ,ru)
        $validatelocale = \PhpOffice\PhpSpreadsheet\Settings::setlocale('fr');
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',"LISTE DES JEUNES ".$selectedBranche->getLibelle()." - ".$groupe->getNom());
        $sheet->setCellValue('A3',"ID");
        $sheet->setCellValue('B3',"NOM");
        $sheet->setCellValue('C3',"PRENOMS");
        $sheet->setCellValue('D3',"DATE DE NAISSANCE");
        $sheet->setCellValue('E3',"OCCUPATION");
        $sheet->setCellValue('F3',"LIEU D'HABITATION");
        $sheet->setCellValue('G3',"TELEPHONE");

        $sheet->setTitle("LISTE DES JEUNES");

        $sheet->mergeCells("A1:G1");
        $sheet->setAutoFilter("A3:G3");
        //format of title
        $spreadsheet->getActiveSheet()->getStyle("A1:G1")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_FILL);
        $spreadsheet->getActiveSheet()->getStyle("A1:G1")
                    ->getBorders()->getTop(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $spreadsheet->getActiveSheet()->getStyle("A1:G1")
                    ->getBorders()->getBottom(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:G1")
                    ->getBorders()->getLeft(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:G1")
                    ->getBorders()->getRight(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                    $styleArray = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];
                    $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray); 
                    
                    




                    $styleheader = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];

                    $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($styleheader); 
                    // $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($styleheader); 
                    // $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($styleheader); 
                   // $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($styleArray); 
                    
                    

                    //DIMENSION
                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    // $sheet->getColumnDimension('H')->setAutoSize(true);
                    // $sheet->getColumnDimension('I')->setAutoSize(true);
                   // $sheet->getColumnDimension('A')->setAutoSize(true);
                    //DIMENSION
















        //format of title
        //write in spreadsheet
        
        //get jeune par groupe
        $jeunes = $query->GetListeJeuneByCriteria($groupe,$branche);
       
        $row = 4;
        for ($i=0; $i < count($jeunes); $i++) {
           // var_dump($jeunes[$i]);
            // for($t=1; $t < count($jeunes[$i]); $t++){
            //     var_dump($jeunes[$i][$t]);
            // }
            $column=1;
            foreach($jeunes[$i] as $k => $jeune){
                
              $sheet->setCellValueByColumnAndRow($column,$row,$jeune);
              $column++;
            }
            $row++;

           
          }




        //create the sheet in xlsx format
        $writer = new Xlsx($spreadsheet);

        //create temporary file
        $filename = "LISTE_JEUNES".$groupe->getNom().".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(),$filename);

        //create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        //return the excell file in attachment
        return $this->file($temp_file,$filename,ResponseHeaderBag::DISPOSITION_ATTACHMENT);
         /* */
        // return new Response("success");
    }




    #[Route('/ExportResponsableDistrict/{groupe}', name: 'ExportResponsableDistrict')]
    public function ExportResponsableDistrict(SessionInterface $session, EntityManagerInterface $em, GroupeRepository $repgroupe,string $groupe)
    {
        //get selected groupe
        $selectedGroupe = $repgroupe->findOneBy(["id"=>$groupe]);
      
        $query = new QueryClass($em);

        $spreadsheet = new Spreadsheet();

        //localisatio of the file (fr, en ,ru)
        $validatelocale = \PhpOffice\PhpSpreadsheet\Settings::setlocale('fr');
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',"LISTE DES CHEFS - ".$selectedGroupe->getNom());
        $sheet->setCellValue('A3',"ID");
        $sheet->setCellValue('B3',"NOM");
        $sheet->setCellValue('C3',"PRENOMS");
        $sheet->setCellValue('D3',"DATE DE NAISSANCE");
        $sheet->setCellValue('E3',"OCCUPATION");
        $sheet->setCellValue('F3',"LIEU D'HABITATION");
        $sheet->setCellValue('G3',"FONCTION");
        $sheet->setCellValue('H3',"TELEPHONE");
       // $sheet->setCellValue('I3',"TELEPHONE");

        $sheet->setTitle("LISTE DES CHEFS");

        $sheet->mergeCells("A1:H1");
        $sheet->setAutoFilter("A3:H3");
        //format of title
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_FILL);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getTop(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getBottom(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getLeft(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")
                    ->getBorders()->getRight(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                    $styleArray = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];
                    $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray); 
                    
                    




                    $styleheader = [
                        'font' => [
                            'bold' => true,
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    
                            'startColor' => [
                                'argb' => 'CCE5FF',
                            ],
                          
                        ],
                    ];

                    $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($styleheader); 
                    $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($styleheader); 
                   // $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($styleheader); 
                   // $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($styleArray); 
                    
                    

                    //DIMENSION
                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                  //  $sheet->getColumnDimension('I')->setAutoSize(true);
                   // $sheet->getColumnDimension('A')->setAutoSize(true);
                    //DIMENSION
















        //format of title
        //write in spreadsheet
        
        //get jeune par groupe
        $chefs = $query->GetListeResponsableByCriteria($groupe);
       // var_dump($chefs);
        $row = 4;
        for ($i=0; $i < count($chefs); $i++) {
           // var_dump($jeunes[$i]);
            // for($t=1; $t < count($jeunes[$i]); $t++){
            //     var_dump($jeunes[$i][$t]);
            // }
            $column=1;
            foreach($chefs[$i] as $k => $jeune){
                if($k!="Groupe")
                {
                    $sheet->setCellValueByColumnAndRow($column,$row,$jeune);
                  
                }
                $column++;
            }
            $row++;

           
          }




        //create the sheet in xlsx format
        $writer = new Xlsx($spreadsheet);

        //create temporary file
        $filename = "LISTE CHEFS ".$selectedGroupe->getNom().".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(),$filename);

        //create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        //return the excell file in attachment
        return $this->file($temp_file,$filename,ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        //return new Response("success");
    }













}
