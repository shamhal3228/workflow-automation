<?php

include 'login_model.php';

if (isset($_POST['submit'])) 
{
    $info_reg = login_check($_POST['email'], $_POST['password']);
}
else{
    header('Location: login_view.html');
}

if ($info_reg=='2')
{
    header('Location: ../admin/admin_view.php');
}
if ($info_reg=='1')
{
    header('Location: ../student/student_view.php');
}
echo $info_reg;

?>