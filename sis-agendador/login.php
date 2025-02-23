<?php 
//Conexão com o banco de dados
include "./db/conexao.php";
//Verificação no banco de dados
$msg_error="";

if(isset($_POST["loginUser"]) && isset($_POST["senhaUser"]) ){
    $loginUser = $_POST["loginUser"];
    $senhaUser = hash('sha256',$_POST["senhaUser"]);


    $sql = "SELECT * FROM tbusuarios WHERE loginUser = :loginUser AND senhaUser = :senhaUser";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':loginUser', $loginUser);
    $stmt->bindParam(':senhaUser', $senhaUser);
    $stmt->execute();
    $linha = $stmt->rowCount();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if($linha != 0){
        session_start();
        $_SESSION['loginUser'] = $loginUser;
        $_SESSION['senhaUser'] = $senhaUser;
        $_SESSION['nomeUser'] = $dados['nomeUser'];
        header('location: index.php');
        exit();

    } else{
        $msg_error="<div class ='alert alert-danger mt-3'>
        <p>Usuário não encontrado ou a senha não confere.</p>
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Login - Agendador</title>
</head>
<body class="bg-secondary">
    
<div class="container">
    <div class="row vh-100 align-items-center justify-content-center">
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 p-4 bg-white shadow rounded">
            <div class="row justify-content-center mb-4">
                <img src="./img/logo_agendador.png" alt="Agendador">
            </div>
            <form class="needs-validation" action="login.php" method="post" novalidate>
                <div class="form-group mb-4">
                    <label class="form-label" for="loginUser">Login</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>
                    <input class="form-control" type="text" name="loginUser" id="loginUser" required>
                    <div class="invalid-feedback">
                        Informe o username.
                    </div>
                    </div>                 
                </div>
                <div class="form-group mb-4">
                    <label class="form-label" for="senhaUser">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-key-fill"></i>
                        </span>
                    <input class="form-control" type="password" name="senhaUser" id="senhaUser" required>
                    <div class="invalid-feedback">
                        Informe a senha.
                    </div> 
                    </div>  
                    <?php
                    echo $msg_error;
                    ?>   
                </div>
                <button class="btn btn-success w-100"><i class="bi bi-box-arrow-in-right"></i> Entrar</button>
            </form>
        </div>
    </div>
</div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="./js/validation.js"></script>
</body>
</html>