<?php 
$txt_pesquisa = (isset($_POST["txt_pesquisa"]))? $_POST["txt_pesquisa"]: "";
//alterna entre status concluído ou não concluído
$idTarefa = (isset($_GET['idTarefa'])) ? $_GET['idTarefa'] :"";
$statusTarefa = (isset($_GET['statusTarefa']) and $_GET['statusTarefa']=='0')?'1':'0';

if(!empty($idTarefa)){
$sql = "UPDATE tbtarefas SET statusTarefa = {$statusTarefa} WHERE idTarefa = {$idTarefa}";

try {
    $rs = $conexao->query($sql);//result set(resultados a serem recebidos)
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
}
?>
<header>
    <h3><i class="bi bi-list-task"></i> Tarefas</h3>
    <link rel="stylesheet" href="css/estilos-padrao.css">
</header>
<div>
    <a class="btn btn-outline-secondary mb-2"href="?menuop=cad-tarefa"><i class="bi bi-list-task"></i> Nova Tarefa</a>
</div>
<div>
    <form action="index.php?menuop=tarefas" method="post">
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
                <th>Data da Conclusão</th>
                <th>Hora da Conclcusão</th>
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
            idTarefa,
            statusTarefa,
            tituloTarefa,
            descricaoTarefa,
            DATE_FORMAT(dataConclusaoTarefa, '%d/%m/%Y') AS dataConclusaoTarefa,
            horaConclusaoTarefa
            From tbtarefas     
            WHERE
            tituloTarefa LIKE '%{$txt_pesquisa}%' OR
            descricaoTarefa LIKE '%{$txt_pesquisa}%' OR
            DATE_FORMAT(dataConclusaoTarefa, '%d/%m/%Y') LIKE '%{$txt_pesquisa}%'
            ORDER BY statusTarefa,DataConclusaoTarefa
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
                    <a class = "btn btn-secondary btn-sm"href="index.php?menuop=tarefas&pagina=<?=$pagina?>&idTarefa=<?=$dados['idTarefa']?>&statusTarefa=<?=$dados['statusTarefa']?>">
                        <?php
                        if($dados['statusTarefa']==0){
                            echo'<i class="bi bi-square"></i>';
                        } else{
                            echo'<i class="bi bi-check-square"></i>';
                        }
                        
                        ?>
                    </a>
                </td>
                <td class="text-nowrap"><?= $dados['tituloTarefa']?></td>
                <td class="text-nowrap"><?= $dados['descricaoTarefa']?></td>
                <td class="text-nowrap"><?= $dados['dataConclusaoTarefa']?></td>
                <td class="text-nowrap"><?= $dados['horaConclusaoTarefa']?></td>

                <td class="text-center"><a class="btn  btn-outline-warning btn-sm" href="index.php?menuop=editar-tarefa&idTarefa=<?= $dados['idTarefa'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                <td class="text-center"><a class="btn btn-outline-danger btn-sm" href="index.php?menuop=excluir-tarefa&idTarefa=<?= $dados['idTarefa'] ?>"><i class="bi bi-trash-fill"></i></a></td>
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
$sqlTotal = "SELECT idTarefa FROM tbtarefas";
try {
    $qrTotal = $conexao->query($sqlTotal);
    $numTotal = $qrTotal->rowCount();
    $totalPagina = ceil($numTotal / $quantidade);//arredondar pra cima
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
echo "<li class='page-item'><span class='page-link'>Total de Registros: $numTotal </span></li> ";
echo "<li class='page-item'><a class= 'page-link' href= \"?menuop=tarefas&pagina=1\">Primeira Página </a></li>";

if($pagina>3){
    ?>
        <li class='page-item'><a class="page-link" href= "?menuop=tarefas&pagina=<?php echo $pagina-1?>"> << </a></li>
    <?php
}


for($i=1; $i<=$totalPagina; $i++){

    if($i>= ($pagina-2) && $i <= ($pagina+2)){
            if($i==$pagina){
                echo "<li class='page-item active'><span class='page-link'>$i</span><li>";
            } else{
                echo "<li class='page-item'><a class='page-link' href=\"?menuop=tarefas&pagina=$i\">$i</a></li> ";
            }
    }

}

if($pagina< ($totalPagina -2)){
    ?>
        <li class="page-item"><a class="page-link" href= "?menuop=tarefas&pagina=<?php echo $pagina+1?>"> >> </a></li>
    <?php
}

echo "<li class='page-item'><a class='page-link' href= \"?menuop=tarefas&pagina=$totalPagina'\"> Última Página</a></li>";

?>
</ul>