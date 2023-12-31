<?php
session_start();
require('../../fpdf/fpdf.php');

if(!isset($_SESSION['valid'])){
    header("Location: ../index.php");
   }
include('../admin/pdo.php');

$idcommande = $_GET['id'];
$sqlStateLigneCommandes = $pdo->prepare('SELECT ligne_commande.*,produit.name as name,produit.prix as prix ,
produit.discount as disc from ligne_commande
INNER JOIN produit ON ligne_commande.id_produit = produit.id 
WHERE id_commande = ?
');
$sqlStateLigneCommandes->execute([$idcommande]);
$lignesCommandes = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_ASSOC);




class PDF extends FPDF {
    function Header(){
        $this->Image('images/logo2.png',10,6,27);
        $this->SetFont('Arial', 'B', 19);
        $this->Cell(0, 10, 'Facture', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Add your company information, customer information, etc.
$pdf->Cell(0, 10, 'Coffee Shop', 0, 1);
$pdf->Cell(0, 10, 'EST, KENITRA, MA', 0, 1);
$pdf->Cell(0, 10, 'Phone: 123-456-789', 0, 1);
$pdf->Cell(0, 10, 'Email: admin@gmail.com', 0, 1);

$pdf->Ln(10);

$email = $_SESSION['valid'];
$name = $_SESSION['username'];
$pdf->Cell(0, 10,'client : '. $name, 0, 1);
$pdf->Cell(0, 10, 'email : '.$email, 0, 1);
$pdf->Cell(0, 10, 'Invoice Date : ' . date('Y-m-d'), 0, 1);

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(38, 10, 'Product', 1);
$pdf->Cell(38, 10, 'Quantity', 1);
$pdf->Cell(38, 10, 'Price U', 1);
$pdf->Cell(38, 10, 'Discount', 1);
$pdf->Cell(38, 10, 'Total', 1);
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);

$totale = 0;
foreach ($lignesCommandes as $product) {
    $pdf->Cell(38, 10, $product['name'], 1);
    $pdf->Cell(38, 10, $product['quantite'], 1);
    $pdf->Cell(38, 10,  number_format($product['prix'], 2)." MAD", 1);
    $pdf->Cell(38, 10, $product['disc'].'%', 1);  
    $pdf->Cell(38, 10,  number_format($product['total'],2)." MAD", 1);   
    $totale += $product['total'];
    $pdf->Ln();
}

$pdf->Ln(10);

$pdf->Cell(152, 10, 'Total Amount', 1);
$pdf->Cell(38, 10, $totale.' MAD' , 1);


$pdf->Output('I');
?>