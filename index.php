<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_bin";

// ✅ สร้างการเชื่อมต่อ MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// ✅ ดึงจำนวนขวดทั้งหมด
$sql_total = "SELECT COUNT(id) AS total FROM photo_electric";
$result_total = $conn->query($sql_total);
$total_bottles = ($result_total && $row_total = $result_total->fetch_assoc()) ? $row_total["total"] : 0;

// ✅ ดึงจำนวนขวดที่ถูกทิ้งวันนี้
$sql_today = "SELECT COUNT(id) AS today FROM photo_electric WHERE DATE(time) = CURDATE()";
$result_today = $conn->query($sql_today);
$today_bottles = ($result_today && $row_today = $result_today->fetch_assoc()) ? $row_today["today"] : 0;

// ✅ ดึงจำนวนขวดที่ถูกทิ้งเดือนนี้
$sql_month = "SELECT COUNT(id) AS month FROM photo_electric 
              WHERE MONTH(time) = MONTH(CURDATE()) AND YEAR(time) = YEAR(CURDATE())";
$result_month = $conn->query($sql_month);
$month_bottles = ($result_month && $row_month = $result_month->fetch_assoc()) ? $row_month["month"] : 0;

// ✅ ดึงข้อมูลรายชั่วโมง
$hourly_data = array_fill(0, 24, 0);
$hourly_labels = [];
for ($i = 0; $i < 24; $i++) {
  $hourly_labels[] = sprintf("%02d:00", $i);  // แสดง 00:00, 01:00, ... 23:00
}

$sql_hourly = "SELECT HOUR(time) AS hour, COUNT(id) AS count 
               FROM photo_electric 
               WHERE DATE(time) = CURDATE()
               GROUP BY HOUR(time)
               ORDER BY hour";
$result_hourly = $conn->query($sql_hourly);

if ($result_hourly) {
  while ($row = $result_hourly->fetch_assoc()) {
    $hourly_data[$row["hour"]] = (int) $row["count"];
  }
}

// ✅ ดึงข้อมูลรายวัน (7 วันล่าสุด)
$daily_data = array_fill(0, 7, 0);
$daily_labels = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

$sql_daily = "SELECT WEEKDAY(time) AS day, COUNT(id) AS count 
              FROM photo_electric 
              WHERE YEARWEEK(time, 1) = YEARWEEK(CURDATE(), 1)
              GROUP BY WEEKDAY(time)";
$result_daily = $conn->query($sql_daily);

if ($result_daily) {
    while ($row = $result_daily->fetch_assoc()) {
        $index = $row["day"];  // ใช้ค่า 0-6 ตรงๆ
        $daily_data[$index] = (int) $row["count"];
    }
}
// ✅ ดึงข้อมูลรายเดือน
$monthly_data = array_fill(0, 12, 0);
$monthly_labels = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                   "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

$sql_monthly = "SELECT MONTH(time) AS month, COUNT(id) AS count 
                FROM photo_electric 
                WHERE YEAR(time) = YEAR(CURDATE())
                GROUP BY MONTH(time)";
$result_monthly = $conn->query($sql_monthly);

if ($result_monthly) {
    while ($row = $result_monthly->fetch_assoc()) {
        $index = $row["month"] - 1;  // แปลงให้ index อยู่ในช่วง 0-11
        $monthly_data[$index] = (int) $row["count"];
    }
}

// ✅ ปิดการเชื่อมต่อ
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="index.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;400;700&display=swap"
    rel="stylesheet" />
  <title>Dashboard</title>
</head>

