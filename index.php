<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Captura de emails</title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <header>
      <h1>apostila grátis</h1>
    </header>
    <main>
      <h2>Apostila de banco de dados</h2>
      <h3>preencha as informações necessárias para receber a apostila:</h3>
      <form class="formulario"  method="post">
        <input type="text" name="nome" id="nome" placeholder="Digite seu nome..." pattern="^(?![ ])(?!.*[ ]{2})((?:e|da|do|das|dos|de|d'|D'|la|las|el|los)\s*?|(?:[A-Z][^\s]*\s*?)(?!.*[ ]$))+$"/>
        <input type="text" name="email" id="email" placeholder="Digite seu email..." />
        <button type="submit" name="button" onclick="email()">Enviar</button>
        <?php
          error_reporting(0);
          ini_set(“display_errors”, 0 );
          if(isset($_POST['button'])){
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $destino = $email;
            $assunto = "Obrigado por se cadastrar em nosso site ".$nome.". Abaixo a apostila desejada:";
            $arquivo = "./arquivo/BancoDeDados.pdf";
            $arq = fopen('arquivo.txt','a+');
            $info=$nome."|".$destino."\n";
            fwrite($arq, $info);
            fclose($arq);
            $boundary = "XYZ-" . date("dmYis") . "-ZYX";
            $headers = "MIME-Version: 1.0\n";
            $headers.= "From: envioemailphp2@gmail.com\n";
            $headers.= "Reply-To: $destino\n";
            $headers.= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
            $headers.= "$boundary\n";
            if(file_exists($arquivo) and !empty($arquivo)){
              $fp = fopen($arquivo, "rb");
              $anexo = fread($fp,filesize($arquivo));
              $anexo = base64_encode($anexo);
              fclose($fp);
              $anexo = chunk_split($anexo);
              $mensagem = "--$boundary\n";
              $mensagem.= "Content-Transfer-Encoding: 8bits\n";
              $mensagem.= "Content-Type: text/html; charset=\"utf-8\"\n\n";
              $mensagem.= "$corpo_mensagem\n";
              $mensagem.= "--$boundary\n";
              $mensagem.= "Content-Type: application/pdf\n";
              $mensagem.= "Content-Disposition: attachment; filename=\"".basename($path,".pdf")."\"\n";
              $mensagem.= "Content-Transfer-Encoding: base64\n\n";
              $mensagem.= "$anexo\n";
              $mensagem.= "--$boundary--\r\n";
            }
            $status = mail($destino, $assunto, $mensagem, $headers);
            if ($status){
      ?>
        <p class="sucesso">E-mail enviado com sucesso!</p>
      <?php
        }
        else{
      ?>
        <p class="erro">Erro no envio do e-mail.</p>
      <?php
        }
      }
      ?>
      </form>
      <div class="livro">
        <img id="liv" src="./imagens/capa.png" alt="capa">
        <div id="bot">
          <a><img src="./imagens/esq.png" id="esq" onclick="esq()" alt="voltar"></a>
          <a><img src="./imagens/dir.png" id="dir" onclick="dire()" alt="avançar"></a>
          <script>
            var cont=0;
            var array = [
              './imagens/capa.png',
              './imagens/sumario.png',
              './imagens/sumario2.png',
              './imagens/sumario3.png'
            ];
            function dire() {
              if (cont<3) {
                cont++;
                document.getElementById("liv").src=array[cont];
              }
            }
            function esq() {
              if (cont>0) {
                cont--;
                document.getElementById("liv").src=array[cont];
              }
              else{
                document.getElementById("liv").src=array[0];
              }
            }
          </script>
        </div>
      </div>
    </main>
    <footer>
      <p>Site de: Nicolas Jimenez Santoni</p>
    </footer>
  </body>
</html>
