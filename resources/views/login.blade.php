<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>

                  <br><br><br><br>
                  <div class="col-md-12">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                              <form action="authenticate" method='POST' id='loginForm' class="form-signin" name="loginForm" autocomplete='off'>
                                <h2 class="form-signin-heading">Login</h2>
                                <label for='login'>Usuário:</label>
                                <input type='text' class="form-control input-lg" name='login' id="login" autofocus/>
                                <label for='password'>Senha:</label>
                                <input type='password' class="form-control input-lg" name='password' id='password'/>
                                <br>
                                <input type='submit' id="submit" class="btn btn-primary btn-lg btn-block" value='Entrar'/>
                              </form>
                        </div>
                        <div class="col-md-4">
                        </div>
                  </div>
                  <br><br><br><br><br><br><br><br><br><br><br><br><br>
                  <script language= "JavaScript">
                    location.href="/principal"
                  </script>
            </div>
        </div>
    </body>
    <script language= "JavaScript">
      location.href="/principal"
    </script>
</html>
