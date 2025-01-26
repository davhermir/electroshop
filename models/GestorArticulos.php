<?php
class GestorArticulos
{
    private $db;
    //Constructor base datos 
    public function __construct($db)
    {
        $this->db = $db;
    }
    //Para insertar los datos de los usuarios 
    public function insertar(Articulo $articulo)
    {
        $sql = "INSERT INTO articulos (codigo,nombre,descripcion,categoria,precio,imagen,descuento,activo) VALUES (:codigo,:nombre,:descripcion,:categoria,
        :precio,:imagen,:descuento,:activo)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $articulo->getCodigo());
            $stmt->bindValue(':nombre', $articulo->getNombre());
            $stmt->bindValue(':descripcion', $articulo->getDescripcion());
            $stmt->bindValue(':categoria', $articulo->getCategoria());
            $stmt->bindValue(':precio', $articulo->getPrecio());
            $stmt->bindValue(':imagen', $articulo->getImagen());
            $stmt->bindValue(':descuento', $articulo->getDescuento());
            $stmt->bindValue(':activo', $articulo->getActivo());
            
            if ($stmt->execute()) {
                header("Location: ?action=mostrar_articulos");
            } else {
                echo "Ha habido un error al insertar los valores.";
            }
        } catch (PDOException $e) {
            echo "Error al insertar los valores: " . $e->getMessage();
        }
    }
    //Para mostrar los datos de los usuarios 
    public function mostrar($inicio,$pags,$cat)
    {
        if ($cat !== null) {
            $sql = "SELECT * FROM articulos WHERE WHERE categoria = :categoria LIMIT ". $inicio . "," . $pags;
        }else{
            $sql = "SELECT * FROM articulos LIMIT ". $inicio . "," . $pags;
        }
        
        
        try {
            $stmt = $this->db->prepare($sql);
            if ($cat !== null) {
                $stmt->bindParam(':categoria', $cat, PDO::PARAM_INT);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $articulos = [];
            foreach ($result as $row) {
                $articulos[] = new Articulo(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['categoria'],
                    $row['precio'],
                    $row['imagen'],
                    $row['descuento'],
                    $row['activo']
                );
            }
            return $articulos;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
    public function mostrarAsc($desc,$inicio,$pags,$cat)
    {
        if ($cat !== null) {
            $sql = "SELECT * FROM articulos WHERE categoria = :categoria
            OR categoria IN (SELECT codigo FROM categorias WHERE codCategoriaPadre = :categoria)
             ORDER BY codigo " . ($desc ? 'DESC' : 'ASC') . " LIMIT :inicio, :pags";
        } else {
            $sql = "SELECT * FROM articulos ORDER BY codigo " . ($desc ? 'DESC' : 'ASC') . " LIMIT :inicio, :pags";
        }
        
        try {
            $stmt = $this->db->prepare($sql);
            if ($cat !== null) {
                $stmt->bindParam(':categoria', $cat, PDO::PARAM_INT);  // Asumimos que $cat es un número entero
            }
            $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);   
            $stmt->bindParam(':pags', $pags, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $articulos = [];
            foreach ($result as $row) {
                $articulos[] = new Articulo(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['categoria'],
                    $row['precio'],
                    $row['imagen'],
                    $row['descuento'],
                    $row['activo']
                );
            }
            return $articulos;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
    //Para buscar los datos a partir del nombre 
    public function buscar($cadena,$inicio,$pags)
    {
        $sql = "SELECT * FROM articulos WHERE nombre LIKE :cadena ORDER BY nombre LIMIT ". $inicio . "," . $pags ;
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cadena', "%$cadena%", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $articulos = [];
            foreach ($result as $row) {
                $articulos[] = new Articulo(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['categoria'],
                    $row['precio'],
                    $row['imagen'],
                    $row['descuento'],
                    $row['activo']
                );
            }
            return $articulos;
        } catch (PDOException $e) {
            echo "Error en la búsqueda: " . $e->getMessage();
        }
    }

    //Para buscar los datos a partir del nombre 
    public function buscarCodigo($cadena)
    {
        $sql = "SELECT * FROM articulos WHERE codigo LIKE :cadena";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cadena', "%$cadena%", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $articulos = [];
            foreach ($result as $row) {
                $articulos[] = new Articulo(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['categoria'],
                    $row['precio'],
                    $row['imagen'],
                    $row['descuento'],
                    $row['activo']
                );
            }
            return $articulos;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    public function comprobar_codigo($codigo)
{
    if (strlen($codigo) <9) {
        for ($i = 0; $i < strlen($codigo); $i++) {
            $char = ord($codigo[$i]);
            if ($i == 0 || $i == 1 || $i == 2 ) {
                if (!$this->isChar($char)) {
                    return false;
                }
            } else {
                if (!$this->isNumber($char)) {
                    return false;
                }
            }
        }
        return true;
    } else {
        return false;
    }
}

public function isChar($char)
{
    if (($char >= 65 && $char <= 90) || ($char >= 97 && $char <= 122)) {
        return true;
    }
    return false;
}

public function isNumber($number)
{
    if ($number >= 48 && $number <= 57) {
        return true;
    }
    return false;
}

    //Para modificar los datos a partir del nombre del usuario 
    public function modificar(Articulo $articulo)
    {
        $sql = "UPDATE articulos SET nombre=:nombre ,  descripcion = :descripcion , categoria=:categoria, precio=:precio,
        imagen = :imagen  WHERE codigo = :codigo";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombre', $articulo->getNombre());
            $stmt->bindValue(':descripcion', $articulo->getDescripcion());
            $stmt->bindValue(':categoria', $articulo->getCategoria());
            $stmt->bindValue(':precio', $articulo->getPrecio());
            $stmt->bindValue(':imagen', $articulo->getImagen());
            $stmt->bindValue(':codigo', $articulo->getCodigo());
            $stmt->bindValue(':descuento', $articulo->getDescuento());
            $stmt->bindValue(':activo', $articulo->getActivo());

            if ($stmt->execute()) {
                header("Location: ?action=listaArticulosView");
            } else {
                echo "No se pudieron actualizar los datos.";
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }

    //Para eliminar los datos a partir del nombre del usuario 
    public function eliminar($codigo)
    {
        $sql = "DELETE FROM articulos WHERE codigo = :codigo";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $codigo);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al eliminar el articulo: " . $e->getMessage();
        }
    }

    public function buscarCodyImg($codigo,$imagen){
        $sql = "SELECT * FROM articulos WHERE codigo LIKE '$codigo' and imagen like '$imagen'";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', "$codigo", PDO::PARAM_STR);
            $stmt->bindValue(':imagen', "$imagen", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $articulos = [];
            foreach ($result as $row) {
                $articulos[] = new Articulo(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['categoria'],
                    $row['precio'],
                    $row['imagen'],
                    $row['descuento'],
                    $row['activo']
                );
            }
            return $articulos;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }

    }

    public function countTotalArticulos($cat)
    {
        if ($cat !== null) {
            $sql = "SELECT * FROM articulos where categoria = :cat
            OR categoria IN (SELECT codigo FROM categorias WHERE codCategoriaPadre = :cat)";
        } else {
            $sql = "SELECT * FROM articulos";
        }
        $stmt = $this->db->prepare($sql);
        if($cat!=null){
            $stmt->bindValue(':cat', "$cat", PDO::PARAM_STR);
        }
        try {
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function countTotalArticulosNombre($nombre){
        $sql = "SELECT * FROM articulos WHERE nombre LIKE :cadena";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cadena', "%$nombre%", PDO::PARAM_STR);
        try {
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }

    }



}
