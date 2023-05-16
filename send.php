<?php
    // NB: Note this code sends mail when hosted online ie 000webhost.com but generates an SMTP & HOST error when run on the local server ie Localhost
    // To send emails using PHPMailer you must first have composer installed in your system thru downloading & installing it which is the official dependancy manager for PHP which allows in declaring the libraries your project depends on and it will manage (install/update) them for you.
    // When installed you can simply call composer from any directory ie 'composer require phpmailer/phpmailer' to create php mailer total package

    // If u don't want to install composer u can add PHPMailer manually then copy the contents of the PHPMailer folder to one of the include_path directories specified in your PHP configuration, and load each class file manually as shown below
?>
<?php
    //We start by creating the PHPMailer & Exception class
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    // Exception class will help you handle errors and debug them & if its missing & an error occurs a msg saying Exception class is not found, will be shown without any details on how to debug
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    // U then connect the PHPMailer to an SMTP server
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';
?>

<?php
    //Now that we have used composer for installation we include the Composer generated autoload.php file which consist of all of the above manual work
    require 'vendor/autoload.php';

    //We then get values from the form fields
    if(isset($_POST['send'])){
        $name = htmlentities($_POST['name']);
        $email = htmlentities($_POST['email']);
        $subject = htmlentities($_POST['subject']);
        $message = htmlentities($_POST['message']);
    }

    //We then create a new PHPMailer object
    $mail = new PHPMailer();

    //Incase of an error see exactly whats the issue by setting the value of SMTPDebug property to 2, you will be actually getting both server and client level transcripts of errors.
    $mail->SMTPDebug = 2;

    //Do some SMTP configuration
    $mail->isSMTP(); //Note that if u comment this line PHPMailer will not be able to Instatiate mail function so make sure to use SMTP to send mail
    //Set the hostname of the mail server
    $mail->Host = "smtp.gmail.com";
    // $mail->Host = "smtp.mail.yahoo.com";
    //$mail->Host = "smtp.mailgun.org";

    //$mail->Mailer = "smtp";
    $mail->SMTPAuth = true;

    //use port 465 when using SMPTSecure 'ssl' & port 587 for authenticated 'tls' in this case we enable TLS encryption
    $mail->SMTPSecure = 'ssl';

    // This code bypasses strictier SSL verification behavior
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    // TCP port to connect to the mail server
    $mail->Port = 465; 

    // Instead of editing the base class in PHPMailer.php u can set the SMTPAutoTLS to false which is set to true in the main class when set to true it enables the server to upgrade the connection & encrypt it so as to protect sensitive information
    // $mail->SMTPAutoTLS = false;

    // Gmail Account: Sending mail with this account succeeds but always display sender as eribrah@gmail.com rather than email used in setFrom() function
    $mail->Username = "eribrah@gmail.com";
    $mail->Password = "jwewljmawymxxzjj";

    // Yahoo Account: Sending mail with this account fails with Mailbox unavailable 550, SMTP server error check later
    // $mail->Username = "eribrah@yahoo.com";
    // $mail->Password = "ntgqpyldxtojwomm";

    // Mailgun Account: To use this make sure u add the address to all authorized recipients u want to send to in Mailgun Account Settings which is impossible coz we don`t know who exactly will contact us thru mail
    // $mail->Username = "postmaster@sandbox2f3800a7f59448a2b41c5105827c73b4.mailgun.org";
    // $mail->Password = "fc9f8703b621eec5c6afc9891bb16927-07a637b8-53586d30";

    //Specify Original PHPMailer headers
    $mail->setFrom($email, $name);

    //$mail->addReplyTo('recepient@mail.com', 'Recepient Name');
    $mail->addAddress('eribrah@yahoo.com', 'Pagebrowser');
    // $mail->addCC('eribrah@yahoo.com', 'Miae');
    // $mail->addBCC('eribrah@yahoo.com', 'Me');

    //Set Email format to HTML
    $mail->isHTML(true);

    //Set a subject
    $mail->Subject = $subject;

    //Input desired content
    $mail->Body = $message;

    //To embed an image u use the CID attachments
    //$mail->addEmbeddedImage('attachments/image_file.jpg', 'image_cid');
    //U add an attachment by specifying the path to the attachement & an optional filename if missing the script uses the actual name of the file
    //$mail->addAttachment('attachments/IRA Certificate 2023.pdf', 'attachments/invoice1.pdf');

    //$mail->Body = '<img src="cid:image_cid"> Mail body in HTML' .$mailContent;

    // $mail->Body = $mailContent;

    // $mail->AltBody = 'This is the plain text version of the email content';


    //Lastly specify the email sending attributes
    if($mail->send()){
        echo 'Message has been sent';
    }else{
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

    //Closing SMTP Connection
    $mail->smtpClose();
?>

