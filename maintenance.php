<?php

#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|
#|                                                                        #|
#|         HABBOPHP - http://habbophp.com                                 #|
#|         Copyright © 2012 Valentin & Robin. All rights reserved.        #|
#|																		  #|
#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|#|

session_start();
define('CORE','CORE');
require'includes/core.php';

$Error = new Error();
if(isset($_POST['username'])){
	if(isset($_POST['username']) && empty($_POST['username']))
		$Error->set('pseudo',$tpl->assign('error_login_pseudo','true'));
	if(isset($_POST['password']) && empty($_POST['password']))
		$Error->set('password',$tpl->assign('error_login_password','true'));
		
				
	if(!$Error->ErrorPresent()){
		if($Auth->connexion($_POST,true)){
			redirection($config->url_site.'/me.php');
		}else{
			$Error->set('AuthFalse','Connexion impossible');
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $config->name ; ?> - Maintenance Break</title>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">(function($) {
 
  $.fn.tweet = function(o){
    var s = {
      username: ["seaofclouds"],              // [string]   required, unless you want to display our tweets. :) it can be an array, just do ["username1","username2","etc"]
      avatar_size: null,                      // [integer]  height and width of avatar if displayed (48px max)
      count: 3,                               // [integer]  how many tweets to display?
      intro_text: null,                       // [string]   do you want text BEFORE your your tweets?
      outro_text: null,                       // [string]   do you want text AFTER your tweets?
      join_text:  null,                       // [string]   optional text in between date and tweet, try setting to "auto"
      auto_join_text_default: "i said,",      // [string]   auto text for non verb: "i said" bullocks
      auto_join_text_ed: "i",                 // [string]   auto text for past tense: "i" surfed
      auto_join_text_ing: "i am",             // [string]   auto tense for present tense: "i was" surfing
      auto_join_text_reply: "i replied to",   // [string]   auto tense for replies: "i replied to" @someone "with"
      auto_join_text_url: "i was looking at", // [string]   auto tense for urls: "i was looking at" http:...
      loading_text: null,                     // [string]   optional loading text, displayed while tweets load
      query: null                             // [string]   optional search query
    };

    $.fn.extend({
      linkUrl: function() {
        var returning = [];
        var regexp = /((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi;
        this.each(function() {
          returning.push(this.replace(regexp,"<a href=\"$1\">$1</a>"))
        });
        return $(returning);
      },
      linkUser: function() {
        var returning = [];
        var regexp = /[\@]+([A-Za-z0-9-_]+)/gi;
        this.each(function() {
          returning.push(this.replace(regexp,"<a href=\"http://twitter.com/$1\">@$1</a>"))
        });
        return $(returning);
      },
      linkHash: function() {
        var returning = [];
        var regexp = / [\#]+([A-Za-z0-9-_]+)/gi;
        this.each(function() {
          returning.push(this.replace(regexp, ' <a href="http://search.twitter.com/search?q=&tag=$1&lang=all&from='+s.username.join("%2BOR%2B")+'">#$1</a>'))
        });
        return $(returning);
      },
      capAwesome: function() {
        var returning = [];
        this.each(function() {
          returning.push(this.replace(/(a|A)wesome/gi, 'AWESOME'))
        });
        return $(returning);
      },
      capEpic: function() {
        var returning = [];
        this.each(function() {
          returning.push(this.replace(/(e|E)pic/gi, 'EPIC'))
        });
        return $(returning);
      },
      makeHeart: function() {
        var returning = [];
        this.each(function() {
          returning.push(this.replace(/[&lt;]+[3]/gi, "<tt class='heart'>&#x2665;</tt>"))
        });
        return $(returning);
      }
    });

    function relative_time(time_value) {
      var parsed_date = Date.parse(time_value);
      var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
      var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
      if(delta < 60) {
      //return 'less than a minute ago';
      return 'il y a moins d\'une minute';
      } else if(delta < 120) {
      //return 'about a minute ago';
      return 'il y a environ une minute';
      } else if(delta < (45*60)) {
      //return (parseInt(delta / 60)).toString() + ' minutes ago';
      return 'il y a ' + (parseInt(delta / 60)).toString() + ' minutes';
      } else if(delta < (90*60)) {
      //return 'about an hour ago';
      return 'il y a environ une heure';
      } else if(delta < (24*60*60)) {
      //return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
      return 'il y a ' + (parseInt(delta / 3600)).toString() + ' heures';
      } else if(delta < (48*60*60)) {
      //return '1 day ago';
      return 'il y a 1 jour';
      } else {
      //return (parseInt(delta / 86400)).toString() + ' days ago';
      return 'il y a ' + (parseInt(delta / 86400)).toString() + ' jours';
      }
    }

    if(o) $.extend(s, o);
    return this.each(function(){
      var list = $('<ul class="tweet_list">').appendTo(this);
      var intro = '<p class="tweet_intro">'+s.intro_text+'</p>'
      var outro = '<p class="tweet_outro">'+s.outro_text+'</p>'
      var loading = $('<p class="loading">'+s.loading_text+'</p>');
      if(typeof(s.username) == "string"){
        s.username = [s.username];
      }
      var query = '';
      if(s.query) {
        query += 'q='+s.query;
      }
      query += '&q=from:'+s.username.join('%20OR%20from:');
      var url = 'http://search.twitter.com/search.json?&'+query+'&rpp='+s.count+'&callback=?';
      if (s.loading_text) $(this).append(loading);
      $.getJSON(url, function(data){
        if (s.loading_text) loading.remove();
        if (s.intro_text) list.before(intro);
        var j = 0;
        $.each(data.results, function(i,item){
          if (item.text.charAt(0) != "@" && j < 5) {
			// auto join text based on verb tense and content
			if (s.join_text == "auto") {
			  if (item.text.match(/^(@([A-Za-z0-9-_]+)) .*/i)) {
				var join_text = s.auto_join_text_reply;
			  } else if (item.text.match(/(^\w+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+) .*/i)) {
				var join_text = s.auto_join_text_url;
			  } else if (item.text.match(/^((\w+ed)|just) .*/im)) {
				var join_text = s.auto_join_text_ed;
			  } else if (item.text.match(/^(\w*ing) .*/i)) {
				var join_text = s.auto_join_text_ing;
			  } else {
				var join_text = s.auto_join_text_default;
			  }
			} else {
			  var join_text = s.join_text;
			};
  
			var join_template = '<span class="tweet_join"> '+join_text+' </span>';
			var join = ((s.join_text) ? join_template : ' ')
			var avatar_template = '<a class="tweet_avatar" href="http://twitter.com/'+ item.from_user+'"><img src="'+item.profile_image_url+'" height="'+s.avatar_size+'" width="'+s.avatar_size+'" alt="'+item.from_user+'\'s avatar" border="0"/></a>';
			var avatar = (s.avatar_size ? avatar_template : '')
			var date = '<a href="http://twitter.com/'+item.from_user+'/statuses/'+item.id+'" class="time">'+relative_time(item.created_at)+'</a>';
			var text = '<span class="tweet_text">' +$([item.text]).linkUrl().linkUser().linkHash()[0]+ '</span>';
			
			// until we create a template option, arrange the items below to alter a tweet's display.
			list.append('<li>' + avatar + join + text + "<br />" + date + '</li>');
  
			list.children('li:first').addClass('tweet_first');
			list.children('li:odd').addClass('tweet_even');
			list.children('li:even').addClass('tweet_odd');
			j++;
          }
        });
        if (s.outro_text) list.after(outro);
      });

    });
  };
})(jQuery);

function showConnexion(){
	$('#connexion').show();
	return false ;
}

</script>
	
	<style>
	body {
	background-color: #bce0ee;
	font-size: 11px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	text-align: center;
	margin: 0;
	padding: 10px;
}

a {
	color: #fc6204;
}

ul {
    margin: 0;
    padding: 0;
}

li {
    list-style: none;
}

#header {
	position: relative;	
    zoom: 1;
}


#header h1 {
	float: left;
	margin: 0;
}

#header h1 span {
	position: relative;
	float: left;
	width: 120px;
	height: 50px;
	background: url(web-gallery/images/habbologo_blackR.gif) no-repeat;
}

#container {
	background-color: #fff;
	border: 1px solid #96b3be;
	width: 760px;
	text-align: left;
	margin: 0 auto;
}

