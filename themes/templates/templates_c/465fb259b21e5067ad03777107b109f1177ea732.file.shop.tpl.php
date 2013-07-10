<?php /* Smarty version Smarty-3.1.8, created on 2013-07-09 12:22:33
         compiled from "/Applications/MAMP/htdocs/HabboPHP/themes/templates/shop.tpl" */ ?>
<?php /*%%SmartyHeaderCode:132745927651dbe469b6f665-56787252%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '465fb259b21e5067ad03777107b109f1177ea732' => 
    array (
      0 => '/Applications/MAMP/htdocs/HabboPHP/themes/templates/shop.tpl',
      1 => 1372518445,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132745927651dbe469b6f665-56787252',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'token' => 0,
    'config' => 0,
    'paypalD' => 0,
    'starpassD' => 0,
    'allopassD' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51dbe469cef803_92145993',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51dbe469cef803_92145993')) {function content_51dbe469cef803_92145993($_smarty_tpl) {?><input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" id="token"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="web-gallery/js/vip.js"></script>
<script>
	jQuery.noConflict();
</script>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
	
	<?php if (isset($_GET['nomoney'])){?>
		<div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;"><?php echo $_smarty_tpl->getConfigVariable('YouHaveNoEnough');?>
 <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
</div>
	<?php }?>
	
	
	<?php if (isset($_GET['errorPaiement'])){?>
		<div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;">Choisissez un mode de paiement</div>
	<?php }?>
	
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title"><?php if (isset($_GET['success'])){?><b><?php echo $_smarty_tpl->getConfigVariable('Success_get_coins');?>
 <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
</b>
							<?php }elseif(isset($_GET['error'])){?><?php echo $_smarty_tpl->getConfigVariable('Error_buy');?>

							<?php }else{ ?>Choisis ton mode de paiement<?php }?>
							</h2>
						<style>
div.credit-amount-coin {
    width: 26px !important;
}
</style>





<style type="text/css">
.method-group.online.bestvalue {
 background-image: url(themes/images/fr_strike_best_value.png);
background-repeat: no-repeat;
}

.price b.from {
  visibility:hidden;
  max-height:1px;
}

.method-group.phone .redeemcode {
    width: 75px!important;
}
.method-group.phone .redeem {
    margin: 0!important;
}
div.phone * a.redeem-submit > b {
    padding: 5px!important;
    width: 55px!important;
}
div.uscashcards  {
    padding-left: 166px!important;
}

</style>

  

            
            <div class="method-group online clearfix  bestvalue  cbs2">


                        <div id="group-content-4854">
                        <div id="price-container">
                            <div id="pricepoints">
                                <form id="selectPricePointFormForConfirmationPage" action="paiement.php" method="get" >
                                    
                                        <ul>
                                            <li <?php echo $_smarty_tpl->tpl_vars['paypalD']->value;?>
>
                                                <label>
                                                    <span class="radio"><input type="radio" name="amoutMethod"  value="paypal"/></span>
    
            <div class="pricepoint-amount-container">
                <div class="credit-amount"><?php echo $_smarty_tpl->tpl_vars['config']->value->paypalamount;?>
 x <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
</div>
            </div>

                                                    
                                                    <span class="credit-amount-equals"></span>
                                                    <span class="price-in-cents">
<?php echo $_smarty_tpl->tpl_vars['config']->value->paypalprice;?>
 <span class="currency-symbol">€</span> Paypal
                                                    </span>
                                                </label>
                                            </li>
                                            

                                        </ul>
                                     
                                        <ul>
                                            <li <?php echo $_smarty_tpl->tpl_vars['starpassD']->value;?>
>
                                                <label>
                                                    <span class="radio"><input type="radio" name="amoutMethod" value="starpass"/></span>
    
            <div class="pricepoint-amount-container">
                <div class="credit-amount"><?php echo $_smarty_tpl->tpl_vars['config']->value->starpassamount;?>
 x <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
</div>
            </div>

                                                    
                                                    <span class="credit-amount-equals"></span>
                                                    <span class="price-in-cents">
1 code Starpass
                                                    </span>
                                                </label>
                                            </li>
                                            

                                        </ul>
                                        
                                               
                                        <ul>
                                            <li <?php echo $_smarty_tpl->tpl_vars['allopassD']->value;?>
>
                                                <label>
                                                    <span class="radio"><input type="radio" name="amoutMethod" value="allopass"/></span>
    
            <div class="pricepoint-amount-container">
                <div class="credit-amount"><?php echo $_smarty_tpl->tpl_vars['config']->value->allopassamount;?>
 x <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
</div>
            </div>

                                                    
                                                    <span class="credit-amount-equals"></span>
                                                    <span class="price-in-cents">1 code Allopass
                                                    </span>
                                                </label>
                                            </li>
                                            

                                        </ul>

                                        <a href="#" onclick="document.forms['selectPricePointFormForConfirmationPage'].submit();" class="large-button large-green-button"><span><b>Continuer</b></span><i></i></a>
                                </form>
                        </div>
                            <div id="methods">
                                <ul>
                                            <li><img alt="Carte Bancaire" src="themes/images/starpass.png"/></li>
                                            <li><img alt="Paypal" src="themes/images/partner_logo_paypal_001.png"/></li>
                                            <li><img alt="Internet+" src="themes/images/allopass.png"/></li>
                                </ul>
                            </div>
                        </div>
                        </div>
                        
                        
                                        
            </div>

<script type="text/javascript">
    document.observe("dom:loaded", function() { new CreditsList('false'); });
</script>

<div class="moreinfo-section">
    <a href="vip.php" class="moreinfo">Adhérer au club VIP !</a>
</div>


						
							
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix darkgray ">
	
							
						<div id="redeem-habblet">
    <div class="redeem-balance">
        <p class="redeem-balance-username"><?php echo $_smarty_tpl->tpl_vars['user']->value->username;?>
</p>
        <p class="redeem-balance-text"><?php echo $_smarty_tpl->getConfigVariable('Your');?>
 <?php echo $_smarty_tpl->tpl_vars['config']->value->moneyname;?>
 :</p>
        <p style="font-size:18px;font-weight:bold;"><?php echo $_smarty_tpl->tpl_vars['user']->value->jetons;?>
</p>
    </div>

    <div class="redeem-redeeming-text"><p class="redeeming-text"><?php echo $_smarty_tpl->getConfigVariable('HaveVoucher');?>
</p></div>

    <div class="redeem-form-container clearfix" style="margin-top:7px;">
        <form method="post" action="#" id="voucher-form">
<div class="redeem-redeeming">
    <div><input type="text" name="voucherCode" value="" id="voucher" class="redeemcode" size="8" /></div>

    <div class="redeem-redeeming-button"><a href="javascript:void(0);" onclick="useVoucher();" class="new-button green-button redeem-submit exclude"><b><span></span><?php echo $_smarty_tpl->getConfigVariable('Exchange');?>
</b><i></i></a></div>
    
</div>
        </form>
    </div>
</div>

<script type="text/javascript">
document.observe("dom:loaded", function() { new NewRedeemHabblet(); });
</script>

						
							
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>

<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
    </div>
<?php }} ?>