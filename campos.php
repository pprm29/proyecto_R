<?php
//==========FUNCTIONS============
function validarEspacios($value){
  if(trim($value) == '')
    return false;
  else
    return true;
}

// function validarCorreo($value){
//   if(filter_var($valor, FILTER_VALIDATE_EMAIL))
//     return true;
//   else
//     return false;
// }

function sinNumeros($value){
  $longitud = strlen($value);

  for ($i=0; $i < $longitud; $i++){
    if(filter_var($value[$i],FILTER_VALIDATE_INT))
      return false;
  }
  return true;
}

function validarCorreo($value){
  $sintaxis = "#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#";
    if(preg_match($sintaxis,$value))
      return true;
    else
      return false;
}

// function validarAlfabeto($value){
//   if (ereg("^[a-zA-Z0-9\-_]{3,20}$", $value))
//     return true;//nombre valido
//   else
//     return false;
// }
//
// function soloLetras($value){
//   if(preg_match('/[^a-Z]/',$value))
//     return true;
//   else
//     return false;
// }

//=================================

$destino1 = "pprm29@gmail.com";
// $destino2 = "caifaguar.jm@gmail.com";
// $destino  = $destino1.", ".$destino2;
$destino = $destino1;
$nombre  = isset($_POST['nombre'])  ? $_POST['nombre']  : null;
$correo  = isset($_POST['correo'])  ? $_POST['correo']  : null;
$asunto  = isset($_POST['asunto'])  ? $_POST['asunto']  : null;
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : null;

$contenido = "Nombre: ".$nombre."\nemail: ".$correo."\nAsunto: ".$asunto."\nMensaje:\n\n".$mensaje;

//variable para errores.
$error  = true;

//validando datos ingresados.
//verificamos que se envíe el formulario.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(!sinNumeros($nombre) || !validarEspacios($mensaje))
    $error = false;

  //verificamos si hay errores.
  if($error){
    mail($destino,$asunto,$contenido);
    header('Location: validado.html');
    exit;
  }
  else
    header('Location: contacto.html');
}
?>
