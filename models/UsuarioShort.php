<?php
class UsuarioShort{
    private $dni;
    private $clave;
    private $nombre;
    private $email;
    private $rol;
    private $activo;

    public function __construct($id,$contr,$nom,$em,$rol,$activo){
        $this->dni=$id;
        $this->clave=$contr;
        $this->nombre=$nom;
        $this->email=$em;
        $this->rol=$rol; 
        $this->activo=$activo; 
    }


    public function getDni(): mixed { 
        return $this->dni; 
    } 
    public function getNombre() { 
        return $this->nombre; 
    } 
    public function getEmail() { 
        return $this->email; 
    } 
    public function getClave() { 
        return $this->clave; 
    } 
    public function getrol() { 
        return $this->rol; 
    }
    public function getActivo() {
        return $this->activo;
    }
    
    
    public function setNombre($nombre) { 
         $this->nombre = $nombre; 
    } 
    public function setEmail($email) { 
        $this->email = $email; 
    } 
    public function setClave($clave) { 
        $this->clave = $clave; 
    } 
    public function setRol($rol) { 
        $this->rol = $rol; 
    } 

    public function setactivo($activo) {
        $this->activo = $activo;
    }
    
    

}
?>