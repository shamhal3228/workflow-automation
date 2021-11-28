<?php
session_start();

if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"]))
{
    $statusMsg = '';

    //file upload path
    $email = $_SESSION['email'];
    $dir = $_SESSION['app'];
    $targetDir = "/var/www/html/students_applications/".$email."/".$dir."/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $flag=false;
        //upload file to server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) 
        {

                $mime = mime_content_type($targetFilePath);
                if (stripos($mime, 'application/pdf')===false && stripos($mime, 'image/')===false && stripos($mime, 'application/vnd')===false && stripos($mime, 'application/x-rar')===false  && stripos($mime, 'text/plain')===false)
                {
                    unlink($targetFilePath);
                    die("Некорректный файл");
                }
                $flag=true;

        } 
        else 
        {
            $statusMsg = "Not uploaded because of error #" . $_FILES["file"]["error"];
        }
} 
else 
{
    header('Location: ../../student/student_view.php');
}

//display status message
if ($flag==true)
    {
        $path = $_SESSION['app']."_view";
        header("Location: ../../applications/$path.php");
    }
else echo $statusMsg;
?>