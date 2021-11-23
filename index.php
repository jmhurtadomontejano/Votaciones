<?php
session_start();
require 'utilities/ConexionBD.php';
require 'utilities/Session.php';
require 'utilities/MensajesFlash.php';
require 'modelos/Candidato.php';
require 'modelos/CandidatoDAO.php';
require 'modelos/Voto.php';
require 'modelos/VotoDAO.php';
/*
//Comprobamos el token
if ($_POST['token'] != $_SESSION['token']) {
    header('Location: index.php');
    MensajesFlash::anadir_mensaje("Token incorrecto");
    die();
}
//Calculamos un token
$token = md5(time() + rand(0, 999));
$_SESSION['token'] = $token;
?>*/

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


        <h1>Listado de Candidatos</h1>
        <?php
        $candidatoDAO = new CandidatoDAO(ConexionBD::conectar()); //conecto con la base de datos
        $candidato = $candidatoDAO->findAll(); //
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID: </th>
                    <th>Nombre:   </th>
                    <th>Foto: </th>
                    <th>Partido: </th>
                    <th>Numero de Votos: </th>

                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidato as $candidatoIndividual) { ?>
                    <tr>
                        <td><?php echo $candidatoIndividual->getId(); ?></td>
                        <td><?php echo $candidatoIndividual->getNombre(); ?></td>
                        <td><?php echo $candidatoIndividual->getFoto(); ?></td>
                        <td><?php echo $candidatoIndividual->getPartido(); ?></td>
                        <td><?php echo $candidatoIndividual->getVotos(); ?></td>
                        <td><a href="insertarVoto.php?id=<?= $candidatoIndividual->getId() ?>"><button>Votar</button></a>
                            <a href="borrarCandidato.php?id=<?= $candidatoIndividual->getId() ?>"><button>Borrar</button></a></button></td>
                    <?php } ?> 

                </tr>


            </tbody>
        </table>
    </body>    


    <script>
<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>
    </script>



</html>