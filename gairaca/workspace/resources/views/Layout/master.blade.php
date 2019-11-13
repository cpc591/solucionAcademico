<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />       
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="application/vnd.ms-excel" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- La información debe sustituirse por la que corresponda a la página o portal. Solo debe ser modificado si es necesario. -->
	<meta name="description" content="Gestión de solicitudes para la dependencia de consejo académico de la Universidad del Magdalena.">
    <meta name="keywords" content="Unimagdalena, Universidad del Magdalena, Magdalena, IES, alta calidad, Santa Marta,Consejo académico, solicitudes" />
    <meta name="author" content="SoftSimulation s.a.s" />
    <meta name="copyright" content="Universidad del Magdalena, SoftSimulation" />
    <meta property="og:title" content="Sistema para la gestión de solicitudes" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.unimagdalena.edu.co" />
    <meta property="og:image" content="https://cdn.unimagdalena.edu.co/images/escudo/bg_light/128.png" />
    <meta property="og:description" content="Institución de Educación Superior acreditada por alta calidad ubicada en la ciudad de Santa Marta, Magdalena"/>
    <title>GAIRACA PLUS</title>
	<meta name='mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='application-name' content='Universidad del Magdalena'>
    <meta name='apple-mobile-web-app-status-bar-style' content='blue'>
    <meta name='apple-mobile-web-app-title' content='Unimagdalena'>
    <link rel='icon' sizes='192x192' href='https://cdn.unimagdalena.edu.co/images/escudo/bg_light/192.png'>
    <link rel='apple-touch-icon' href='https://cdn.unimagdalena.edu.co/images/escudo/bg_light/192.png'>
    <meta name='msapplication-TileImage' content='https://cdn.unimagdalena.edu.co/images/escudo/bg_light/144.png'>
    <meta name='msapplication-TileColor' content='#004A87'>
    <meta name="theme-color" content="#004A87" />
    <link rel="shortcut icon" href="https://cdn.unimagdalena.edu.co/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="https://cdn.unimagdalena.edu.co/images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.unimagdalena.edu.co/code/css/normalize.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.unimagdalena.edu.co/code/css/public.min.css" type="text/css" />
    <link href="https://cdn.unimagdalena.edu.co/code/css/public_768.min.css" rel="stylesheet" media="(min-width: 768px)">
    <link href="https://cdn.unimagdalena.edu.co/code/css/public_992.min.css" rel="stylesheet" media="(min-width: 992px)">
    <link href="https://cdn.unimagdalena.edu.co/code/css/public_1200.min.css" rel="stylesheet" media="(min-width: 1200px)">
    <link href="https://cdn.unimagdalena.edu.co/code/css/public_1600.min.css" rel="stylesheet" media="(min-width: 1600px)">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:400,700" rel="stylesheet">
    
    <link href="{{asset('/css/add.css')}}" rel="stylesheet"/>
    <link href="{{asset('/css/mycss.css')}}" rel="stylesheet"/>
    <link href="{{asset('/css/sweetalert.css')}}" rel="stylesheet"/>
    <link href="{{asset('/css/select.min.css')}}" rel="stylesheet"/>
	<link href="{{asset('/css/sweetalert.min.css')}}" rel="stylesheet"/>
	<link href="{{asset('/css/lf-ng-md-file-input.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
	<link href="{{asset('/css/load.css')}}" rel="stylesheet"/>
	<link href="{{asset('/css/ADM-dateTimePicker.css')}}" rel="stylesheet"/>
	<link href="{{asset('/multiple_calendar/multipleDatePicker.css')}}" rel="stylesheet"/>
	   
	
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ng-table/0.8.3/ng-table.min.css" />
    <style type="text/css">
        .navbar-default .navbar-brand, .navbar-default .navbar-nav>li>a,.navbar-default .navbar-brand:hover, .navbar-default .navbar-nav>li>a:hover{
            color:white;
        }
        
        .navbar-default{
            background-color:#004a87;
            border-color:#004a87;
            border-radius:0;
        }
    </style>
	@yield('estilo')
    
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


