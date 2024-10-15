<!-- dropdown.php -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เลือกโรงพยาบาลขนาดใหญ่</title>
</head>
<body>
    <h1>เลือกโรงพยาบาลขนาดใหญ่</h1>

    <form>
        <label for="hospitals">โรงพยาบาลขนาดใหญ่:</label>
        <select id="hospitals" name="hospitals">
            <?php
            
            $jsonData = file_get_contents('priv_hos.json');
            $data = json_decode($jsonData, true);

            
            foreach ($data['features'] as $hospital) {
                if ($hospital['properties']['num_bed'] >= 91) { 
                    echo '<option value="' . $hospital['properties']['name'] . '">' . $hospital['properties']['name'] . '</option>';
                }
            }
            ?>
        </select>
        <input type="submit" value="เลือก">
    </form>
</body>
</html>
