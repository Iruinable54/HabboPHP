<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="{$config->url_site}/web-gallery/js/jquery.dataTables.min.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			$.noConflict();
			jQuery(document).ready(function() {
				jQuery('#example').dataTable({
					 "oLanguage": {
						"sSearch": "{#FindAFriend#}",
						"sLengthMenu": "{#See#} _MENU_ {#friends#}",
						"sEmptyTable": "{#NoFriends#}",
						"sInfo": "",
						"oPaginate": {
        					"sLast": "{#Previous#}",
        					"sNext" : "{#Next#}",
        					"sPrevious": "{#Previous#}"
      					}
				}
				});
			} );
			
			function deleteFriends(oid,tid){
				var token = jQuery("#token").val();
				alert(token);
				jQuery.get('ajax/friends_delete.php?oid='+oid+'&tid='+tid+'&token='+token+'',function(data){
					alert(data);
				if(data == 1)
					jQuery('#remove-friend-button-'+oid).fadeOut();
				});
			}
			
		</script>
<style>


.list:hover{
	background: #EFF0FF;
}


.dataTables_filter{
	float:left;
	width: 300px ;
}

.dataTables_filter label{
	padding: 10px 0 ;
}

.dataTables_length{
	float: right;
}

.dataTables_paginate {
	margin: 10px 0 ;
}

.remove-friend{
	cursor: pointer;
}

	div.paging_two_button a {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		background: #F6F6F6 -webkit-gradient(linear, 0% 0%, 0% 100%, from(white), to(#EFEFEF));
	border: 1px solid #CCC;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	color: #646566;
	text-decoration: none;
	cursor: pointer;
	height: 2.0833em
		}
	div.paging_two_button a:hover, div.digg a:active {
		-webkit-box-shadow: #999 0px 0px 3px;
	background: #F3F3F3 -webkit-gradient(linear, 0% 0%, 0% 100%, from(white), to(#EBEBEB));
	color: #FC6204;
	border-color: #999;
	outline: 0px;
	
	}
	
	tr:nth-child(odd)		{ background-color:#eee; }
tr:nth-child(even)		{ background-color:#fff; }
</style>
<div id="container">
	<div id="content" style="position: relative" class="clear fix">
    <div>

<div class="content">
<div class="habblet-container" style="float:left; width:210px;">
<div class="cbb settings">

<h2 class="title">{#AccountSettings#}</h2>
<div class="box-content">
            <div id="settingsNavigation">
            <ul>

                <li class="slected"><a href="{$config->url_site}/profile.php?page=index">{#Motto#}</a>
                </li>


                 <li class=""><a href="{$config->url_site}/profile.php?page=password">{#Password#}</a>
                </li>
                
         
                <li class="selected" >{#FriendManagement#}
                </li>

            </ul>
            </div>
</div></div>
</div>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">{#FriendManagement#}</h2>
            <div class="box-content">
            
<div id="category-view" class="clearfix">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr style="background-color: #4AB501; color:white ;">
			<th style="height: 20px; padding:0 5px;">{#Name#}</th>
			<th>{#LastConnected#}</th>
			<th>{#Remove#}</th>
		</tr>
	</thead>
	<tbody>

{foreach from=$friends  item=i }
		<tr class="list"  style="height:15px;" id="remove-friend-button-{$i.user_one_id}">
			<td  style="padding-left:5px;">{$i.username}</td>
			<td>{$i.last_online}</td>
		<td class="friend-remove"><a  style="cursor: pointer;" href="javascript:void(0);" onclick="deleteFriends({$i.user_one_id},{$i.user_two_id})"  style="margin-left:10px;" class="friendmanagement-small-icons friendmanagement-remove remove-friend">X</a></td>

		</tr>
		{/foreach}
		
			</tbody>
	
</table>

<script type="text/javascript">
$("profileForm-submit").show();
</script>

</div>
</div>
</div>
</div>
</div>