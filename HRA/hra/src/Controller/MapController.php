<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Data;

class MapController extends AbstractController
{
    #[Route('/adminMap', name: 'map')]
    public function map(): Response
    {
        $doctrine = $this->getDoctrine()->getManager();    
        $dataObjects = $doctrine->getRepository(Data::class)->findAll();    
        $coordinate = array();
        foreach($dataObjects as $dataObject){
            
            $idTruck = ($dataObject->getIdTruck());
            
            dump($idTruck);
            die();
            
            $nmeaTrame = explode(",", $dataObject->getNmea());
            
            $latitude = floatval($nmeaTrame[2]);
            $longitude = floatval($nmeaTrame[4]);
            
            
            $degreLatitude = ($latitude/100)%100;
            $minuteLatitude = $latitude%100;
            $secondeLatitude = $latitude-($latitude%10000);
            $trameLatitude = $degreLatitude + ($minuteLatitude/60)+ ($secondeLatitude*60/3600);
       
            $degreLongitude = ($longitude/100)%1000;
            $minuteLongitude = $longitude%100;
            $secondeLongitude = $longitude-($longitude%10000);
            $trameLongitude = $degreLongitude + ($minuteLongitude/60)+ ($secondeLongitude*60/3600);
            

            $var = ($nmeaTrame[3]);
            
            if($var=='S'){
                $trameLatitude = -$trameLatitude;
            }
            
            $var2 = ($nmeaTrame[5]);
            
            if($var2=='O'){
                $trameLongitude = -$trameLongitude;
            }
           array_push($coordinate, array("latitude" => $trameLatitude, "longitude" => $trameLongitude));
        }
        
        return new JsonResponse($coordinate);
    }
}