<body id="wrap">
        
        <!-- Versión 1.6 28/08/2018 Editado por: Jorge Luis Pineda Montagut / CIDS -->
        @if(Auth::user() != null)
            @include('Layout.headerAdmin')
        @else
		    @include('Layout.headerPublic')
	    @endif
        
    	<div class="hidden" id="load2" style="position: fixed;top:0px; width: 100%; height: 100%; background: rgba(15, 14, 14, 0.29); z-index: 1160;" >
    		
               <div class="sk-fading-circle" style=" top: 30%; position: relative; margin-bottom:20px; width:100px !important;height:100px !important;" >
                          <div class="sk-circle1 sk-circle"></div>
                          <div class="sk-circle2 sk-circle"></div>
                          <div class="sk-circle3 sk-circle"></div>
                          <div class="sk-circle4 sk-circle"></div>
                          <div class="sk-circle5 sk-circle"></div>
                          <div class="sk-circle6 sk-circle"></div>
                          <div class="sk-circle7 sk-circle"></div>
                          <div class="sk-circle8 sk-circle"></div>
                          <div class="sk-circle9 sk-circle"></div>
                          <div class="sk-circle10 sk-circle"></div>
                          <div class="sk-circle11 sk-circle"></div>
                          <div class="sk-circle12 sk-circle"></div>
                </div>    
        </div>
        
        <div class="loadingContent" aria-hidden="true">
		    <div class="loader"></div>
		    <span>Cargando. Por favor espere...</span>
		</div>
        
        <div id="contenido" @yield('app') @yield('controller')>
        	@yield('contenido')
        </div>
        
        <!-- Versión 1.6 28/08/2018 Editado por: Jorge Luis Pineda Montagut / CIDS -->
<footer class="footerUM">
    <div class="container">
        <div class="logosGeneral">
            <img id="selloUnimagdalena" src="https://cdn.unimagdalena.edu.co/images/escudo/bg_dark/default.png" alt="escudo de la Universidad del Magdalena" />
            <img id="yearsUnimagdalena" src="https://cdn.unimagdalena.edu.co/images/years_96.png" alt="escudo de los años que tiene la Universidad del Magdalena" />
            <img id="selloAcreditacion" src="https://cdn.unimagdalena.edu.co/images/acreditacion/default-border.png" alt="Marca de acreditación de alta calidad" />
            <img id="selloColombia" src="https://cdn.unimagdalena.edu.co/images/escudo_colombia.png" alt="Escudo de colombia" />
            <img id="sellosCalidad" class="img-responsive" src="https://cdn.unimagdalena.edu.co/images/calidad/bg-dark/default.png" alt="Sellos de calidad" />
        </div>
    </div>
    <div class="container">
        <div id="enlacesInteres">
            <div class="row">
                <div class="col-xs-12 col-md-3 col-sm-6 footerColum">
                    <h3 class="tituloColum">ENLACES DE INTERÉS</h3>
                    <ul>
                        <li>
                            <a href="http://estrategia.gobiernoenlinea.gov.co" target="_blank" rel="noopener noreferrer">Gobierno en línea</a>
                        </li>
                        <li>
                            <a href="http://www.mineducacion.gov.co/1759/w3-channel.html" target="_blank" rel="noopener noreferrer">Ministerio de Educación</a>
                        </li>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/Publico/Mecanismos">Mecanismos de control y vigilancia</a>
                        </li>
                        <li>
                            <a href="http://aprende.colombiaaprende.edu.co/estudiantes2016" target="_blank" rel="noopener noreferrer">Colombia Aprende</a>
                        </li>
                        <li>
                            <a href="https://portal.icetex.gov.co/Portal/" target="_blank" rel="noopener noreferrer">Icetex</a>
                        </li>
                        <li>
                            <a href="http://www.colciencias.gov.co" target="_blank" rel="noopener noreferrer">Colciencias</a>
                        </li>
                        <li>
                            <a href="http://www.renata.edu.co/index.php" target="_blank" rel="noopener noreferrer">Renata</a>
                        </li>
                        <li>
                            <a href="http://www.universia.net.co" target="_blank" rel="noopener noreferrer">Universia</a>
                        </li>
                        <li>
                            <a href="https://www.encuestafacil.com/universia/UnivGenerica.aspx" target="_blank" rel="noopener noreferrer">universia.encuestafacil </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-3 col-sm-6 footerColum">
                    <h3 class="tituloColum">ATENCIÓN AL CIUDADANO</h3>
                    <ul>
                        <li>
                            <a role="menuitem" href="/Transparencia">Transparencia y acceso a la información pública</a>
                        </li>
                        <li>
                            <a role="menuitem" href="https://pse.unimagdalena.edu.co/">Pagos en línea</a>
                        </li>
                        <li>
                            <a role="menuitem" href="/Publico/PortalNinos">Portal para niños</a>
                        </li>
                        <li>
                            <a role="menuitem" href="/Publico/Contacto">Ubicación y medios de contacto</a>
                        </li>
                        <li>
                            <a role="menuitem" href="/Publico/PreguntasFrecuentes">Preguntas frecuentes</a>
                        </li>
                        <li>
                            <a role="menuitem" href="http://cogui.unimagdalena.edu.co/index.php?option=com_samco&view=pqr&Itemid=867" target="_blank" rel="noopener noreferrer">Peticiones, quejas, reclamos y sugerencias</a>
                        </li>
                        <li>
                            <a role="menuitem" href="/Publico/ProteccionDatosPersonales">Protección de datos personales</a>
                        </li>
                        <li>
                            <a role="menuitem" href="/Content/DocumentosSubItems/subitem-20171129151642_181.pdf">Carta de trato digno al ciudadano</a>
                        </li>
                
                        <li>
                            <a role="menuitem" href="/Publico/Glosario">Glosario</a>
                        </li>
                    </ul>

                </div>
                <div class="col-xs-12 col-md-3 col-sm-6 footerColum">
                    <h3 class="tituloColum">INFORMACIÓN GENERAL</h3>
                    <ul>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/Content/Public/Docs/reglamento_estudiantil.pdf" target="_blank" rel="noopener noreferrer">Reglamento estudiantil</a>
                        </li>
                        <li>
                            <a href="https://admisiones.unimagdalena.edu.co/eventos/index.jsp" target="_blank" rel="noopener noreferrer">Calendario académico</a>
                        </li>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/Publico/ProteccionDatosPersonales">Protección de datos personales</a>
                        </li>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/Publico/InformesGestion">Informes de gestión</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-3 col-sm-6 footerColum">
                    <h3 class="tituloColum">SERVICIOS</h3>
                    <ul>
                        <li>
                            <a href="http://bienestar.unimagdalena.edu.co" target="_blank" rel="noopener noreferrer">Bienestar universitario</a>
                        </li>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/UnidadesOrganizativas/Dependencia/9">Recursos educativos</a>
                        </li>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/UnidadesOrganizativas/Dependencia/6">Biblioteca Germán Bula Meyer</a>
                        </li>
                        <li>
                            <a href="http://consultorio.unimagdalena.edu.co" target="_blank" rel="noopener noreferrer">Consultorio jurídico y centro de conciliación</a>
                        </li>
                        <li>
                            <a href="https://www.unimagdalena.edu.co/UnidadesOrganizativas/Dependencia/4">Cartera</a>
                        </li>
                        <li>
                            <a href="https://pse.unimagdalena.edu.co">Pagos en línea</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-bottom">
        <div class="container text-center">

            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="tituloColum">INFORMACIÓN DE CONTACTO</h3>
                    <ul>
                        <li>Línea Gratuita Nacional: 01 8000 516060. PBX: (57 - 5) 4217940</li>
                        <li><a href="https://goo.gl/maps/tad2rQS5Jqj" target="_blank" rel="noopener noreferrer">Dirección: Carrera 32 No 22 – 08 Santa Marta D.T.C.H. - Colombia. Código Postal No. 470004</a></li>
                        <li><a href="mailto:contacto@unimagdalena.edu.co" target="_blank" rel="noopener noreferrer">Correo electrónico: ciudadano@unimagdalena.edu.co</a></li>
                    </ul>

                </div>
                <div class="col-xs-12 text-center">
                    <p class="infoContacto">La Universidad del Magdalena está sujeta a inspección y vigilancia por el Ministerio de Educación Nacional.</p>
                    <p>Desarrollado por el Centro de Investigación y Desarrollo de Software CIDS - Unimagdalena © 2018<p>
                        <a href="#goto-content" id="goto-up" class="sr-only">Regresar al inicio</a>
                </div>
            </div>
        </div>
    </div>

