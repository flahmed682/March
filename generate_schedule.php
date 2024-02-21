<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include MPDF library

// Get the next month and year
$currentMonth = date('m');
$currentYear = date('Y');
if ($currentMonth == 12) {
    $nextMonth = '01';
    $nextYear = $currentYear + 1;
} else {
    $nextMonth = sprintf("%02d", $currentMonth + 1);
    $nextYear = $currentYear;
}
// Get the number of days in the next month
$numDays = date('t', strtotime("$nextYear-$nextMonth-01"));

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs for person 1
    $personNames1 = explode(",", $_POST["person_names1"]);
    $selectedDays1 = $_POST["selected_days1"];

    // Get user inputs for person 2
    $personNames2 = explode(",", $_POST["person_names2"]);
    $selectedDays2 = $_POST["selected_days2"];

    // Get user inputs for person 3
    $personNames3 = explode(",", $_POST["person_names3"]);
    $selectedDays3 = $_POST["selected_days3"];
}

// Start building the HTML content
$calendarHTML = "<div class='table-container'><table>";

// First row: Dates of the month
$calendarHTML .= "<tr><th>Person</th>";
for ($day = 1; $day <= $numDays; $day++) {
    $calendarHTML .= "<th>$day</th>";
}
$calendarHTML .= "</tr>";

// Second row: Days of the week
$calendarHTML .= "<tr><th>Day</th>";
for ($day = 1; $day <= $numDays; $day++) {
    $timestamp = strtotime("$nextYear-$nextMonth-$day");
    $dayName = date('D', $timestamp);
    $calendarHTML .= "<td>$dayName</td>";
}
$calendarHTML .= "</tr>";

// Arrays for each option
$weekendDays = [6, 7, 1]; // Saturday, Sunday, Monday (ISO-8601 numeric representation)
$weekdayDays = [2, 3, 4]; // Tuesday, Wednesday, Thursday (ISO-8601 numeric representation)

// Loop through each person 1
foreach ($personNames1 as $personName) {
    $calendarHTML .= "<tr>";
    // First column: Person's name
    $calendarHTML .= "<td>$personName</td>";

    // Loop through each day of the month to generate the schedule
    for ($day = 1; $day <= $numDays; $day++) {
        $timestamp = strtotime("$nextYear-$nextMonth-$day");
        $dayOfWeek = date('N', $timestamp);

        // Check the selected radio button and generate schedule accordingly
        switch ($selectedDays1) {
            case 'all_days':
                if ($dayOfWeek != 5) { // 5 represents Friday
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>"; // Exclude 'L' for Friday
                }
                break;
            case 'weekend_days':
                if (in_array($dayOfWeek, $weekendDays)) {
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>";
                }
                break;
            case 'weekday_days':
                if (in_array($dayOfWeek, $weekdayDays)) {
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>";
                }
                break;
        }
    }
    $calendarHTML .= "</tr>";
}

// Loop through each person 2
foreach ($personNames2 as $personName) {
    $calendarHTML .= "<tr>";
    // First column: Person's name
    $calendarHTML .= "<td>$personName</td>";

    // Loop through each day of the month to generate the schedule
    for ($day = 1; $day <= $numDays; $day++) {
        $timestamp = strtotime("$nextYear-$nextMonth-$day");
        $dayOfWeek = date('N', $timestamp);

        // Check the selected radio button and generate schedule accordingly
        switch ($selectedDays2) {
            case 'all_days':
                if ($dayOfWeek != 5) { // 5 represents Friday
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>"; // Exclude 'L' for Friday
                }
                break;
            case 'weekend_days':
                if (in_array($dayOfWeek, $weekendDays)) {
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>";
                }
                break;
            case 'weekday_days':
                if (in_array($dayOfWeek, $weekdayDays)) {
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>";
                }
                break;
        }
    }
    $calendarHTML .= "</tr>";
}

// Loop through each person 3
foreach ($personNames3 as $personName) {
    $calendarHTML .= "<tr>";
    // First column: Person's name
    $calendarHTML .= "<td>$personName</td>";

    // Loop through each day of the month to generate the schedule
    for ($day = 1; $day <= $numDays; $day++) {
        $timestamp = strtotime("$nextYear-$nextMonth-$day");
        $dayOfWeek = date('N', $timestamp);

        // Check the selected radio button and generate schedule accordingly
        switch ($selectedDays3) {
            case 'all_days':
                if ($dayOfWeek != 5) { // 5 represents Friday
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>"; // Exclude 'L' for Friday
                }
                break;
            case 'weekend_days':
                if (in_array($dayOfWeek, $weekendDays)) {
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>";
                }
                break;
            case 'weekday_days':
                if (in_array($dayOfWeek, $weekdayDays)) {
                    $calendarHTML .= "<td class='L'>L</td>";
                } else {
                    $calendarHTML .= "<td>-</td>";
                }
                break;
        }
    }
    $calendarHTML .= "</tr>";
}

$calendarHTML .= "</table></div>";

// Create MPDF object
$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); // Landscape orientation

// Include CSS styles
$stylesheet = file_get_contents('styles.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

// Add title
$title = "Calendar Schedule - " . date('F Y') . " - Group A"; // Month and Group
$mpdf->SetTitle($title);

// Write HTML content to PDF
$mpdf->WriteHTML("<h1>$title</h1>");
$mpdf->WriteHTML($calendarHTML);

// Output PDF
$mpdf->Output('calendar_schedule.pdf', 'D');
?>
