<?php include "includes/header.php"; ?>
<?php if(Tools::checkACL($user->rank,ACL_LOGS_VIEW)) {  ?>
<header class="jumbotron subhead" id="overview">
  <h1>Admin logs</h1>
</header>

<script>

</script>

<section id="server">

<input type="text" name="search" value="" id="id_search" placeholder="<?php echo $lang['Search']; ?>" />

 <table  class="table table-bordered table-striped">
  <thead>
    <tr style="background:white;">
      <th><?php echo $lang['Username']; ?></th>
      <th><?php echo $lang['Action']; ?></th>
      <th><?php echo $lang['Date']; ?></th>
      <th>IP</th>
    </tr>
  </thead>
  <tbody>
  <?php
   $req = mysql_query('SELECT * FROM habbophp_logs ORDER BY id DESC LIMIT 300');
   while($data = mysql_fetch_assoc($req)){
  ?>
    <tr id="l<?php echo $data['id']; ?>">
      <td><?php echo $data['user'] ;?></td>
      <td><?php echo $data['action'] ;?></td>
      <td><?php echo $data['date']; ?></td>
      <td><?php echo $data['ip'] ;?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

</section>

<?php } ?>
<?php include "includes/footer.php"; ?>