<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
<!--   <link rel="icon" href="../../favicon.ico">-->

        <title>Bienvenido a PABE Comercial</title>
        <!--PACE-->
        <link href="<?php echo base_url("assets/css/paceTheme.css");?>" rel="stylesheet">
        <script src="<?php echo base_url('assets/js/pace.min.js');?>"></script>
        <!-- Bootstrap core CSS -->
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400|Montserrat' rel='stylesheet' type='text/css'>
        <link href="<?php echo base_url("assets/css/bootstrap.min.css");?>" rel="stylesheet">
        <link href="<?php echo base_url("assets/slick/slick.css");?>" rel="stylesheet">
        <link href="<?php echo base_url("assets/slick/slick-theme.css");?>" rel="stylesheet">
        <link href="<?php echo base_url("assets/css/goFull.css");?>" rel="stylesheet">
        <link href="<?php echo base_url("assets/css/custom.css");?>" rel="stylesheet">
        <script>
            var baseURL = "<?php echo base_url();?>index.php" ;
            //alert(baseURL)
        </script>
    </head>
    <body>
        <div id="content">
            <!--NAVBAR
            ========================================-->
            <div id="navLimit"></div>
            <nav class="navbar navbar-default navbar-fixed-top" id="nav"> <!--BASE NAV-->
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar" class="navbar-centered navbar-collapse collapse">
                        <ul class="nav navbar-nav ">
                            <li class='active'><a href="./">INICIO</a></li>
                            <li><a href="../navbar-static-top/">SOBRE NOSOTROS</a></li>
                            <li><a href="../navbar-fixed-top/">LA TRIPULACION</a></li>
                            <li><a href="../navbar-fixed-top/">PRODUCTOS</a></li>
                            <li><a href="../navbar-fixed-top/">CONTACTO</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
        <!-- Content is everything. The idea is to wait for the site to FULLY load..
        then show it to people o/ This will be achieved using PACE.JS
        =============================================================-->
            <div class="goFull">
                <img class="goFull-bg" src="<?php echo base_url("assets/img/Image.jpg")?>"/>
                <img class='goFull-logo' src="<?php echo base_url("assets/img/logo.png")?>"/>
                <span class='goFull-caption'>Importaciones, Representaciones y Distribuidores en General</span>
                <img class = 'goFull-button' src="<?php echo base_url("assets/img/arrowDown.png");?>"/>
            </div>


            <!--MAIN CONTENT CONTAINER
            =================================
            -->

            <div class="container">
                <div class="row" id="sobreNosotros"> <!-- SECTION A -> "SOBRE NOSOTROS" -->
                    <img class="centered-bg" id='sobreNosotros-bg' src="<?php echo base_url("assets/img/Image2.jpg");?>"/>
                    <div id="sobreNosotros-2">
                        <div class="col-xs-12 col-md-4 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">MISION</div>
                                <div class="panel-body">
                                    <p>
                                        Manetener siempre los requisitos del cliente
                                        como nuestra razón de ser bajo la relación
                                        calidad - precio - servicio mejor del mercado,
                                        dando el mejor bienestar a nuestros clientes
                                        y relacionados, ya sea en nuestro rol de importadores,
                                        distribuidores o representantes, siempre sustentados
                                        sobre los principios éticos y morales.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">VISION</div>
                                <div class="panel-body">
                                    <p>
                                        Ser una empresa de productos innovadores y exclusivos,
                                        que nos permitan anticiparnos con acierto a las tendencias
                                        del mercado,; logrando asi incidencias importantes
                                        a nivel nacional, la satisfaccion de nuestros clientes,
                                        el desarrollo de nuestros recursos humanos y el de nuestra nacion.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-md-4 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">VALORES</div>
                            <div class="panel-body">
                                <p>
                                    <strong>Trabajo:</strong> Unico medio para conseguir
                                    logros y alcanzar nuestras metas y propositos.
                                    <br/>
                                    <span class="bold">Integridad:</span> Sentido de etica,
                                    honestidad y responsabilidad forman un lenguaje comun que
                                    nos guia en el accionar cotidiano.
                                    <br/>
                                    <span class="bold">Compromiso:</span> Sentido de cooperacion,
                                    solidaridad y dedicacion.
                                    <br/>
                                    <span class="bold">Innovacion:</span> Creatividad, apertura,
                                    iniciativa, sentido de urgencia y entusiasmo.
                                    <br/>
                                    <span class="bold">Pasión:</span> Deseo,furor y entrega por lo
                                    que hacemos.
                                    <br/>
                                    <span class="bold">Excelencia:</span> Superación, calidad,
                                    liderazco y perfección.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="Tripulacion">
                    <div class="col-xs-12 col-sm-6 superPad">
                        <div>
                            <h1 class="text-center pabeFont">La Tripulación</h1>
                            <br/>
                            <p class="text-justify">
                                <span class="bold pabeFont">PABE COMERCIAL, S.R.L.</span> Es una Empresa Familiar dedicada a la comercialización de productos de lícito comercio,
                                comprometida con la lealtad a sus trabajadores, la satisfacción de sus clientes y proveedores, el cuidado al medio ambiente,
                                el apoyo a la comunidad, y el cumplimiento con las regulaciones e imposiciones del Estado, siempre con su gran objetivo de no
                                solo competir sino de crecer.
                            </p>
                        </div>
                    </div>
                    <div class='col-xs-12 col-sm-6 noPad'>
                        <img src="<?php echo base_url("assets/img/Tripulacion.png");?>" class="centered-bg"/>
                    </div>

                </div>
                <div class="row noPad" id='productos-imgs'>
                    <div><img class='centered-bg-fit' src="<?php echo base_url("assets/img/shoes1.jpg")?>"/></div>
                    <div><img class='centered-bg-fit' src="<?php echo base_url("assets/img/shoes2.jpg")?>"/></div>
                    <div><img class='centered-bg-fit' src="<?php echo base_url("assets/img/shoes3.jpg")?>"/></div>
                </div>
                <div class="row" id="productos" >
                    <div class="col-xs-12 col-sm-offset-1 col-sm-10">
                        <h1 class="text-center pabeFont">Productos y Servicios</h1>
                        <br/>
                        <p class='text-justify'>
                            Nuestra razón comercial se fundamenta en la representación en general de calzados, útiles escolares de fabricacion nacional e importados y otros productos afines con nuestro negocio, entre los cuales podemos destacar los siguientes:
                            <br/>
                            <ul>
                                <li>Sandalias</li>
                                <li> Botas de Gomas </li>
                                <li>calipsos </li>
                                <li>Chancletas </li>
                                <li>Fundas plásticas lisas, ralladas, de basura y genéricas </li>
                                <li>Tenis Nacionales e Importados </li>
                                <li>Cuadernos Cocidos y espirales </li>
                                <li>Rollos plásticos de todas las numeraciones y calibres </li>
                                <li>Margarinas de mesa y de repostería </li>
                                <li>Cátedras nacionales e importada </li>
                                <li>Zapatos de goma nacionales e importados </li>
                                <li>Perchas Plásticas </li>
                                <li>Alpargatas nacionales e importadas </li>
                                <li>entre otros. </li>
                            </ul>
                        </p>
                    </div>
                </div>
                <div class='row' id="contacto">
                    <div class="col-md-5 col-sm-7 col-xs-12 noPad" >
                        <div id="forma-contacto" class="center-block">
                            <div id="contacto-general">
                                <h1 class="pabeFont text-center">Contactenos</h1>
                                <br/>
                                <div class="col-xs-12">
                                    <p><strong>Direccion </strong> Alguna dir</p>
                                </div>
                                <br/>
                                <div class="col-xs-12">
                                    <p><strong>Telefonos </strong> 809-999-999</p>
                                </div>
                                <br/>
                                <div class="col-xs-12">
                                    <p><strong>Correo Electronico </strong> serviciocliente@pabe.com.do</p>
                                </div>
                                <hr>
                            </div>
                            <div id='contacto-mensaje'>
                                <h1 class="pabeFont text-center">Envienos un Mensaje</h1>
                                <form>
                                    <div class='col-xs-12 noPad'>
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input class="form-control" placeholder="Nombre" name="name"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Correo</label>
                                            <input type="email" class="form-control" placeholder="Correo Electronico" name="email"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Mensaje</label>
                                            <textarea class="form-control" rows="10" name="msg"></textarea>
                                        </div>
                                        <div class='col-xs-5 noPad'>
                                            <button class="btn btn-default btn-block">ANEXAR IMAGEN
                                                <input type="file" name="uploadedFile"/></button>
                                        </div>
                                        <div class='col-xs-6 col-xs-offset-1 noPad'>
                                            <button class="btn btn-default btn-block" id="sendMail">ENVIAR</button>
                                        </div>
                                </form>
                                    <br/>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-7 col-sm-5 col-xs-12 noPad'>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m21!1m12!1m3!1d30097.534903063577!2d-70.67270371391253!3d19.447292989830718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m6!3e6!4m0!4m3!3m2!1d19.455806!2d-70.655956!5e0!3m2!1sen!2sdo!4v1432698346233"></iframe>
                    </div>
                </div>
            </div>

            <div class="container-fluid" id="copy">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-center">&copy Luis Rojas</p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url('assets/js/jquery-2.1.4.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/slick/slick.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.transit.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.ba-resize.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/goFull.js');?>"></script>
        <script src="<?php echo base_url('assets/js/centerImage.js');?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js');?>"></script>
    </body>
</html>
