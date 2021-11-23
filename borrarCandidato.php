<?php
session_start();
require 'utilities/ConexionBD.php';
require 'utilities/Session.php';
require 'utilities/MensajesFlash.php';
require 'modelos/Candidato.php';
require 'modelos/CandidatoDAO.php';
require 'modelos/Voto.php';
require 'modelos/VotoDAO.php';

$candidatoDAO = new CandidatoDAO(ConexionBD::conectar());
$candidato = $candidatoDAO->find($_GET['id']);
//Comprobamos el el usuario es propietario del artículo

    imprimir_datos($candidato);
    if ($candidatoDAO->delete($candidato)) {
        MensajesFlash::anadir_mensaje("Candidato borrado");
    } else {
        MensajesFlash::anadir_mensaje("Candidato no encontrado");
    }
    

//header("Location: index.php");
?>

 <!DOCTYPE html>
<html>
    <head>
        <title>Votaciones Juanmi - Examen</title>
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
