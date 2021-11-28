<?php

function reg_check(&$login, &$email, &$password, &$password2, &$user_group, &$user_ed_group)
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $info_reg = '';

    if (empty($login)) 
    {
        $info_reg = 'Вы не ввели ФИО';
    }
    elseif (preg_match("/[0-9~`!#$%\^&*+=\-\[\]\\';,\/{}|\:<>\?\.]/", $login))
    {
        $info_reg = 'Некорректная фамилия- попробуйте снова';
    }       
    elseif (empty($email)) 
    {
        $info_reg = 'Вы не ввели почту';
    }
    elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $email)) 
    {
        $info_reg = 'Неправильно введен адрес электронной почты';
    }           
    elseif (empty($password)) 
    {
        $info_reg = 'Вы не ввели пароль';
    }
    elseif (empty($password2)) 
    {
        $info_reg = 'Вы не ввели пароль повторно';
    }
    elseif ($password != $password2) 
    {
        $info_reg = 'Пароли не совпадают';
    }
    elseif (!preg_match("/^[a-zA-Z0-9~`!@#$%()\^&*+=\-\[\]\\';,\/{}|\:<>\?\._]{3,35}$/", $password)) 
    {
        $info_reg = 'Пароль должен состоять из 3-35 символов';
    }
    elseif (empty($user_ed_group) && $user_group==1)     
    {
        $info_reg = 'Введите учебную группу';
    }
    elseif ($user_group==1 && !preg_match("/^[\x{0400}-\x{04FF}]{4}-[0-9]{2}-[0-9]{2}$/u", $user_ed_group))     
    {
        $info_reg = 'Введите учебную группу корректно';  
    }
    elseif ($user_group==1 && preg_match("/[0]{2}/", $user_ed_group))     
    {
        $info_reg = 'Введите учебную группу корректно';
    }                      
    else
    {
        
        $login = mysqli_real_escape_string($connection, $login);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
	    $user_group = $user_group;
        if ($user_group == 1)
            $user_ed_group = mysqli_real_escape_string($connection, $user_ed_group);
        else $user_ed_group = NULL;
  
        $query = "INSERT INTO `users` (login, email, password, user_group, user_ed_group) VALUES ('$login', '$email', '$password', '$user_group', '$user_ed_group')";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

        if ($user_group == 1)
        {
            $user = mysqli_query($connection, "SELECT `id` FROM `users` WHERE `email` = '$email'");
            $id_user = mysqli_fetch_array($user);
            $parsed_user_id = $id_user['id'];
    
            $query = "INSERT INTO `applications` (name, status, student_id, app_type) VALUES ('Курсовая работа', 'Доступно', '$parsed_user_id', '1')";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
            $query = "INSERT INTO `applications` (name, status, student_id, app_type) VALUES ('Заявление на военную кафедру', 'Доступно', '$parsed_user_id', '2')";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
            $query = "INSERT INTO `applications` (name, status, student_id, app_type) VALUES ('Заявление на материальную помощь', 'Доступно', '$parsed_user_id', '3')";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

            $filepath = "mkdir -p ../students_applications/".$email;
            shell_exec($filepath);

            $filepath = "mkdir -p ../students_applications/".$email."/1";
            shell_exec($filepath);

            $filepath = "mkdir -p ../students_applications/".$email."/2";
            shell_exec($filepath);

            $filepath = "mkdir -p ../students_applications/".$email."/3";
            shell_exec($filepath);

            $filepath = "touch ../students_applications/".$email."/1/text.txt";
            shell_exec($filepath);

            $filepath = "touch ../students_applications/".$email."/2/text.txt";
            shell_exec($filepath);

            $filepath = "touch ../students_applications/".$email."/3/text.txt";
            shell_exec($filepath);
        }
    }

    return $info_reg;
}
?>