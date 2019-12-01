<?php
  include_once('../database/db_notifications.php');

 function draw_header($username) { 
  $notifications = getUnseenNotifications($username);
?>
  <!DOCTYPE html>
  <html>

    <head>
      <title>Super Houses</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
      <link rel="icon" type="image/png" href="../css/favicon-16x16.png">
      <script src="../js/main.js" defer></script>
    </head>

    <body>

      <header id="pagetop">        
        <span>
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
                  <ul id="notificationList">
                    <?php foreach ($notifications as $notif) { ?>
                      <li class="<?=$notif['seen']?'':'notifUnseen'?>">
                        <a class="notifClickable" href="../actions/view_notification.php?id=<?=$notif['id']?>">
                          <p class="notifContent"><?=$notif['content']?></p>
                          <span class="notifDate"><?=$notif['dateTime']?></span>
                        </a>
                        <span class="notifMarkAsSeen"><i class="fas fa-eye"></i></span>
                      </li>
                    <?php } ?>
                  </ul>
                </li>
                <li>Signed in as <a id="loggeduser" href="editprofile.php"><?=$username?></a></li>
                <li><a id="logoutbutton" href="../actions/action_logout.php">Logout</a></li>
              </ul>
            </nav>
          <?php } ?>
        </span>
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