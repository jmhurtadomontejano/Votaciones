<?php
session_start();
require 'utilities/ConexionBD.php';
require 'utilities/Session.php';
require 'utilities/MensajesFlash.php';
require 'modelos/Candidato.php';
require 'modelos/CandidatoDAO.php';
require 'modelos/Voto.php';
require 'modelos/VotoDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $error = false;
    MensajesFlash::anadir_mensaje("Datos llegan por GET");
}
$idVoto='';
$idVoto = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$votoNuevo = new Voto();
$votoNuevo->setId_candidato($idVoto);
//conecto el Usuario DAO y lanzo la consulta de insertar el contacto preaparado
$votoDAO = new VotoDAO(ConexionBD::conectar());
$result = $votoDAO->insert($votoNuevo);
//   imprimir_datos($contacto_nuevo);
if ($result) {
   MensajesFlash::anadir_mensaje("Voto registrado correctamente"+$idVoto);
} else {
    MensajesFlash::anadir_mensaje("Voto no registrado"+$idVoto);
}
   

//header("Location: index.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pantalla Insertar VOTO - Examen</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
            <h1>Índice de Votaciones</h1>
            <menu id="menu">
                <ul id="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="anadirCandidato.php">Añadir un Candidato</a></li>

                </ul>
            </menu>
            <?php mensajesFlash::imprimir_mensajes() ?>
        </header>
    </body>


    <script>
<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>


    </script>


</html>