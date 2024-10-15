<!-- index.php -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตารางรายชื่อโรงพยาบาลเอกชน</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>ตารางรายชื่อโรงพยาบาลเอกชน</h1>

    <?php
    
    $jsonData = file_get_contents('priv_hos.json'); 
    $hospitals = json_decode($jsonData, true);

    
    $hospitalList = [];

    
    foreach ($hospitals['features'] as $hospital) {
        $name = $hospital['properties']['name'];
        $num_bed = $hospital['properties']['num_bed'];

        $hospitalList[$name] = [
            'large' => $num_bed >= 91,
            'medium' => ($num_bed >= 31 && $num_bed <= 90),
            'small' => $num_bed < 31
        ];
    }
    ?>

    <table>
        <tr>
            <th>ชื่อโรงพยาบาล</th>
            <th>ขนาดเล็ก</th>
            <th>ขนาดกลาง</th>
            <th>ขนาดใหญ่</th>
        </tr>
        <?php foreach ($hospitalList as $name => $sizes): ?>
            <tr>
                <td><?php echo $name; ?></td>
                <td><?php echo $sizes['small'] ? '✔️' : ''; ?></td>
                <td><?php echo $sizes['medium'] ? '✔️' : ''; ?></td>
                <td><?php echo $sizes['large'] ? '✔️' : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
