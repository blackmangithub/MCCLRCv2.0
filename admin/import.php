<?php
include('authentication.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];
    
    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row)
        {
            if($count > 0)
            {
                $firstname = $row['0'];
                $lastname = $row['1'];
                $username = $row['2'];

                $ms_query = "INSERT INTO ms_account (firstname,lastname,username) VALUES ('$firstname', '$lastname', '$username')";
                $result = mysqli_query($con, $ms_query);
                $msg = true;
            }
            else
            {
                $count = "1";
            }
        }

        if(isset($msg))
        {
            $_SESSION['status'] = "File imported sucessfully.";
            $_SESSION['status_code'] = "success";
            header('Location:ms_account.php');
            exit(0); 
        }
        else
        {
            $_SESSION['status'] = "File not imported.";
            $_SESSION['status_code'] = "error";
            header('Location:ms_account.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "Invalid file type. Please upload an Excel or CSV file.";
        $_SESSION['status_code'] = "error";
        header('Location:ms_account.php');
        exit(0);
    }
}

?>