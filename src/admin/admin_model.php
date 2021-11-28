<?php

function accept(&$whatfile2)
{
    session_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");
    $id_application_posted=$whatfile2;

    $mysqli = new mysqli("db", "user", "password", "appDB");
    $result = $mysqli->query("SELECT status FROM applications WHERE id = $id_application_posted");

    foreach ($result as $row)
    {
        $msg = $row['status'];
    }
    if ($msg!='Принято')
    {
        return "ERR";
    }

    $query = "UPDATE `applications` SET status='Одобрено' WHERE id = $id_application_posted";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

function reject(&$whatfile2)
{
    session_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");
    $id_application_posted=$whatfile2;

    $mysqli = new mysqli("db", "user", "password", "appDB");
    $result = $mysqli->query("SELECT status FROM applications WHERE id = $id_application_posted");
    foreach ($result as $row)
    {
        $msg = $row['status'];
    }
    if ($msg!='Принято')
    {
        return "ERR";
    }

    $query = "UPDATE `applications` SET status='Отклонено' WHERE id = $id_application_posted";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

?>