<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/storages/bookingstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');
session_start();
$userStorage = new UserStorage();
$appointment_storage = new AppointmentStorage();
$bookingStorage = new BookingStorage();
$auth = new Auth($userStorage);


if($auth->is_authenticated()){
    $modifyAppointment = $bookingStorage->findById($_GET['appointment_id']);
    $bookingStorage->deleteMany(function ($booking) use ($auth){
        return $booking["user_id"] === $auth->authenticated_user()["id"] && $booking["appointment_id"] === $_GET['appointment_id'];
    });
}


redirect("index.php");
?>