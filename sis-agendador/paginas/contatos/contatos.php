<?php 
//Variável da pesquisa
$txt_pesquisa = (isset($_POST["txt_pesquisa"]))? $_POST["txt_pesquisa"]: "";
?>
<header>
    <h3><i class="bi bi-person-square"></i> Contatos</h3>
    <link rel="stylesheet" href="css/estilos-padrao.css">
</header>
<div>
    <a class="btn btn-outline-secondary mb-2"href="?menuop=cad-contato"><i class="bi bi-person-plus-fill"></i> Novo Contato</a>
</div>
<div>
    <form action="index.php?menuop=contatos" method="post">
        <div class="input-group">
            <input class="form-control" type="text" name="txt_pesquisa" value="<?= $txt_pesquisa?>">
            <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-search"></i> Pesquisar</button>
        </div>

    </form>
</div>
<div class="tabela">
<table class="table table-dark table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>
                    <i class="bi bi-star-fill"></i>
                </th>
                <th>ID</th>
                <th>Nome</th>
                <th>E-Mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Sexo</th>
                <th>Data de Nasc</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $quantidade = 10;
            $pagina = (isset($_GET['pagina']))?(int)$_GET['pagina']:1 ;
            $inicio =($quantidade * $pagina) - $quantidade;
            // (10 * 1) - 10 = 0
            // (10 * 2) - 10 = 10

            
            //contato é include da página index, o contatos.php é carregado, também está sendo carregado arquivo conexao.php
            $sql = "SELECT 
            idContato,
            upper(nomeContato) AS nomeContato,
            lower(emailContato) AS emailContato,
            telefoneContato,
            upper(enderecoContato) AS enderecoContato,
            CASE
                WHEN sexoContato='F' THEN 'FEMININO'
                WHEN sexoContato='M' THEN 'MASCULINO'
            ELSE
                'NÃO ESPECIFICADO'
            END AS sexoContato,
            DATE_FORMAT(dataNascContato,'%d/%m/%Y') AS dataNascContato,
            flagFavoritoContato
            FROM `tbcontatos`
            WHERE 
            idContato='{$txt_pesquisa}' or
            nomeContato LIKE '%{$txt_pesquisa}%'
            ORDER BY flagFavoritoContato DESC, nomeContato ASC
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
                    <?php 
                    if($dados["flagFavoritoContato"] === 1){
                        echo "<a href=\"#\"class=\"flagFavoritoContato link-warming\" tittle=\"Favorito\" id=\"{$dados["idContato"]}\">
                        <i class= \"bi bi-star-fill\"></i>
                        <a/>";
                    } else{
                        echo "<a href=\"#\"class=\"flagFavoritoContato link-warming\" tittle=\"Não Favorito\" id=\"{$dados["idContato"]}\">
                        <i class= \"bi bi-star\"></i>
                        <a/>";
                    }
                    ?>
                </td>
                <td><?= $dados['idContato']?></td>
                <td class="text-nowrap"><?= $dados['nomeContato']?></td>
                <td class="text-nowrap"><?= $dados['emailContato']?></td>
                <td class="text-nowrap"><?= $dados['telefoneContato']?></td>
                <td class="text-nowrap"><?= $dados['enderecoContato']?></td>
                <td><?= $dados['sexoContato']?></td>
                <td><?= $dados['dataNascContato']?></td>
                <td class="text-center"><a class="btn  btn-outline-warning btn-sm" href="index.php?menuop=editar-contato&idContato=<?= $dados['idContato'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                <td class="text-center"><a class="btn btn-outline-danger btn-sm" href="index.php?menuop=excluir-contato&idContato=<?= $dados['idContato'] ?>"><i class="bi bi-trash-fill"></i></a></td>
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
$sqlTotal = "SELECT idContato FROM tbcontatos";
try {
    $qrTotal = $conexao->query($sqlTotal);
    $numTotal = $qrTotal->rowCount();
    $totalPagina = ceil($numTotal / $quantidade);//arredondar pra cima
} catch (PDOException $e) {
    die("Erro ao executar a consulta: " . $e->getMessage());
}
echo "<li class='page-item'><span class='page-link'>Total de Registros: $numTotal </span></li> ";
echo "<li class='page-item'><a class= 'page-link' href= \"?menuop=contatos&pagina=1\">Primeira Página </a></li>";

if($pagina>3){
    ?>
        <li class='page-item'><a class="page-link" href= "?menuop=contatos&pagina=<?php echo $pagina-1?>"> << </a></li>
    <?php
}


for($i=1; $i<=$totalPagina; $i++){

    if($i>= ($pagina-2) && $i <= ($pagina+2)){
            if($i==$pagina){
                echo "<li class='page-item active'><span class='page-link'>$i</span><li>";
            } else{
                echo "<li class='page-item'><a class='page-link' href=\"?menuop=contatos&pagina=$i\">$i</a></li> ";
            }
    }

}

if($pagina< ($totalPagina -2)){
    ?>
        <li class="page-item"><a class="page-link" href= "?menuop=contatos&pagina=<?php echo $pagina+1?>"> >> </a></li>
    <?php
}

echo "<li class='page-item'><a class='page-link' href= \"?menuop=contatos&pagina=$totalPagina'\"> Última Página</a></li>";

?>
</ul>