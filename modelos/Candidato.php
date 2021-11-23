<?php

class Candidato {

    private $id;
    private$nombre;
    private $foto;
    private $partido;
    private $votos;

    function constructorVacio() {
        
    }

    function constructor($id, $nombre, $foto, $partido) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->partido = $partido;
    }
    function getVotos() {
        return $this->votos;
    }

    function setVotos($votos): void {
        $this->votos = $votos;
    }

        function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getFoto() {
        return $this->foto;
    }

    function getPartido() {
        return $this->partido;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setFoto($foto): void {
        $this->foto = $foto;
    }

    function setPartido($partido): void {
        $this->partido = $partido;
    }

}
