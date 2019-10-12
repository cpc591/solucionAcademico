<header role="banner">
    <div class="toolbar">
        <a id="goto-content" href="#content-main" class="sr-only">Ir al contenido</a>
        <a href="https://www.facebook.com/UniversidadDelMagdalena/" class="btn btn-xs btn-link" title="Facebook" target="_blank" rel="noopener noreferrer"><span aria-hidden="true" class="ion-social-facebook"></span><span class="sr-only">Facebook</span></a>
        <a href="https://twitter.com/unimagdalena" class="btn btn-xs btn-link" title="Twitter" target="_blank" rel="noopener noreferrer"><span aria-hidden="true" class="ion-social-twitter"></span><span class="sr-only">Twitter</span></a>
        <a href="https://www.instagram.com/unimagdalena/" class="btn btn-xs btn-link" title="Instagram" target="_blank" rel="noopener noreferrer"><span aria-hidden="true" class="ion-social-instagram-outline"></span><span class="sr-only">Instagram</span></a>
        <a href="https://www.youtube.com/user/unimagdalenatv" class="btn btn-xs btn-link" title="Youtube" target="_blank" rel="noopener noreferrer"><span aria-hidden="true" class="ion-social-youtube"></span><span class="sr-only">Youtube</span></a>
        <!-- Solo habilitar si el portal es capaz de segmentar o filtar el contenido publicado por estamentos. -->
        <!--<div class="estamento-lineal visible-md visible-lg">
            <a href="/?estamento=5" id="enlaceEstamento-5" title="Visualizar la página web como aspirantes">Aspirantes</a>
            <a href="/?estamento=1" id="enlaceEstamento-1" title="Visualizar la página web como estudiante">Estudiantes</a>
            <a href="/?estamento=2" id="enlaceEstamento-2" title="Visualizar la página web como docente">Docentes</a>
            <a href="/?estamento=3" id="enlaceEstamento-3" title="Visualizar la página web como egresado">Egresados</a>
            <a href="/?estamento=4" id="enlaceEstamento-4" title="Visualizar la página web como funcionario">Funcionarios</a>
        </div>
        <form action="/" method="get" class="visible-xs visible-sm">
            <label class="sr-only" for="estamentoUsuario">Seleccionar estamento</label>
            <select onchange = "this.form.submit();" id="estamentoUsuario" name="estamento">
                <option value="5">Aspirantes</option>
                <option value="1">Estudiantes</option>
                <option value="2">Docentes</option>
                <option value="3">Egresados</option>
                <option value="4">Funcionarios</option>
            </select>
        </form> -->
		<div class="btn-group">
            <button type="button" id="menuOpcionesCiudadano" class="btn btn-xs btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ciudadano <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
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
        <a href="https://www.unimagdalena.edu.co/Publico/EnlacesAcceso" class="btn btn-xs btn-link">Mapa de sitio</a>
        <!-- Solo habilitar si el sistema es multi idioma. Reemplazar el action del formulario -->
        <!-- <form action="/Home/ChangeIdioma" method="get" title="Selección de idioma">

            <label class="sr-only" for="langPortal">Seleccionar idioma</label>
			<select id="langPortal" name="idioma" onchange="this.form.submit();">
				<option selected="selected" value="es">Español</option>
				<option value="en">Inglés</option>
			</select>

        </form> -->
    	<!-- Solo habilitar si el sistema posee un login o acceso a módulos administrables -->
        
        <!-- <a href="/Home/DashBoard" class="btn btn-xs btn-link hidden-xs" title="Ir a mi perfil"><span class="glyphicon glyphicon-cog"></span><span class="sr-only">Ir al perfil</span></a> -->
    	
    	<!-- Solo habilitar si el sistema posee acceso a módulos administrables (una vez logueado). Solo mostrar cuando el usuario este logueado. Usar condición de lenguaje servidor -->
        <!-- <a href="/Account/Login" class="btn btn-xs btn-link hidden-xs" title="Iniciar sesión"><span class="glyphicon glyphicon-user"></span><span class="sr-only">Iniciar sesión</span></a> -->
        
    </div>
    <div class="nav-bar">
        <div class="brand">
            <a href="https://www.unimagdalena.edu.co">
                <img src="https://cdn.unimagdalena.edu.co/images/escudo/bg_dark/default.png" alt="Escudo de la Universidad del Magdalena" />
                <h1>Universidad del <span>Magdalena</span></h1>
            </a>
        </div>
        <div id="navbar-mobile" class="text-center">
            <button type="button" class="btn btn-block btn-primary" title="Menu de navegación"><span aria-hidden="true" class="ion-navicon-round"></span><span class="sr-only">Menú de navegación</span></button>
        </div>
        <nav role="navigation" id="nav-main">
            <ul role="menubar">
                <li>
                    <a role="menuitem" href="https://www.unimagdalena.edu.co">Inicio</a>
                </li>
                <li>
                    <a role="menuitem" href="#miUniversidad" aria-haspopup="true" aria-expanded="false">Mi Universidad</a>
                    <ul role="menu" id="miUniversidad" aria-label="Mi Universidad">
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/Historia">Historia</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/MisionVision">Misión y visión</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/SimbolosInstitucionales">Símbolos institucionales</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/PEI">Proyecto Educativo Institucional</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/EstructuraOrganizacional">Estructura organizacional</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/UnidadesAdministrativas">Unidades administrativas</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Facultades">Facultades</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/DirectorioTelefonico">Directorio telefónico</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/PlanesGobierno">Planes de gobierno</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/PlanesDesarrollo">Planes de desarrollo</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/RendicionCuentas">Rendición de cuentas</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/Publico/InformesGestion">Informes de gestión</a>
                        </li>
                        <li role="none">
                            <a role="menuitem" href="https://www.unimagdalena.edu.co/UnidadesOrganizativas/Direccion/8">Secretaría general</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a role="menuitem" href="#ofertaAcademica" aria-haspopup="true" aria-expanded="false">Oferta académica</a>
                    <ul role="menu" id="ofertaAcademica" aria-label="Oferta académica">
                        <li>
                            <a role="menuitem" href="#ofertaPregrado" class="menu">Pregrado</a>
                            <ul role="menu" id="ofertaPregrado" aria-label="Pregrado">
                                
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Pregrado?nivel=1">Profesional</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Pregrado?nivel=3">Tecnológico</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Pregrado?nivel=6">Técnico profesional</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a role="menuitem" aria-haspopup="true" aria-expanded="false" href="#ofertaPostgrado" class="menu">Postgrado</a>
                            <ul role="menu" id="ofertaPostgrado" aria-label="Postgrado">
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Postgrado?nivel=2">Especializaciones</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Postgrado?nivel=4">Maestrías</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/Postgrado?nivel=5">Doctorados</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a role="menuitem" aria-haspopup="true" aria-expanded="false" href="#ofertaFormacionParaElTrabajo" class="menu">Formación para el trabajo y desarrollo humano</a>
                            <ul role="menu" id="ofertaFormacionParaElTrabajo" aria-label="Formación para el trabajo y desarrollo humano">
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/FormacionParaElTrabajo?nivel=1004">Técnico laboral</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/OfertaAcademica/FormacionParaElTrabajo?nivel=1005">Técnico laboral por competencias</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a role="menuitem" aria-haspopup="true" aria-expanded="false" href="#formacionContinua" class="menu">Formación continua</a>
                            <ul role="menu" id="formacionContinua" aria-label="Formación continua">
                                <li role="none">
                                    <a role="menuitem" href="http://estudiosgenerales.unimagdalena.edu.co/home/informacion" target="_blank" rel="noopener noreferrer">Idiomas</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="https://www.unimagdalena.edu.co/Diplomados/Listado">Diplomados</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="http://estudiosgenerales.unimagdalena.edu.co/home/programanivelatorio" target="_blank" rel="noopener noreferrer">Nivelatorio</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li>
                    <a role="menuitem" href="http://investigacion.unimagdalena.edu.co/" target="_blank" rel="noopener noreferrer">Investigación</a>
                </li>
                <li>
                    <a role="menuitem" href="http://vicextension.unimagdalena.edu.co/" target="_blank" rel="noopener noreferrer">Extensión</a>
                </li>
                <li>
                    <a role="menuitem" href="https://www.unimagdalena.edu.co/Internacionalizacion">Internacionalización</a>
                    
                </li>
                <li>
                    <a role="menuitem" id="searchFormLink" href="#buscadorGeneral"><span aria-hidden="true" class="glyphicon glyphicon-search" title="Buscador general"></span><span class="sr-only">Buscador general</span></a>
                    <ul id="buscadorGeneral" class="right">
                        <li>
                            <form class="form-inline" name="globalSearchForm" onsubmit="return searchForm(event)">
                                <label class="sr-only" for="searchMain">Buscador general</label>
                                <input class="form-control" name="search" id="searchMain" placeholder="Buscar..." maxlength="255" required />
                                <button type="submit" class="btn btn-primary" title="Buscar"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></button>
                            </form>

                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>