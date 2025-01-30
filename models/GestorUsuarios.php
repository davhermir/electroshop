<?php
class GestorUsuarios
{
    private $db;
    //Constructor base datos 
    public function __construct($db)
    {
        $this->db = $db;
    }
    //Para insertar los datos de los usuarios 
    public function insertar(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios (dni,clave,nombre,apellidos,direccion,localidad,provincia,telefono, email,rol,activo) VALUES 
        (:dni,:clave,:nombre,:apellidos,:direccion,:localidad,
        :provincia,:telefono,:email,:rol,:activo)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dni', $usuario->getDni());
            $stmt->bindValue(':clave', password_hash($usuario->getClave(), PASSWORD_DEFAULT));
            $stmt->bindValue(':nombre', $usuario->getNombre());
            $stmt->bindValue(':apellidos', $usuario->getApellidos());
            $stmt->bindValue(':direccion', $usuario->getDireccion());
            $stmt->bindValue(':localidad', $usuario->getLocalidad());
            $stmt->bindValue(':provincia', $usuario->getProvincia());
            $stmt->bindValue(':telefono', $usuario->getTelefono());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':rol', $usuario->getrol());
            $stmt->bindValue(':activo', $usuario->getActivo());


            if ($stmt->execute()) {
                $user = $usuario->getDni();
                // MIRAR RUTA POR SI HAY QUE LLEVARLO A LISTAR ARTICULOS
                header("Location: ?action=listar_usuarios_view&nuevo=$user");
            } else {
                return "Ha habido un error al insertar los valores.";
            }
        } catch (PDOException $e) {
            return "Error al insertar los valores: " . $e->getMessage();
        }
    }

    public function insertarShort(UsuarioShort $usuario)
    {
        $sql = "INSERT INTO usuarios (dni,clave,nombre,email,rol,activo) VALUES 
        (:dni,:clave,:nombre,:email,:rol,:activo)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dni', $usuario->getDni());
            $stmt->bindValue(':clave', password_hash($usuario->getClave(), PASSWORD_DEFAULT));
            $stmt->bindValue(':nombre', $usuario->getNombre());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':rol', $usuario->getrol());
            $stmt->bindValue(':activo', $usuario->getActivo());


            if ($stmt->execute()) {
                $user = $usuario->getDni();
                header("Location: ?action=mostrar_articulos");
            } else {
                return "Ha habido un error al insertar los valores.";
            }
        } catch (PDOException $e) {
            return "Error al insertar los valores: " . $e->getMessage();
        }
    }
    //Para mostrar los datos de los usuarios 
    public function getUsers($inicio, $pags, $dni)
    {
        $sql = "SELECT * FROM usuarios where dni not like :dni LIMIT " . $inicio . "," . $pags;
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dni', $dni);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $usuarios = [];
            foreach ($result as $row) {
                $usuarios[] = new Usuario(
                    $row['dni'],
                    $row['clave'],
                    $row['nombre'],
                    $row['apellidos'],
                    $row['direccion'],
                    $row['localidad'],
                    $row['provincia'],
                    $row['telefono'],
                    $row['email'],
                    $row['rol'],
                    $row['activo'],

                );
            }
            return $usuarios;
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }
    public function mostrarAsc($desc, $inicio, $pags)
    {
        $sql = "SELECT * FROM usuarios ORDER BY dni " . ($desc ? 'DESC' : 'ASC') . " LIMIT " . $inicio . "," . $pags;

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $usuarios = [];
            foreach ($result as $row) {
                $usuarios[] = new Usuario(
                    $row['dni'],
                    $row['clave'],
                    $row['nombre'],
                    $row['apellidos'],
                    $row['direccion'],
                    $row['localidad'],
                    $row['provincia'],
                    $row['telefono'],
                    $row['email'],
                    $row['rol'],
                    $row['activo'],
                );
            }
            return $usuarios;
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }
    //Para buscar los datos a partir del nombre 
    public function buscar($cadena, $inicio, $pags)
    {
        $sql = "SELECT * FROM usuarios WHERE nombre LIKE :cadena ORDER BY nombre LIMIT " . $inicio . "," . $pags;
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cadena', "%$cadena%", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $usuarios = [];
            foreach ($result as $row) {
                $usuarios[] = new Usuario(
                    $row['dni'],
                    $row['clave'],
                    $row['nombre'],
                    $row['apellidos'],
                    $row['direccion'],
                    $row['localidad'],
                    $row['provincia'],
                    $row['telefono'],
                    $row['email'],
                    $row['rol'],
                    $row['activo'],
                );
            }
            return $usuarios;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }


    //Para buscar los datos a partir del nombre 
    public function buscarDni($cadena)
    {
        $sql = "SELECT * FROM usuarios WHERE dni LIKE :cadena";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cadena', "%$cadena%", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $usuarios = [];
            foreach ($result as $row) {
                $usuarios[] = new Usuario(
                    $row['dni'],
                    $row['clave'],
                    $row['nombre'],
                    $row['apellidos'],
                    $row['direccion'],
                    $row['localidad'],
                    $row['provincia'],
                    $row['telefono'],
                    $row['email'],
                    $row['rol'],
                    $row['activo'],
                );
            }
            return $usuarios;
        } catch (PDOException $e) {
            return "Error en la búsqueda: " . $e->getMessage();
        }
    }

    //Para modificar los datos a partir del nombre del usuario 
    public function modificar(Usuario $usuario)
    {
        $sql = "UPDATE usuarios SET nombre=:nombre ,apellidos=:apellidos,  direccion = :direccion , localidad=:localidad, provincia=:provincia,
        telefono = :telefono, email = :correo, rol=:rol,activo=:activo  WHERE dni = :dni";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombre', $usuario->getNombre());
            $stmt->bindValue(':apellidos', $usuario->getApellidos());
            $stmt->bindValue(':direccion', $usuario->getDireccion());
            $stmt->bindValue(':localidad', $usuario->getLocalidad());
            $stmt->bindValue(':provincia', $usuario->getProvincia());
            $stmt->bindValue(':telefono', $usuario->getTelefono());
            $stmt->bindValue(':correo', $usuario->getEmail());
            //$stmt->bindValue(':clave',  password_hash($usuario->getClave(),PASSWORD_DEFAULT));
            $stmt->bindValue(':rol', $usuario->getrol());
            $stmt->bindValue(':activo', $usuario->getActivo());
            $stmt->bindValue(':dni', $usuario->getDni());

            if ($stmt->execute()) {
                header("Location: ?cation=listar_usuarios_view");
            } else {
                echo "No se pudieron actualizar los datos.";
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }

    //Para eliminar los datos a partir del nombre del usuario 
    public function eliminar($dni)
    {
        $sql = "DELETE FROM usuarios WHERE dni = :dni";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dni', $dni);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al eliminar el usuario: " . $e->getMessage();
        }
    }

    public function countTotalUsuarios()
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios");
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function countTotalUsuariosNombre($nombre)
    {
        $sql = "SELECT * FROM usuarios WHERE nombre LIKE :cadena";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cadena', "%$nombre%", PDO::PARAM_STR);
        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return "Error en la consulta: " . $e->getMessage();
        }

    }

    public function updatePasswd($mail, $pwd)
    {
        $sql = "UPDATE usuarios SET clave=:clave WHERE email = :email";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':clave', password_hash($pwd, PASSWORD_DEFAULT));
            $stmt->bindValue(':email', $mail);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }

    public function login($usu, $pwd)
    {
        try {
            $sql = "select * from usuarios where email=:email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $usu, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch();
            if ($usuario && password_verify($pwd, $usuario['clave'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['dni'] = $usuario['dni'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['autentificado'] = "OK";
                $_SESSION['rol'] = $usuario['rol'];
                header("Location: index.php");
            } else {
                header("Location: ?action=mostrar_articulos&incorrect_pwd=true");
            }
            exit;
        } catch (PDOException $e) {
            echo 'Error de conexión a la base de datos';
            exit;
        }
    }

    public  function logout(){
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    public function checkDni($dni)
    {
        if (comprobar_dni($dni)) {
            $result = $this->buscarDni($dni);
            if (count($result) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            header( "Location: ?action=nuevo_usuario&dni_error=true");
        }
    }

    public function checkCorreo($correo)
    {
        //echo "<script>console.log('PHP-Gestor: " . $correo . "');</script>";
        $result = $this->buscarCorreo($correo);
        if (is_array($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCorreoUpdate($correo,$dni)
    {
        //echo "<script>console.log('PHP-Gestor: " . $correo . "');</script>";
        $result = $this->buscarCorreo($correo);
        if (is_array($result) && count($result) > 0) {
            if($dni == $result[0]->getDni()){
                return true;
            }
        } 
        return false;
        
    }

    public function buscarCorreo($cadena)
    {
        $sql = "SELECT * FROM usuarios WHERE email=:cadena";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cadena', $cadena, PDO::PARAM_STR);
            $stmt->execute();
            $usuarios = [];

            $errorInfo = $stmt->errorInfo();

            if ($errorInfo[0] != '00000') {
                echo "<script>console.log('Error en la consulta SQL: " . $errorInfo[2] . "');</script>";
            } else {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!is_array($result)) {
                    //echo "<script>console.log('PHP-Gestor-buscar: " . json_encode($result) . "');</script>";
                } else {
                    //echo "<script>console.log('PHP-Gestor-buscar: " . json_encode($result) . "');</script>";
                    //var_dump($result);
                    foreach ($result as $row) {
                        $usuarios[] = new Usuario(
                            $row['dni'],
                            $row['clave'],
                            $row['nombre'],
                            $row['apellidos'],
                            $row['direccion'],
                            $row['localidad'],
                            $row['provincia'],
                            $row['telefono'],
                            $row['email'],
                            $row['rol'],
                            $row['activo'],
                        );
                    }
                }
            }

            return $usuarios;
        } catch (PDOException $e) {
            echo "<script>console.log('Error en la búsqueda: " . $e->getMessage() . "');</script>";
            return false;
        }
    }
    public function updateUserGestion($dni,$activo,$rol){
        $sql = "UPDATE usuarios SET rol=:rol,activo=:activo  WHERE dni = :dni";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol);
            $stmt->bindValue(':activo', $activo);
            $stmt->bindValue(':dni', $dni);

            if ($stmt->execute()) {
                header("Location: ?cation=gestion_usuarios");
            } else {
                echo "No se pudieron actualizar los datos.";
            }
        } catch (PDOException $e) {
            echo "Ha habido un error al actualizar los valores: " . $e->getMessage();
        }
    }
}
