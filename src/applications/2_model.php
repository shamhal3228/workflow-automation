<?php

function app2_check(&$data, &$pasport, &$pasport_data, &$pasport_place, &$chifr, &$voen, &$voen_place)
{
    session_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");
    
    $info_reg = '';

    if (empty($data)) 
    {
        $info_reg = 'Вы не ввели дату рождения';
    }
    elseif (empty($pasport)) 
    {
        $info_reg = 'Вы не ввели серию и номер паспорта';
    }
    elseif (!preg_match("/^[0-9]{4} [0-9]{6}$/", $pasport))
    {
        $info_reg = 'Неверный формат серии и номера паспорта (ХХХХ ХХХХХХ)';
    } 
    elseif (empty($pasport_data)) 
    {
        $info_reg = 'Вы не ввели дату выдачи паспорта';
    }
    elseif (empty($pasport_place)) 
    {
        $info_reg = 'Вы не ввели место выдачи паспорта';
    }
    elseif (empty($chifr)) 
    {
        $info_reg = 'Вы не ввели шифр';
    }
    elseif (!preg_match("/^[0-9]+$/", $chifr)) 
    {
        $info_reg = 'Некорректный шифр';
    }
    elseif (empty($voen))
    {
        $info_reg = 'Вы не ввели место выдачи военного удостоверения';
    }
    elseif (!preg_match("/^[A-Z]{2} [0-9]{7}$/", $voen)) 
    {
        $info_reg = 'Некорректный шифр';
    }
    elseif (empty($voen_place)) 
    {
        $info_reg = 'Вы не ввели место выдачи военного удостоверения';
    }
    else
    {
        $name = $_SESSION['login'];
        $group = $_SESSION['user_ed_group'];
        $data = mysqli_real_escape_string($connection, $data);
        $pasport = mysqli_real_escape_string($connection, $pasport);
        $pasport_data = mysqli_real_escape_string($connection, $pasport_data);
        $pasport_place = mysqli_real_escape_string($connection, $pasport_place);
        $chifr = mysqli_real_escape_string($connection, $chifr);
        $voen = mysqli_real_escape_string($connection, $voen);
        $voen_place = mysqli_real_escape_string($connection, $voen_place);
        
        
        $email = $_SESSION['email'];
        $text = "echo \"ФИО: ".$name;
        $text = $text."\nГруппа: ".$group;
        $text = $text."\nДата рождения: ".$data;
        $text = $text."\nСерия и номер паспорта: ".$pasport;
        $text = $text."\nДата выдачи паспорта: ".$pasport_data;
        $text = $text."\nМесто выдачи паспорта: ".$pasport_place;
        $text = $text."\nШифр направления: ".$chifr;
        $text = $text."\nСерия и номер военного удостоверения: ".$voen;
        $text = $text."\nМесто выдачи военного удостоверения: ".$voen_place;
        $text = $text."\" > /var/www/html/students_applications/".$email."/2/text.txt";
        
        shell_exec($text);
        
        $student_id=$_SESSION['id'];
        $query = "UPDATE `applications` SET status='Отправлено' WHERE student_id=$student_id AND app_type=2";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    return $info_reg;
}
?>