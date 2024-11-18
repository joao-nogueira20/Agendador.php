<header>
    <h3>Atualizar Contato</h3>
</header>

<?php 
$idContato = $_POST["idContato"];
$idContato = $conexao->quote($idContato);
$idContato = substr($idContato, 1, -1);

$nomeContato = $_POST["nomeContato"];
$nomeContato = $conexao->quote($nomeContato);
$nomeContato = substr($nomeContato, 1, -1);

//O código recebe um valor de entrada de um formulário (por exemplo, o nome de um contato), escapa caracteres especiais para evitar SQL injection usando o método quote do PDO, e então remove as aspas que o quote adiciona ao redor da string. Isso assegura que o valor inserido no banco de dados seja seguro e não introduza vulnerabilidades de segurança.

$emailContato = $_POST["nomeContato"];
$emailContato = $conexao->quote($emailContato);
$emailContato = substr($emailContato, 1, -1);

$emailContato = $_POST["emailContato"];
$emailContato = $conexao->quote($emailContato);
$emailContato = substr($emailContato, 1, -1);

$telefoneContato = $_POST["telefoneContato"];
$telefoneContato = $conexao->quote($telefoneContato);
$telefoneContato = substr($telefoneContato, 1, -1);

$sexoContato = $_POST["sexoContato"];
$sexoContato = $conexao->quote($sexoContato);
$sexoContato = substr($sexoContato, 1, -1);

$enderecoContato = $_POST["enderecoContato"];
$enderecoContato = $conexao->quote($enderecoContato);
$enderecoContato = substr($enderecoContato, 1, -1);

$dataNascContato = $_POST["dataNascContato"];
$dataNascContato = $conexao->quote($dataNascContato);
$dataNascContato = substr($dataNascContato, 1, -1);


$sql="UPDATE tbcontatos SET
nomeContato = '{$nomeContato}',
emailContato = '{$emailContato}',
telefoneContato = '{$telefoneContato}',
sexoContato = '{$sexoContato}',
enderecoContato = '{$enderecoContato}',
dataNascContato = '{$dataNascContato}'
WHERE idContato = '{$idContato}'
";

    try {
        $conexao->query($sql);
    } catch (PDOException $e) {
        die("Erro ao executar a consulta: " . $e->getMessage());
    }

    echo "O registro foi atualizado com sucesso!";
?>