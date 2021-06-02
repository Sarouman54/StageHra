<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $nmeaTrame = explode(",", $dataObject->getNmea());
            
            $trameLatitude = floatval($nmeaTrame[2]);
            $trameLongitude = floatval($nmeaTrame[4]);
            
            $degreLatitude = ($trameLatitude/100)%100;
            $minuteLatitude = $trameLatitude%100;
            $secondeLatitude = $trameLatitude-($trameLatitude%10000);
            $latitude = $degreLatitude+($minuteLatitude/60)+($secondeLatitude*60/3600);
            
            $degreLongitude = ($trameLongitude/100)%1000;
            $minuteLongitude = $trameLongitude%100;
            $secondeLongitude = $trameLongitude-($trameLongitude%10000);
            $longitude = $degreLongitude+($minuteLongitude/60)+($secondeLongitude*60/3600);
            
            if($nmeaTrame[3] == 'S'){
                $latitude = -$latitude;
            };
            if($nmeaTrame[5] == 'O'){
                $longitude = -$longitude;
            };
                                    
//             dump($latitude);
//             dump($longitude);
//             die();

            array_push($coordinate, array("latitude" => $latitude, "longitude" => $longitude));
        }
        return new JsonResponse($coordinate);
    }
}
