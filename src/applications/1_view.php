<?php
session_start();
$_SESSION['app']=1;

if (!array_key_exists('user_group', $_SESSION) || $_SESSION['user_group'] != 1)
{
    header("HTTP/1.0 404 Not Found");
    die();
}
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Заявление на курсовую работу</title>

<style>
    body {
      background-color: #f5f5f5;
      margin-left: 12px;
    }
    .wid30{
        width: 30%;
    }
    .input_height{
        height: 40px;
    }
    .text-area{
        cols: 10;
    }
    .wid40{
        width: 40%;
    }
    .wid7{
        float: right;
        margin-top: 3px;
        margin-right: 6px;
        width: 7%;
    }
</style>

</head>
<body>

<a href="../logout.php" class="btn btn-primary wid7">Выйти</a>
<p><b>Загрузить файлы Вашей работы</b></p>

<div class="input-group mb-3">
<form action="/data/service/upload.php" method="post" enctype="multipart/form-data">
    <input type="file" class="form-control" name="file">
    <p></p>
    <input type="submit" class="btn btn-primary" name="submit" value="Загрузить">
</form>
</div>

<p>Загруженные файлы:</p>
<?php
$email = $_SESSION['email'];
$print_command="cd ../students_applications/".$email."/1 && ls -1 && cd ../applications";
$result = shell_exec($print_command);
$result = str_replace("text.txt", "", $result);
$result = str_replace("zip.zip", "", $result);
echo $result;
?>

<br><br><br>

<form action="1_controller.php" method="POST" />
<div class="input-group mb-3 wid30">
  <input type="text" class="form-control input_height" placeholder="Введите тему курсовой работы" aria-label="Recipient's username" aria-describedby="basic-addon2" name="theme">
</div>

<div class="input-group mb-3 wid30">
  <input type="text" class="form-control input_height" placeholder="Перечислите использованные технологии" aria-label="Recipient's username" aria-describedby="basic-addon2" name="tech">
</div>

<div class="input-group wid40">
<textarea class="form-control" rows="7" aria-label="With textarea" placeholder="Необходимая дополнительная информация:" name="info"></textarea>
</div>
<p></P>
<input class="btn btn-primary" type="submit" value="Отправить" name="submit" />

</form>
</body>
</html>