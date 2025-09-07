<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendrier</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="calendar">
<?php 

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=phpadmin', 'utilisateur', '');

// Récupérer les événements de la base de données
$stmt = $pdo->prepare("SELECT date, event_description FROM events");
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Créer un tableau associatif des événements pour faciliter l'affichage
$events_map = [];
foreach ($events as $event) {
    $events_map[$event['date']] = $event['event_description'];
}

// Afficher le calendrier
$month = date('n');
$year = date('Y');

echo '<table>';
echo '<tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr>';

// Premier jour du mois
$first_day = mktime(0, 0, 0, $month, 1, $year);

// Nombre de jours dans le mois
$days_in_month = date('t', $first_day);

// Jour de la semaine du premier jour du mois
$day_week = date('N', $first_day);

// Commencer la première ligne du calendrier
echo '<tr>';

// Afficher les jours vides avant le premier jour du mois
for ($i = 1; $i < $day_week; $i++) {
    echo '<td></td>';
}

// Boucle sur tous les jours du mois
for ($day = 1; $day <= $days_in_month; $day++) {
    // Vérifier s'il y a un événement pour ce jour
    $event_description = isset($events_map[date('Y-m-d', mktime(0, 0, 0, $month, $day, $year))]) ? $events_map[date('Y-m-d', mktime(0, 0, 0, $month, $day, $year))] : '';

    // Déterminer la classe CSS pour le jour actuel ou avec un événement
    $class = ($day == date('j') && $month == date('n') && $year == date('Y')) ? 'current-day' : '';
    $class .= ($event_description != '') ? ' has-event' : '';

    // Afficher le jour avec un lien pour afficher les détails de l'événement
    echo '<td class="' . $class . '" title="' . $event_description . '">' . $day . '</td>';

    // Passer à la prochaine ligne si c'est le dernier jour de la semaine
    if ($day_week == 7) {
        echo '</tr>';
        if ($day < $days_in_month) {
            echo '<tr>';
        }
        $day_week = 1;
    } else {
        $day_week++;
    }
}

// Compléter la dernière ligne du calendrier avec des jours vides si nécessaire
if ($day_week != 1) {
    for ($i = $day_week; $i <= 7; $i++) {
        echo '<td></td>';
    }
    echo '</tr>';
}

echo '</table>';
 
?>

 
</div>

</body>
</html>
