<?php

function app1_check(&$theme, &$tech, &$info)
{
    session_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $info_reg = '';

    if (empty($theme)) 
    {
        $info_reg = 'Вы не ввели тему';
    }
    elseif (empty($tech))
    {
        $info_reg = 'Вы не ввели использованные технологии';
    }
    else
    {
        $name = $_SESSION['login'];
        $group = $_SESSION['user_ed_group'];
        $theme = mysqli_real_escape_string($connection, $theme);
        $tech = mysqli_real_escape_string($connection, $tech);
        if (!empty($info))
            $info = mysqli_real_escape_string($connection, $info);
        else $info = "";
        
        $email = $_SESSION['email'];
        $text = "echo \"ФИО: ".$name;
        $text = $text."\nГруппа: ".$group;
        $text = $text."\nТема курсовой работы: ".$theme;
        $text = $text."\nИспользованные технологии: ".$tech;
        $text = $text."\nНеобходимая дополнительная информация: ".$info;
        $text = $text."\" > /var/www/html/students_applications/".$email."/1/text.txt";
        
        shell_exec($text);
        
        $student_id=$_SESSION['id'];
        $query = "UPDATE `applications` SET status='Отправлено' WHERE student_id=$student_id AND app_type=1";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    }

    return $info_reg;
}
?>