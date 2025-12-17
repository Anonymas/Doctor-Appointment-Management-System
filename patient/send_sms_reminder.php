<?php
require '../vendor/autoload.php'; // Correct path to Composer autoload file
include("../connection.php");

use Twilio\Rest\Client;

function sendSMSReminder($phone, $name, $appointmentDate) {
    $sid = '';  //  Actual Twilio SID
    $token = '';  //  Actual Twilio Auth Token
    $client = new Client($sid, $token);

    $message = "Dear $name, this is a reminder for your appointment scheduled on $appointmentDate. Regards, Prime Care Health Services";

    try {
        $client->messages->create(
            $phone,
            [
                'from' => '+1',  // Actual Twilio phone number
                'body' => $message
            ]
        );
        echo "SMS sent to $phone successfully.\n";
    } catch (Exception $e) {
        echo "Failed to send SMS to $phone. Error: " . $e->getMessage() . "\n";
    }
}

// Fetch appointments for the next day
$query = "SELECT pname, ptel, DATE_FORMAT(appodate, '%Y-%m-%d %H:%i:%s') as appodate FROM appointment WHERE ptel IS NOT NULL AND appodate >= CURDATE() AND appodate < CURDATE() + INTERVAL 1 DAY";
$result = $database->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        sendSMSReminder($row['ptel'], $row['pname'], $row['appodate']);
    }
} else {
    echo "No Appointments Found Today!.\n";
}

$database->close();
?>
