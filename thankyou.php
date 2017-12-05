<?php

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function Connect()
{
 $dbhost = "%YOUR HOST%";
 $dbuser = "%YOUR USER%";
 $dbpass = "%YOUR PASSWORD%";
 $dbname = "%YOUR NAME%";

 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

 return $conn;
}

date_default_timezone_set("America/Sao_Paulo");

$conn    = Connect();
$name    = $conn->real_escape_string($_POST['nome']);
$email   = $conn->real_escape_string($_POST['email']);
$ip      = get_client_ip();
$message = $conn->real_escape_string($_POST['msg']);
$date    = date("Y-m-d H:i:s");

if($email <= "   " or $name <= "   ") {
	echo "Email ou Nome inválidos :(";
	goto end;
}

$query = ("SELECT ID FROM tb_cform WHERE u_email = '$email'");
$success = $conn->query($query);

if($success->num_rows == 0) {
	$query = "INSERT into tb_cform (u_name,u_email,u_ip,u_message,u_date) VALUES('" . $name . "','" . $email . "','" . $ip . "','" . $message . "','" . $date . "')";
	$success = $conn->query($query);
        echo "Agradecemos o seu cadastro!";
	goto end;
} 
else {
	echo "Email já cadastrado.";
	goto end;
}

/*
if (!$success) {
    die("Couldn't enter data: ".$conn->error);
}
*/

end:
$conn->close();

//$to      = $_POST['email'];
//$subject = 'Bem vindo a Up Start!';
//$message = '<div class="container">

//      <div class="bg-faded p-4 my-4">
//        <hr class="divider">
 //       <h2 class="text-center text-lg text-uppercase my-0">
//          <strong>Obrigado pela inscrição</strong>
          
//        </h2>
//        <hr class="divider">
//        <p class="text-center">Iremos te atualizar com todas as informações sobre startups</p>
//        <p class="text-center">Traremos notías sobre programas de aceleração e seus processos seletivos</p>
//        <p class="text-center">Compartilhe com seus colegas profissionais ou com quem possui idéias  e precisa de um espaço para se inspirar</p>
//        <p class="text-center"><a>upstart.co.nf</a></p>
//      </div>

//    </div>';
//$headers = 'From: %YOUR MAIL%' . "\r\n" .
 //   'Reply-To: %YOUR MAIL%' . "\r\n" .
 //   'X-Mailer: PHP/' . phpversion();

//mail($to, $subject, $message, $headers);

?>
