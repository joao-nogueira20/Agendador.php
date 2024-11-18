/*
jQuery $(document).ready():

Quando é executado? Assim que o DOM está completamente carregado e parseado, mas antes de que todos os recursos, como imagens e estilos, sejam totalmente carregados.
Uso comum: Para quando você precisa manipular elementos da página o mais rápido possível após o DOM estar disponível, sem ter que esperar que tudo na página (imagens, scripts, etc.) esteja totalmente carregado.
JavaScript window.addEventListener('load'):

Quando é executado? Depois que toda a página foi completamente carregada, incluindo todos os recursos externos como imagens, folhas de estilo, e outros scripts.
Uso comum: Ideal quando você quer garantir que todos os recursos da página foram carregados (imagens, vídeos, etc.) antes de executar alguma ação.
*/
$(document).ready(function(){
    var mensagem = $("#mensagem");
    var preloader= $("#preloader");
    var barra = $("#barra");
    $("#editar-foto").hide();
    mensagem.hide();
    preloader.hide();
    
    $("#btn-editar-foto").on('click',function(){
        $("#editar-foto").toggle();
    });

    $("#btn-enviar-foto").on('click',function(event){
        event.preventDefault();
        $("#form-upload-foto").ajaxForm({
            url:'./paginas/contatos/upload/executa-upload.php',
            uploadProgress:function(event,position,total,precentComplete){
                preloader.show();
                barra.width(precentComplete + '%');
                barra.html(precentComplete + '%');
            },
            success:function(data){
                var msg = data.substring(0,data.indexOf(';'));
                var tipoMsg = data.substring(data.indexOf(';')+1);

                if(tipoMsg == "concluido"){
                    var caminho_foto = msg;
                    msg= "Upload da foto realizado com sucesso!";
                    $("#foto-contato").attr("src",caminho_foto + "?timestamp="+ new Date().getTime())// "?timestamp="+ new Date().getTime() é usado para renovar o cache se não ele não atualiza fotos que já entraram no cache
                    mensagem.show().attr("class","mb-3 alert alert-success").html(msg);
                } else if(tipoMsg == "aviso"){
                    mensagem.show().attr("class","mb-3 alert alert-warning").html(msg);
                    preloader.hide();
                } else{
                    mensagem.show().attr("class","mb-3 alert alert-danger").html(msg);
                    preloader.hide();
                }
            },
            error:function(data){
                console.log(data);
            }
        }).submit();
    });
});