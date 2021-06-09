<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Data;
use App\Entity\Truck;

class MapController extends AbstractController
{
    
    /**************************************************************    Affichage camions    *************************************************************/
    
    #[Route('/adminMap', name: 'map')]
    public function map(): Response
    {
        $doctrine = $this->getDoctrine()->getManager();    
        $truckObjects = $doctrine->getRepository(Truck::class)->findAll();    
        $truckCoordinate = array();
        foreach($truckObjects as $truckObject){
            
            $dataArray = $truckObject->getIdData();
            $dataObject = $dataArray->last();

            $heure = $this->Heure($dataObject->getNmea());
            $coordinate = $this->DSMToDD($dataObject->getNmea());
            array_push($truckCoordinate, array("idTruck" => $truckObject->getId(),  "latitude" => $coordinate["latitude"], "longitude" => $coordinate["longitude"], "heure" => $heure["heure"], "minute" => $heure["minute"], "seconde" => $heure["seconde"]));
        }
        
        return new JsonResponse($truckCoordinate);
    }
    
    /****************************************************************************************************************************************************/
    
    /**********************************************************    Affichage camions => ID    ***********************************************************/    
    
    #[Route('/mapTruck', name: 'mapTruck')]
    public function sendDataIdTruck(): Response
    {    
        if(!isset($_GET["idTruck"]))
            return new Response(Response::HTTP_NOT_FOUND);
    
        $doctrine = $this->getDoctrine()->getManager();
        $truckObject = $doctrine->getRepository(Truck::class)->findOneById($_GET["idTruck"]);
        $truckCoordinate = array();
        
        foreach($truckObject->getIdData() as $dataObject) {            
            $heure = $this->Heure($dataObject->getNmea());
            $coordinate = $this->DSMToDD($dataObject->getNmea());
            array_push($truckCoordinate, array("idTruck" => $truckObject->getId(),  "latitude" => $coordinate["latitude"], "longitude" => $coordinate["longitude"], "heure" => $heure["heure"], "minute" => $heure["minute"], "seconde" => $heure["seconde"]));
        }
        
        return new JsonResponse($truckCoordinate);
    }

    /****************************************************************************************************************************************************/    
    
    /********************************************************    Calcul Longitude et Latitude    ********************************************************/  
    
    private function DSMToDD($trameArray): array
    {    
        $nmeaTrame = explode(",", $trameArray);
        
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
        return array("longitude" => $trameLongitude, "latitude" => $trameLatitude);
    }
    
    /****************************************************************************************************************************************************/

    /*****************************************************************    Calcul Heure    ***************************************************************/
    
    private function Heure($trameArray): array
    {
        $nmeaTrame = explode(",", $trameArray);

        $temps = floatval($nmeaTrame[1]);
        
        $heure = (($temps/10000)%100000);
        $minute = (($temps/100)%100);
        $seconde = ($temps%100);
       
        return array("heure" => $heure, "minute" => $minute, "seconde" => $seconde);
    }
    
    /****************************************************************************************************************************************************/
   
}
