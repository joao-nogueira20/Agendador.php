<header>
    <h3>Excluir Contato</h3>
</header>

<?php 
$idContato = $_GET["idContato"];
$idContato = $conexao->quote($idContato);
$idContato = substr($idContato, 1, -1);
$sql= "DELETE FROM tbcontatos WHERE idContato = '{$idContato}'";

try {
    $conexao->query($sql);
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
echo "Registro excluido com sucesso!";
?>