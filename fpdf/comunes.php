<?php
include ("conectar.php"); 

class PDF extends FPDF
{
//Cabecera de pagina
function Header()
{
//consulta sql
$consulta = "SELECT * FROM empresa order by empresa.rif_empresa";
$query = pg_query($consulta);
$row = pg_fetch_array($query);
    //Logo
    $this->Image('./logo/logo.jpg',20,8,180);
    $this->Ln(30);	
}

//Pie de p�gina
function Footer()
{
    //Posici�n: a 1,5 cm del final
    $this->SetY(-21);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //N�mero de p�gina
    $this->Cell(0,10,utf8_decode('CTSI-VPA'),0,0,'C');	
	
	//Posici�n: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //N�mero de p�gina
    $this->Cell(0,10,utf8_decode('Sistema de Gestión de Militantes PSUV-GUANARE'),0,0,'C');	
	

    //Posici�n: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //N�mero de p�gina
    $this->Cell(0,10,'-- '.$this->PageNo().' --',0,0,'C');
}


}
?>
