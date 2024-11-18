<?php 
set_time_limit(0);//o  browser tem um tempo para fazer o upload do arquivo, por isso colocamos zero para ignorar o tempo e esperar o upload por mais que seja demorado
include_once('../../../db/conexao.php');



$extensoes_validas = array(".jpg",".png",".bmp");
$caminho_absoluto = "../fotos-contatos"; //caminho da pasta onde será depositada a cópia da imagem que será feita o upload
$tamanho_bytes = 5000000; //equivale a uns 5mb

if(isset($_FILES['arquivo']['name'])):
    $idContato = $_POST['idContato'];
    $nome_arquivo= $_FILES['arquivo']['name'];
    $extensao = strrchr($nome_arquivo,'.');//pega uma substring da string total(nesse caso pega a partir do caractere '.')
    $tamanho_arquivo = $_FILES['arquivo']['size'];
    $arquivo_temporario = $_FILES['arquivo']['tmp_name']; //guarda uma cópia digital do arquivo selecionado
    $nome_arquivo_novo = $idContato . $extensao;


    if ($tamanho_arquivo > $tamanho_bytes):
        die("Arquivo deve ter no máximo {$tamanho_bytes} bytes.;aviso");
    endif;

    if (!in_array($extensao, $extensoes_validas)):
        die("Extensões de arquivo de imagem inválida para o upload.;aviso");
    endif;

    if(move_uploaded_file($arquivo_temporario,"$caminho_absoluto/$nome_arquivo_novo"))://mover arquivo temporário e jogar no caminho absoluto com o nome novo
        $sql = "UPDATE tbcontatos SET nomeFotoContato = :nome_arquivo_novo WHERE idContato = :idContato";

        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':nome_arquivo_novo', $nome_arquivo_novo);
            $stmt->bindParam(':idContato', $idContato);
            $stmt->execute();
            echo "./paginas/contatos/fotos-contatos/{$nome_arquivo_novo};concluido";
        } catch (PDOException $e) {
            die("Erro ao executar a consulta: " . $e->getMessage());
        }
       // echo "./paginas/contatos/fotos-contatos/{$nome_arquivo_novo};concluido";
    else:
        die("O arquivo não pode ser copiado para o servidor.;erro");
    endif;
else:
    die("Selecione um arquivo de imagem para fazer o upload.;aviso");
endif;
?>