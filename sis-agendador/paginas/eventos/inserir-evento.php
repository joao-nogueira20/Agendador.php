<header>
    <h3>
        <i class="bi bi-calendar-check"></i> Inserir Evento
    </h3>
</header>

<?php 
$tituloEvento = strip_tags($_POST['tituloEvento']);
$descricaoEvento = strip_tags($_POST['descricaoEvento']);
$dataInicioEvento = strip_tags($_POST['dataInicioEvento']);
$horaInicioEvento = strip_tags($_POST['horaInicioEvento']);
$dataFimEvento = strip_tags($_POST['dataFimEvento']);
$horaFimEvento = strip_tags($_POST['horaFimEvento']);

$sql="INSERT INTO tbeventos
(
    tituloEvento,
    descricaoEvento,
    dataInicioEvento,
    horaInicioEvento,
    dataFimEvento,
    horaFimEvento
)
VALUES
(
    :tituloEvento,
    :descricaoEvento,
    :dataInicioEvento,
    :horaInicioEvento,
    :dataFimEvento,
    :horaFimEvento
)
";

$stmt = $conexao->prepare($sql);

$stmt->bindParam(':tituloEvento', $tituloEvento);
$stmt->bindParam(':descricaoEvento', $descricaoEvento);
$stmt->bindParam(':dataInicioEvento', $dataInicioEvento);
$stmt->bindParam(':horaInicioEvento', $horaInicioEvento);
$stmt->bindParam(':dataFimEvento', $dataFimEvento);
$stmt->bindParam(':horaFimEvento', $horaFimEvento);

$rs = $stmt->execute();

if ($rs) {
    ?>
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Inserir Evento</h4>
  <p>Evento inserida com sucesso.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=eventos">Voltar para a lista de Eventos</a></p>
</div>
    <?php
} else {
    ?>
        <div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Erro</h4>
  <p>A Evento não pode ser inserida.</p>
  <hr>
  <p class="mb-0"><a href="?menuop=eventos">Voltar para a lista de Eventos</a></p>
</div>
    <?php
    echo "Erro ao inserir, tente novamente mais tarde.";
}
?>