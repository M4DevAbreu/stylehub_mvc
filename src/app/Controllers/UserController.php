<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\User;

use PDO; 

class UserController{

    public function formLogin(){
        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/login.html.twig', [
            'title' => 'Login'

        ]);
    }

    public function Login(){

        $email = $_POST["email"] ?? '';
        $senha = $_POST["senha"] ?? '';

        if (empty($email) || empty($senha)) {
            echo "preencha todoos os campos";
            return;
        }

        try{

            $usuario = User::buscaEmail($email);

            if ($usuario && password_verify($senha, $usuario->senha)) {
                $_SESSION['usuario_id'] = $usuario -> id;
                $_SESSION['nome'] = $usuario ->nome;
                $_SESSION['tipo_usuario'] = $usuario->tipo_usuario;

                if ($usuario->tipo_usuario === 'gestor' || $usuario->tipo_usuario === 'admin' ) {
                    header('Location: /barbearia/home');
                } else{
                    header('Location: /users/inicio');
                }
                exit;
            } else{
                $_SESSION['error_login'] = 'Email ou senha inválidos.';
                header('Location: /login');
                exit;
            }
        } catch (\PDOException $e){
            error_log ('Erro ao fazer login: ' . $e->getMessage());
            echo 'Erro interno, tente novamente!';
        }
    
    }

    public function formCadastro(){
        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/teladecadastro.html.twig', [
            'title' => 'Cadastro'

        ]);
    }

    public function cadastro(){
        $nome = $_POST['nome'] ?? '';
        $sobrenome = $_POST['sobrenome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $endereco = $_POST['endereco'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $genero = $_POST['genero'] ?? 'personalizado';

        if (empty($nome) || empty($email) || empty($senha)) {
            echo "Preencha os campos obrigatórios";
            return;
        }

        try{
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            
            $userModel = new \App\Models\User();
            $userModel->cadastrar([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'cpf' => $cpf,
            'email' => $email,
            'telefone' => $telefone,
            'endereco' => $endereco,
            'senha' => $senha_hash,
            'genero' => $genero,
            ]);
            header('Location: /login');
            exit;

        } catch(\PDOException $e){
            error_log('Erro ao cadastrar: ' . $e->getMessage());
            echo 'Erro ao cadastrar usuário!';
        }

    }
    

}

?>
