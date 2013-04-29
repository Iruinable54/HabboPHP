<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    	<div>
    		<div class="content">
    			<div class="habblet-container" style="width:400px ;float:left" >
    				<div class="cbb clearfix green" >
    					<h2 class="title" >Achat de {$config->winwin} WinWin</h2>
    					<div class="box-content">
    					{if isset($errorPrix)}
    							<div style="padding:10px;font-size:18px;background:#c40000;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;">{#YouHaveNoEnough#} {$config->moneyname}</div>
    					{/if}
    					{if isset($success)}
    							<div style="padding:10px;font-size:18px;background:#60B200;color:white;text-shadow:0 1px 0 #990000;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;margin:10px;">{#SuccessWinWin#}</div>
    					{/if}
	    					<p>Salut {$user->username} !<br><br/>
		    					Sur {$config->name} tu peux acheter {$config->winwin} WinWin pour {$config->winwinprix} !
	    					</p>
	    					<form accept="winwin.php" method="post" id="winwin">
	    					<input class="large-button large-green-button" name="submit" type="submit" value="Acheter"/>
	    					</form>    					
	    				</div>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>
</div>