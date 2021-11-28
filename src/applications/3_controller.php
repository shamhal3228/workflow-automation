<?php

include '3_model.php';

if (isset($_POST['submit']))
{
    $info_reg = app3_check($_POST['chifr'], $_POST['phone'], $_POST['app'], $_POST['ed_form']);
}
else header('Location: 3_view.php');

if ($info_reg=='')
    header('Location: ../student/student_view.php');

echo $info_reg;
?>