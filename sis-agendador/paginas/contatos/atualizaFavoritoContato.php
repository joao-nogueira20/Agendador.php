<?php 
include("../../db/conexao.php");
$idContato = $_GET["idContato"];
$flagFavoritoContato =$_GET["flagFavoritoContato"];

$sql = "UPDATE tbcontatos SET flagFavoritoContato = {$flagFavoritoContato} WHERE idContato = {$idContato}";
try {
    $stmt = $conexao->prepare($sql);
    $stmt->execute(); // Executa a consulta
    $rs = $stmt->fetchAll(); // Pega todos os resultados, se aplicável
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
?>