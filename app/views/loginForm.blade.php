<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      Magman - Fumetti - Login
    </title>
    <!-- BOOTSTRAP STYLES-->
    <link href="{{ URL::asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{ URL::asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="{{ URL::asset('assets/js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />
    <!-- LOGIN STYLES-->
    <link href="{{ URL::asset('assets/css/login.css') }}" rel="stylesheet" />
  </head>

  <body>
    <div class="container">
      <div class="row login_box">

        <div class="col-md-12 col-xs-12 login_control">
            <div class="control centerAlign min-height-error">
              <?php
                $message = Session::get('message');
                if (!empty($message)){
                  echo "<div class=\"transparent-background-error\">".$message."</div>";
                }
              ?>
            </div>
          <?php echo Form::open(array('url' => '/login', 'class' => 'box login')); ?>
            <div class="control benvenuto">
              <span>Benvenuto!</span>
            </div>
            <div class="control">
              <input type="text" class="form-control transparent-input input-lg" name="username" placeholder="Indirizzo Email" required autofocus/>
            </div>

            <div class="control">
              <input type="password" name="password" class="form-control transparent-input input-lg" placeholder="Password" required/>
            </div>
            <div class="control squaredThree">
              <input type="checkbox" value="None" id="squaredThree" name="persist" />
              <label for="squaredThree"><span class="checkbox-label">Ricordami</span></label>
            </div>
            <div align="center">
              <button class="btn btn-danger btn-login">ACCEDI</button>
            </div>


          </form>
        </div>

      </div>
    </div>

  </body>
</html>