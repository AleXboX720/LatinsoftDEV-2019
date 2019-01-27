<?php

namespace App\Http\Controllers\Imprimir;

use Illuminate\Http\Request;

//use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;


class PagosController extends ConfiguracionController
{
	private $_linkAVL = "http://avl.kguard.org:81/informes/api/conductores/servicio/";
	private $testStr = 'Nombre\Apellidos\DNI';
	//private $footer = EscposImage::load(public_path('assets\img\conductores.png'));
	
	public function imprimir(Request $request)
	{
		//$connector = new CupsPrintConnector($this->nomb_impre);
		$connector = new WindowsPrintConnector($this->nomb_impre);
		//$connector = new FilePrintConnector($this->nomb_impre);
		$printer = new Printer($connector);
		
		try {
			//$this->imagen($printer, "img/tux.png");
			$servicio = $request['servicio'][0];			
			$controladas = $request['controladas'];
			
			
			$inic_servi = new \DateTime($servicio['inic_servi']);
			$fech_servi = $inic_servi->format('d-m-Y');
			$hora_servi = $inic_servi->format('H:i');
			//$fech_servi = date("d-m-Y", strtotime($this->_zonaHoraria, $servicio['inic_servi']));
			//$hora_servi = date("H:i", strtotime($this->_zonaHoraria, $servicio['inic_servi']));
			
			$codi_servi = $servicio['codi_servi'];
			$codi_circu = $servicio['codi_circu'];			
			$paginaWEB = $this->_linkAVL .$codi_circu. '/' .$codi_servi;
			
			$printer->setLineSpacing(44);
			$this->negrita2($printer, "Movil      : ");
			$this->letra2($printer, $servicio['nume_movil']);			
			$this->negrita2($printer, "         Patente : ");
			$this->letra2($printer, $servicio['pate_movil'] ."\n");
			
			$this->negrita2($printer, "Conductor  : ");
			$this->letra2($printer, $servicio['docu_perso'] ." - ". $servicio['conductor'] ."\n");		
			$this->negrita2($printer, "Fecha      : ");
			$this->letra2($printer, $fech_servi);
			$this->negrita2($printer, "  Hora : ");
			$this->letra2($printer, $hora_servi ."\n");
			/*
			$this->negrita2($printer, "Controlador: ");
			$this->letra2($printer, "12345678 - Nombre Apellido\n");
			*/
			$this->lineaSeparacion2($printer);
			
			/**/
			$this->codigoQR($printer, $paginaWEB);
			$this->lineaSeparacion1($printer);
			/**/
			$this->titulo1($printer, "SERVICIO      ". $hora_servi ."\n", Printer::JUSTIFY_CENTER);
			$this->lineaSeparacion2($printer);
			
			$regresando = FALSE;

			foreach($controladas as $obj){
				if($obj['codi_senti'] == 1 AND $regresando == FALSE){
					$this->lineaSeparacion1($printer);
					$this->titulo1($printer, "*******REGRESO*******\n", Printer::JUSTIFY_CENTER);
					$regresando = TRUE;
				}
				/*																						//<--LINUX
				$fecha = date("H:i:s d-m-Y", strtotime($this->_zonaHoraria, $servicio['inic_servi']));
				$hhmm = substr($fecha, 0, 5);
				*/
				/*																						//<--WINDOWs*/
				$fecha = $obj['fech_progr'];
				$hhmm = substr($fecha, 11, 5);
				/**/
				if($obj['minu_toler'] > 0){
					$this->titulo1($printer, $hhmm, Printer::JUSTIFY_LEFT);
					//$this->titulo3($printer, $hhmm, Printer::JUSTIFY_LEFT);
					$this->negrita1($printer, "+". $obj['minu_toler'] ." ");
					$control = $obj['nomb_geoce'];					
				} else {
					$this->titulo1($printer, $hhmm ."  ", Printer::JUSTIFY_LEFT);
					//$this->titulo3($printer, $hhmm ."  ", Printer::JUSTIFY_LEFT);
					$control = $obj['nomb_geoce'];
				}
				$this->titulo1($printer, substr($control, 0, 14) ."\n", Printer::JUSTIFY_LEFT);
				//$this->titulo3($printer, substr($control, 0, 14) ."\n", Printer::JUSTIFY_LEFT);
				//$printer->setLineSpacing(44);
			}
			$this->lineaSeparacion2($printer);

			//$this->codigoBarras1($printer, "012345678901");
			//$this->lineaSeparacion1($printer);
			//$printer->setLineSpacing();

			/**/
			//$this->codigoPDF417($printer, $this->testStr);
			//$this->lineaSeparacion2($printer);
			/**/
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$this->negrita2($printer, "INF. Impreso: ");
			$this->letra2($printer, date("H:i:s d-m-Y"));
			$printer->feed(1);
			$printer->cut();
		} catch (Exception $e) {
		    $printer->text($e->getMessage() . "\n");
		} finally {
			$printer->close();
			//return 'IMPRIMIENDO EN: ' .$this->nomb_impre;
		}
	}
}