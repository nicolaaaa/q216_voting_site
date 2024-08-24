<?php


$allimages = glob('img/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
$allimages = array_map('basename', $allimages);


$totalImages = count($allimages);
$halfImages = ceil($totalImages / 2); // Split the images in half for two tables

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anhang: Bilder Übersicht</title>
    <style>
        .table-container {
            display: flex;
            justify-content: space-between;
        }
        table {
            width: 48%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<h2>Anhang: Bilder Übersicht</h2>

<div class="table-container">
    <!-- First Table -->
    <table>
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < $halfImages; $i++): ?>
            <tr>
                <td><img src="img/<?php echo $allimages[$i]; ?>" alt="<?php echo htmlspecialchars($allimages[$i]); ?>"></td>
                <td><?php echo htmlspecialchars($allimages[$i]); ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <!-- Second Table -->
    <table>
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = $halfImages; $i < $totalImages; $i++): ?>
            <tr>
                <td><img src="img/<?php echo $allimages[$i]; ?>" alt="<?php echo htmlspecialchars($allimages[$i]); ?>"></td>
                <td><?php echo htmlspecialchars($allimages[$i]); ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>

</body>
</html>
