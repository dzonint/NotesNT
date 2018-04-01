<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
     <?php if(!empty($_SESSION['logged_in'])) { ?>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php } ?>
      <a class="navbar-brand" href="#">NotesNT</a>
    </div>

    <?php if(!empty($_SESSION['logged_in'])) { ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Hello, <?= $_SESSION["username"] ?></a></li>
        <li class="dropdown">
          <a href="#" onclick="Logout()" role="button"><span class="glyphicon glyphicon-log-out"></span> Log out</a>
        </li>
      </ul>  
    </div><!-- /.navbar-collapse -->
    <?php } ?>
  </div><!-- /.container-fluid -->
</nav>