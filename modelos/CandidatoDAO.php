<?php

/**
 * Description of UsuarioDAO
 *
 * @author DAW2
 */
class CandidatoDAO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($candidato) {
//Comprobamos que el parámetro sea de la clase Contacto
        if (!$candidato instanceof Candidato) {
            return false;
        }
        $nombre = $candidato->getNombre();
        $foto = $candidato->getFoto();
        $partido = $candidato->getPartido();

        $sql = "INSERT INTO `candidatos`(`nombre`, `foto`, `partido`) VALUES "
                . "('$nombre','$foto','$partido')";
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
        $candidato->setId($this->conn->insert_id);
        return true;
        if (!$result = $this->conn->query($sql)) {
            MensajesFlash::anadir_mensaje("Error en la ejecución de la consulta SQL al añadir el Contacto");
            die("Error en la SQL: " . $this->conn->error);
        }
    }

    public function findAll($orden = 'ASC', $campo = 'partido') {
        $sql = "SELECT * FROM candidatos ORDER BY $campo $orden";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $arrayCandidatos = array();
        while ($candidato = $result->fetch_object('Candidato')) {
            $arrayCandidatos[] = $candidato;
        }
        return $arrayCandidatos;
    }

    public function delete($candidato) {
//Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($candidato == null || get_class($candidato) != 'Candidato') {
            return false;
        }
        $sql = "DELETE FROM candidatos WHERE id = " . $candidato->getId();
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

 
    public function find($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM candidatos WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL : " . $this->conn->error);
        }
        return $result->fetch_object('Candidato');
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

    public function findByNombrePartido($nombre, $partido) {
        $sql = "SELECT * FROM candidatos WHERE nombre='$nombre' and partido='$partido'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $arrayCandidatosNombrePartido = new Candidato();
        while ($candidatoNombrePartido = $result->fetch_object('Candidato')and $arrayCandidatosNombrePartido != null) {
            $arrayCandidatosNombrePartido = $candidatoNombrePartido;
        }
        return $arrayCandidatosNombrePartido; /* ->fetch_object('Contacto') */
    }


}
