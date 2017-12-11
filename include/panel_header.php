<header id="main-header">
    <nav id="header-nav" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a href="index.php" class="pull-left visible-md visible-lg">
                    <div id="logo-img"></div>
                </a>
                <div class="navbar-brand">
                    <a href="index.php"><h1>Panel de administración</h1></a>
                   <!-- <p>
                        <span>Sitio web para docentes</span>
                    </p>-->
                </div>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
            </div>

            <div id="collapsable-nav" class="collapse navbar-collapse">

                <ul id="nav-list" class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> - <?= $_SESSION['admin_name']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="btn btn-block btn-default" href="#"><i class="fa fa-fw fa-user"></i> Perfil</button>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <button class="btn btn-block btn-default"  href="#"><i class="fa fa-fw fa-gear"></i> Opciones</button>
                            </li>
                        </ul>
                    </li>


                </ul><!-- #nav-list -->

            </div><!-- .collapse .navbar-collapse -->
        </div><!-- .container -->



    </nav><!-- #header-nav -->
</header>