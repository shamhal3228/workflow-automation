<?php

include "admin_model.php";

if (isset($_POST['accept'])) 
{
    if ($_POST['whatfile2']!=NULL)
    {
        $msg = accept($_POST['whatfile2']);
        if ($msg=='ERR')
            echo "Вы ввели неккоректное ID заявления";
    }
    else echo "Вы не ввели ID заявления";
}
elseif (isset($_POST['reject'])) 
{
    if ($_POST['whatfile2']!=NULL)
    {
        $msg = reject($_POST['whatfile2']);
        if ($msg=='ERR')
            echo "Вы ввели неккоректное ID заявления";
    }
    else echo "Вы не ввели ID заявления";
}
header('Location: admin_view.php');

?>