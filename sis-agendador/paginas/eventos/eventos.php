<?php 
$txt_pesquisa = (isset($_POST["txt_pesquisa"]))? $_POST["txt_pesquisa"]: "";
//alterna entre status concluído ou não concluído
$idEvento = (isset($_GET['idEvento'])) ? $_GET['idEvento'] :"";
$statusEvento = (isset($_GET['statusEvento']) and $_GET['statusEvento']=='0')?'1':'0';

if(!empty($idEvento)){
$sql = "UPDATE tbeventos SET statusEvento = {$statusEvento} WHERE idEvento = {$idEvento}";

try {
    $rs = $conexao->query($sql);//result set(resultados a serem recebidos)
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
}
?>
<header>
    <h3><i class="bi bi-calendar-check"></i> Eventos</h3>
    <link rel="stylesheet" href="css/estilos-padrao.css">
</header>
<div>
    <a class="btn btn-outline-secondary mb-2"href="?menuop=cad-evento"><i class="bi bi-list-task"></i> Novo Evento</a>
</div>
<div>
    <form action="index.php?menuop=eventos" method="post">
        <div class="input-group">
            <input class="form-control" type="text" name="txt_pesquisa" value=<?=$txt_pesquisa?>>
            <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-search"></i> Pesquisar</button>
        </div>

    </form>
</div>
<div class="tabela">
<table class="table table-dark table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>Status</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Data de início</th>
                <th>Hora de ínicio</th>
                <th>Data de Fim</th>
                <th>Hora de Fim</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $quantidade = 10;
            $pagina = (isset($_GET['pagina']))?(int)$_GET['pagina']:1 ;
            $inicio =($quantidade * $pagina) - $quantidade;

            
            $sql = "SELECT 
            idEvento,
            statusEvento,
            tituloEvento,
            descricaoEvento,
            DATE_FORMAT(dataInicioEvento, '%d/%m/%Y') AS dataInicioEvento,
            horaInicioEvento,
            DATE_FORMAT(dataFimEvento, '%d/%m/%Y') AS dataFimEvento,
            horaFimEvento
            From tbeventos     
            WHERE
            tituloEvento LIKE '%{$txt_pesquisa}%' OR
            descricaoEvento LIKE '%{$txt_pesquisa}%' OR
            DATE_FORMAT(dataInicioEvento, '%d/%m/%Y') LIKE '%{$txt_pesquisa}%'
            ORDER BY statusEvento,DataInicioEvento
            LIMIT $inicio, $quantidade
            ";
            try {
                $rs = $conexao->query($sql);//result set(resultados a serem recebidos)
            } catch (PDOException $e) {
                die("Erro ao executar a consulta: " . $e->getMessage());
            }
            

            while ($dados = $rs->fetch(PDO::FETCH_ASSOC)) {//fetch(PDO::FETCH_ASSOC) é usado para obter as linhas da tabela como um array associativo. Ele retorna false quando não há mais linhas para buscar, encerrando o loop while.   
            ?>
            <tr>
                <td>
                    <a class = "btn btn-secondary btn-sm"href="index.php?menuop=eventos&pagina=<?=$pagina?>&idEvento=<?=$dados['idEvento']?>&statusEvento=<?=$dados['statusEvento']?>">
                        <?php
                        if($dados['statusEvento']==0){
                            echo'<i class="bi bi-square"></i>';
                        } else{
                            echo'<i class="bi bi-check-square"></i>';
                        }
                        
                        ?>
                    </a>
                </td>
                <td class="text-nowrap"><?= $dados['tituloEvento']?></td>
                <td class="text-nowrap"><?= $dados['descricaoEvento']?></td>
                <td class="text-nowrap"><?= $dados['dataInicioEvento']?></td>
                <td class="text-nowrap"><?= $dados['horaInicioEvento']?></td>
                <td class="text-nowrap"><?= $dados['dataFimEvento']?></td>
                <td class="text-nowrap"><?= $dados['horaFimEvento']?></td>

                <td class="text-center"><a class="btn  btn-outline-warning btn-sm" href="index.php?menuop=editar-evento&idEvento=<?= $dados['idEvento'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                <td class="text-center"><a class="btn btn-outline-danger btn-sm" href="index.php?menuop=excluir-evento&idEvento=<?= $dados['idEvento'] ?>"><i class="bi bi-trash-fill"></i></a></td>
            </tr>
            <?php 
            } 
            ?>
        </tbody>
</table>
</div>
<br>


<ul class="pagination justify-content-center">
<?php 
$sqlTotal = "SELECT idEvento FROM tbeventos";
try {
    $qrTotal = $conexao->query($sqlTotal);
    $numTotal = $qrTotal->rowCount();
    $totalPagina = ceil($numTotal / $quantidade);//arredondar pra cima
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
echo "<li class='page-item'><span class='page-link'>Total de Registros: $numTotal </span></li> ";
echo "<li class='page-item'><a class= 'page-link' href= \"?menuop=eventos&pagina=1\">Primeira Página </a></li>";

if($pagina>3){
    ?>
        <li class='page-item'><a class="page-link" href= "?menuop=eventos&pagina=<?php echo $pagina-1?>"> << </a></li>
    <?php
}


for($i=1; $i<=$totalPagina; $i++){

    if($i>= ($pagina-2) && $i <= ($pagina+2)){
            if($i==$pagina){
                echo "<li class='page-item active'><span class='page-link'>$i</span><li>";
            } else{
                echo "<li class='page-item'><a class='page-link' href=\"?menuop=eventos&pagina=$i\">$i</a></li> ";
            }
    }

}

if($pagina< ($totalPagina -2)){
    ?>
        <li class="page-item"><a class="page-link" href= "?menuop=eventos&pagina=<?php echo $pagina+1?>"> >> </a></li>
    <?php
}

echo "<li class='page-item'><a class='page-link' href= \"?menuop=eventos&pagina=$totalPagina'\"> Última Página</a></li>";

?>
</ul>