<?php
session_start();

if (!array_key_exists('user_group', $_SESSION) || $_SESSION['user_group'] != 1)
{
    header("HTTP/1.0 404 Not Found");
    die();
}
?>

<html lang="ru">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<title>Student page</title>
<meta charset="utf-8">

<style>
    body {
      background-color: #f5f5f5;
      margin-left: 12px;
      margin-right: 12px;
    }
    .wid7{
        width: 7%;
        float: right;
        margin-top: 1%;
        margin-bottom: 1%;
    }
    .lin{
        display: inline;
    }
</style>

</head>
<body>

    <h1 class="lin">Подайте заявление</h1>
    <a href="../logout.php" class="btn btn-primary wid7 lin">Выйти</a>

<table class="table table-striped">
    <th width="30%">Название документа</th><th width="10%">Статус</th><th width="10%"></th>

    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM applications");

        foreach ($result as $row){
            if ($row['student_id']==$_SESSION['id'])
            {
                $href="../applications/".$row['app_type']."_view.php";
                if ($row['status']=='Доступно' || $row['status']=='Отклонено')
                echo "<tr><td>{$row['name']}</td><td>{$row['status']}</td><td><a style='color: #rrggbb'  href='$href'>Подать заявление</a></td></tr>";
                else echo "<tr><td>{$row['name']}</td><td>{$row['status']}</td><td></td></tr>";
            }
        }
    ?>
</table>

</body>
</html>