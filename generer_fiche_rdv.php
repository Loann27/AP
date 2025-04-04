<?php

//inclure la class
require_once('../libs/fpdf.php');

//Connexion a la base de données
$host = "localhost";
$user = "root";
$pass = "sio2024";
$dbname = "hopital";

$conn = new mysqli($host, $user, $pass, $dbname);

//Vérifier la connexion
if($conn->connect_error){
    die("Connection échouée : " . $conn->connect_error);
}
 
//creation de l'objet pdf
$pdf=new FPDF();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();

// Ajout du logo
$pdf->Image("../images/LPFS_logo.png", 10, 8, 33);
$pdf->Ln(20); // Saut de ligne

// Titres des colonnes
$pdf->Cell(40, 10, 'Nom', 1);
$pdf->Cell(40, 10, 'Prénom', 1);
$pdf->Cell(50, 10, 'Numéro Sécurité Sociale', 1);
$pdf->Cell(40, 10, 'Date Pré-admission', 1);
$pdf->Cell(40, 10, 'Médecin', 1);
$pdf->Cell(40, 10, 'Service', 1);
$pdf->Ln(); // Nouvelle ligne
 
// Requête SQL pour récupérer les données
$sql = "SELECT 
            Patient.nom_naissance, 
            Patient.prenom, 
            Sociale.num_secu, 
            Preadmi.date_preadmi 
        FROM Patient 
        JOIN Sociale ON Patient.id_patient = Sociale.id_patient
        JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient";

$result = $conn->query($sql); 

// Vérifier si des résultats existent
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, utf8_decode($row['nom_naissance']), 1);
        $pdf->Cell(40, 10, utf8_decode($row['prenom']), 1);
        $pdf->Cell(50, 10, $row['num_secu'], 1);
        $pdf->Cell(40, 10, $row['date_preadmi'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(170, 10, "Aucune donnée trouvée", 1, 1, 'C');
}

//Fermeture de la connexion à la base de données
$conn->close();

//Génération du PDF
$pdf->Output();
?>