<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Truck;

class MapController extends AbstractController
{
    /* ********************************************** Send Last Location's Truck ************************************************** */
    
    #[Route('/admin/map', name: 'mapLastData')]
    public function sendDataLastLocation(): Response
    {
        $doctrine = $this->getDoctrine()->getManager();
        $truckObjects = $doctrine->getRepository(Truck::class)->findAll();
        $truckCoordinate = array();
        
        foreach($truckObjects as $truckObject){
            $dataArray = $truckObject->getIdData();
            $dataObject = $dataArray->last();
            $coordinate = $this->DSMToDD($dataObject->getNmea());
            $hour = $this->Hour($dataObject->getNmea());
            array_push($truckCoordinate, array( "idTruck" => $truckObject->getId(),  
                                                "latitude" => $coordinate["latitude"], 
                                                "longitude" => $coordinate["longitude"], 
                                                "hours" => $hour["hours"], 
                                                "minutes" => $hour["minutes"], 
                                                "seconds" => $hour["seconds"]));
        }
        return new JsonResponse($truckCoordinate);
//         dump($truckCoordinate);
//         die();
    }
    /* ******************************************************************************************************************* */
    
    
    /* ********************************************** Send All Data's Truck ************************************************** */
    
    #[Route('/admin/map/truck', name: 'mapTruckData')]
    public function sendDataIdTruck(): Response
    { 
        if(!isset($_GET["idTruck"])) return new Response(Response::HTTP_NOT_FOUND);
            
        $doctrine = $this->getDoctrine()->getManager();
        $truckObjectId = $doctrine->getRepository(Truck::class)->findOneById($_GET["idTruck"]);
        $truckCoordinate = array();
        
        foreach($truckObjectId->getIdData() as $dataObject) {
            $coordinate = $this->DSMToDD($dataObject->getNmea());
            $hour = $this->Hour($dataObject->getNmea());
            array_push($truckCoordinate, array( "idTruck" => $truckObjectId->getId(),  
                                                "latitude" => $coordinate["latitude"], 
                                                "longitude" => $coordinate["longitude"], 
                                                "hours" => $hour["hours"], 
                                                "minutes" => $hour["minutes"], 
                                                "seconds" => $hour["seconds"]));
        }
        return new JsonResponse($truckCoordinate);
    }
    /* ******************************************************************************************************************* */
    
    
    /* *********************************************** Get Coordinate **************************************************** */
    
    private function DSMToDD($frameArray): array
    {
        $nmeaFrame = explode(",", $frameArray);
        
        $frameLatitude = floatval($nmeaFrame[2]);
        $frameLongitude = floatval($nmeaFrame[4]);
        
        $degreeLatitude = ($frameLatitude / 100) % 100;
        $minuteLatitude = ($frameLatitude % 100);
        $secondLatitude = ($frameLatitude - ($frameLatitude % 10000));
        $latitude = ($degreeLatitude + ($minuteLatitude / 60) + ($secondLatitude * 60 / 3600));
        
        $degreeLongitude = (($frameLongitude / 100) % 1000);
        $minuteLongitude = ($frameLongitude % 100);
        $secondLongitude = ($frameLongitude - ($frameLongitude % 10000));
        $longitude = ($degreeLongitude + ($minuteLongitude / 60) + ($secondLongitude * 60 / 3600));
        
        if($nmeaFrame[3] == 'S'){
            $latitude = -$latitude;
        };
        if($nmeaFrame[5] == 'O'){
            $longitude = -$longitude;
        };
        
        return array("longitude" => $longitude, "latitude" => $latitude);
    }   
    /* ******************************************************************************************************************* */
    
    
    /* *************************************************** Get Hour ****************************************************** */
    
    private function Hour($frameArray): array
    {
        $nmeaFrame = explode(",", $frameArray);
        
        $frameHour = floatval($nmeaFrame[1]);

        $hours = (($frameHour / 10000) % 100000);
        $minutes = (($frameHour / 100) % 100);
        $seconds = ($frameHour % 100);
        
        return array("hours" => $hours, "minutes" => $minutes, "seconds" => $seconds);
    }
    /* ******************************************************************************************************************* */
    
}
