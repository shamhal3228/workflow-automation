<?php
session_start();

if (!array_key_exists('user_group', $_SESSION) || $_SESSION['user_group'] != 2)
{
    header("HTTP/1.0 404 Not Found");
    die();
}

?>

<html lang="en">
<head>
<title>Admin</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
    body {
      background-color: #f5f5f5;
      margin-left: 12px;
      margin-right: 12px;
    }
    .text{
        margin-top: 12px;
    }
    .wid30{
        width: 30%;
    }
    .wid50{
        width: 50%;
        display: inline;
    }
    .wid8{
        width: 8%;
    }
    .wid7{
        width: 7%;
        float: right;
        margin-right: 1%;
    }
    .lin{
        display: inline;
    }
</style>

</head>
<body>
<a href="../logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<h1 class="text">Таблица студентов</h1>
<table class="table table-striped">
    <tr><th width="5%">Id</th><th>ФИО</th><th>Почта</th><th width="15%">Группа</th></tr>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM users");
        foreach ($result as $row){
            if ($row['user_group']==1)
             echo "<tr><td>{$row['id']}</td><td>{$row['login']}</td><td>{$row['email']}</td><td>{$row['user_ed_group']}</td></tr>";
        }
    ?>
</table>

<br>

<h1>Таблица всех заявлений и их статусы</h1>
<table class="table table-striped">
    <tr><th width="5%">Id</th><th width="35%">Заявление</th><th>ФИО</th><th width="15%">Статус</th></tr>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM applications");
        foreach ($result as $row){
            if ($row['status']!="Доступно"){
            $temp = $row['student_id'];
            $student_id = $mysqli->query("SELECT login FROM users WHERE id=$temp");

            foreach ($student_id as $row2)
            {
                echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row2['login']}</td><td>{$row['status']}</td></tr>";
            }
        }
    }
    ?>
</table>

<br>

<h1>Таблица необработанных заявлений</h1>
<table class="table table-striped">
    <tr><th width="5%">Id</th><th>Заявление</th><th width="50%">ФИО</th></tr>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM applications");
        $flag=false;
        foreach ($result as $row){
            if ($row['status']=="Отправлено"){

                $temp = $row['student_id'];
                $student_id = $mysqli->query("SELECT login FROM users WHERE id=$temp");

                foreach ($student_id as $row2)
                {
                    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row2['login']}</td></tr>";
                    $flag=true;
                }
                
            }
        }

        if ($flag==false)
            echo "<p>Новых заявлений нет</p>";
    ?>
</table>

<form name="form" action="../data/service/download_controller.php" method="POST">
<div class="input-group mb-3 wid30">
    <p class="text"><b>Для скачивания заявления введите его ID и нажмите на кнопку "Скачать"</b></p>
    <input type="text" class="form-control input_height" aria-label="Recipient's username" aria-describedby="basic-addon2" name="whatfile" id="whatfile" value="">
</div>
<input class="btn btn-primary" type="submit" name="submit" value="Скачать">
</form>

<br>

<h1>Таблица принятых заявлений без окончательного статуса</h1>
<table class="table table-striped">
    <tr><th  width="5%">Id</th><th>Заявление</th><th width="50%">ФИО</th></tr>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM applications");
        $flag=false;
        foreach ($result as $row){
            if ($row['status']=="Принято"){

                $temp = $row['student_id'];
                $student_id = $mysqli->query("SELECT login FROM users WHERE id=$temp");

                foreach ($student_id as $row2)
                {
                    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row2['login']}</td></tr>";
                    $flag=true;
                }
                
            }
        }

        if ($flag==false)
            echo "<p>Новых заявлений нет</p>";
    ?>
</table>

<br>

<form name="form" action="admin_controller.php" method="POST">

<div class="input-group mb-3 wid30">
    <p class="text"><b>Для принятия/отклонения заявления введите его ID и выберите нужную функцию</b></p>
    <input type="text" class="form-control input_height" aria-label="Recipient's username" aria-describedby="basic-addon2" name="whatfile2" id="whatfile2" value="">
</div>

<input class="btn btn-primary" type="submit" name="accept" value="Принять">
<input class="btn btn-primary" type="submit" name="reject" value="Отклонить">
</form>

</table>
</body>
</html>