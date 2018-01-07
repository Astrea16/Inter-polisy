<?php
session_start();
$data['result']='error';
function validStringLength($string,$min,$max) {
  $length = mb_strlen($string,'UTF-8');
  if (($length<$min) || ($length>$max)) {
    return false;
  }
  else {
    return true;
  }
	}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$data['result']='success';
	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		if (!validStringLength($name,2,30)) {
			$data['name']='Поля имя содержит недопустимое количество символов.';   
			$data['result']='error';     
		}
	} else {
		$data['result']='error';
	} 
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$data['email']='Поле email введено неправильно';
			$data['result']='error';
		}
	} else {
		$data['result']='error';
	}
	 if (isset($_POST['message'])) {
      $message = $_POST['message'];
      if (!validStringLength($message,20,500)) {
        $data['message']='Поле сообщение содержит недопустимое количество символов.';     
        $data['result']='error';   
      }      
    } else {
      $data['result']='error';
    }
     if (isset($_POST['message'])) {
      $message = $_POST['message'];
      if (!validStringLength($message,20,500)) {
        $data['message']='Поле сообщение содержит недопустимое количество символов.';     
        $data['result']='error';   
      }      
    } else {
      $data['result']='error';
    } 
    if ($data['result']=='success'){
    $output = "---------------------------------" . "\n";
    $output .= date("d-m-Y H:i:s") . "\n";
    $output .= "Имя пользователя: " . $name . "\n";
    $output .= "Адрес email: " . $email . "\n";
    $output .= "Сообщение: " . $message . "\n";
    if (file_put_contents(dirname(__FILE__).'/message.txt', $output, FILE_APPEND | LOCK_EX)) {
      $data['result']='success';
    } else {
      $data['result']='error';         
    } 
    require_once dirname(__FILE__) . '/phpmailer/PHPMailer.php';
    require_once dirname(__FILE__) . '/phpmailer/SMTP.php';
    //формируем тело письма
    $output = "Дата: " . date("d-m-Y H:i") . "\n";
    $output .= "Имя пользователя: " . $name . "\n";
    $output .= "Адрес email: " . $email . "\n";
    $output .= "Сообщение: " . "\n" . $message . "\n"; 

    $mail = new PHPMailer;
 
    $mail->CharSet = 'UTF-8'; 
    $mail->From      = 'daite@gmail.com';
    $mail->FromName  = 'Имя сайта';
    $mail->Subject   = 'Сообщение с формы обратной связи';
    $mail->Body      = $output;
    $mail->AddAddress( '7yatan@gmail.com');
 
    // отправляем письмо
    if ($mail->Send()) {
      $data['result']='success';
    } else {
      $data['result']='error';
    } 
    }
    echo json_encode($data);     
	?>