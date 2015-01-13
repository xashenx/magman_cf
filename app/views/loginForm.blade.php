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
        <div class="col-md-12 col-xs-12" align="center">
          <br/>
          <div class="outter"><img src="http://media.comicbook.com/wp-content/uploads/2013/03/GetMAD.jpg" class="image-circle"/></div>
          <h1>Benvenuto Ospite</h1>
          <span></span>
          <br/>
        </div>

        <div class="col-md-12 col-xs-12 login_control">
          <?php echo Form::open(array('url' => '/login', 'class' => 'box login')); ?>
            <div class="control">
              <input type="text" class="form-control" name="username" placeholder="Email address" required autofocus/>
            </div>

            <div class="control">
              <input type="password" name="password" class="form-control" placeholder="Password" required/>
            </div>
            <div class="control">
              <div class="label">
                <input type="checkbox" name="persist" tabindex="3">
                <span>Ricordami</span>
              </div>
            </div>
            <div align="center">
              <button class="btn btn-orange">LOGIN</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>