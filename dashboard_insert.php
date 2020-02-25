<?php

function build_calender($month,$year){

  $conn = mysqli_connect(localhost,'root','','patientdatabase');

        if (isset($_GET['date'])) {

            $date = $_GET['date'];

            $mysqli = "SELECT * FROM bookings WHERE MONTH(date) =?";
            $mysqli->bind_param('ss',$month,$year);
            $bookings = array();

      if ($mysqli->execute()) {

          $result = $mysqli->get_result();

            if ($result->num_rows>0) {

              while ($row = $result->fetch_assoc()) {

                  $bookings[] = $row['timeslot'];

              }

              $conn->close();

            }

      }

    }

  $daysOfWeek =array('Sunday','Monday','Tuesdays','Wedensday','Thursday','Friday','Saturday');

  $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

  $numberDays = date('t',$firstDayOfMonth);

  $dateComponents = getdate($firstDayOfMonth);

  $monthName = $dateComponents['month'];

  $dayOfWeek = $dateComponents['wday'];

  $todaysdate = date('Y-m-d');

    $calendar = "<table class='table table-bordered'>";
    $calendar.= "<center><h2>$monthName $year</h2></center>";

    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m'.mktime(0,0,0,$month-1,1,$year))."&year=".date('Y',mktime(0,0,0,$month-1,1,$year))."<Previous Month</a>";

    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y').">Current Month</a>";

    $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m',mktime(0,0,0,$month+1,1,$year))."&year=".date('Y',mktime(0,0,0,$month+1,1,$year)).">Next Month</a></center><br>";

    $calendar.= "<tr>";

        foreach ($daysOfWeek as $day) {

          $calendar.= "<th class='header'>$day</th>";

        }

      $currentDay = 1;
      $calendar.="</tr><tr>";

        if ($dayOfWeek > 0) {

            for ($i=0; $i < $dayOfWeek; $i++) {

               $calendar.="<td class='empty'></td>";

            }

        }

      $month = str_pad($month,2,"0",STR_PAD_LEFT);

      while ($currentDay <= $numberDays) {

          if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar.=" </tr><tr>";

          }

          $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
          $date ="$year-$month-$currentDayRel";

          $dayname = "strtolower(date('l',strotime($date)))";
          $eventNum = 0;
          $today = $date==date('Y-m-d')?"today":"";

          if ($date<date('Y-m-d')) {

            $calendar.= "<td><h4>$currentDay</h4><button class='btn btn-danger btn-xs'>N/A</button>";

          }elseif (in_array($date,$bookings)) {

              $calendar.= "<td class='$today'><h4>$currentDay</h4><button class='btn btn-danger btn-xs'>Already Booked</button>";

          }else {

            $calendar.= "<td class='$today'><h4>$currentDay</h4><a href='booking.php?date=".$date."' class='btn btn-success btn-xs'>Book</a>";

          }

          $calendar.="</td>";

          $currentDay++;
          $dayOfWeek++;
        }

        if ($dayOfWeek!=7) {

          $remainingDays = 7-$dayOfWeek;

            for ($n=0; $n < $remainingDays;$n++) {

                $calendar.="<td></td>";

            }

          $calendar.="</tr>";
          $calendar.="</table>";

          echo $calendar;

      }

}



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style media="screen">
      table{

        table-layout:fixed;

      }
      td{

        width:100px;
        text-align: center;

      }
      .today{

        background:yello;
      }

    </style>
    <title>Dashbord</title>
  </head>
  <link rel="stylesheet" href="dashboard.css">
  <body>
    <div class ="container">
      <div class="row">
        <div class="col-md-12">

    <?php

        $dateComponents = getdate();
        $month = $dateComponents['mon'];
        $year = $dateComponents['year'];

        echo build_calender($month,$year);

     ?>
      </div>
    </div>
 <div>

  </body>
</html>
