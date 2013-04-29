
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>{$config->name}</title>
<script src="{$config->url_site}/web-gallery/js/visual.js" type="text/javascript"></script>
<link rel="stylesheet" href="{$config->url_site}/web-gallery/styles/cbs2creditsflow.css" type="text/css" />




<!--[if IE 8]>
<link rel="stylesheet" href="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/972/web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/972/web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/972/web-gallery/static/styles/ie6.css" type="text/css" />
<script src="/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/972/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="HabboPHP 1.0" />
</head>

<body id="home" class=" " style="background:#FDF6EC;">

    <div id="container">
        <div id="payment-details-container">
    
    <div id="payment-details-header">
        <div class="rounded"><h1>{#ConfirmBuyCredits#} {$config->moneyname}</h1></div>
    </div>


   
        
               
        <div id="payment-details">
            <h2>{#DetailsBuy#}</h2>
                        
            <table>
                <colgroup>
                    <col class="product"/>
                    <col class="price"/>
                    <col class="user"/>
                </colgroup>
                <thead>
                    <tr>
                        <th class="credit-amount">{#Product#}</th>
                        <th class="price">{#Amount#}</th>
                        <th class="username">{#ForTheAccount#}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="credit-amount">
                            <span class="credit-amount">{$MethodPrice.amout}</span>
                            <span class="credit-amount-x"></span>
                            <span class="credit-amount-coin"></span>
                        </td>
                        <td class="price">
                                {$MethodPrice.price}
                        </td>
                        <td class="username">{$user->username}</td>
                    </tr>
                </tbody>
            </table>


            
		    
		   
            <div id="payment-methods" class="hide-methods">
          
                
{if $MethodPrice.type eq 'starpass'}             

<div id="starpass_{$config->starpassacc}"></div>
<script type="text/javascript" src="http://script.starpass.fr/script.php?idd={$config->starpassacc}&amp;verif_en_php=1&amp;datas={$user->id}">
</script>
<noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
<a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
</noscript>
{/if}
{if $MethodPrice.type eq 'allopass'}
<iframe width="550" height="480" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="https://payment.allopass.com/buy/buy.apu?ids={$allopass.0}&idd={$allopass.1}&data={$user->id}"></iframe>
{/if}
{if $MethodPrice.type eq 'paypal'}  

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<!--
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
-->
     <input type="hidden" name="cmd" value="_xclick">           
     <input type="hidden" name="business" value="{$config->paypalemail}">  
     <input type="hidden" name="item_name" value="{$config->moneyname}">   
     <input type="hidden" name="item_number" value="1">  
     <input type="hidden" name="amount" value="{$MethodPrice.price}">  
     <input type="hidden" name="tax" value="0">  
     <input type="hidden" name="quantity" value="1">    
     <input type="hidden" name="no_note" value="1">    
     <input type="hidden" name="currency_code" value="EUR">  
     <!-- Enable override of payer’s stored PayPal address. -->  
	<input name="return" type="hidden" value="{$config->url_site}/paiement/Paypal_paiementValide.php" /> <!-- URL de VALIDATION -->
	<input name="cancel_return" type="hidden" value="{$config->url_site}/shop.php?error" /> <!-- URL DE RETOUR -->
	<input name="notify_url" type="hidden" value="{$config->url_site}/shop.php?error" /> <!-- Sera appelée par l'IPN: name="notify_url" -->
     <!-- Set prepopulation variables to override stored address. -->  
     <input type="hidden" name="country" value="FR">  
	 <input name="no_note" type="hidden" value="1" />
	 <input name="custom" type="hidden" value="{$user->id}" />
	<input name="bn" type="hidden" value="PP-BuyNowBF" />
	<INPUT TYPE="hidden" name="charset" value="utf-8">
   <center><input type="image" src="images/paypal.png" onmouseover="this.src='images/paypalh.png';" style="border:0" border="0" onmouseout="this.src='images/paypal.png';" /></center>
  </form> 
<p style="color:red">Il faut impérativement cliquer sur "Retour sur.." pour valider votre achat.</p>
{/if}

            </div>

           
            <div style="color:black; font-size: 8pt;">
                <a href="{$config->url_site}/shop.php"> <span>{#Return#}</span></a>
            </div>
        </div>
        
    </form>

    

</div>



   </div>

<script type="text/javascript">Rounder.init();</script>
</body>
</html>