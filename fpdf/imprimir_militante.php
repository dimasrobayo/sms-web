<?php
define('FPDF_FONTPATH','font/');
require('pg_table.php');
include("comunes.php");
include ("conectar.php"); 

$pdf=new PDF('L');
$pdf->Open();
$pdf->AddPage();

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(50);
$pdf->SetX(0);
$pdf->MultiCell(220,6,"LISTADO DE MILITANTES",0,C,0);//

$pdf->Ln();    

//T�tulos de las columnas
$header=array('CEDULA','NOMBRE DEL MILITANTE','CARGO','CENTRO','TELEFONO');

	//Colores, ancho de linea y fuente en negrita
    $pdf->SetFillColor(85,186,243);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('Arial','B',10);
	
	//Cabecera
    $w=array(20,60,40,120,30);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $pdf->Ln();
	
	//Restauracion de colores y fuentes
    $pdf->SetFillColor(246,246,246);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);

	//Buscamos y listamos los clientes
	$consulta = "SELECT * FROM parroquia, centro_votacion, cargo, militantes where parroquia.codigo_parroquia = centro_votacion.codigo_parroquia and centro_votacion.codigo_centro= militantes.codigo_centro and cargo.codigo_cargo = militantes.codigo_cargo order by militantes.cedula_militante";
	$query = pg_query($consulta);

while ($row = pg_fetch_array($query))
  {
		//posicion celda, alto,contenido,bordes que mostramos(left,right top botton),0, alineacion izquierda
		//imprimo nombre, apellidos y localidad
		$pdf->Cell($w[0],6,$row["cedula_militante"],'LRTB',0,'C',$fill);
		$pdf->Cell($w[1],6,utf8_decode($row["nombre_militante"] ." " .$row["apellido_militante"]),'LRTB',0,'L',$fill);
		$pdf->Cell($w[2],6,utf8_decode($row["nombre_cargo"]),'LRTB',0,'L',$fill);
		$pdf->Cell($w[3],6,utf8_decode($row["nombre_centro"]),'LRTB',0,'L',$fill);
		$pdf->Cell($w[4],6,utf8_decode($row["telefono_militante"]),'LRTB',0,'C',$fill);
		$pdf->Ln(); //Este es para alinear los campos de la base de datos en el pdf.
		$fill = !$fill;

  };
$pdf->Output();
?> 
