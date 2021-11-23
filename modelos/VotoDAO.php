<?php

/**
 * Description of UsuarioDAO
 *
 * @author DAW2
 */
class VotoDAO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($voto) {
//Comprobamos que el parámetro sea de la clase Contacto
        if (!$voto instanceof Voto) {
            return false;
        }
        $idVoto = $voto->getId();
        $ipCliente = $_SERVER['REMOTE_ADDR'];
//        $fecha = $voto->getFecha();

        $sql = "INSERT INTO `votos`(`id_candidato`, `ip_cliente`) VALUES "
                . "('$idVoto','$ipCliente')";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        /*     $sql = "INSERT INTO `contactos`(`nombre`, `partido`, `telefono`, `email`, `direccion`, `CP`, `ciudad`, `provincia`, `pais`, `fecha_nacimiento`, `foto`, `categoria`) VALUES "
          . "(?,?,?,?,?,?,?,?,?,?,?,?)";
          if (!$result = $this->conn->query($sql)) {
          die("Error en la SQL: " . $this->conn->error);
          }
          //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
          if (!$stmt = $this->conn->prepare($sql)) {
          die("Error al preparar la consulta SQL: " . $this->conn->error);
          }

          $stmt->bind_param('ssssssssssss', $nombre, $partido, $telefono, $email, $direccion, $cp, $ciudad, $provincia, $pais, $fecha_nacimiento, $foto, $categoria);
          $stmt->execute();
          $result = $stmt->get_result();
         */
        // Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $voto->setId($this->conn->insert_id);
        return true;
        if (!$result = $this->conn->query($sql)) {
            MensajesFlash::anadir_mensaje("Error en la ejecución de la consulta SQL al añadir el Voto");
            die("Error en la SQL: " . $this->conn->error);
        }
    }

    /**
     * Devuelve el usuario de la BD 
     * @param type $ip id del usuario
     * @return \Usuario Usuario de la BD o null si no existe
     */
    public function existeIP($ip) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM votos WHERE ip_cliente=$ip";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL : " . $this->conn->error);
        }
        return $result->fetch_object('Voto');
        /* También se podría sustituir el fetch_object por lo siguiente:
         * 
         * if ($fila = $result->fetch_assoc()) {
          $usuario = new Usuario();
          $usuario->setEmail($fila['email']);
          $usuario->setPassword($fila['password']);
          $usuario->setId($fila['id']);
          $usuario->setFoto($fila['foto']);
          $usuario->setNombre($fila['nombre']);

          return $usuario;
          } else {
          return null;
          } */
    }

    public function obtenerPorCandidato($id_candidato) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM votos WHERE id_candidato=$id_candidato";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL : " . $this->conn->error);
        }
        return $result->fetch_object('Voto');
    }

    public function find($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM votos WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL : " . $this->conn->error);
        }
        return $result->fetch_object('Voto');
    }

    public function findAll($orden = 'ASC', $campo = 'id_candidato') {
        $sql = "SELECT * FROM votos ORDER BY $campo $orden";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $arrayVotos = array();
        while ($voto = $result->fetch_object('Voto')) {
            $arrayVotos[] = $voto;
        }
        return $arrayVotos;
    }

}
