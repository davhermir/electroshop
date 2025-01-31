<?php
class GestorCategorias
{
    private $db;
    //Constructor base datos 
    public function __construct($db)
    {
        $this->db = $db;
    }
    //Para insertar los datos de los usuarios 
    public function insertar(Categoria $categoria)
    {
        $sql = "INSERT INTO categorias (codigo,nombre,activo,codCategoriaPadre) VALUES (:codigo,:nombre,:activo,:codCategoriaPadre)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $categoria->getCodigo());
            $stmt->bindValue(':nombre', $categoria->getNombre());
            $stmt->bindValue(':activo', $categoria->getActivo());
            $stmt->bindValue(':codCategoriaPadre', $categoria->getCodpadre());
            
            if ($stmt->execute()) {
                header('Location: ?action=gestion_categorias');
            } else {
                return "Ha habido un error al insertar los valores.";
            }
        } catch (PDOException $e) {
            echo "Error al insertar los valores: " . $e->getMessage();
        }
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias where activo=1 ORDER BY codCategoriaPadre DESC";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categorias = [];
            foreach ($result as $row) {
                $categorias[] = new Categoria(
                    $row['codigo'],
                    $row['nombre'],
                    $row['activo'],
                    $row['codCategoriaPadre']
                );
            }
            return $categorias;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

    public function getCategoriasAdmin()
    {
        $sql = "SELECT * FROM categorias ORDER BY codCategoriaPadre,activo DESC";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categorias = [];
            foreach ($result as $row) {
                $categorias[] = new Categoria(
                    $row['codigo'],
                    $row['nombre'],
                    $row['activo'],
                    $row['codCategoriaPadre']
                );
            }
            return $categorias;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

    //Para buscar los datos a partir del codigo 
    public function buscarCodigo($cadena)
    {
        $sql = "SELECT * FROM categorias WHERE codigo = :cadena";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cadena', "$cadena", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categorias = [];
            foreach ($result as $row) {
                $categorias[] = new Categoria(
                    $row['codigo'],
                    $row['nombre'],
                    $row['activo'],
                    $row['codCategoriaPadre']
                );
            }
            return $categorias;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    //Para modificar los datos a partir del nombre del usuario 
    public function modificar(Categoria $categoria,$codigoAnterior)
    {
        $sql = "UPDATE categorias SET codigo=:codigo, nombre=:nombre ,  activo=:activo, codCategoriaPadre=:codCategoriaPadre WHERE codigo = :codigoAnterior";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $categoria->getCodigo());
            $stmt->bindValue(':nombre', $categoria->getNombre());
            $stmt->bindValue(':activo', $categoria->getActivo());
            $stmt->bindValue(':codCategoriaPadre', $categoria->getCodpadre());
            $stmt->bindValue(':codigoAnterior', $codigoAnterior);

            if ($stmt->execute()) {
                header("Location: ?action=gestion_categorias");
            } else {
                echo "No se pudieron actualizar los datos.";
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }

    

    public function countTotalCategorias()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias where activo=1");
        try {
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function countTotalCategoriasNombre($nombre){
        $sql = "SELECT * FROM categorias WHERE nombre LIKE :cadena and activo=1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cadena', "%$nombre%", PDO::PARAM_STR);
        try {
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }

    }

    public function borrarCategoria($codigo){
        $sql = "UPDATE categorias SET activo=0 WHERE codigo = :codigo";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $codigo);
            if ($stmt->execute()) {
                header("Location: ?action=gestion_categorias");
            } else {
                echo "No se pudieron actualizar los datos.";
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }

    public function getCategoriasByidPadre($codigo){
        $sql = "SELECT * FROM categorias WHERE codCategoriaPadre LIKE :codigo and activo=1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', "$codigo", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }

    }


}
