<?php
class Categoria
{
    private $codigo;
    private $nombre;
    private $activo;
    private $codCategoriaPadre;

    public function __construct($id, $nom, $act, $catpad)
    {
        $this->codigo = $id;
        $this->nombre = $nom;
        $this->activo = $act;
        $this->codCategoriaPadre = $catpad;
    }


    public function getCodigo(): mixed
    {
        return $this->codigo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getActivo()
    {
        return $this->activo;
    }
    public function getCodpadre()
    {
        return $this->codCategoriaPadre;
    }


    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setAct($activo)
    {
        $this->activo = $activo;
    }
    public function setCodpadre($codCategoriaPadre)
    {
        $this->codCategoriaPadre = $codCategoriaPadre;
    }
}
?>