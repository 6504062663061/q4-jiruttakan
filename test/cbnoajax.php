<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เลือกประเภทโรงพยาบาล</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>เลือกประเภทโรงพยาบาล</h1>

    <form method="POST">
        <label>
            <input type="checkbox" name="size[]" value="large"> โรงพยาบาลขนาดใหญ่ (91 เตียงขึ้นไป)
        </label><br>
        <label>
            <input type="checkbox" name="size[]" value="medium"> โรงพยาบาลขนาดกลาง (31-90 เตียง)
        </label><br>
        <label>
            <input type="checkbox" name="size[]" value="small"> โรงพยาบาลขนาดเล็ก (ไม่เกิน 30 เตียง)
        </label><br><br>
        <input type="submit" value="แสดงรายชื่อโรงพยาบาล">
    </form>

    <?php
    if (isset($_POST['size'])) {
        
        $jsonData = file_get_contents('priv_hos.json');
        $data = json_decode($jsonData, true);

        
        $selectedSizes = $_POST['size'];

       
        echo "<h2>รายชื่อโรงพยาบาลที่เลือก:</h2>";
        echo "<table>
                <tr>
                    <th>ชื่อโรงพยาบาล</th>
                    <th>จำนวนเตียง</th>
                    <th>ที่อยู่</th>
                    <th>เบอร์โทร</th>
                </tr>";

        
        foreach ($data['features'] as $hospital) {
            $num_bed = $hospital['properties']['num_bed'];

            
            if ((in_array('large', $selectedSizes) && $num_bed >= 91) ||
                (in_array('medium', $selectedSizes) && $num_bed >= 31 && $num_bed <= 90) ||
                (in_array('small', $selectedSizes) && $num_bed <= 30)) {

                echo "<tr>
                        <td>" . htmlspecialchars($hospital['properties']['name']) . "</td>
                        <td>" . htmlspecialchars($hospital['properties']['num_bed']) . "</td>
                        <td>" . htmlspecialchars($hospital['properties']['address']) . "</td>
                        <td>" . htmlspecialchars($hospital['properties']['tel']) . "</td>
                      </tr>";
            }
        }
        echo "</table>";
    }
    ?>
</body>
</html>
