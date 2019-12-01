<?php function draw_header($username, $script) { 
  include_once('../database/db_notifications.php');
  $notifications = getUnseenNotifications($username);
?>
  <!DOCTYPE html>
  <html lang="en">

    <head>
      <title>Super Houses</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
      <link rel="icon" type="image/png" href="../css/favicon-16x16.png">
      <?php if ($script != null) { ?>
        <script src="<?=$script?>" defer></script>
      <?php } ?>
      <script src="../js/ajax.js" defer></script>
      <script src="../js/general.js" defer></script>
      <script src="../js/notifications.js" defer></script>
    </head>

    <body>

      <header id="pagebanner">        
        <section id="pagetop">
          <h1>
            <a href="../index.php">Super Houses</a>
            <small>We rent.</small>
          </h1>          
          <?php if ($username != NULL) { ?>
            <nav>
              <ul>
                <li id="notifications">
                  <i id="notificationBell" class="far fa-bell"></i>
                  <span id="notificationNum"><?=count($notifications)?></span>
                  <?=drawNotificationList($notifications)?> 
                </li>
                <li>Signed in as <a id="loggeduser" href="editprofile.php"><?=$username?></a></li>
                <li><a id="logoutbutton" href="../actions/action_logout.php">Logout</a></li>
              </ul>
            </nav>
          <?php } ?>
        </section>
      </header>
      <?php if (isset($_SESSION['messages'])) {?>
        <section id="messages">
          <?php foreach($_SESSION['messages'] as $message) { ?>
            <div class="<?=$message['type']?>"><?=$message['content']?></div>
          <?php } ?>
        </section>
      <?php unset($_SESSION['messages']); } ?>
<?php } ?>

<?php function draw_footer() { 
/**
 * Draws the footer for all pages.
 */ ?>
  </body>
</html>
<?php } ?>

<?php function drawEmptyNotificationList() { ?>
  <ul id="notificationList">
    <li><p class="notifContent">No notifications</p></li>
  </ul>
<?php } ?>

<?php function drawNotificationList($notifications) { ?>
  <ul id="notificationList">
    <?php foreach ($notifications as $notif) { ?>
      <li class="<?=$notif['seen']?'notifSeen':'notifUnseen'?>">
        <span class="notifId hidden"><?=$notif['id']?></span>
        <a class="notifClickable" href="../actions/view_notification.php?id=<?=$notif['id']?>">
          <p class="notifContent"><?=toHTML($notif['content'])?></p>
          <span class="notifDate"><?=toHTML($notif['dateTime'])?></span>
        </a>
        <span class="notifMarkAsSeen"><i class="fas fa-eye"></i></span>
      </li>
    <?php } ?>
  </ul>
<?php } ?>