#content {
	margin: 21px;
}

#process-content {
	clear: both;
	padding-top: 21px;
}

h2 {
	margin: 4px;
	padding: 4px 10px;
	font-size: 14px;
	background-color: #959595;
	color: #fff;
	position: relative;
    text-align: center;
}

div.fireman {
	color: #fff;
	background: #f60 url(web-gallery/images/fireman.png) no-repeat 100% 140px;
	border: 1px solid #d6d6d6;
	float: left;
	width: 396px;
	height: 400px;
}

div.fireman h1 {
	margin: 14px 14px 7px 14px;
	font-size: 30px;
}

div.fireman p {
	margin: 0 14px 7px 14px;
	font-size: 16px;
}

div.tweet-container {
	border: 1px solid #d6d6d6;
	float: right;
	width: 290px;
	height: 400px;
	overflow: auto;
}

div.tweet-container1 {
	border: 1px solid #d6d6d6;
	float: lieft;
	width: 718px;
	height: 100px;
	overflow: auto;
}

ul.tweet_list li {
	padding: 7px 14px;
}

li.tweet_even {
	background-color: #ececec;
}

a.time {
	color: #b8b8b8;
}



#footer {
	clear: both;
	text-align: center;
	font-size: 11px;
	padding: 16px 0 0 4px;

}

