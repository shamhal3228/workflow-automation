<?php

function app3_check(&$chifr, &$phone, &$app, &$ed_form)
{
    session_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $info_reg = '';

    if (empty($chifr)) 
    {
        $info_reg = 'Вы не ввели номер студ. билета';
    }
    elseif (!preg_match("/^[0-9]{2}[\x{0400}-\x{04FF}][0-9]{4}$/u", $chifr))
    {
        $info_reg = 'Неверный формат номера студ. билета (2 цифры, буква, 4 цифры)';
    } 
    elseif (empty($phone)) 
    {
        $info_reg = 'Вы не ввели номер телефона';
    }
    elseif (!preg_match("/^[0-9]{10}$/", $phone))
    {
        $info_reg = 'Неверный формат телефона';
    } 
    elseif (empty($app)) 
    {
        $info_reg = 'Вы не ввели основание заявления';
    }
    else
    {
        $name = $_SESSION['login'];
        $group = $_SESSION['user_ed_group'];
        $chifr = mysqli_real_escape_string($connection, $chifr);
        $phone = mysqli_real_escape_string($connection, $phone);
        $app = mysqli_real_escape_string($connection, $app);
        $ed_form = mysqli_real_escape_string($connection, $ed_form);
        
        
        
        $email = $_SESSION['email'];
        $text = "echo \"ФИО: ".$name;
        $text = $text."\nГруппа: ".$group;
        $text = $text."\nНомер студ. билета: ".$chifr;
        $text = $text."\nНомер телефона: ".$phone;
        $text = $text."\nОснование заявления: ".$app;
        if ($ed_form==1)
            $text = $text."\nФорма обучения: Внебюджетная";
        else $text = $text."\nФорма обучения: Бюджетная";
        $text = $text."\" > /var/www/html/students_applications/".$email."/3/text.txt";
        
        shell_exec($text);
        
        $student_id=$_SESSION['id'];
        $query = "UPDATE `applications` SET status='Отправлено' WHERE student_id=$student_id AND app_type=3";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    return $info_reg;
}
?>