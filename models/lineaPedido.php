<?php
class LineaPedido
{
    private $numPedido;
    private $numLinea;
    private $codArticulo;
    private $cantidad;
    private $precio;
    private $descuento;

    public function __construct($numLinea, $numPedido, $codArticulo, $cantidad, $precio, $descuento)
    {
        $this->numLinea = $numLinea;
        $this->numPedido = $numPedido;
        $this->codArticulo = $codArticulo;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->descuento = $descuento;
    }

    public function getNumLinea()
    {
        return $this->numLinea;
    }
    public function getNumPedido()
    {
        return $this->numPedido;
    }
    public function getCodArticulo()
    {
        return $this->codArticulo;
    }
    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getDescuento()
    {
        return $this->descuento;
    }

    public function setNumLinea($numLinea)
    {
        $this->numLinea = $numLinea;
    }
    public function setNumPedido($numPedido)
    {
        $this->numPedido = $numPedido;
    }
    public function setCodArticulo($codArticulo)
    {
        $this->codArticulo = $codArticulo;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

}
?>