<body>
  <div class="container">
    <div class="menu">
      <div class="logo">
        <h3>ถังคัดแยกพลาสติกอัจฉริยะ</h3>
      </div>
      <div class="underline-logo"></div>
      <div class="nav">
        <div class="menu-list">
          <ul>
            <li style="border-right: 3px solid #2eaf7d">
              <a href="index.html" style="color: #2eaf7d">
                <i class="fa-solid fa-house"></i>
                <span class="text">Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="head">
        <h1>ภาพรวม</h1>
        <hr style="width: 98%" />
      </div>
      <div class="overview">
        <div class="dashboard">
          <div class="dashborad-icon">
            <i class="fa-solid fa-trash-can"></i>
          </div>
          <div class="dashboard-detail">
            <p class="text">จำนวนขวดที่ถูกทิ้งทั้งหมด</p>
            <p class="number"><?php echo $total_bottles; ?></p>
          </div>
        </div>
        <div class="dashboard">
          <div class="dashborad-icon">
            <i class="fa-solid fa-calendar-check"></i>
          </div>
          <div class="dashboard-detail">
            <p class="text">จำนวนขวดที่ถูกทิ้งเดือนนี้</p>
            <p class="number"><?php echo $month_bottles; ?></p>
          </div>
        </div>
        <div class="dashboard">
          <div class="dashborad-icon">
            <i class="fa-regular fa-calendar"></i>
          </div>
          <div class="dashboard-detail">
            <p class="text">จำนวนขวดที่ถูกทิ้งวันนี้</p>
            <p class="number"><?php echo $today_bottles; ?></p>
          </div>
        </div>
      </div>

      <div class="trash-chart">
        <div class="trash-h">
          <div class="title-trash">
            <p style="padding: 10px; font-size: 1.2rem; font-weight: 600">
              จำนวนขวดที่ถูกทิ้งรายชั่วโมง
            </p>
            <i class="fa-solid fa-chart-simple"></i>
          </div>
          <div id="chart-h"></div>
        </div>
        <div class="trash-d">
          <div class="title-trash">
            <p style="padding: 10px; font-size: 1.2rem; font-weight: 400">
              จำนวนขวดที่ถูกทิ้งรายวัน
            </p>
            <i class="fa-solid fa-chart-simple"></i>
          </div>
          <div id="chart-d"></div>
        </div>
        <div class="trash-m">
          <div class="title-trash">
            <p style="padding: 10px; font-size: 1.2rem; font-weight: 600">
              จำนวนขวดที่ถูกทิ้งรายเดือน
            </p>
            <i class="fa-solid fa-chart-simple"></i>
          </div>
          <div id="chart-m"></div>
        </div>
      </div>
    </div>
  </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script
  src="https://kit.fontawesome.com/a2be86925b.js"
  crossorigin="anonymous"></script>

<script>
  // ✅ กราฟรายชั่วโมง
  var optionsArea = {
    chart: {
      height: 350,
      type: "area",
    },
    dataLabels: {
      enabled: false,
    },
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.7,
        opacityTo: 0.9,
        stops: [0, 90, 100],
      },
    },
    series: [{
      name: "จำนวนขวดที่ถูกทิ้งรายชั่วโมง",
      data: <?php echo json_encode($hourly_data, JSON_NUMERIC_CHECK); ?>,
    }, ],
    xaxis: {
      categories: <?php echo json_encode($hourly_labels); ?>,
    },
    colors: ["#59d584"],
  };
  var chartArea = new ApexCharts(document.querySelector("#chart-h"), optionsArea);
  chartArea.render();

  // ✅ กราฟรายวัน
  var optionsBar = {
    chart: {
      height: 350,
      type: "bar",
    },
    series: [{
      name: "จำนวนขวดที่ถูกทิ้งรายวัน",
      data: <?php echo json_encode($daily_data, JSON_NUMERIC_CHECK); ?>,
    }, ],
    xaxis: {
      categories: [
        "วันจันทร์",
        "วันอังคาร",
        "วันพุธ",
        "วันพฤหัสบดี",
        "วันศุกร์",
        "วันเสาร์",
        "วันอาทิตย์",
      ],
    },
    colors: ["#59d584"],
  };
  var chartBar = new ApexCharts(document.querySelector("#chart-d"), optionsBar);
  chartBar.render();

  // ✅ กราฟรายเดือน (ยังใช้ค่าคงที่)
  var options = {
    series: [{
      name: "จำนวนขวดที่ถูกทิ้งต่อเดือน",
      data: <?php echo json_encode($monthly_data, JSON_NUMERIC_CHECK); ?>,
    }, ],
    chart: {
      type: "bar",
      height: 380,
    },
    plotOptions: {
      bar: {
        borderRadius: 4,
        borderRadiusApplication: "end",
        horizontal: true,
      },
    },
    dataLabels: {
      enabled: false,
    },
    xaxis: {
      categories: [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม"
      ],
    },
    colors: ["#59d584"],
  };

  var chart = new ApexCharts(document.querySelector("#chart-m"), options);
  chart.render();
</script>


</html>