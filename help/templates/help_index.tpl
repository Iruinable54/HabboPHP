
  <div id="solution_suggestion">
<div class="content content_green"><div class="green_box_top"><div class="box box_top"></div></div>    <h2 id="search_box">FAQ</h2>
    <form id="suggest_form" action="search.php">
      <input id="suggestions_query" name="suggestions_query" type="text">
      <input class="button search primary" id="suggestion_submit"  type="submit" value="Recherche">
   
    </form>

      <div id="topic_search_loading"></div>
<div id="topic_search" style="display:none;">
  <div class="frame" style="margin-top: 15px; padding-bottom: 20px;">
    <div id="topic_search_result"></div>


    <h2 style="margin-top: 5px; padding-top: 12px;">Ce n'est pas ce que vous cherchez ?</h2>



    <div class="deflect tickets" id="ticket-deflect">
      <h3>Contactez notre équipe :</h3>
      <ul><li><a href="">Remplissez le formulaire de demande</a></li></ul>
    </div>

    <div style="clear:both;"></div>
  </div>
</div>

<div class="green_box_bottom"><div class="box box_bottom"></div></div>
</div><div class="box_bottom_clear">&nbsp;</div></div>


















  <div class="forum_tabs">
<div class="content content_grey"><div class="grey_box_top"><div class="box box_top"></div></div>      
  <p class="forum-nav">
    <a href="index.php" id="forum_nav_overview" url="index.php" class="active">Voir tous</a>
    <span class="delim">|</span>
    <a href="category.php">Derniers</a>
  </p>



      <div id="content_entries">
        <div class="frame columns">


<div>
          
        

  <div class="category" id="category_none">

<div class="column" id="forum_278771">
  <h3 class="clearfix">
    <a href="category.php">
      <span>Les derniers!</span>
      <span class="sub-counter">({$totallast})</span>
      <span class="follow_link">»</span>
    </a>

  </h3>

  <ul>
  	 {foreach from=$last key=k item=i}
<li class="fade_truncation_outer articles ">
          <div class="fade_truncation_inner"></div>
          <span style="display: block; position: relative; ">
            <a href="more.php?id={$i.id}" title="{$i.id}">{$i.title}</a>
          <span class="faded_truncation" style="height: 14px; display: block; "><span class="faded_truncation" style="height: 14px; "></span></span><span class="faded_truncation" style="height: 14px; "></span></span>
        </li>
{/foreach}
  </ul>
</div>






    <div style="clear:both; height:0px;">&nbsp;</div>
  </div>


      </div>





<div class="category-header">
    <h2><a href="file://localhost/Users/Valentin/Downloads/help.habbo.fr/categories/5796-questions-frequentes/index.html">Questions fréquentes<span class="follow_link">»</span></a></h2>
</div>
  





<div class="category" id="category_5796" data-category_path="/categories/5796-questions-frequentes">




{$category}










<div style="clear:both; height:0px;">&nbsp;</div>
  </div>



</div>

      </div>
      
      







<div class="grey_box_bottom"><div class="box box_bottom"></div></div></div><div class="box_bottom_clear">&nbsp;</div>  </div>















  
  
  
  
  
  



    </div>
  </div>



</div>


  </div>