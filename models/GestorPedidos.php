<?php
class GestorPedidos
{
    private $db;
    //Constructor base datos 
    public function __construct($db)
    {
        $this->db = $db;
    }
    //Para insertar los datos de los usuarios 
    public function insertar(Pedido $pedido)
    {
        $sql = "INSERT INTO pedidos (fecha,total,estado,codUsuario,activo) VALUES 
        (:fecha,:total,:estado,:codUsuario,:activo)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':fecha', $pedido->getFecha());
            $stmt->bindValue(':total', $pedido->getTotal());
            $stmt->bindValue(':estado', $pedido->getestado());
            $stmt->bindValue(':codUsuario', $pedido->getCodUsuario());
            $stmt->bindValue(':activo', $pedido->getActivo());
        
            if ($stmt->execute()) {
                $id_pedido = $this->db->lastInsertId();
                return $id_pedido;
            } else {
                return "Ha habido un error al insertar los valores.";
            }
        } catch (PDOException $e) {
            return "Error al insertar los valores: " . $e->getMessage();
        }
    }

    
    public function insertarLineaPedido(LineaPedido $lineapedido)
    {
        $sql = "INSERT INTO lineapedido (numPedido ,codArticulo ,cantidad,precio,descuento) VALUES 
        (:numPedido,:codArticulo,:cantidad,:precio,:descuento)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':numPedido', $lineapedido->getNumPedido());
            $stmt->bindValue(':codArticulo', $lineapedido->getCodArticulo());
            $stmt->bindValue(':cantidad', $lineapedido->getCantidad());
            $stmt->bindValue(':precio', $lineapedido->getPrecio());
            $stmt->bindValue(':descuento', $lineapedido->getDescuento());
        
            if ($stmt->execute()) {
                $_SESSION['carrito'] = [];
                header('Location: ?action=ver_pedidos');
            } else {
                echo "Ha habido un error al insertar los valores.";
            }
        } catch (PDOException $e) {
            return "Error al insertar los valores: " . $e->getMessage();
        }
    }

    public function getPedidosByUser($cadena){
        $sql = "SELECT * FROM pedidos WHERE codUsuario LIKE :cadena and activo=1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cadena', "%$cadena%", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pedidos = [];
            foreach ($result as $row) {
                $pedidos[] = new Pedido(
                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['codUsuario'],
                    $row['activo'],
                );
            }
            return $pedidos;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    public function getlineaPedido($idPedido){
        $sql = "SELECT * FROM lineapedido WHERE numPedido = :idPedido";
        try{
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idPedido', "$idPedido", PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lineaspedido = [];
        foreach ($result as $row) {
            $lineaspedido[] = new LineaPedido(
                $row['numPedido'],
                $row['numLinea'],
                $row['codArticulo'],
                $row['cantidad'],
                $row['precio'],
                $row['descuento'],
            );
        }
        return $lineaspedido;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    public function getAllPedidos(){
        $sql = "SELECT * FROM pedidos";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pedidos = [];
            foreach ($result as $row) {
                $pedidos[] = new Pedido(
                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['codUsuario'],
                    $row['activo'],
                );
            }
            return $pedidos;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    public function getPedidoById($id){
        $sql = "SELECT * FROM pedidos WHERE idPedido LIKE :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pedidos = [];
            foreach ($result as $row) {
                $pedidos[] = new Pedido(
                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['codUsuario'],
                    $row['activo'],
                );
            }
            return $pedidos;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    public function countTotalPedidos($id){
        if ($id) {
                $sql = "SELECT * FROM pedidos where idPedido = :id";
        } else {
                $sql = "SELECT * FROM pedidos";
        }
        $stmt = $this->db->prepare($sql);
        if ($id != null) {
            $stmt->bindValue(':idPedido', "$id", PDO::PARAM_STR);
        }
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function modificar($idPedido,$estado,$activo){
        $sql = "UPDATE pedidos SET estado=:estado, activo=:activo WHERE idPedido  = :idPedido ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':estado', $estado);
            $stmt->bindValue(':activo', $activo);
            $stmt->bindValue(':idPedido', $idPedido);
            if ($stmt->execute()) {
                header("Location: ?action=ver_pedidos");
            } else {
                echo "No se pudieron actualizar los datos.";
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }
}