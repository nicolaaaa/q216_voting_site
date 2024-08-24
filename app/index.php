<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Q216 Image Voting</title>

    <!-- Favicon -->
    <link rel="icon" href="icon/q216.png" type="image/png" />

    <!-- Theme style CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css">
</head>
<?php

   $link = mysqli_connect('voting_db', 'travellist_user', 'password', 'travellist');

if (!$link) {
    ?>
    <div style="width: 100%">
        <div class="error-content">
            <h1>Database connection error</h1>
            <p>
                <?php
                echo mysqli_connect_errno() . ":" . mysqli_connect_error();
                ?>
            </p>
        </div>
    </div>

    <?php
}

$sid = $_COOKIE['q216_session'];

if ($_POST['positive'] != '') {
    $positive = $_POST['positive'];
    $query = "INSERT INTO survey_results (image_name,num_total_votes,num_negative_votes, sid) VALUES ('$positive',1,0,'$sid')";
    mysqli_query($link, $query);
}

if ($_POST['negative'] != '') {
    $negative = $_POST['negative'];
    $query = "INSERT INTO survey_results (image_name,num_total_votes,num_negative_votes,sid) VALUES ('$negative',1,1,'$sid')";
    mysqli_query($link, $query);
}

$images = [];
//$res = mysqli_query($link, "select image_name, sum(num_negative_votes) as neg, count(num_negative_votes) as sum from survey_results group by image_name order by neg / sum desc limit 6;");

$res = mysqli_query($link, "select image_name, sum(num_negative_votes) as neg, count(num_negative_votes) as sum from survey_results group by image_name order by sum(num_negative_votes) desc limit 6;");
while ($row = mysqli_fetch_assoc($res)) {
    $images[] = $row;
}

