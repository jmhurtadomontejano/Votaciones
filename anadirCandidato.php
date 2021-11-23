<?php
session_start();

require 'utilities/ConexionBD.php';
require 'utilities/Session.php';
require 'utilities/MensajesFlash.php';
require 'modelos/Candidato.php';
require 'modelos/CandidatoDAO.php';
require 'modelos/Voto.php';
require 'modelos/VotoDAO.php';

//Comprobamos el token
    if ($_POST['token'] != $_SESSION['token']) {
        header('Location: index.php');
        MensajesFlash::anadir_mensaje("Token incorrecto");
        die();
    }

$nombre = '';
$foto = '';
$candidato = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = false;

//Comprobamos el token
    if ($_POST['token'] != $_SESSION['token']) {
        header('Location: index.php');
        MensajesFlash::anadir_mensaje("Token incorrecto");
        die();
    }


    //Sanitizo todas las variables que voy a operar
    $nombre = filter_var($_POST['nombreEntrada'], FILTER_SANITIZE_SPECIAL_CHARS);
    $foto = $_POST['foto'];
    $partido = filter_var($_POST['partidoEntrada'],FILTER_SANITIZE_SPECIAL_CHARS);

//compruebo si las variables básicas están rellenadas
    if (empty($_POST['nombreEntrada'])) {
        MensajesFlash::anadir_mensaje("*El nombre no puede estar vacio");
        $error = true;
    }


    if (!$error) {//si no hay error, preparo todos los campos del candidato
        //conecto el Candidato DAO 
        $candidatoDAO = new CandidatoDAO(ConexionBD::conectar());
        $existeCandidato = $candidatoDAO->findByNombrePartido($nombre, $partido);

        $candidatoNormal = $existeCandidato;
        imprimir_datos($candidatoNormal);

        if (!$candidatoNormal->getNombre() == $nombre) {
            $candidatoNuevo = new Candidato();
            $candidatoNuevo->setNombre($nombre);
            $candidatoNuevo->setFoto($foto);
            $candidatoNuevo->setPartido($partido);


       /*     
              //Validación foto
              if ($_FILES['foto']['type'] != 'image/png' &&
              $_FILES['foto']['type'] != 'image/gif' &&
              $_FILES['foto']['type'] != 'image/jpeg') {
              MensajesFlash::anadir_mensaje("El archivo seleccionado no es una foto.");
              $error = true;
              }
              if ($_FILES['foto']['size'] > 1000000) {
              MensajesFlash::anadir_mensaje("El archivo seleccionado es demasiado grande. Debe tener un tamaño inferior a 1MB");
              $error = true;
              }

              if (!$error) {
              //Copiar foto
              //Generamos un nombre para la foto
              $nombre_foto = md5(time() + rand(0, 999999));
              $extension_foto = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.') + 1);
              $extension_foto = filter_var($extension_foto, FILTER_SANITIZE_SPECIAL_CHARS);
              //Comprobamos que no exista ya una foto con el mismo nombre, si existe calculamos uno nuevo
              while (file_exists("imagenes/$nombre_foto.$extension_foto")) {
              $nombre_foto = md5(time() + rand(0, 999999));
              }
              //movemos la foto a la carpeta que queramos guardarla y con el nombre original
              move_uploaded_file($_FILES['foto']['tmp_name'], "imagenes/$nombre_foto.$extension_foto");


              $contacto_nuevo->setFoto($nombre_foto . $extension_foto);
              }
             */
            if (!$error) {
                // lanzo la consulta de insertar el contacto preaparado
                $result = $candidatoDAO->insert($candidatoNuevo);
                 //imprimir_datos($candidatoNuevo);




                MensajesFlash::anadir_mensaje("Candidato añadido correctamente");
                //limpio variables
                $nombre = '';
                $foto = '';
                $partido = '';

                /*   header('Location: index.php');
                  die(); */
            }
        } else {
            MensajesFlash::anadir_mensaje("El candidato con ese nombre y partido ya existe");
        }
    }
}


//Calculamos un token
$token = md5(time() + rand(0, 999));
$_SESSION['token'] = $token;
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Añadir Candidatos Juanmi</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
            <h1>Candidatos</h1>
            <menu id="menu">
                <ul id="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="anadirCandidato.php">Añadir un Candidato</a></li>
                </ul>
            </menu>
            <?php mensajesFlash::imprimir_mensajes() ?>
        </header>

        <fieldset>
            <legend>Insertar Candidato</legend>
            <form action="" method="post" class="form"  enctype=”multipart/form-data”>
                <input type="hidden" name="token" value="<?= $token ?>">
                <div> Nombre: <input type="text" name="nombreEntrada" value="<?php echo $nombre ?>"></div>
                <div> Foto: <input type="file" id="foto" name="foto" accept="image/jpeg,image/gif,image/png"></div>
                <div> Partido: <input type="text" name="partidoEntrada" value="<?php echo $candidato ?>"></div>
                <div>
                    <input type="submit" value="Guardar Candidato">
                </div>
            </form>
        </fieldset>

       

       
    </body>    


    <script>
<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>

        function muestraCategorias() {
            let cate
        }
    </script>



</html>
<!--A continuación, cajón desastre, que no quiero perder por si me hace falta -->
