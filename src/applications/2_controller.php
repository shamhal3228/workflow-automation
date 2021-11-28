<?php

include '2_model.php';

if (isset($_POST['submit'])) 
{
    $info_reg = app2_check($_POST['data'], $_POST['pasport'], $_POST['pasport_data'], $_POST['pasport_place'], $_POST['chifr'], $_POST['voen'], $_POST['voen_place']);
}
else header('Location: 2_view.php');

if ($info_reg=='')
    header('Location: ../student/student_view.php');

echo $info_reg;
?>