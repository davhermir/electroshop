<?php
class Pedido
{
    private $idPedido;
    private $fecha;
    private $total;
    private $estado;
    private $codUsuario;
    private $activo;

    public function __construct($id, $fecha, $total, $estado, $codUsuario, $act)
    {
        $this->idPedido = $id;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->estado = $estado;
        $this->codUsuario = $codUsuario;
        $this->activo = $act;
    }


    public function getIdPedido()
    {
        return $this->idPedido;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function getestado()
    {
        return $this->estado;
    }
    public function getCodUsuario()
    {
        return $this->codUsuario;
    }
    public function getActivo()
    {
        return $this->activo;
    }


    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function setestado($estado)
    {
        $this->estado = $estado;
    }
    public function setCodUsuario($codUsuario)
    {
        $this->codUsuario = $codUsuario;
    }
    public function setAct($activo)
    {
        $this->activo = $activo;
    }

}
?>