if ($_POST['image'] != '') {
    $randomImage = $_POST['image'];
    $res = mysqli_query($link, "select 1 from survey_results where image_name = '" . $randomImage . "' and sid = '" . $sid . "' ;");
    $already_voted = mysqli_num_rows($res);

} else {
    $already_voted = 1;
    do {
        $allImages = glob('img/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $allImages = array_map('basename', $allImages);
        $randomImage = $allImages[array_rand($allImages)];

        $res = mysqli_query($link, "select 1 from survey_results where image_name = '" . $randomImage . "' and sid = '" . $sid . "' ;");
        $already_voted = mysqli_num_rows($res);
    } while ($already_voted > 0);
}
?>

<body>
    <div class="container">

        <div class="side side_mini" id="mySidenav">
            <div class="header">
                <div class="title">Top 6 Picks zum Austauschen</div>
                <span class="close" id="sidebar-close-toggle">&times;</span>
            </div>

            <?php foreach ($images as $image) { ?>
                <?php
                echo "<form method='post' name='formEvaEdit' target='_self' action='/'>\n";
                echo "<input type='hidden' name='image' value='" . $image['image_name'] . "' />\n"; ?>
                <div class="messages">
                    <div class="avatar">
                        <?php echo '<img src="img/thumbnails/' . $image['image_name'] . '" alt="">' ?>
                    </div>
                    <div class="message">
                        <div class="text">
                            <?php echo $image['neg'] ?> Votes für
                            Tauschen
                        </div>
                    </div>
                </div>
                <?php
                echo "</form>\n";
            } ?>
            <div>
                <div class="expand" id="sidebar-expand-toggle">
                    <span title="Navigation erweitern" class="fas fa-angle-double-right menu_icon"></span>
                    <span title="Navigation erweitern" class="fas fa-trophy menu_icon"></span>
                </div>
            </div>
        </div>


        <div class="content">
            <div class="header">
                <div class="title">Bild behalten?</div>
            </div>
            <div class="card">
                <div class="user">
                    <?php echo '<img src="img/' . $randomImage
                        . '" class="user" alt="">' ?>
                    <div class="profile">
                    </div>
                </div>
            </div>

            <div class="buttons">

                <?php
                echo "<form method='post' name='no' target='_self' action='/'>\n";
                echo "<input type='hidden' name='negative' value='" . $randomImage . "' />\n"; ?>
                <div class="no <?php
                $cls = $already_voted != 0 ? "disabled" : "enabled";
                echo $cls; ?>">
                    <i class="fas fa-times"></i>
                </div>
                <?php
                echo "</form>" ?>

                <?php
                echo "<form method='post' name='heart' target='_self' action='/'>\n";
                echo "<input type='hidden' name='positive' value='" . $randomImage . "' />\n"; ?>
                <div class="heart <?php
                $cls = $already_voted != 0 ? "disabled" : "enabled";
                echo $cls; ?>" disabled="true">
                    <i class="fas fa-heart"></i>
                </div>
                <?php
                echo "</form>" ?>

                <?php if ($already_voted != 0): ?>
                    <div class="heart enabled">
                        <a href="/">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
                <?php endif ?>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">

<div>

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#deutsch" aria-controls="deutsch" role="tab" data-toggle="tab">Deutsch</a></li>
    <li role="presentation"><a href="#english" aria-controls="english" role="tab" data-toggle="tab">English</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="deutsch">
Hallo liebe*r Nachbar*in aus dem Q216 😀,<br>
hier wollen wir gemeinsam darüber abstimmen, welche Bilder im Haus wir für sexistisch oder geschmacklos halten. Die Bilder mit den meisten Votes werden dann ersetzt.<br>
Das ist die Umsetzung der ersten Forderung 🎉  die wir Ende Juni an die Eigentümer gestellt haben.  Den aktuellen Stand findest du in der Tabelle, den allgemeinen Überblick zur Vernetzung gibts auf der <a href="https://mg-berlin.org/q216/">🌐  Q216 MGB Website</a>.

<table class="table table-sm">
<thead>
  <tr>
    <th></th>
    <th>Forderung</th>
    <th>Reaktion</th>
  </tr></thead>
<tbody>
  <tr class="danger">
    <th scope="row">Kaltmiete</th>
    <td>Senkung auf 8 €/qm</td>
    <td>Können wir nicht</td>
  </tr>
  <tr class="danger">
    <th scope="row">Warmmiete</th>
    <td>Anpassung an die reale Wohnungsgröße</td>
    <td>Abrechung erfolgt angeblich nach qm</td>
  </tr>
  <tr class="warning">
    <th scope="row">Hausverwaltung</th>
    <td>Reaktion innerhalb von 3 Werktagen</td>
    <td>Neue Hausverwaltung soll besser sein</td>
  </tr>
  <tr class="warning">
    <th scope="row">Kellerräume</th>
    <td>Mehr Sicherheit</td>
    <td>Sind angeblich mitlerweile sicher</td>
  </tr>
  <tr class="warning">
    <th scope="row">Glassfaser</th>
    <td>Schneller Anschluss und Infos für Bewohner</td>
    <td>Wird gerade geprüft</td>
  </tr>
  <tr class="warning">
    <th scope="row">Reinigung</th>
    <td>Regelmäßig für mehr Sauberkeit</td>
    <td>Soll es angeblich schon geben</td>
  </tr>
  <tr class="warning">
    <th scope="row">Schädlinge</th>
    <td>Bekämpfung gezahlt von Eigentümern</td>
    <td>Unklare Antwort</td>
  </tr>
  <tr class="success">
    <th scope="row">Flur- Bilder</th>
    <td>Ersetzen der geschmacklosen und sexistischen</td>
    <td>Sagts uns welche ersetzt werden sollen</td>
  </tr>
</tbody></table>

Achte auf Ankündigungen im Community-Chat, tausch dich mit deinen Nachbar*innen aus und check deinen Briefkasten in den kommenden Tagen für die nächste Aktion. Gemeinsam für ein besseres Q216 ✊!<br><br>
<b>Hinweis:</b> Bilder, die im Haus mehrmals hängen tauchen auch mehrmals im Voting auf. Die Reinfolge wird per Zufall bestimmt.
</div>
    <div role="tabpanel" class="tab-pane" id="english">
Hello dear neighbor from the Q216 😀,<br>
Here we want to vote together on which pictures in the house we consider sexist or tasteless. The pictures with the most votes will then be replaced.<br>
This is the implementation of the first demand 🎉 that we made to the owners at the end of June.  You can find the current status in the table, the general overview of the network can be found on the <a href="https://mg-berlin.org/en/q216-house/">🌐 Q216 MGB website</a>.

<table class="table table-sm">
<thead>
  <tr>
    <th></th>
    <th>Demand 			</th>
    <th>Reaction 			</th>
  </tr></thead>
<tbody>
  <tr class="danger">
    <th>Cold rent</th>
    <td>Reduction to 8 €/sqm</td>
    <td>We cannot</td>
  </tr>
  <tr class="danger">
    <th>Warn rent</th>
    <td>Adjustment to the actual room size</td>
    <td>Supposedly according to sqm</td>
  </tr>
  <tr class="warning">
    <th>Property management</th>
    <td>Response within 3 working days</td>
    <td> New property management should be better</td>
  </tr>
  <tr class="warning">
    <th>Basement rooms </th>
    <td>More security</td>
    <td>Are supposedly safe in the meantime</td>
  </tr>
  <tr class="warning">
    <th>Glass fiber</th>
    <td>Fast connection and transparency</td>
    <td>Currently being checked</td>
  </tr>
  <tr class="warning">
    <th>Cleaning</th>
    <td>Regularly for more cleanliness</td>
    <td>Supposedly it already exists</td>
  </tr>
  <tr class="warning">
    <th>Pests</th>
    <td>Control paid by owners</td>
    <td>Unclear answer</td>
  </tr>
  <tr class="success">
    <th>Hallway pictures</th>
    <td>Replacing the tasteless and sexist ones</td>
    <td>Tell us which ones should be replaced</td>
  </tr>
</tbody></table>

Watch out for announcements in the community chat, talk to your neighbors and check your mailbox in the coming days for the next campaign. Together for a better Q216 ✊!<br><br>
<b>Note:</b> Pictures that hang several times in the house also appear several times in the voting. The sequence is random.

</div>
  </div>

</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="info btn" type="button" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-info"></i>
            </button>
        </div>
    </div>

    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <?php if(!isset($_COOKIE['q216_session'])): ?>
        <script>
            $('#myModal').modal({
                show: true
            })
        </script>
    <?php endif ?>
</body>
</html>
