<style>
label{
	width: 150px;
	float:left;
}
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

                <li class=""><a href="{$config->url_site}/profile.php?page=index">{#Motto#}</a>
                </li>


                <li class="selected">{#password#}
                </li>

                <li ><a href="{$config->url_site}/friendsmanagement.php">{#FriendManagement#}</a>
                </li>

            </ul>
            </div>
</div></div>
</div>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">{#ChangePassword#}</h2>
            <div class="box-content">
            



<h3>{#FacebookError#}</h3>

<div id="error-messages-container" class="">
            <div class="rounded" style="background-color: #cb2121;">
               <div id="error-title" class="">
                    {#profile_error_password_fb#}
                </div>
            </div>
        </div>


<script type="text/javascript">
$("profileForm-submit").show();
</script>

</div>
</div>
</div>
</div>
</div>