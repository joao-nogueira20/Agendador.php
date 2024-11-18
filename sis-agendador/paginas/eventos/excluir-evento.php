<header>
    <h1>Excluir Evento</h1>
</header>

<?php 
$idEvento= $_GET['idEvento'];

$sql="DELETE FROM tbeventos WHERE idEvento = :idEvento";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':idEvento', $idEvento);

$rs = $stmt->execute();

if ($rs) {
    ?>
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Excluir Evento</h4>
  <p>Evento excluida com sucesso.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=eventos">Voltar para a lista de Eventos</a></p>
</div>
    <?php
} else {
    ?>
        <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Erro</h4>
  <p>A Evento não pode ser excluida.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=eventos">Voltar para a lista de Eventos</a></p>
</div>
    <?php
    echo "Erro ao inserir, tente novamente mais tarde.";
}
?>