<header>
    <h3>
        <i class="bi bi-list-task"></i> Inserir Tarefa
    </h3>
</header>

<?php 
$tituloTarefa = strip_tags($_POST['tituloTarefa']);
$descricaoTarefa = strip_tags($_POST['descricaoTarefa']);
$dataConclusaoTarefa = strip_tags($_POST['dataConclusaoTarefa']);
$horaConclusaoTarefa = strip_tags($_POST['horaConclusaoTarefa']);
$dataLembreteTarefa = strip_tags($_POST['dataLembreteTarefa']);
$horaLembreteTarefa = strip_tags($_POST['horaLembreteTarefa']);
$recorrenciaTarefa = strip_tags($_POST['recorrenciaTarefa']);

$sql="INSERT INTO tbtarefas
(
    tituloTarefa,
    descricaoTarefa,
    dataConclusaoTarefa,
    horaConclusaoTarefa,
    dataLembreteTarefa,
    horaLembreteTarefa,
    recorrenciaTarefa
)
VALUES
(
    :tituloTarefa,
    :descricaoTarefa,
    :dataConclusaoTarefa,
    :horaConclusaoTarefa,
    :dataLembreteTarefa,
    :horaLembreteTarefa,
    :recorrenciaTarefa
)
";

$stmt = $conexao->prepare($sql);

$stmt->bindParam(':tituloTarefa', $tituloTarefa);
$stmt->bindParam(':descricaoTarefa', $descricaoTarefa);
$stmt->bindParam(':dataConclusaoTarefa', $dataConclusaoTarefa);
$stmt->bindParam(':horaConclusaoTarefa', $horaConclusaoTarefa);
$stmt->bindParam(':dataLembreteTarefa', $dataLembreteTarefa);
$stmt->bindParam(':horaLembreteTarefa', $horaLembreteTarefa);
$stmt->bindParam(':recorrenciaTarefa', $recorrenciaTarefa);

$rs = $stmt->execute();

if ($rs) {
    ?>
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Inserir Tarefa</h4>
  <p>Tarefa inserida com sucesso.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=tarefas">Voltar para a lista de tarefas</a></p>
</div>
    <?php
} else {
    ?>
        <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Erro</h4>
  <p>A tarefa não pode ser inserida.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=tarefas">Voltar para a lista de tarefas</a></p>
</div>
    <?php
    echo "Erro ao inserir, tente novamente mais tarde.";
}
?>