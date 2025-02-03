<?php
if (isset($_GET['value'])) {
    $value = intval($_GET['value']); // ป้องกันการโจมตี
 echo "Received value: " . $value;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smart_bin";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO photo_electric (value) VALUES (?)");
    $stmt->bind_param("i", $value);

    if ($stmt->execute()) {
        echo "Save ok";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No value received!";
}
?>
