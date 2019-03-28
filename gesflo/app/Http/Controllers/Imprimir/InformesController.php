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
			$mi_servicio = $request['mi_servicio'];
			$mis_controladas = $request['mis_controladas'];
			$tu_servicio = $request['tu_servicio'];
			$tus_controladas = $request['tus_controladas'];

			$inic_servi = new \DateTime($mi_servicio['inic_servi']);
			$fech_servi = $inic_servi->format('d-m-Y');
			$hora_servi = $inic_servi->format('H:i');
			//$fech_servi = date("d-m-Y", strtotime($this->_zonaHoraria, $mi_servicio['inic_servi']));
			//$hora_servi = date("H:i", strtotime($this->_zonaHoraria, $mi_servicio['inic_servi']));
			
			$codi_servi = $mi_servicio['codi_servi'];
						
			
			$this->titulo1($printer, $this->_titulo, Printer::JUSTIFY_CENTER);
			$this->lineaSeparacion2($printer);
			$printer->setLineSpacing(44);
			
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$this->negrita2($printer, "Movil      : ");
			$this->letra2($printer, $mi_servicio['nume_movil']);			
			$this->negrita2($printer, "         Patente : ");
			$this->letra2($printer, $mi_servicio['pate_movil'] ."\n");
			
			$this->negrita2($printer, "Conductor  : ");
			$this->letra2($printer, $mi_servicio['docu_perso'] ." - ". $mi_servicio['conductor'] ."\n");
			$this->negrita2($printer, "Fecha      : ");
			$this->letra2($printer, $fech_servi);
			$this->negrita2($printer, " Hora : ");
			$this->letra2($printer, $hora_servi ."\n");
			
			
			$this->negrita2($printer, "Circuito   : ");
			$this->letra2($printer, $mi_servicio['codi_circu'] ." - ". $mi_servicio['nomb_circu']. "\n");
			/**/
			$this->lineaSeparacion2($printer);
			//$printer->setReverseColors(true);
			$tabs = chr(6). chr(11). chr(16). chr(20). chr(25). chr(29). chr(35).chr(38). chr(0);
			$printer->setHorizontalTab($tabs);
			$this->negrita2($printer, "ZONAS");$printer->tabularH();
			$this->negrita2($printer, "PROGR");$printer->tabularH();
			$this->negrita2($printer, "M.MAR");$printer->tabularH();
			$this->negrita2($printer, "TOL");$printer->tabularH();
			$this->negrita2($printer, "MUL");$printer->tabularH();
			$this->negrita2($printer, "PROGR");$printer->tabularH();
			$this->negrita2($printer, "T.MAR");$printer->tabularH();	
			$this->negrita2($printer, "MUL");$printer->tabularH();
			$this->negrita2($printer, "TOTAL");		
			//$printer->setReverseColors(false);
			$this->negrita2($printer, "\n");
			$this->lineaSeparacion1($printer);
			/**/
			
			$tabs = chr(6). chr(11). chr(16). chr(20). chr(25). chr(29). chr(35). chr(38). chr(0);
			$printer->setHorizontalTab($tabs);
			
			$regresando = FALSE;
			$tota_pagar = 0;
			$item = 0;
			foreach($mis_controladas as $obj)
			{
				if($obj['codi_senti'] == 1 AND $regresando == FALSE){
					$this->lineaSeparacion1($printer);
					$regresando = TRUE;
				}				
				//$fech_progr = date("H:i:s d-m-Y", strtotime($this->_zonaHoraria, $obj['fech_progr']));
				//$hora_progr = substr($fech_progr, 0, 5);
							
				/*IMPRIMIR CONTROLADAS*/
				$this->negrita2($printer, $obj['abre_geoce']);$printer->tabularH();
				//<--WINDOWs	
				$fech_progr = $obj['fech_progr'];
				$hora_progr = substr($fech_progr, 11, 5);
				$this->letra2($printer, $hora_progr);$printer->tabularH();
				if($obj['fech_contr'] != null){
					//$fech_contr = date("H:i:s d-m-Y", strtotime($this->_zonaHoraria, $obj['fech_contr']));
					//$hora_contr = substr($fech_contr, 0, 5);
					//$this->letra2($printer, $hora_contr);					
					//<--WINDOWs
					$fech_contr = $obj['fech_contr'];
					$hora_contr = substr($fech_contr, 11, 5);
					$this->letra2($printer, $hora_contr);					
				} else {
					$this->letra2($printer, "--:--");
				}
				$printer->tabularH();
				if($obj['minu_toler'] > 0){
					$tolerancia = sprintf("%'.03d", $obj['minu_toler']);
					$this->letra2($printer, $tolerancia);
				} else {
					$this->letra2($printer, "---");
				}
				$printer->tabularH();
				
				$minutos = $obj['dife_contro'];
				$multa = 0;				
				if($obj['minu_toler'] > 0){
					$this->letra2($printer, "---");
				} else {
					if($minutos > 0){
						$minutos = sprintf("%'.03d", $minutos);
						$this->negrita2($printer, $minutos);
						$multa = $minutos * 1000;
						$tota_pagar = $tota_pagar + $multa;
					} else {
						$this->letra2($printer, "---");
					}
				}
				$printer->tabularH();
				/*====================*/
				
				
				
				/*TUS DATOS*/
				
				//<--WINDOWs
				if(isset($tus_controladas))
				{
					$fech_progr = $tus_controladas[$item]['fech_progr'];
					$hora_progr = substr($fech_progr, 11, 5);
					$this->letra2($printer, $hora_progr);$printer->tabularH();
					if($tus_controladas[$item]['fech_contr'] != null){
						//$fech_contr = date("H:i:s d-m-Y", strtotime($this->_zonaHoraria, $tus_controladas[$item]['fech_contr']));
						//$hora_contr = substr($fech_contr, 0, 5);
						//$this->letra2($printer, $hora_contr);					
						//<--WINDOWs
						$fech_contr = $tus_controladas[$item]['fech_contr'];
						$hora_contr = substr($fech_contr, 11, 5);
						$this->letra2($printer, $hora_contr);					
					} else {
						$this->letra2($printer, "--:--");
					}
					$printer->tabularH();
					
					$minutos = $tus_controladas[$item]['dife_contro'];
					if($tus_controladas[$item]['minu_toler'] > 0){
						$this->letra2($printer, "---");
					} else {
						if($minutos > 0){
							$minutos = sprintf("%'.03d", $minutos);
							$this->negrita2($printer, $minutos);
						} else {
							$this->letra2($printer, "---");
						}
					}
					$printer->tabularH();					
				} else {
					$this->letra2($printer, "--:--");$printer->tabularH();
					$this->letra2($printer, "--:--");$printer->tabularH();
					$this->letra2($printer, "---");$printer->tabularH();
				}
				/*=========*/
				if($multa > 0){
					$multa = sprintf("%'. 6d", $multa);
					$this->negrita2($printer, $multa);
				}
				$this->negrita2($printer, "\n");
				
				$item++;
			}
			/*
			*/
			
				$this->lineaSeparacion1($printer);
				$printer->setLineSpacing();
				$printer->setJustification(Printer::JUSTIFY_CENTER);
				$this->negrita2($printer, "POR PAGAR : $");
				$this->letra2($printer, $tota_pagar .".-\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);		
			/*TU SERVICIO*/
			if(isset($tu_servicio))
			{
				$printer->setLineSpacing(5);
				$this->lineaSeparacion2($printer);
				$printer->setJustification(Printer::JUSTIFY_CENTER);		
				$this->negrita2($printer, "SERVICIO ANTERIOR\n");
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$this->lineaSeparacion1($printer);
				
				$this->negrita2($printer, "Movil Ant. : ");
				$this->letra2($printer, $tu_servicio['nume_movil']);			
				$this->negrita2($printer, "         Patente : ");
				$this->letra2($printer, $tu_servicio['pate_movil'] ."\n");
				
				
				$inic_servi = new \DateTime($tu_servicio['inic_servi']);
				$fech_servi = $inic_servi->format('d-m-Y');
				$hora_servi = $inic_servi->format('H:i');
				$this->negrita2($printer, "Fecha      : ");
				$this->letra2($printer, $fech_servi);
				$this->negrita2($printer, " Hora : ");
				$this->letra2($printer, $hora_servi ."\n");
				
				$this->negrita2($printer, "Conductor  : ");
				$this->letra2($printer, $tu_servicio['conductor'] ."\n");
				
				
			}
			/**/
				//$this->codigoPDF417($printer, $this->testStr);
				//$this->lineaSeparacion2($printer);
			/**/
				//$this->codigoBarras1($printer, "012345678901");
				//$this->lineaSeparacion2($printer);
			/**/			
			$this->lineaSeparacion2($printer);
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