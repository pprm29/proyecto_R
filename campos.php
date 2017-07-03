<?php
//==========FUNCTIONS============
function validarEspacios($value){
  if(trim($value) == '')
    return false;
  else
    return true;
}

function sinNumeros($value){
  $longitud = strlen($value);

  for ($i=0; $i < $longitud; $i++){
    if(filter_var($value[$i],FILTER_VALIDATE_INT))
      return false;
  }
  return true;
}
//=================================
//================================
// $destino  = "pprm29@gmail.com";
// $destino .= ", caifaguar.jm@gmail.com";
$destino  = "caifaguar.jm@gmail.com";

$nombre  = isset($_POST['nombre'])  ? $_POST['nombre']  : null;
$correo  = isset($_POST['correo'])  ? $_POST['correo']  : null;
$asunto  = isset($_POST['asunto'])  ? $_POST['asunto']  : null;
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : null;
$captcha = $_POST['g-recaptcha-response'];

$secret  = "";
if (!$captcha)
  echo "verifica captcha";

$contents  = "https://www.google.com/recaptcha/api/siteverify?";
$contents .= "secret=$secret&response=$captcha";
$response = file_get_contents($contents);

var_dump($response);
$arr = json_decode($response,TRUE);


$headers  = "From: $nombre <$correo>\r\n";
$headers .= "X-Mailer: PHP5\n";
$headers .= 'MIME-Version: 1.0'."\n";
$headers .= 'Content-type: text/html; charset = iso-8859-1'."\r\n";

$contenido  = "Nombre: ".$nombre."<br>";
$contenido .= "email: ".$correo."<br>";
$contenido .= "Asunto: ".$asunto."<br>";
$contenido .= "Mensaje:<br>".$mensaje;

//variable para errores.
$error  = false;
//validando datos ingresados.
//verificamos que se envíe el formulario.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(!sinNumeros($nombre) || !validarEspacios($mensaje))
    $error = true;

  //verificamos si hay errores.
  if(!$error && $arr['success']){
    mail($destino,$asunto,$contenido,$headers);
    header('Location: validado.html');
    exit;
  }
  else
    header('Location: form.html');
}
?>
