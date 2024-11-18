<header>
    <h3>
        <i class="bi bi-calendar-check"></i> Cadastro de Evento
    </h3>
</header>
<?php 
$idEvento = strip_tags($_POST['idEvento']);
$tituloEvento = strip_tags($_POST['tituloEvento']);
$descricaoEvento = strip_tags($_POST['descricaoEvento']);
$dataInicioEvento = strip_tags($_POST['dataInicioEvento']);
$horaInicioEvento = strip_tags($_POST['horaInicioEvento']);
$dataFimEvento = strip_tags($_POST['dataFimEvento']);
$horaFimEvento = strip_tags($_POST['horaFimEvento']);

$sql= "UPDATE tbeventos SET
tituloEvento = :tituloEvento,
descricaoEvento = :descricaoEvento,
dataInicioEvento = :dataInicioEvento,
horaInicioEvento = :horaInicioEvento,
dataFimEvento = :dataFimEvento,
horaFimEvento = :horaFimEvento
WHERE idEvento= :idEvento
";
$stmt = $conexao->prepare($sql);

$stmt->bindParam(':tituloEvento', $tituloEvento);
$stmt->bindParam(':descricaoEvento', $descricaoEvento);
$stmt->bindParam(':dataInicioEvento', $dataInicioEvento);
$stmt->bindParam(':horaInicioEvento', $horaInicioEvento);
$stmt->bindParam(':dataFimEvento', $dataFimEvento);
$stmt->bindParam(':horaFimEvento', $horaFimEvento);
$stmt->bindParam(':idEvento', $idEvento);

$rs = $stmt->execute();

if ($rs) {
    ?>
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Inserir Evento</h4>
  <p>Evento atualizada com sucesso.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=eventos">Voltar para a lista de Eventos</a></p>
</div>
    <?php
} else {
    ?>
        <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Erro</h4>
  <p>A Evento não pode ser atualizada.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=eventos">Voltar para a lista de Eventos</a></p>
</div>
    <?php
    echo "Erro ao inserir, tente novamente mais tarde.";
}

?>