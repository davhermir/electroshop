<?php
class Articulo
{
    private $codigo;
    private $nombre;
    private $descripcion;
    private $categoria;
    private $precio;
    private $imagen;
    private $descuento;
    private $activo;

    public function __construct($id, $nom, $desc, $cat, $prec, $ima, $descuent, $act)
    {
        $this->codigo = $id;
        $this->nombre = $nom;
        $this->descripcion = $desc;
        $this->categoria = $cat;
        $this->precio = $prec;
        $this->imagen = $ima;
        $this->descuento = $descuent;
        $this->activo = $act;
    }


    public function getCodigo(): mixed
    {
        return $this->codigo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getDescuento()
    {
        return $this->descuento;
    }
    public function getActivo()
    {
        return $this->activo;
    }

    public function calcularPrecioOferta(){
        return $this->precio - $this->precio*($this->descuento/100);
    }


    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}
?>