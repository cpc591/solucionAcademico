<!DOCTYPE html>
<html>
    <head>
    	<title></title>
        <style>
           @page { margin: 180px 50px; }
    #header2 { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px; text-align: center; }
    #footer2 { position: fixed; bottom: -140px; height: 150px;}
    #numero .page:after {content: counter(page); }
    body,html{font-size:9pt;}
        </style>
        
    </head>
    <body>
        <div class="row" id="header2">
            <div class="xs-12">
                <img style="text-align:left" src="img/header.jpg" width="100%"/>    
            </div>
        </div>
        <div class="row" id="footer2">
            <div class="xs-12" id="numero" style="text-align:right">
                
                <p class="page"> </p>
            </div>
            <div class="xs-12">
                <img style="text-align:left" src="img/piePagina.jpg" width="100%"/>   
            </div>
        </div>
        <div class="row" id="content">
            <div class="xs-12">
                {!!$respuesta!!}    
            </div>
        </div>
        
    </body>
</html>