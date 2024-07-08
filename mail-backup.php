<?php 
include('inc/header-mail.php'); 
error_reporting(0); 

?>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';
 
    $dbhost ='localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'yarn_management';
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $backupAlert = '';
    $tables = array();
    $result = mysqli_query($connection, "SHOW TABLES");
    if (!$result) {
        $backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($connection) . 'ERROR NO :' . mysqli_errno($connection);
    } else {
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
        mysqli_free_result($result);

        $return = '';
        foreach ($tables as $table) {
            $result = mysqli_query($connection, "SELECT * FROM " . $table);
            if (!$result) {
                $backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($connection) . 'ERROR NO :' . mysqli_errno($connection);
            } else {
                $num_fields = mysqli_num_fields($result);
                if (!$num_fields) {
                    $backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($connection) . 'ERROR NO :' . mysqli_errno($connection);
                } else {
                    $return .= 'DROP TABLE ' . $table . ';';
                    $row2 = mysqli_fetch_row(mysqli_query($connection, 'SHOW CREATE TABLE ' . $table));
                    if (!$row2) {
                        $backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($connection) . 'ERROR NO :' . mysqli_errno($connection);
                    } else {
                        $return .= "\n\n" . $row2[1] . ";\n\n";
                        for ($i = 0; $i < $num_fields; $i++) {
                            while ($row = mysqli_fetch_row($result)) {
                                $return .= 'INSERT INTO ' . $table . ' VALUES(';
                                for ($j = 0; $j < $num_fields; $j++) {
                                    $row[$j] = addslashes($row[$j]);
                                    if (isset($row[$j])) {
                                        $return .= '"' . $row[$j] . '"';
                                    } else {
                                        $return .= '""';
                                    }
                                    if ($j < $num_fields - 1) {
                                        $return .= ',';
                                    }
                                }
                                $return .= ");\n";
                            }
                        }
                        $return .= "\n\n\n";
                    }
                }
            }
        }

        $backup_file = "F:/wamp64/www/db" . $dbname.'-'. date("Y-m-d-H-i-s") . '.sql'; // Update the file path
        $handle = fopen($backup_file, 'w+');
        if ($handle !== false) {
            fwrite($handle, $return);
            fclose($handle);

            // Send email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'ibrahim.ali718@gmail.com';
                $mail->Password = 'xsusscagohezlsnv'; 
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Email content
                $mail->setFrom('ibrahim.ali718@gmail.com', 'Ibrahim Ali'); // Your email address and name
                $mail->addAddress('yarndbbackup@gmail.com', 'Raten Enterprise'); // Recipient's email address and name
                $mail->Subject = 'Yarn DB Backup';
                $mail->Body = 'Please find the attached database backup file.';
                $mail->addAttachment($backup_file);

                // Send email
                $mail->send();

                $backupAlert = 'Backup created and sent to the recipient!';
            } catch (Exception $e) {
                $backupAlert = 'Error sending email: ' . $mail->ErrorInfo;
            }
        } else {
            $backupAlert = 'Error creating backup file.';
        }
    }

 ?> 
<script> 
  var backupAlert = "<?php echo $backupAlert; ?>";
  swal({
    title: "Update Success: " + backupAlert,
    text: "",
    icon: "success"
  });

  setTimeout(function() {
    window.close(); // Close the current browser window/tab
  }, 3000); // 3000 milliseconds = 3 seconds
</script>
 <?php
 
?>
 
<?php include('inc/footer.php'); ?>