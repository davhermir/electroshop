<?php
class Usuario{
    private $dni;
    private $clave;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $localidad;
    private $provincia;
    private $telefono;
    private $email;
    private $rol;
    private $activo;

    public function __construct($id,$contr,$nom,$ape,$dir,$loc,$prov,$tel,$em,$rol,$activo){
        $this->dni=$id;
        $this->clave=$contr;
        $this->nombre=$nom;
        $this->apellidos=$ape;
        $this->direccion=$dir;
        $this->localidad=$loc;
        $this->provincia=$prov;
        $this->telefono=$tel;
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
    public function getApellidos() {
        return $this->apellidos;
    }
    public function getDireccion() { 
        return $this->direccion; 
    } 
    public function getLocalidad() { 
        return $this->localidad; 
    } 
    public function getProvincia() { 
        return $this->provincia; 
    } 
    public function getTelefono() { 
        return $this->telefono; 
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
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }
    public function setDireccion($direccion) { 
        $this->direccion = $direccion; 
    }
    public function setLocalidad($localidad) { 
        $this->localidad = $localidad; 
    }
    public function setProvincia($provincia) { 
        $this->provincia = $provincia; 
    }
    public function setTelefono($telefono) { 
        $this->telefono = $telefono; 
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