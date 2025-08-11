<?php
namespace App\Controllers;


class LogoutController{

    public function sair(){
 
        if (session_status() === PHP_SESSION_ACTIVE) {
            
            session_unset();

            session_destroy();

            header("Location: /login");

            exit;
            
        }


    }
    

}

?>