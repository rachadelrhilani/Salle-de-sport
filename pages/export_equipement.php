<?php
require '../vendor/autoload.php';
include("../connection/connect.php");

use Dompdf\Dompdf;

ini_set('memory_limit', '1024');

$export_equipements = "SELECT * FROM equipements WHERE etat = 'Moyen' ORDER BY type ASC";
$send_query = mysqli_query($connect,$export_equipements);
$rows_equipements = mysqli_fetch_assoc($send_query);
$html = '<h2>Liste des equipements</h2>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
<tr>
<th>Nom</th><th>type</th><th>quantite disponible</th><th>etat</th>
</tr>';
while($rows_equipements){
   $html .= "<tr>
    <td>{$rows_equipements['nom']}</td>
    <td>{$rows_equipements['type']}</td>
    <td>{$rows_equipements['quantite_disponible']}</td>
    <td>{$rows_equipements['etat']}</td>
    </tr>"; 
}
$html .= "</table>";
$pdf_equipement = new Dompdf();
$pdf_equipement->loadHtml($html);
$pdf_equipement->setPaper("A4","landscape");
$pdf_equipement->render();
$pdf_equipement->stream("liste_equipement.pdf", ["Attachment" => true]);
?>
