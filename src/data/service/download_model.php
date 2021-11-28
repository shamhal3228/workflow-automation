<?php

function download(&$whatfile)
{

    ob_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $id_application_posted=$whatfile;
    
    $user = mysqli_query($connection, "SELECT `student_id` FROM `applications` WHERE `id` = '$id_application_posted'");
    $id_user = mysqli_fetch_array($user);
    
    if ($id_user==NULL)
        return "Заявления с таким ID нет";

    $parsed_id_user=$id_user['student_id'];
    $email_posted = mysqli_query($connection, "SELECT `email` FROM `users` WHERE `id` = '$parsed_id_user'");
    $email = mysqli_fetch_array($email_posted);
    $parsed_email=$email['email'];


    $app_type_posted = mysqli_query($connection, "SELECT `app_type` FROM `applications` WHERE `id` = '$id_application_posted'");
    $app_type = mysqli_fetch_array($app_type_posted);
    $parsed_app_type=$app_type['app_type'];
    

    // Enter the name of directory
    $pathdir = "/var/www/html/students_applications/".$parsed_email."/".$parsed_app_type."/"; 
  
    // Enter the name to creating zipped directory
    $zipcreated = "/var/www/html/students_applications/".$parsed_email."/".$parsed_app_type."/zip.zip";

    if (!file_exists($zipcreated))
    {
        // Create new zip class
        $zip = new ZipArchive;
   
        if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
      
            // Store the path into the variable
            $dir = opendir($pathdir);
       
            while($file = readdir($dir)) {
                if(is_file($pathdir.$file)) {
                    $zip -> addFile($pathdir.$file, $file);
                }
            }
            $zip ->close();
        }
    }
  



    $filename = "/var/www/html/students_applications/".$parsed_email."/".$parsed_app_type."/zip.zip";

    if (file_exists($filename)) {

        //Get file type and set it as Content Type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        header('Content-Type: '.finfo_file($finfo, $filename));

        finfo_close($finfo);

        //Use Content-Disposition: attachment to specify the filename
        header('Content-Disposition: attachment; filename='.basename($filename));

        //No cache
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        //Define file size
        header('Content-Length: '.filesize($filename));

        ob_clean();
        flush();
        readfile($filename);

        $query = "UPDATE `applications` SET status='Принято' WHERE id=$id_application_posted";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    }
    return "";
}
?>