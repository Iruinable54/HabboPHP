<div class="clear"></div>
	
	</div><!-- /#main -->

</div><!-- /#container -->

</div><!-- /#bg -->

<?php
	if($disable_jquery_loading !== true){
		echo '<script type="text/javascript" src="js/jquery.min.js"></script>';
	}
?>

<script type="text/javascript" src="js/jquery.support.borderRadius.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript">
    $(function(){
    	if(!$.support.borderRadius) { 
    	   $('#main, #content, #sidebar, .box').corner("13px");
        }
    });
</script>
<?php if(!empty($footer_data)){ echo $footer_data; } ?>

     <!-- Footer
      ================================================== -->
      <footer class="footer">
        <p class="pull-right">
        Form manager power by <a href="http://www.appnitro.com/">AppNitro</a>
        </p>
        <p><?php echo $lang['MadeInFranceWith']; ?> ♥ <?php echo $lang['by']; ?> <a href="http://habbophp.com">HabboPHP</a>.</p>
        <p>Joliment mis en page par Twitter et son <a href="http://twitter.github.com/bootstrap/" target="_blank">BootStrap.</p>
      </footer>

    </div><!-- /container -->


</div>
</body>
</html>