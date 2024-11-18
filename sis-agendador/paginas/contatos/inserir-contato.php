<header>
    <h3>Inserir Contato</h3>
</header>

<?php 
$nomeContato = strip_tags($_POST["nomeContato"]);
$nomeContato = $conexao->quote($nomeContato);//O método quote do PDO é usado para escapar os caracteres especiais em uma string, o que é necessário para evitar SQL injection. No entanto, o método quote também adiciona aspas ao redor da string.
$nomeContato = substr($nomeContato, 1, -1);//Como o método quote do PDO adiciona aspas no início e no fim da string, a função substr é usada para removê-las, mantendo apenas a string escapada.

//O código recebe um valor de entrada de um formulário (por exemplo, o nome de um contato), escapa caracteres especiais para evitar SQL injection usando o método quote do PDO, e então remove as aspas que o quote adiciona ao redor da string. Isso assegura que o valor inserido no banco de dados seja seguro e não introduza vulnerabilidades de segurança.

$emailContato = strip_tags($_POST["nomeContato"]);
$emailContato = $conexao->quote($emailContato);
$emailContato = substr($emailContato, 1, -1);

$emailContato = strip_tags($_POST["emailContato"]);
$emailContato = $conexao->quote($emailContato);
$emailContato = substr($emailContato, 1, -1);

$telefoneContato = strip_tags($_POST["telefoneContato"]);
$telefoneContato = $conexao->quote($telefoneContato);
$telefoneContato = substr($telefoneContato, 1, -1);

$enderecoContato = strip_tags($_POST["enderecoContato"]);
$enderecoContato = $conexao->quote($enderecoContato);
$enderecoContato = substr($enderecoContato, 1, -1);

$sexoContato = strip_tags($_POST["sexoContato"]);
$sexoContato = $conexao->quote($sexoContato);
$sexoContato = substr($sexoContato, 1, -1);

$dataNascContato = strip_tags($_POST["dataNascContato"]);
$dataNascContato = $conexao->quote($dataNascContato);
$dataNascContato = substr($dataNascContato, 1, -1);


$sql="INSERT INTO tbcontatos (
    nomeContato,
    emailContato,
    telefoneContato,
    enderecoContato,
    sexoContato,
    dataNascContato)
    VALUES(
        '{$nomeContato}',
        '{$emailContato}',
        '{$telefoneContato}',
        '{$enderecoContato}',
        '{$sexoContato}',
        '{$dataNascContato}'
    )";

    try {
        $conexao->query($sql);
    } catch (PDOException $e) {
        die("Erro ao executar a consulta: " . $e->getMessage());
    }

    echo "O registro foi inserido com sucesso!";
?>