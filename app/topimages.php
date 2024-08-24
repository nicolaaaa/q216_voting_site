<?php

class ImageData {
    private static $idCounter = 1; // Auto-incrementing counter for ID

    public $id;
    public $image_name;
    public $neg;
    public $total;
    public $percentage;
    public $marked;

    public function __construct($image_name, $neg, $total) {
        $this->id = self::$idCounter++;
        $this->image_name = $image_name;
        $this->neg = $neg;
        $this->total = $total;
        $this->percentage = ($total != 0) ? ($neg / $total) * 100 : 0;
        $this->marked = $image_name=== "09-06.jpg" || $image_name === "09-23.jpg";
    }

    // You can add methods to interact with or display the data if needed
}

// Sample data as provided
$data = [
    "09-06.jpg,60,88",
    "01-09.jpg,53,75",
    "09-23.jpg,48,75",
    "10-10.jpg,43,64",
    "10-04.jpg,38,58",
    "09-20.jpg,36,60",
    "03-25.jpg,36,56",
    "00-10.jpg,35,51",
    "02-13.jpg,35,62",
    "09-28.jpg,34,52",
    "09-03.jpg,33,55",
    "09-29.jpg,32,54",
    "08-06.jpg,32,51",
    "09-22.jpg,32,53",
    "01-15.jpg,32,54",
    "08-18.jpg,31,51",
    "01-19.jpg,31,56",
    "08-22.jpg,31,59",
    "01-27.jpg,31,51",
    "04-22.jpg,30,59",
];


//"09-06.jpg,114,174",
//"09-23.jpg,66,107",


// Creating an array to hold the ImageData objects
$imageObjects = [];

foreach ($data as $entry) {
    list($image_name, $neg, $total) = explode(',', $entry);
    $imageObjects[] = new ImageData($image_name, $neg, $total);
}

////$allimages = glob('img/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
////$allimages = array_map('basename', $allimages);
//
//$clones = array("09-06", "07-01", "10-09");
//$clones2 = array("09-23","08-06");
$totalImages = count($imageObjects);
$halfImages = ceil($totalImages / 2); // Split the images in half for two tables

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auswertung Bilderumfrage Top 20</title>
    <style>
        .table-container {
            display: flex;
            justify-content: space-between;
            gap: 50px; /* Add a large gap between the two tables */
        }
        table {
            width: 48%;
            border-collapse: collapse;
            font-size: 12px; /* Make the font smaller */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-height: 100px;
            width: auto;
        }
        footer {
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>

<h2>Auswertung Bilderumfrage Top 20</h2>

<div class="table-container">
    <!-- First Table -->
    <table>
        <thead>
        <tr>
            <th>Platz</th>
            <th>Image Name</th>
            <th>Votes Austauschen</th>
            <th>Votes Gesamt</th>
            <th>Prozent </th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < $halfImages; $i++): ?>
            <tr>
                <td><?php echo $imageObjects[$i]->id; ?></td>
                <td><img src="img/<?php echo $imageObjects[$i]->image_name; ?>" alt="<?php echo htmlspecialchars($imageObjects[$i]->image_name); ?>"></td>
                <td><?php echo $imageObjects[$i]->neg; ?></td>
                <td><?php echo $imageObjects[$i]->total; ?></td>
                <td><?php echo number_format($imageObjects[$i]->percentage, 2); ?>% <?php if ($imageObjects[$i]->marked) echo ' *'?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <!-- Second Table -->
    <table>
        <thead>
        <tr>
            <th>Platz</th>
            <th>Image Name</th>
            <th>Votes Austauschen</th>
            <th>Votes Gesamt</th>
            <th>Prozent </th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = $halfImages; $i < $totalImages; $i++): ?>
            <tr>
                <td><?php echo $imageObjects[$i]->id; ?></td>
                <td><img src="img/<?php echo $imageObjects[$i]->image_name; ?>" alt="<?php echo htmlspecialchars($imageObjects[$i]->image_name); ?>"></td>
                <td><?php echo $imageObjects[$i]->neg; ?></td>
                <td><?php echo $imageObjects[$i]->total; ?></td>
                <td><?php echo number_format($imageObjects[$i]->percentage, 2); ?>%</td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>* Bilder waren mehrfach in der Abstimmung da sie mehrfach im Haus hängen (Bild 09-06 dreimal, Bild 09-23 zweimal). Ergebniss wurde dahingehend bereinigt, dass wenn mit gleichem Cookie für das Bild mehrfach gestimmt wurde nur eine Stimme gezählt wurde. Unbereinigte Ergenisse sind für 09-06 114/174 und für 09-23 66/107</p>

</body>
</html>