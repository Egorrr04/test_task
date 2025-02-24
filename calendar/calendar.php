<?php


//пропускаем выходные дни
function calculateDate($dateCell, $interval){
    $holidays = [
        "2025-01-01",
        "2025-01-07",
        "2025-02-23",
        "2025-03-08",
        "2025-05-01",
        "2025-05-09",
        "2025-06-12",
        "2025-11-04",
        "2026-01-01",
        "2026-01-07",
        "2026-02-23",
        "2026-03-08",
        "2026-05-01",
        "2026-05-09",
        "2026-06-12",
        "2026-11-04",
        "2027-01-01",
        "2027-01-07",
        "2027-02-23",
        "2027-03-08",
        "2027-05-01",
        "2027-05-09",
        "2027-06-12",
        "2027-11-04",
    ];

    $date = new DateTime($dateCell);
    $i = 1;

    //если выбран выходной или праздник, пропускаем его
    while ($date->format('N') >=6||in_array($date->format('Y-m-d'), $holidays)) {
        $date->modify("+1 day");
    }

    // вычитывает дату исходя от интервала
    while ($i <= $interval) {
        $date->modify("+1 day");
        if($i == $interval) {
            break;
        }
        // если не выходной и не праздник  - инкрементируем
        else if($date->format('N') < 6 && !in_array($date->format('Y-m-d'), $holidays) ) {  
            $i++;
        }
        
    }
    return $date->format('Y-m-d');
}

//передали значения post запросом
if($_SERVER['REQUEST_METHOD'] ==='POST' && isset($_POST['calculate_date'])){

    //print_r($_POST);  
    
    $dateCell = $_POST['dateCell'];
    $interval = $_POST['interval'];

    $futureDate = calculateDate($dateCell, $interval);
    // $date ->modify("+$interval day");
    $printCorectDate = "Выбранная дата: $dateCell";
    $printDate = "$printCorectDate" . "<br>". "Дата через $interval рабочих дней : " . $futureDate . "\n";
}
 
//функция генерации одного месяца 
function generateMonth($year, $month) {

    $date = new DateTime("$year-$month-01");
    $numDays= $date->format('t');
    $firstDayOfWeek = $date->format('N');
    $calendarTitle =  $date->format('F') . " " . $year ; 
    $calendar = '<div class="slide"><form id="myForm" method="post"><table border="1">';
    $calendar .= "<thead> <tr><td colspan='7'><h2 class='calendar__title'>$calendarTitle</h2></td></tr>";
    $calendar .= '<th>ПН</th><th>ВТ</th><th>СР</th><th>ЧТ</th><th>ПТ</th><th>СБ</th><th>ВС</th>';
    $calendar .= "</thead><tbody> <tr>";
    //echo  $dateSell ;
    for ( $i = 1; $i < $firstDayOfWeek; $i++){
        $calendar .= '<td> </td>';
    }
   
    $correctDay = 1;
    $correctDayOfWeek = $firstDayOfWeek;
    while($correctDay<=$numDays) {
        $dateCell = $date->format("Y-m-$correctDay");
       
        $calendar .= "<td class='td__cell'>
        <p class='date__cell'>$correctDay </p> 
        <input class='input__cell' id='cell-$dateCell'  form='myForm' required value=\"$dateCell\" type='radio' name='dateCell'> 
        <span class='emulator__cell'></span>
        </td>";

        if($correctDayOfWeek % 7 ==0&& $correctDay!=$numDays) {
            $calendar .=' </tr><tr>';
             
        }
        $correctDayOfWeek++;
        $correctDay++;
    }
    
    while($correctDayOfWeek % 7 !=0 && $correctDayOfWeek % 7 !=1 ){
        $calendar .= '<td></td>';
        $correctDayOfWeek++;
        
      
    }
     
    // $yearInPost = "<input form='myForm' type='hidden' name='year' value='$year'>";
    // $monthInPost = "<input form='myForm' type='hidden' name='month' value='$month'>";
    $calendar .= '</tbody></table>' . '</form> </div>';
    return $calendar;
}

$lengthOfCalendarInYears = 3;
//функция генерации всего календаря 
function generateCalendar(int $lengthOfCalendarInYears){
    $currentYear = date("Y");
    $monthIter = 0;
    $yearInter = 0;
    $fullCalendar = '';
    while($yearInter<$lengthOfCalendarInYears){
        
        while($monthIter < 12){
            $fullCalendar.= generateMonth($currentYear+$yearInter , 1 + $monthIter);
            $monthIter++;
        }
        $monthIter = 0; 
        $yearInter++;
    }
    return $fullCalendar;
}

?>
<div class="calendar">
    <div class="calendar__body">
        <button class="slider__button-prev"></button>
        <div class="slider">
            <div class="slider__line">
                <?=generateCalendar($lengthOfCalendarInYears)?>
            </div> 
        </div> 
        <button class="slider__button-next"></button>  
      </div> 
      <h2 class="calendar__print-time"><?php if(isset($printDate)) echo $printDate;?></h2>
      <input class="input" form="myForm" required type="number" name="interval" value="" placeholder = "Введите кол-во рабочих дней" min="1" max="100000">
    <button form="myForm" class="button" type="submit" name="calculate_date">Посчитать</button>
</div>


 
 




