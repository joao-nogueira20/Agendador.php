<?php
include("config.php");

//Explicar a diferença de mysqli pra PDO
//$conexao = mysqli_connect(SERVIDOR,USUARIO,SENHA,BANCO) or die("Erro na conexão com o servidor! " . mysqli_connect_errror());

try {
    $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
    // Definindo o modo de erro do PDO para exceção
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    die("Erro na conexão com o servidor! " . $e->getMessage());
}