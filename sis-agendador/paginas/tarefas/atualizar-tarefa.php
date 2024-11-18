<header>
    <h3>
        <i class="bi bi-list-task"></i> Cadastro de Tarefa
    </h3>
</header>
<?php 
$idTarefa = strip_tags($_POST['idTarefa']);
$tituloTarefa = strip_tags($_POST['tituloTarefa']);
$descricaoTarefa = strip_tags($_POST['descricaoTarefa']);
$dataConclusaoTarefa = strip_tags($_POST['dataConclusaoTarefa']);
$horaConclusaoTarefa = strip_tags($_POST['horaConclusaoTarefa']);
$dataLembreteTarefa = strip_tags($_POST['dataLembreteTarefa']);
$horaLembreteTarefa = strip_tags($_POST['horaLembreteTarefa']);
$recorrenciaTarefa = strip_tags($_POST['recorrenciaTarefa']);

$sql= "UPDATE tbtarefas SET
tituloTarefa = :tituloTarefa,
descricaoTarefa = :descricaoTarefa,
dataConclusaoTarefa = :dataConclusaoTarefa,
horaConclusaoTarefa = :horaConclusaoTarefa,
dataLembreteTarefa = :dataLembreteTarefa,
horaLembreteTarefa = :horaLembreteTarefa,
recorrenciaTarefa = :recorrenciaTarefa
WHERE idTarefa= :idTarefa
";
$stmt = $conexao->prepare($sql);

$stmt->bindParam(':tituloTarefa', $tituloTarefa);
$stmt->bindParam(':descricaoTarefa', $descricaoTarefa);
$stmt->bindParam(':dataConclusaoTarefa', $dataConclusaoTarefa);
$stmt->bindParam(':horaConclusaoTarefa', $horaConclusaoTarefa);
$stmt->bindParam(':dataLembreteTarefa', $dataLembreteTarefa);
$stmt->bindParam(':horaLembreteTarefa', $horaLembreteTarefa);
$stmt->bindParam(':recorrenciaTarefa', $recorrenciaTarefa);
$stmt->bindParam(':idTarefa', $idTarefa);

$rs = $stmt->execute();

if ($rs) {
    ?>
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Inserir Tarefa</h4>
  <p>Tarefa atualizada com sucesso.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=tarefas">Voltar para a lista de tarefas</a></p>
</div>
    <?php
} else {
    ?>
        <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Erro</h4>
  <p>A tarefa não pode ser atualizada.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=tarefas">Voltar para a lista de tarefas</a></p>
</div>
    <?php
    echo "Erro ao inserir, tente novamente mais tarde.";
}

?>