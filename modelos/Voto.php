<?php

class Voto{
    
    private $id;
    private $id_candidato;
    private $ip_cliente;
    private $fecha;
    
    
    function constructorVacio() {
        
    }
    function constructorVoto($id, $id_candidato, $ip_cliente, $fecha) {
        $this->id = $id;
        $this->id_candidato = $id_candidato;
        $this->ip_cliente = $ip_cliente;
        $this->fecha = $fecha;
    }
    function getId() {
        return $this->id;
    }

    function getId_candidato() {
        return $this->id_candidato;
    }

    function getIp_cliente() {
        return $this->ip_cliente;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setId_candidato($id_candidato): void {
        $this->id_candidato = $id_candidato;
    }

    function setIp_cliente($ip_cliente): void {
        $this->ip_cliente = $ip_cliente;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }


}