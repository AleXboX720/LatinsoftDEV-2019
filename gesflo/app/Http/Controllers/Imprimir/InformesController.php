<?php

namespace App\Http\Controllers\Imprimir;

use Illuminate\Http\Request;

//use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

class InformesController extends ConfiguracionController
{
	private $_titulo = "INFORME DEL SERVICIO\n";
	private $testStr = "Testing 123";
		
	//private $footer = EscposImage::load(public_path('assets\img\conductores.png'));
	
	public function imprimir(Request $request)
	{
		//$connector = new CupsPrintConnector($this->nomb_impre);
		$connector = new WindowsPrintConnector($this->nomb_impre);
		//$connector = new FilePrintConnector($this->nomb_impre);
		$printer = new Printer($connector);
		
		try {
			$servicio = $request['servicio'][0];
			$controladas = $request['controladas'];
			$fech_servi = date("d-m-Y", strtotime($this->_zonaHoraria, $servicio['inic_servi']));
			$hora_servi = date("H:i", strtotime($this->_zonaHoraria, $servicio['inic_servi']));
			
			$codi_servi = $servicio['codi_servi'];
						
			
			$this->titulo1($printer, "INFORME DEL SERVICIO\n", Printer::JUSTIFY_CENTER);
			$this->lineaSeparacion2($printer);
			$printer->setLineSpacing(44);
			$printer->setJustification(Printer::JUSTIFY_LEFT);
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
			
			//$this->lineaSeparacion2($printer);			
			//$this->negrita2($printer, "Controlador  : ");
			//$this->letra2($printer, "12345678 - Nombre Apellido\n");
			$this->lineaSeparacion2($printer);
			/**/
			$this->negrita2($printer, "ZONAS   ");
			$this->negrita2($printer, "PROGR ");
			$this->negrita2($printer, "CONTR ");
			$this->negrita2($printer, "TOL ");
			$this->negrita2($printer, "MUL  ");
			$this->negrita2($printer, "VALOR $\n");
			$this->lineaSeparacion1($printer);
			/**/
			
			$regresando = FALSE;
			//print_r($controladas);
			$tota_pagar = 0;
			foreach($controladas as $obj){
				print_r($obj);
				if($obj['codi_senti'] == 1 AND $regresando == FALSE){
					$this->lineaSeparacion1($printer);
					$regresando = TRUE;
				}
				$this->negrita2($printer, $obj['abre_geoce'] ." ");				
				
				/*																						//<--LINUX
				$fech_progr = date("H:i:s d-m-Y", strtotime($this->_zonaHoraria, $obj['fech_progr']));
				$hora_progr = substr($fech_progr, 0, 5);
				*/
				/*																						//<--WINDOWs*/
				$fech_progr = $obj['fech_progr'];
				$hora_progr = substr($fech_progr, 11, 5);
				/**/
				$this->letra2($printer, $hora_progr ." ");
				
				
				$minutos = 0;
				$multa = 0;
				
				if($obj['fech_contr'] != null){
					/*																						//<--LINUX
					$fech_contr = date("H:i:s d-m-Y", strtotime($this->_zonaHoraria, $obj['fech_contr']));
					$hora_contr = substr($fech_contr, 0, 5);
					$this->letra2($printer, $hora_contr);
					
					
					$minutos = floor(($obj['fech_contr'] - $obj['fech_progr']) / 60);
					*/
					/*																						//<--WINDOWs*/
					$fech_contr = $obj['fech_contr'];
					$hora_contr = substr($fech_contr, 11, 5);
					$this->letra2($printer, $hora_contr);
					
					
					$minutos = floor((strtotime($fech_contr) - strtotime($fech_progr)) / 60);
					/**/
					
				} else {
					$this->negrita2($printer, "--:--");
				}
				
				$tolerancia = 0;
				if($obj['minu_toler'] > 0){
					$tolerancia = $obj['minu_toler'];
					$this->negrita2($printer, " ". sprintf("%'.03d", $tolerancia));
				} else {
					$this->letra2($printer, " ---");
				}
				
				if($obj['minu_toler'] > 0){
					$this->letra2($printer, " ---");
				} else {
					if($minutos > 0){
						$this->negrita2($printer, "  ". $minutos);
						$multa = $minutos * 1000;
						$tota_pagar = $tota_pagar + $multa;
					} else {
						$this->letra2($printer, " ---");
					}
				}
				
				if($multa > 0){
					$this->negrita2($printer, " ". $multa ." \n");
				} else {
					$this->negrita2($printer, "\n");
				}
				/*
				
					
				
				if($obj['minu_toler'] > 0){
					$this->titulo3($printer, $hhmm);
					$this->negrita1($printer, "+". $obj['minu_toler'] ." ");
					$control = $obj['nomb_geoce'];					
				} else {
					$this->titulo3($printer, $hhmm ."  ");
					$control = $obj['nomb_geoce'];
				}
				$this->titulo3($printer, substr($control, 0, 14) ."\n");
				*/
			}
			
				$this->lineaSeparacion1($printer);
				$printer->setLineSpacing();
				$printer->setJustification(Printer::JUSTIFY_CENTER);
				$this->negrita2($printer, "POR PAGAR : $");
				$this->letra2($printer, $tota_pagar .".-\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$this->lineaSeparacion2($printer);
			/**/
				//$this->codigoPDF417($printer, $this->testStr);
				//$this->lineaSeparacion2($printer);
			/**/
				//$this->codigoBarras1($printer, "012345678901");
				//$this->lineaSeparacion2($printer);
			/**/
			$this->negrita2($printer, "INF. Impreso: ");
			$this->letra2($printer, date("H:i:s d-m-Y"));
			$printer->feed(1);
			$printer->cut();
		} finally {
			$printer -> close();
			return 'imprimir REPORTES DIARIOS';
		}
	}
	
}