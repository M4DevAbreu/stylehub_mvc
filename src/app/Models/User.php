<?php
namespace App\Models;

use App\Models\BD;
use PDO;

class User{

    public  static function buscaEmail(string $email){
        $conn = BD::getConnection();

        $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(':email', $email, PDO::PARAM_STR);
        $sql->execute();
        
        return $sql->fetch(PDO::FETCH_OBJ);


    }
}

?>