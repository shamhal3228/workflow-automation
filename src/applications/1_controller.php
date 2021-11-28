<?php

include '1_model.php';

if (isset($_POST['submit'])) 
{
    $info_reg = app1_check($_POST['theme'], $_POST['tech'], $_POST['info']);
}
else header('Location: 1_view.php');

if ($info_reg=='')
    header('Location: ../student/student_view.php');

echo $info_reg;
?>