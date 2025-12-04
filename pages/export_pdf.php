<?php
require '../vendor/autoload.php';
include("../connection/connect.php");

use Dompdf\Dompdf;

$query = "SELECT * FROM cours ORDER BY date_cours DESC";
$result = mysqli_query($connect, $query);

$html = '<h2>Liste des Cours</h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
<tr>
<th>Nom</th><th>Catégorie</th><th>Date</th><th>Heure</th>
<th>Durée</th><th>Max Participants</th>
</tr>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
    <td>{$row['nom']}</td>
    <td>{$row['categorie']}</td>
    <td>{$row['date_cours']}</td>
    <td>{$row['heure']}</td>
    <td>{$row['duree']}</td>
    <td>{$row['nb_max_participants']}</td>
    </tr>";
}

$html .= '</table>';

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream("liste_cours.pdf", ["Attachment" => true]);
?>
