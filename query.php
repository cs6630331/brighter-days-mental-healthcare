<?php
$servername = "localhost";
$username = "168DB36";
$password = "F6pM0aPf";
$dbname = "168DB_36";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
     <meta charset="UTF-8">
     <title>ระบบจัดการคลินิกจิตเวช</title>
</head>
<body>
     <h1>ระบบจัดการคลินิกจิตเวช</h1>
     
     <h2>Query 1: รายการนัดหมายทั้งหมด</h2>
     <table border="1">
          <tr>
               <th>วันที่สร้าง</th>
               <th>ชื่อผู้ป่วย</th>
               <th>นามสกุลผู้ป่วย</th>
               <th>ชื่อแพทย์</th>
               <th>นามสกุลแพทย์</th>
               <th>วันที่นัด</th>
               <th>เวลานัด</th>
          </tr>
          <?php

          //query1
          $sql1 = "SELECT 
                         `_appointment`.`timestamp`,
                         `_user`.`user_name`,
                         `_user`.`user_surname`,
                         `_doctor`.`doctor_name`,
                         `_doctor`.`doctor_surname`,
                         `_appointment`.`appointment_date`,
                         `_appointment`.`appointment_time`
                    FROM `_appointment`
                    JOIN `_doctor` ON `_doctor`.doctor_id = `_appointment`.`doctor_id`
                    JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id`
                    GROUP BY `_appointment`.`appointment_id`";
          
          $stmt1 = $pdo->prepare($sql1);
          $stmt1->execute();
          $appointments = $stmt1->fetchAll(PDO::FETCH_ASSOC);
          
          foreach($appointments as $row) {
               echo "<tr>";
               echo "<td>" . $row['timestamp'] . "</td>";
               echo "<td>" . $row['user_name'] . "</td>";
               echo "<td>" . $row['user_surname'] . "</td>";
               echo "<td>" . $row['doctor_name'] . "</td>";
               echo "<td>" . $row['doctor_surname'] . "</td>";
               echo "<td>" . $row['appointment_date'] . "</td>";
               echo "<td>" . $row['appointment_time'] . "</td>";
               echo "</tr>";
          }
          ?>
     </table>

     <h2>Query 2: รายละเอียดการรักษาเสร็จสิ้น (กันยายน 2025)</h2>
     <table border="1">
          <tr>
               <th>วันที่</th>
               <th>เวลา</th>
               <th>ชื่อคนไข้</th>
               <th>นามสกุลคนไข้</th>
               <th>ชื่อหมอ</th>
               <th>นามสกุลหมอ</th>
               <th>หมายเหตุ</th>
          </tr>
          <?php
          
          //query2
          $sql2 = "SELECT 
               `_appointment`.`appointment_date`,
               `_appointment`.`appointment_time`,
               `_user`.`user_name` AS patient_name,
               `_user`.`user_surname` AS patient_surname,
               `_doctor`.`doctor_name`,
               `_doctor`.`doctor_surname`,
               `_appointment`.`notes`
               FROM 
               `_appointment`
               JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
               JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id`
               WHERE 
               `_appointment`.`appointment_date` LIKE '2025-09%' AND
               `_appointment`.`status` = 'completed'
               ORDER BY 
               `_appointment`.`appointment_date`, `_appointment`.`appointment_time`";
          
          $stmt2 = $pdo->prepare($sql2);
          $stmt2->execute();
          $doctor1_stats = $stmt2->fetchAll(PDO::FETCH_ASSOC);
          
          foreach($doctor1_stats as $row) {
               echo "<tr>";
               echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
               echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
               echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
               echo "<td>" . htmlspecialchars($row['patient_surname']) . "</td>";
               echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
               echo "<td>" . htmlspecialchars($row['doctor_surname']) . "</td>";
               echo "<td>" . htmlspecialchars($row['notes']) . "</td>";
               echo "</tr>";
          }
          ?>
     </table>

     <h2>Query 3: สถิติการรักษาเสร็จสิ้นทั้งหมด (กันยายน 2025)</h2>
     <table border="1">
          <tr>
               <th>วันที่</th>
               <th>จำนวนการรักษาที่เสร็จสิ้น</th>
          </tr>
          <?php

          //query3
          $sql3 = "SELECT 
                         `_appointment`.`appointment_date`,
                         COUNT(`_doctor`.`doctor_id`) AS count
                    FROM `_appointment`
                    JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
                    WHERE `_appointment`.`appointment_date` LIKE '2025-09%'
                    AND `_appointment`.`status` = 'completed'
                    GROUP BY `_appointment`.`appointment_date`";
          
          $stmt3 = $pdo->prepare($sql3);
          $stmt3->execute();
          $all_completed_stats = $stmt3->fetchAll(PDO::FETCH_ASSOC);
          
          foreach($all_completed_stats as $row) {
               echo "<tr>";
               echo "<td>" . $row['appointment_date'] . "</td>";
               echo "<td>" . $row['count'] . "</td>";
               echo "</tr>";
          }
          ?>
     </table>

     <h2>Query 4: สถิติการนัดหมายรายวัน (กันยายน 2025)</h2>
     <table border="1">
          <tr>
               <th>วันที่</th>
               <th>จำนวนการนัดหมาย</th>
          </tr>
          <?php
          //query4
          $sql4 = "SELECT
                         `_appointment`.`timestamp`,
                         COUNT(`_doctor`.`doctor_id`) AS count
                    FROM `_appointment`
                    JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
                    WHERE `_appointment`.`timestamp` LIKE '2025-09%'
                    GROUP BY CAST(`_appointment`.`timestamp` AS DATE)";
          
          $stmt4 = $pdo->prepare($sql4);
          $stmt4->execute();
          $daily_stats = $stmt4->fetchAll(PDO::FETCH_ASSOC);
          
          foreach($daily_stats as $row) {
               echo "<tr>";
               echo "<td>" . date('Y-m-d', strtotime($row['timestamp'])) . "</td>";
               echo "<td>" . $row['count'] . "</td>";
               echo "</tr>";
          }
          ?>
     </table>
</body>
</html>
