<?php

class AuctionsController extends Controller {

  private static $instance;

  public static function getInstance() {

    if (!isset(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {

  }



  public function listAuctions() {

  }

  public function listadoSubastasHabilitadas($idResidencia){

     $inactivas= PDOSubasta::getInstance()->traerSubastasInactivas($idResidencia);
     $hoy = date('Y-m-d');
     foreach ($inactivas as $key => $subasta) {
         $fecha = date_create($subasta->getFechaInicio());
         date_sub($fecha, date_interval_create_from_date_string('6 months'));
         $f= date_format($fecha, 'Y-m-d');

         if($hoy >= $f){

          PDOSubasta::getInstance()->activarSubasta($subasta->getIdSubasta());
         }

      }

      $activas= PDOSubasta::getInstance()->traerSubastasActivas($idResidencia);
       
       return $activas;

   }



}