#footer p {
	margin: 0;
	padding-top: .7em;
    padding-bottom: 0;
    font-size: 9px;
    color: #777;
}

#footer a {
    color: #000000;
}

.clearfix:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
}

.clear {
	clear: both;
}
</style>
	

</head>
<body>

<div id="container">
	<div id="content">
		<div id="header" class="clearfix">
			<h1><span></span></h1>
		</div>
		<div id="process-content">

<div class="fireman">

<h1>Maintenance break!</h1>


<p> 
Nous sommes d&eacute;sol&eacute; mais tu ne peux pas te connecter &agrave; <?php echo $config->name ; ?> pour l&#39;instant. Nous sommes en train de mettre &agrave; jour.

<p> 
</div>

<div class="tweet-container">

<h2>Mais que se passe-t-il ?</h2>

<div class="tweet"></div>

</div>

<div id="footer">
<p class="copyright">&copy; 2009 - 2012 HABBOBETA, Nous ne sommes pas lié ou autorisé par Sulake Corporation Oy. HABBO est une marque déposée de Sulake Corporation Oy dans l'Union Européenne, les Etats-Unis, le Japon, la république populaire de Chine et autres juridictions. Tous droits réservés.</p>
</div>
<br/>
<center>
<?php
echo $Error->display('AuthFalse');
?>
<div id="connexion" style="display:block;">
	<form accept="" method="post">
		<input type="text" name="username"/>
		<input type="password" name="password"/>
		<input type="submit" name="submit" value="Se connecter"/>
	</form>
</div><br/>
<div id="fb-root"></div>
<script type="text/javascript">
 
    window.fbAsyncInit = function() {
        
        FB.init({appId: '<?php echo $config->fb_appid ; ?>', status: true, cookie: true, xfbml: true, oauth: true});
        $(document).fire("fbevents:scriptLoaded");

    };
    window.assistedLogin = function(FBobject, optresponse) {
        
      
        FB.init({appId: '<?php echo $config->fb_appid ; ?>', status: true, cookie: true, xfbml: true, oauth: true});

        permissions = 'email';
        defaultAction = function(response) {

            if (response.authResponse) {
                fbConnectUrl = "<?php echo $config->url_site ; ?>/register.php?page=5";
	            window.location.replace(fbConnectUrl);
            }
        };

        if (typeof optresponse == 'undefined')
            FB.login(defaultAction, {scope:permissions});
        else
            FB.login(optresponse, {scope:permissions});

    };

    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/fr_FR/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
     
</script>
<a class="fb_button fb_button_large" onclick="assistedLogin(FB); return false;">
    <span class="fb_button_text">Entre avec Facebook</span>
</a>
</center>
		</div>
	</div>
</div>



<script src="/urchin.js" type="text/javascript">
</script>

<script type='text/javascript'>
$(document).ready(function(){
  $(".tweet").tweet({
    username: "axsofficial",
    count: 7
  });
});
</script>

</body>
</html>
