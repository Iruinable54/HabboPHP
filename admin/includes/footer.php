 <div class="modal hide fade" id="ok">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $lang['ModificationOKTitle']; ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo $lang['ModificationOK']; ?></p>
  </div>
  <div class="modal-footer">
    <a href="javascript:void(0);" data-dismiss="modal" class="btn"><?php echo $lang['Close']; ?></a>
  </div>
</div>

     <!-- Footer
      ================================================== -->
      <footer class="footer">
        <p class="pull-right">
        </p>
        <p><?php echo $lang['MadeInFranceWith']; ?> ♥ <?php echo $lang['by']; ?> <a style="color:#08C!important;" href="http://habbophp.com"><span style="color:#08C!important;">HabboPHP</span></a>.</p>
        <p>Joliment mis en page par Twitter et son <a href="http://twitter.github.com/bootstrap/" style="color:#08C!important;" target="_blank">BootStrap.</p>
      </footer>

    </div><!-- /container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/application.js"></script>
    <script src="assets/js/w.js" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						

<script type="text/javascript">
$(document).ready(function(){
	new nicEditor().panelInstance('tai');    
	$('.tabs a:first').tab('show')
	var token = $('#token').val();
	$("#paging_buttonn a").click(function(){
		$("#paging_buttonn a").css({'border' : '1px solid #fff'});
		$(this).css({'border' : '1px solid #ccc'});
		$("#imagenews").load("ajax/imagenews.php?page=" + this.id +"&token="+token);	
		return false;
	});
	$("#1").css({'border' : '1px solid #ccc'});
	$("#imagenews").load("ajax/imagenews.php?page=1&token="+token);
	
	
	$.post('ajax/getban.php',{ page:1 },function(data){
		$('#banList').html(data);
	});
	
});


function addRareManage(){
	var oid = 	$('#oidRare').val();
	var name = 	$('#nameRare').val();
	var prix = 	$('#prixRare').val();
	var image = $('#imageRare').val();
	var token = $('#token').val();
	
	if(oid == ''){  alert('<?php echo $lang['NeedIDRare']; ?>'); return false; }
	
	$.post('ajax/addRareManage.php',{oid:oid,name:name,prix:prix,image:image,token:token}, function(data){
		if(data == 1){
			document.location.reload() ;
		}
		else{
			alert('Error');
		}
	});
}

function deleteRareManager(id){
	var token = $('#token').val();
	$.post('ajax/deleteRareManager.php',{id:id,token:token},function(data){
		$('#r'+id).fadeOut();
	});
}

function ChangeUsers(id){
	var token = $('#token').val();
	var username = $('#inusername_'+id).val();
	var mail = $('#inmail_'+id).val();
	var credits = $('#incredits_'+id).val();
	var vip_points = $('#invippoints_'+id).val();
	var motto = $('#inmotto_'+id).val();
	var rank = $('#inrank_'+id).val();
	var password = $('#inpassword_'+id).val();
	var jetons = $('#injetons_'+id).val();
	if(username == ""){ alert('<?php echo $lang['NeedUsername']; ?>'); return false; }
	if(mail == ""){ alert('<?php echo $lang['NeedMail']; ?>'); return false; }
	if(rank == ""){ alert('<?php echo $lang['NeedRank']; ?>'); return false; }
	if(jetons != ""){
		if(!$.isNumeric(jetons)){
			alert('<?php echo $lang['NeedJetonsInt']; ?>'); 
			return false ; 
		}
	}
	
	$.get('ajax/updateusers.php?username='+username+'&mail='+mail+'&credits='+credits+'&vip_points='+vip_points+'&motto='+motto+'&rank='+rank+'&password='+password+'&id='+id+'&token='+token+'&jetons='+jetons+'',function(data){
	if(data == 11){
		$('#ok').modal();
	}else {
			if(data == 'ERRORTOKEN'){
				alert('<?php echo $lang['ErrorToken']; ?>');	
			}else
				alert('Error');
		}
	});
	
//	$('#ok').modal();

}

