<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <title>HabboPHP Installation</title>
        
        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        
         
        
             <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
        <script src="assets/js/alajax-1.2.js"></script>
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    
    <body>
    <section id="container">
	    <div id="steps">
        	<div id="b0" class="bulle bactive">0</div><div id="t0" class="text tactive" lang="en">Welcome</div>
        	<div id="b1" class="bulle">1</div><div id="t1" class="text" lang="en">Permissions</div>
        	<div id="b2" class="bulle">2</div><div id="t2" class="text" lang="en">Database</div>
        	<div id="b3" class="bulle">3</div><div id="t3" class="text" lang="en">Configuration</div>
        	<div id="b4" class="bulle">4</div><div id="t4" class="text" lang="en">Admin account</div>
        </div>
        <br style="clear:both"/>
        
        <div id="content-ajax">
        	<p>Bienvenue dans HabboPHP Rétro Révolution !
        	<br/><br/>Continuer en :</p>
        
        	<img onclick="langHabbo('fr')" src="assets/img/france-2.png"/>
        	<img onclick="langHabbo('en')" src="assets/img/usa-2.png"/><br/>
        	<a href="javascript:void(0);" id="next-chmod" style="display:none" onclick="load('chmod')" class="downloadButton" lang="en">Continuer</a>
        </div>	
        
    </section>
    

     
      <script>
        $(function(){
        	$('#step0').slideDown().animate({opacity:1});
       });
       
       function langHabbo(iso){
	       document.cookie='iso='+escape(iso);
	       if(iso == 'en'){
		       $('#next-chmod').html('Next');
	       }
	       else if(iso == 'fr'){
		       $('#next-chmod').html('Suivant');
	       }
	       $('#next-chmod').show();
       }
       
       function load(page){
	       $.get('ajax-2/'+page+'.php',function(data){
	     	  // $('#content-ajax').slideUp();
	     	   $('#content-ajax').html(data);
	     	   
	     	   if(page == 'chmod'){
		     	   $('#t0').removeClass('tactive');
		     	   $('#b0').removeClass('bactive');
		     	   
		     	   $('#t1').addClass('tactive');
		     	   $('#b1').addClass('bactive');
	     	   }
	     	   
	     	  // $('#content-ajax').slideDown();
		    });
	   }
       
       </script>
     
    
    </body>
</html>
   