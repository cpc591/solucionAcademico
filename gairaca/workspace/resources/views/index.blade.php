@extends('Layout.master')
@section('Title','Inicio de sesión')
@section('app','ng-app="appLogin"')
@section('controller','ng-controller="loginCtrl"')

@section('estilo')
    <style>
        .carousel-inner>.item{
            height:312px;
        }
    </style>
    
@endsection

@section('contenido')
    <div class="container" style="padding-top:30px">
        <div class="row" style="align-items: center;">
            <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" align="center">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="5" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
						<li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
						
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img class="img-responsive img-rounded" src="img/gairaca.jpg" alt="">
                            <div class="carousel-caption">
                            </div>
                        </div>
                        
                        <div class="item">
                            <img class="img-responsive img-rounded" src="img/slider2.jpg" alt="">
                            <div class="carousel-caption">
                            </div>
                        </div>
                        <div class="item">
                            <img class="img-responsive img-rounded" src="img/slider3.JPG" alt="">
                            <div class="carousel-caption">
 
                            </div>
                        </div>
                        <div class="item">
                            <img class="img-responsive img-rounded" src="img/slider4.JPG" alt="">
                            <div class="carousel-caption">
 
                            </div>
                        </div>
						  <div class="item">
                            <img class="img-responsive img-rounded" src="img/slider5.JPG" alt="">
                            <div class="carousel-caption">
 
                            </div>
                        </div>
						  <div class="item">
                            <img class="img-responsive img-rounded" src="img/slider6.JPG" alt="">
                            <div class="carousel-caption">
 
                            </div>
                        </div>

                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control hidden-xs" href="#carousel-example-generic" role="button" data-slide="prev">
                        <i class="fa fa-chevron-circle-left fa-3x"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control hidden-xs" href="#carousel-example-generic" role="button" data-slide="next">
                         <i class="fa fa-chevron-circle-right fa-3x"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6" id="login">
                <!-- Nav tabs -->
                  <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                    
                    <li role="presentation" class="active"><a href="#estudiantes" aria-controls="estudiantes" role="tab" data-toggle="tab">Estudiantes</a></li>
                    <li role="presentation"><a href="#dependencias" aria-controls="dependencias" role="tab" data-toggle="tab">Dependencias</a></li>
                  </ul>
                
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="estudiantes" style="padding:30px">
                        
                        <br>
                        @if(Session::has('message'))
                            <span class="messages">
                                <span class="color_errores">{{Session::get('message')}}</span>
                            </span>
                        @endif
                        <br>
                        
                        <br>
                        
                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="login">
                            <p style="font-size: 0.9em; font-weight: bold;  color: #125ca2;">Cuenta educativa de la Universidad del Magdalena</p>
                            <form class="form-horizontal"  action="/loginestudiante" method="POST" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="form-group row col-sm-12 col-xs-12" >
                                  
                                  <input type="text" name="codigo" class="form-control" id="inputEmail" placeholder="Código" required>
                                  
                              </div>
            
                             <div class="form-group col-sm-12 col-xs-12" >
                                
                                  <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
                                
                              </div>
                              <div class="form-group col-sm-12 col-xs-12" style="text-align:center;">
                                  
                                  <button type="submit" class="btn btn-default" id="btn-login">Iniciar sesión</button>
                                  
                              </div>
                              
                            </form>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="dependencias">
                        <div  style="padding:30px">
                            <br>
                            @if(Session::has('message'))
                                <span class="messages">
                                    <span class="color_errores">{{Session::get('message')}}</span>
                                </span>
                            @endif
                            <br><br>
                                
                            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="login">
                                <p style="font-size: 0.9em; font-weight: bold;  color: #125ca2;">Cuenta educativa de la Universidad del Magdalena</p>
                                <form class="form-horizontal" name="formLogin"  action="/logindependencia" method="POST" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <div class="form-group row col-sm-12 col-xs-12" >
                                      
                                      <input type="text" name="userName" class="form-control" id="inputEmail2" placeholder="Nombre de usuario" required>
                                      
                                  </div>
                
                                 <div class="form-group col-sm-12 col-xs-12" >
                                    
                                      <input type="password" name="password" class="form-control" id="inputPassword2" placeholder="Contraseña" required>
                                    
                                  </div>
                                  <div class="form-group col-sm-12 col-xs-12" style="text-align:center;">
                                      
                                      <button type="submit" class="btn btn-default" id="btn-login">Iniciar sesión</button>
                                      
                                  </div>
                                  
                                </form>
                            </div>
                        </div>
                    </div>
                    
                  </div>
            </div>
		
       
    </div>    	 
    	<br><br>
    
    </div>
@endsection

@section('javascript')
    <script src="{{asset('/js/login/login.js')}}"></script>
    <script src="{{asset('/js/login/loginServices.js')}}"></script>
@endsection