function addwordfilterPhoenix(word,neww,strict) {
	var token = $('#token').val();
	$.get('ajax/addwordfilterPhoenix.php?word='+word+'&new='+neww+'&strict='+strict+'&token='+token+'', function(data) {
		if(data==1){
			$('#word').val('');
			$('#new').val('');
			$('#nowords').hide();
			if(strict==1) var stri="Oui";
			else var stri="Non";
			$('#addword').append('<tr id="word-'+word+'"><td>'+word+'</td><td>'+neww+'</td><td>'+stri+'</td><td><a href="javascript:void(0);" onclick="removewordfilter(\''+word+'\',\''+word+'\');" class="btn btn-danger">Supprimer</a></td></tr>');
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}


function addwordfilterButterfly(word,neww,strict) {
	var token = $('#token').val();
	$.get('ajax/addwordfilterButterfly.php?word='+word+'&new='+neww+'&strict='+strict+'&token='+token+'', function(data) {
		if(data==1){
			$('#word').val('');
			$('#new').val('');
			$('#nowords').hide();
			if(strict==1) var stri="Oui";
			else var stri="Non";
			$('#addword').append('<tr id="word-'+word+'"><td>'+word+'</td><td><a href="javascript:void(0);" onclick="removewordfilter(\''+word+'\',\''+word+'\');" class="btn btn-danger">Supprimer</a></td></tr>');
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}

function removewordfilter(word,woord) {
	var token = $('#token').val();
	$.get('ajax/removewordfilter.php?word='+word+'&token='+token+'', function(data) {
		if(data==1){
			$('#word-'+woord+'').hide();
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}
function postnews(image,title,shortdesc,content,comment) {
	var token = $('#token').val();
	if(image=="") { alert('<?php echo $lang['NeedImage']; ?>'); return false; }
	if(title=="") { alert('<?php echo $lang['NeedTitle']; ?>'); return false; }
	if(shortdesc=="") { alert('<?php echo $lang['NeedShortDesc']; ?>'); return false; }
	if(content=="<br>") { alert('<?php echo $lang['NeedContent']; ?>'); return false; }
	$.post('ajax/postnews.php',{image:image, title:title,shortdesc:shortdesc,content:content,token:token,comment:comment},function(data){
		if(data == 1 ){
			$('#shortdescnews').val('');
			$('#titlenews').val('');
			$('.nicEdit-main').html('');
			$('#postnewsload').modal();
			setTimeout("document.location.reload();",3000);
		} else {
			alert(data);
		}
	});
}

function editnews(id,title,shortdesc,content,token) {
	var token = $('#token').val();
	if(title=="") { alert('<?php echo $lang['NeedTitle']; ?>'); return false; }
	if(shortdesc=="") { alert('<?php echo $lang['NeedShortDesc']; ?>'); return false; }
	if(content=="<br>") { alert('<?php echo $lang['NeedContent']; ?>'); return false; }
	$.post('ajax/editnews.php',{title:title,shortdesc:shortdesc,content:content,token:token,id:id},function(data){
		if(data == 1 ){
			//$('#shortdescnews').val('');
			//$('#titlenews').val('');
			//$('.nicEdit-main').html('');
			$('#ok').modal();
			//setTimeout("document.location.reload();",);
		} else {
			alert(data);
		}
	});
}



function deletenews(idd) {
	var token = $('#token').val();
	$.get('ajax/deletenews.php?id='+idd+'&token='+token+'', function(data) {
		if(data==1){
			$('#news-'+idd+'').hide();

		} else {
			alert('<?php echo $lang['Error']; ?>');
			if(data == 'token'){
				alert('Erreur token');
			}
		}
	});
}
function maintenanceon() {
	var token = $('#token').val();
	$.get('ajax/setmaintenance.php?action=true&token='+token+'', function(data) {
		if(data==1){
			$('#ok').modal();
			setTimeout("document.location.reload();",1000);
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}
function maintenanceoff() {
	var token = $('#token').val();
	$.get('ajax/setmaintenance.php?action=false&token='+token+'', function(data) {
		if(data==1){
			$('#ok').modal();
			setTimeout("document.location.reload();",1000);
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}
function setconfig(value,type) {
	var token = $('#token').val();
	$.post('ajax/setconfig.php',{ value:value,type:type,token:token }, function(data) {
		if(data==1){
			$('#ok').modal();
		} else {
			if(data == 'ERRORTOKEN'){
				alert('<?php echo $lang['ErrorToken']; ?>');	
				console.log(data);
			}else
			alert('<?php echo $lang['Error']; ?>');
			console.log(data);
		}
	});
}
function ban(type,value,reason,duree) {
	var token = $('#token').val();
	if(duree == ""){alert('Une durée est demandée'); return false ;}
	if(reason == ""){alert('Une raison est demandée'); return false ;}
	$.get('ajax/ban.php?type='+type+'&value='+value+'&reason='+reason+'&token='+token+'&duree='+duree+'', function(data) {
		if(data==1){
			$('.ban').modal('hide');
			$('#ok').modal();
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}
function addvoucher(amount) {
	var token = $('#token').val();
	$.get('ajax/addvoucher.php?amount='+amount+'&token='+token+'', function(data) {
		$('#voucherv').html('<?php echo $lang['NewVoucherIs']; ?>'+data);
		$('#voucherm').modal();
	});
}
function searchusers(value) {
	var token = $('#token').val();
	$('#loaderImg').show();
	$.get('ajax/searchusers.php?search='+value+'&token='+token+'', function(data) {
		$('#resultsSearch').html(data);
		$('#loaderImg').hide();
	});
}
function addhcategory(value) {
	var token = $('#token').val();
	$.get('ajax/addhcategory.php?value='+value+'&token='+token+'', function(data) {
		if(data==1){
			$('#categoryname').val('');
			$('#nocategory').hide();
			$('#addcategoryc').append('<tr><td>'+value+'</td><td><a href="javascript:void(0);" onclick="window.location=\'help.php\';" class="btn btn-primary">Actualiser</a></td></tr>');
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}
function removehcategory(id) {
	var token = $('#token').val();
	$.get('ajax/removehcategory.php?id='+id+'&token='+token+'', function(data) {
		if(data==1){
			$('#category-'+id+'').hide();
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}
function addharticle(cat,title,content) {
	var token = $('#token').val();
	$.post('ajax/addharticle.php',{ cat:cat,title:title,content:content,token:token }, function(data) {
		if(data==1){
			$('#articlescat').val('');
			$('#articlestitle').val('');
			$('.nicEdit-main').html('');
			$('#noarticles').hide();
			$('#addarticlesc').append('<tr><td><a href="javascript:void(0);" onclick="window.location=\'help.php\';" class="btn btn-primary">Actualiser</a></td><td>'+title+'</td><td><a href="javascript:void(0);" onclick="window.location=\'help.php\';" class="btn btn-primary">Actualiser</a></td></tr>');
		} else {
			alert('<?php echo $lang['Error']; ?>');
			alert(data);
		}
	});
}
function removeharticles(id) {
	var token = $('#token').val();
	$.get('ajax/removeharticles.php?id='+id+'&token='+token+'', function(data) {
		if(data==1){
			$('#articles-'+id+'').hide();
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}

function editServer(){
	var token = $('#token').val();
	var ip = $('#inip').val();
	var texts = $('#intexts').val();
	var vars = $('#invars').val();
	var swf = $('#inswf').val();
	$.get('ajax/editserver.php?server_ip='+ip+'&server_texts='+texts+'&server_vars='+vars+'&server_swf='+swf+'&token='+token+'',function(data){
		if(data == 1){
			$('#ok').modal();
		}
		 else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}

function removeban(id){
	var token = $('#token').val();
	$.post('ajax/removeban.php',{id:id,token:token},function(data){
		if(data == 1){
			$('#l'+id+'').hide();
		}
		else {
			alert('<?php echo $lang['Error']; ?>');
			if(data == 'token'){
				alert('Erreur token');
			}
		}
	});
}


function removebadges(userid,badgeid) {
	var token = $('#token').val();
	$.get('ajax/removebadges.php?uid='+userid+'&bid='+badgeid+'&token='+token+'', function(data) {
		if(data==1){
			$('#badge-'+badgeid+'').hide();
		} else {
			alert('<?php echo $lang['Error']; ?>');
		}
	});
}

function addbadges(uid,bid) {
	var token = $('#token').val();
	$.get('ajax/addbadges.php?uid='+uid+'&bid='+bid+'&token='+token+'', function(data) {
		if(data==1){
			$('#bid'+uid+'').val('');
			$('#nobadges'+uid+'').hide();
			$('#addbadge'+uid+'').append('<tr id="badge'+uid+bid+'"><td>'+bid+'</td><td><a href="javascript:void(0);" onclick=\'removebadges('+uid+',"'+bid+'");$("#badge'+uid+bid+'").hide();\' class="btn btn-danger">Supprimer</a></td></tr>');
		} else {
			alert(data);
		}
	});
}

function deleteBadgesManager(id){
	var token = $('#token').val();
	$.post('ajax/deleteBadgesManage.php',{ id:id,token:token },function(data){
	if(data == '1'){
		$('#b'+id+'').fadeOut();
	}
	else{
		alert(data);
	}
	});
}

function addbadgesManage(id,prix){
	var token = $('#token').val();
	if(id == ""){ alert('ID Badge SVP'); exit; }
	if(prix == ""){ alert('Prix SVP'); exit;}
	$.post('ajax/addBadgesManage.php',{ idbadge:id,amount:prix,token:token }, function(data){
	if($.isNumeric(data)){
		$('#badgesB').val('');
		$('#prix').val('');
		$('#newbadge').append('<tr id="b'+data+'"><td>'+id+'</td><td>'+prix+'</td><td style="text-align:center;"><img src="http://images.habbo.com/c_images/album1584/'+id+'.gif" ></img></td><td style="text-align:center;"><button type="button" onclick="deleteBadgesManager('+data+')" class="btn btn-danger big btn-big"><?php echo $lang['Delete']; ?></button></td></tr>');
    $('#badges').modal('hide');
    	}else {
			if(data == 'ERRORTOKEN'){
				alert('<?php echo $lang['ErrorToken']; ?>');	
			}else
			alert('<?php echo $lang['Error']; ?>');
		}
		});
	}
		
function addPage(ide){
	var title = $('#titlenews').val();
	var content = $('.nicEdit-main').html()
	var token = $('#token').val();	
		if(title == ""){ alert('<?php echo $lang['TitleNeed'] ; ?>'); return false ; }
		if(content == ""){ alert('<?php echo $lang['ContentNeed'] ; ?>'); return false ; }
		
	if(ide == 0){
		$.post('ajax/addPage.php', { title:title,content:content,token:token}, function(data){
			if(data == 1){
				$('#titlenews').val('');
				$('#tai').html('');
				$('#postpageload').modal();
				setTimeout("document.location.reload();",2000);
			}
			else {
			alert('<?php echo $lang['Error']; ?>');
		}
		});
	}
	if(ide != 0){
		$.post('ajax/addPage.php', { title:title,content:content,token:token,id:ide}, function(data){
		
			if(data == 1){
				$('#postpageload').modal();
				setTimeout("document.location.reload();",2000);
			}
			else {
			alert('<?php echo $lang['Error']; ?>');
		}
		});
	}
		
		
}

function deletePage(id){
	var token = $('#token').val();	
	$.post('ajax/deletePage.php',{ id:id,token:token },function(data){
		$('#l'+id+'').fadeOut();
	});
}

function displayMail(){
	var mailType = $("#ServerPredifined").val();
	if(mailType == "Autre"){
	$("#mailAutre").slideDown();
	}
	else{
		$("#mailAutre").slideUp();
	}
}


</script>

<style>
.nicEdit-main {
	background:#fff;
}
.imagenewsa {
	-webkit-box-shadow: 0px 0px 7px rgba(39, 160, 255, 0.7);
	-moz-box-shadow: 0px 0px 7px rgba(39, 160, 255, 0.7);
	box-shadow: 0px 0px 7px rgba(39, 160, 255, 0.7);
}
.preview
{
width:695px;
height:275px;
text-align:center;
}
#preview
{
color:#cc0000;
font-size:12px
}
.fileinput-button {
  position: relative;
  overflow: hidden;
  float: left;
  margin-right: 4px;
}
.fileinput-button input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  border: solid transparent;
  border-width: 0 0 100px 200px;
  opacity: 0;
  filter: alpha(opacity=0);
  -moz-transform: translate(-300px, 0) scale(4);
  direction: ltr;
  cursor: pointer;
}
.fileupload-buttonbar .btn,
.fileupload-buttonbar .toggle {
  margin-bottom: 5px;
}
.files .progress {
  width: 200px;
}
.progress-animated .bar {
  background: url(../img/progressbar.gif) !important;
  filter: none;
}
.fileupload-loading {
  position: absolute;
  left: 50%;
  width: 128px;
  height: 128px;
  background: url(../img/loading.gif) center no-repeat;
  display: none;
}
.fileupload-processing .fileupload-loading {
  display: block;
}

/* Fix for IE 6: */
*html .fileinput-button {
  line-height: 22px;
  margin: 1px -3px 0 0;
}

/* Fix for IE 7: */
*+html .fileinput-button {
  margin: 1px 0 0 0;
}

@media (max-width: 480px) {
  .files .btn span {
    display: none;
  }
  .files .preview * {
    width: 40px;
  }
  .files .name * {
    width: 80px;
    display: inline-block;
    word-wrap: break-word;
  }
  .files .progress {
    width: 20px;
  }
  .files .delete {
    width: 60px;
  }
}

</style>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>

<script type="text/javascript" >
		$(document).ready(function() { 
		
            $('#photoimg').live('change', function() { 
			           $("#preview").html('');
			    $("#preview").html('<center><img src="assets/img/loader.gif" /></center>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
        }); 
</script>

<script type="text/javascript" >
		$(document).ready(function() { 
		
            $('#photoimglogo').live('change', function() { 
			           $("#logoupdatesubmited").html('');
			    $("#preview").html('<center><img src="assets/img/loader.gif" /></center>');
			$("#imageformlogo").ajaxForm({
						target: '#logoupdatesubmited'
		}).submit();
		
			});
        }); 
        
(function($, window, document, undefined) {
	$.fn.quicksearch = function (target, opt) {
		
		var timeout, cache, rowcache, jq_results, val = '', e = this, options = $.extend({ 
			delay: 100,
			selector: null,
			stripeRows: null,
			loader: null,
			noResults: '',
			matchedResultsCount: 0,
			bind: 'keyup',
			onBefore: function () { 
				return;
			},
			onAfter: function () { 
				return;
			},
			show: function () {
				this.style.display = "";
			},
			hide: function () {
				this.style.display = "none";
			},
			prepareQuery: function (val) {
				return val.toLowerCase().split(' ');
			},
			testQuery: function (query, txt, _row) {
				for (var i = 0; i < query.length; i += 1) {
					if (txt.indexOf(query[i]) === -1) {
						return false;
					}
				}
				return true;
			}
		}, opt);
		
		this.go = function () {
			
			var i = 0,
				numMatchedRows = 0,
				noresults = true, 
				query = options.prepareQuery(val),
				val_empty = (val.replace(' ', '').length === 0);
			
			for (var i = 0, len = rowcache.length; i < len; i++) {
				if (val_empty || options.testQuery(query, cache[i], rowcache[i])) {
					options.show.apply(rowcache[i]);
					noresults = false;
					numMatchedRows++;
				} else {
					options.hide.apply(rowcache[i]);
				}
			}
			
			if (noresults) {
				this.results(false);
			} else {
				this.results(true);
				this.stripe();
			}
			
			this.matchedResultsCount = numMatchedRows;
			this.loader(false);
			options.onAfter();
			
			return this;
		};
		
		/*
		 * External API so that users can perform search programatically. 
		 * */
		this.search = function (submittedVal) {
			val = submittedVal;
			e.trigger();
		};
		
		/*
		 * External API to get the number of matched results as seen in 
		 * https://github.com/ruiz107/quicksearch/commit/f78dc440b42d95ce9caed1d087174dd4359982d6
		 * */
		this.currentMatchedResults = function() {
			return this.matchedResultsCount;
		};
		
		this.stripe = function () {
			
			if (typeof options.stripeRows === "object" && options.stripeRows !== null)
			{
				var joined = options.stripeRows.join(' ');
				var stripeRows_length = options.stripeRows.length;
				
				jq_results.not(':hidden').each(function (i) {
					$(this).removeClass(joined).addClass(options.stripeRows[i % stripeRows_length]);
				});
			}
			
			return this;
		};
		
		this.strip_html = function (input) {
			var output = input.replace(new RegExp('<[^<]+\>', 'g'), "");
			output = $.trim(output.toLowerCase());
			return output;
		};
		
		this.results = function (bool) {
			if (typeof options.noResults === "string" && options.noResults !== "") {
				if (bool) {
					$(options.noResults).hide();
				} else {
					$(options.noResults).show();
				}
			}
			return this;
		};
		
		this.loader = function (bool) {
			if (typeof options.loader === "string" && options.loader !== "") {
				 (bool) ? $(options.loader).show() : $(options.loader).hide();
			}
			return this;
		};
		
		this.cache = function () {
			
			jq_results = $(target);
			
			if (typeof options.noResults === "string" && options.noResults !== "") {
				jq_results = jq_results.not(options.noResults);
			}
			
			var t = (typeof options.selector === "string") ? jq_results.find(options.selector) : $(target).not(options.noResults);
			cache = t.map(function () {
				return e.strip_html(this.innerHTML);
			});
			
			rowcache = jq_results.map(function () {
				return this;
			});

			/*
			 * Modified fix for sync-ing "val". 
			 * Original fix https://github.com/michaellwest/quicksearch/commit/4ace4008d079298a01f97f885ba8fa956a9703d1
			 * */
			val = val || this.val() || "";
			
			return this.go();
		};
		
		this.trigger = function () {
			this.loader(true);
			options.onBefore();
			
			window.clearTimeout(timeout);
			timeout = window.setTimeout(function () {
				e.go();
			}, options.delay);
			
			return this;
		};
		
		this.cache();
		this.results(true);
		this.stripe();
		this.loader(false);
		
		return this.each(function () {
			
			/*
			 * Changed from .bind to .on.
			 * */
			$(this).on(options.bind, function () {
				
				val = $(this).val();
				e.trigger();
			});
		});
		
	};

}(jQuery, this, document));

$('input#id_search').quicksearch('table tbody tr');
</script>
<script>
function twitter(){
var url='http://api.twitter.com/1/statuses/user_timeline/HabboPHPCom.json?callback=?'; // make the url
	$.getJSON(url,function(tweet){ // get the tweets
		$("#lasttweet").html(tweet[0].text); // get the first tweet in the response and place it inside the div
	});
}
twitter();
</script>

  </body>
</html>