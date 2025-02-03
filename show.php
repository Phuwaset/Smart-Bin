<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_bin";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่า table มี column `timestamp` หรือไม่
$sql = "SELECT id, value, time FROM photo_electric ORDER BY `id` DESC" ;
$result = $conn->query($sql);

// ถ้า SQL Query ผิดพลาด แสดง Error ออกมา
if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Bin Data</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 50%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f4a261; }
        tr:nth-child(even) { background-color: #f1f1f1; }
    </style>
</head>
<body>

    <h2>📊 Smart Bin - ข้อมูลล่าสุด</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Value</th>
            <th>Timestamp</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["value"] . "</td>";
                echo "<td>" . $row["time"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>ไม่มีข้อมูล</td></tr>";
        }
        $conn->close();
        ?>
    </table>

</body>
</html>
