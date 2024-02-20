<?php
// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');
// Get the number of days in the current month
$numDays = date('t');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $personNames = explode(",", $_POST["person_names"]);
    $selectedDays = $_POST["selected_days"];
}

echo "<h2>Calendar for $currentMonth/$currentYear</h2>";
echo "<table>";

// First row: Dates of the month
echo "<tr><th>Person</th>";
for ($day = 1; $day <= $numDays; $day++) {
    echo "<th>$day</th>";
}
echo "</tr>";

// Second row: Days of the week
echo "<tr><th>Day</th>";
for ($day = 1; $day <= $numDays; $day++) {
    $timestamp = strtotime("$currentYear-$currentMonth-$day");
    $dayName = date('D', $timestamp);
    echo "<td>$dayName</td>";
}
echo "</tr>";

// Arrays for each option
$weekendDays = [6, 7, 1]; // Saturday, Sunday, Monday (ISO-8601 numeric representation)
$weekdayDays = [2, 3, 4]; // Tuesday, Wednesday, Thursday (ISO-8601 numeric representation)

// Loop through each person
foreach ($personNames as $personName) {
    echo "<tr>";
    // First column: Person's name
    echo "<td>$personName</td>";
    
    // Loop through each day of the month to generate the schedule
    for ($day = 1; $day <= $numDays; $day++) {
        $timestamp = strtotime("$currentYear-$currentMonth-$day");
        $dayOfWeek = date('N', $timestamp);
        
        // Check the selected radio button and generate schedule accordingly
switch ($selectedDays) {
    case 'all_days':
        if ($dayOfWeek != 5) { // 5 represents Friday
            echo "<td>M</td>";
        } else {
            echo "<td>-</td>"; // Exclude 'L' for Friday
        }
        break;
    case 'weekend_days':
        if (in_array($dayOfWeek, $weekendDays)) {
            echo "<td>L</td>";
        } else {
            echo "<td>-</td>";
        }
        break;
    case 'weekday_days':
        if (in_array($dayOfWeek, $weekdayDays)) {
            echo "<td>L</td>";
        } else {
            echo "<td>-</td>";
        }
        break;
}

    }
    echo "</tr>";
}
echo "</table>";
?>