</footer>
	
	<script src="/js/plugins/jquery.js"></script>
	<script src="/bootstrap/js/bootstrap.js"></script>
    <script src="/js/plugins/angular.min.js"></script>
    @yield('javascript')

	
	<style type="text/css">
		body{height:auto!important;
			min-height: auto;
		}
	</style>
		
	<script>
	        $(document).ready(function () {
	
	            var h_body = document.body.clientHeight;
	            var h = window.innerHeight;
	            if (h_body < h) {
	                $('#contenido').css("minHeight", (h - 300) + "px");
	            }
	            $(window).resize(function () {
	                var h_body = document.getElementById('contenido').clientHeight;
	                var h = window.innerHeight;
	                if (h_body < h) {
	                    $('#contenido').css("minHeight", (h - 300) + "px");
	                }
	            })
	        });
	    </script>
	    
    <script src="https://cdn.unimagdalena.edu.co/code/js/main.min.js" async></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function (event) {
            
            $('.loadingContent').delay(250).fadeOut("fast");
        });
        
    </script>
    <script defer>
        function searchForm(event) {
            event.preventDefault(); // disable normal form submit behavior
            var win = window.open("https://www.google.com.co/search?q=site:http://www.unimagdalena.edu.co+" + document.globalSearchForm.search.value, '_blank');
            win.focus();
            
            return false; // prevent further bubbling of event
        }
    </script>
	    
</body>

</html>