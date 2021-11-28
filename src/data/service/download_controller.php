<?php

include "download_model.php";

if (isset($_POST['submit'])) 
{   
    if ($_POST['whatfile']==NULL)
        echo "Вы не ввели ID заявления";
    else echo(download($_POST['whatfile']));
}
else {
    header('Location: ../../admin/admin_view.php');
}
?>