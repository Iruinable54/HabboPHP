
<div class="content content_grey"><div class="grey_box_top"><div class="box box_top"></div></div>  <div class="content-top-right top">
    <p>
      
    </p>
  </div>

  <h2 class="forums"><a href="/help/">{#logout#} ( {$total_rows} réponse{if $total_rows gt 1}s{/if}  )</a></h2>
{if $total_rows == 0}
Pas de résultat
{/if}
{if isset($data)}
{foreach from=$data key=k item=i}
  <div class="frame">
    <div class="entry nobottom" style="padding-bottom:0;">
      
      <h3 class="entry-title" style="padding-bottom: 9px;"> <a href="more.php?id={$i.id}">{$i.title}</a></h3>


      <div class="user_formatted header_section clearfix">
        <p>{$i.articles}</p>
      </div>
      

      <table class="entry_footer header_section for_vote for_share_buttons">
        <tbody>
          <tr>
            <td>
              <div class="" id="voting_control"></div>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
{/foreach}
{/if}
<div class="grey_box_bottom"><div class="box box_bottom"></div></div></div><div class="box_bottom_clear">&nbsp;</div>
<div class="forum_tabs">
<div class="content content_green"><div class="green_box_top"><div class="box box_top"></div></div>

<div class="green_box_bottom"><div class="box box_bottom"></div></div></div><div class="box_bottom_clear">&nbsp;</div></div>
</div>