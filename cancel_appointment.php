<?php
session_start();

// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

// Проверяем наличие ID записи
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: profile.php");
    exit();
}

$appointment_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Подключаемся к БД
$link = mysqli_connect('localhost', 'root', '', 'vetklinika') or die(mysqli_error($link));

// Проверяем, что запись принадлежит пользователю и имеет статус 'pending'
$check_query = "SELECT id_appointment FROM appointments WHERE id_appointment = $appointment_id AND user_id = $user_id AND status = 'pending'";
$check_result = mysqli_query($link, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // Обновляем статус на 'cancelled'
    $update_query = "UPDATE appointments SET status = 'cancelled' WHERE id_appointment = $appointment_id";
    if (mysqli_query($link, $update_query)) {
        mysqli_close($link);
        header("Location: profile.php?cancelled=1");
        exit();
    }
}

// Если что-то пошло не так
mysqli_close($link);
header("Location: profile.php?error=1");
exit();
?>