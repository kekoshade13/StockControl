<?php
include_once('connection.php');
session_start();
if(!empty($_POST['funcion'])) {
    switch($_POST['funcion']) {
        case 'addUser':
            if(!empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['nombre_u']) && !empty($_POST['password']) && !empty($_POST['ci']) && !empty($_POST['gender'])) {
                $nombre = $_POST['name'];
                $apellido = $_POST['lastname'];
                $usuario = $_POST['nombre_u'];
                $contrasenia = $_POST['password'];
                $cedula = $_POST['ci'];
                $class = "";
                $genero = $_POST['gender'];

                if(isset($_POST['class'])) {
                    $class = $_POST['class'];
                }
                userClass::registrarUsuario($nombre, $apellido, $usuario, $cedula, $contrasenia, $class, $genero);
            }
            break;
        case 'deleteUser':
            if(!empty($_POST['id_user'])) {
                $id = $_POST['id_user'];
                userClass::eliminarUsuario($id);
            }
            break;
        case 'loginUsuario':
            if(!empty($_POST['cedula']) && !empty($_POST['contrasenia'])) {
                $ci = $_POST['cedula'];
                $pass = $_POST['contrasenia'];

                userClass::userLogin($ci, $pass);
            }
            break;
        case 'actualizarTarget':
            if(!empty($_POST['target']) && !empty($_POST['usuario'])) {
                $user = $_POST['usuario'];
                $target = $_POST['target'];

                userClass::actualizarTarget($user, $target);
            }
            break;
    }
}
class  userClass {

    public static $options = ['cost' => 12];

    public function __construct() {

    }
    public static function userLogin($ci, $contrasenia) {  
        try {
            $db = getDB();
            $query = $db->prepare("SELECT * FROM users WHERE ci= ?");
            $query->execute([$ci]);
            $data = $query->fetch(PDO::FETCH_OBJ);
            $count = $query->rowCount();

            if($count > 0) {
                if(password_verify($contrasenia, $data->pass)) {
                    $_SESSION['uid'] = $data->id_user;
                    $_SESSION['sesion_exito'] = 1;
                    $_SESSION['hora']=time();

                    return $_SESSION['uid'];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function registrarUsuario($nombre, $apellido, $usuario, $ci, $pass, $class, $genero) {
        $db = getDB();
        try {
            
            $verify = $db->prepare("SELECT * FROM users WHERE nombre_u = ?");
            $verify->execute([$usuario]);

            $countUser = $verify->rowCount();

            if($countUser > 0) {
                echo json_encode(0);
            } else {
                $verifyCI = $db->prepare("SELECT * FROM users WHERE ci = ?");
                $verifyCI->execute([$ci]);
                $countCI = $verifyCI->rowCount();

                if($countCI > 0) {
                    echo json_encode(2);
                } else {
                    $passhash= password_hash($pass, PASSWORD_BCRYPT);;
                    $query = $db->prepare("INSERT INTO users (nombre_u, nombre, apellido, ci, pass, class, genero) VALUES ('$usuario', '$nombre', '$apellido', '$ci', '$passhash', '$class', '$genero')");
                    $query->execute();
                    if($query) {
                        $carpeta = "../img/img_perfil/" . $usuario;
                        if(!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }
                        echo json_encode(1);
                    } else { 
                        echo json_encode(0);
                    }
                }
                
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
        
    }

    public static function actualizarTarget($user, $target) {

        try {
            $db = getDB();

            $stmt = $db->prepare("select * from Users where id_user = ?");
            $stmt->execute([$user]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $stmt1 = $db->prepare("UPDATE Users SET targetProd = $target WHERE (id_user = ?)");
                $stmt1->execute([$user]);

                if($stmt1) {
                    echo json_encode(1);
                } else {
                    echo json_encode(0);
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerDatosUnUsuario($id) {
        try {
            $db = getDB();
            $query = $db->prepare("SELECT * FROM users WHERE id_user= ?");
            $query->execute([$id]);
            
            $count = $query->rowCount();

            if($count > 0) {
                $dataUser = $query->fetch(PDO::FETCH_OBJ);
                return $dataUser;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerUsuarios() {
        try {
            $db = getDB();
            $query = $db->prepare("SELECT * FROM Users");
            $query->execute();

            $dataUser = $query->fetchAll(PDO::FETCH_OBJ);
            return $dataUser;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function eliminarUsuario($id) {
        try {
            $db = getDB();
            $query = $db->prepare("DELETE FROM users WHERE id_user= ?");
            $query->execute([$id]);

            if($query) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }
}

?>  