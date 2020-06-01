<?php

Resource::use('phpmailer/class.phpmailer');
Resource::use('phpmailer/class.pop3');
Resource::use('phpmailer/class.smtp');

class EmailController
{

  public function send($request) {
    $mailTitle = $request->body->title . ' - ' . utf8_decode(APP_CONTENT_PAGE_TITLE);
    $message = $request->body->message;
    $to = [$request->body->to];

    $mailer = new PHPMailer();
    $mailer->IsSMTP();
    $mailer->SMTPDebug = 0;
    $mailer->Port      = 587; //Indica a porta de conexão para a saída de e-mails. Utilize obrigatoriamente a porta 587.
    $mailer->Host      = 'smtp.usios.com.br'; //Onde em 'servidor_de_saida' deve ser alterado por um dos hosts abaixo:
    //Para cPanel: 'localhost';
    //Para Plesk 11 / 11.5: 'smtp.dominio.com.br';
  
    //Descomente a linha abaixo caso revenda seja 'Plesk 11.5 Linux'
    //$mailer->SMTPSecure = 'tls';
  
    $mailer->SMTPAuth = true; //Define se haverá ou não autenticação no SMTP
    $mailer->Username = EMAIL_LOGIN; //Informe o e-mail o completo
    $mailer->Password = EMAIL_PASSWORD; //Senha da caixa postal
    $mailer->FromName = utf8_decode(APP_CONTENT_PAGE_TITLE); //Nome que será exibido para o destinatário
    $mailer->From     = EMAIL_LOGIN; //Obrigatório ser a mesma caixa postal indicada em "username"
  
    foreach ($to as $emailAddr) {
      $mailer->AddAddress($emailAddr); //Destinatários
    }
  
    $mailer->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mailer->Subject  = $mailTitle;
    $mailer->Body     = '
      <!doctype html>
      <html lang="pt-br">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
          <meta charset="iso-8859-1">
          <title>'.$mailTitle.'</title>
        </head>

        <body>
          '.utf8_decode($message).'
        </body>
      </html>
    ';
    $mailer->AltBody  = strip_tags($message);
  
    if(!$mailer->Send()) {
      // echo $mailer->ErrorInfo;
      // return false;
      response(['status' => false, 'message' => 'error', 'error' => $mailer->ErrorInfo]);
    }
    response(['status' => true, 'message' => 'OK']);
  }

}