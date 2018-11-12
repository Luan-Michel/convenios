
   <!DOCTYPE html>
   <html lang="pt-br">
     <head>
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta name="description" content="">
       <meta name="author" content="">
       <link rel="shortcut icon" href="http://portal.uepg.br/favicon.ico" />

       <title>UEPG - JS desativado</title>

       <link href="{{ asset('/css/bootstrap.sandstone.min.css') }}" rel="stylesheet">
     </head>

     <body>

       <div class="container">

         <div align="center" class="col-md-12">
           <h1>Para o melhor funcionamento do sistema é necessário o ativamento do javascript</h1>
           <p class="lead">Para ativar o javascript selecione seu navegador e siga o tutorial</p>
         </div>
         <br><br><br><br><br><br><br><br><br><br><br><br>
         <div class="row">
            <!-- Modal Chrome -->
            <div class="col-md-2 col-md-offset-1">
               <a data-toggle="modal" href="http://wiki.uepg.br/index.php/Js_para_Google_Chrome"><img src="http://177.101.17.18/err_cafe/imagens/chrome_256x256.png" alt="Google Chrome"/></a>
            </div><!-- /.chrome -->
            <!-- Modal Firefox -->
            <div class="col-md-2">
               <a data-toggle="modal" href="http://wiki.uepg.br/index.php/Js_para_Mozilla_Firefox"><img src="http://177.101.17.18/err_cafe/imagens/firefox_256x256.png" alt="Google Chrome"/></a>
            </div><!-- /.firefox -->
            <!-- Modal Explorer -->
            <div class="col-md-2">
               <a data-toggle="modal" href="http://wiki.uepg.br/index.php/Js_para_Internet_Explorer"><img src="http://177.101.17.18/err_cafe/imagens/internet-explorer_256x256.png" alt="Google Chrome"/></a>
            </div><!-- /.explorer -->

            <!-- Modal Opera -->
            <div class="col-md-2">
               <a data-toggle="modal" href="http://wiki.uepg.br/index.php/Js_para_Opera"><img src="http://177.101.17.18/err_cafe/imagens/opera_256x256.png" alt="Opera"/></a>
            </div><!-- /.opera -->

            <!-- Modal Safari -->
            <div class="col-md-2">
               <a data-toggle="modal" href="http://wiki.uepg.br/index.php/Js_para_Safari"><img src="http://177.101.17.18/err_cafe/imagens/safari_256x256.png" alt="Safari"/></a>
            </div><!-- /.safari -->
         </div><!-- /.row -->



         <br><br><br><br><br><br>
             <div align="center" class="col-md-12">
              <h1>Suporte</h1>
			  <p class="lead">Suporte t&eacute;cnico - Centro de Processamento de Dados - (42)3220-3434</p>
              </div>


       </div><!-- /.container -->

       <!-- Bootstrap core JavaScript
       ================================================== -->
       <!-- Placed at the end of the document so the pages load faster -->
       <script src="{{ asset('/js/jquery.min.js') }}"></script>
       <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
     </body>
   </html>
