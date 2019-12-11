<?php function draw_header($page_id,$username, $script) { 
  $notifications = getUnseenNotifications($username);
?>
  <!DOCTYPE html>
  <html lang="en">

    <head>
      <title>Super Houses</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="../css/responsive.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
      <link rel="icon" type="image/png" href="../css/favicon-16x16.png">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="../js/ajax.js" defer></script>
      <script src="../js/general.js" defer></script>
      <script src="../js/notifications.js" defer></script>
      <?php if ($script != null) { ?>
        <script src="<?=$script?>" defer></script>
      <?php } ?>
    </head>

    <body id=<?= $page_id?>>

      <header id="pagebanner">        
        <section id="pagetop">
          
          <h1>
            <a href="../index.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="933.3" height="705.3" viewBox="0 0 700 529"><path d="M84.7 73.4L28 129.6l.5 370.5L356 499c2-.8 6.8-5.5 14.6-14.6l23.7-27 18.3-20.6a339 339 0 0 1 13-14.1l14.5-16c4.2-5 8.8-10 10.2-11.5l9.8-11A1626 1626 0 0 1 502 337l22.6-25a1610 1610 0 0 1 37.4-42l32.8-37a270 270 0 0 1 11.1-12.6l12.6-14c8.5-10 14.7-16.5 16-16.5.8 0 .1 306.3-.7 310.3-.1 1 6.2 1.3 24.6 1.5l24.7.2 1-368.5c1.7-1 1-4.3-1-5.8a539 539 0 0 1-15.2-13.9L563.7 17H141.5L84.7 73.4zM497 64.6c0 2.3-3.2 7.4-4.6 7.4-1.3 0-7.4-6.8-7.4-8.2 0-.5 2.7-.8 6-.8 4.8 0 6 .3 6 1.6zM184.4 68c.3.4-1.4 2.3-3.7 4.2A497 497 0 0 0 164.6 87c-13.3 13-21 23.7-29.4 41-5 10.3-11.2 27.5-11.2 31.2 0 1-.6 1.8-1.2 1.7a185 185 0 0 1-22.6-26c-.3-1.8 13.7-16 44-45.2L168 67h8c4.4 0 8.2.4 8.5 1zm176 .6a138 138 0 0 1 49 13.6c13.8 6.7 24.2 14.2 28.5 20.4 5 7.4 12.5 28 13.8 38.2l.7 5.8h118l-.3-24.3c-.3-21-.2-24.2 1.2-24.2.8 0 8.2 6 16.4 13.2l19.5 17c5.3 4.3 5.7 5.7 2.4 8.4A217 217 0 0 0 599 148l-47 51.3c-.3.4-5-3.7-10.6-9.2l-15-12.4-32.2-15.7a71 71 0 0 1-8.7-2.4c-4-1.4-12.3-3.4-18.3-4.5l-15-3a53 53 0 0 0-10.6-1 35 35 0 0 1-9.2-1c-2.2-.8-54.7-2-71-1.8-13.8.2-59-1.8-68-3-27-4-30-4.7-47.2-14-1.3-.8-3.8-3.5-5.4-6-2.5-4-3-5.6-3-11.4 0-8.3 2.4-13.7 8.3-18.8a88 88 0 0 1 18.2-12.4l8.5-4c10-4.7 16.7-6.5 38.5-10.5 8-1.4 37-1.3 49 .3zM82.3 193.3l33.2 37a1585 1585 0 0 0 36 40.1l25 28c8.7 10 18.5 21 22 25L218 345c1.6 1.4 7 7 11.7 12.6 4.8 5.6 15 17.2 22.7 25.8l20.5 23.3a356 356 0 0 0 16 17.7l30 34a6447 6447 0 0 1-120.2.4l-120.3-.3L77.3 189c.5 0 2.7 2 5 4.3zM215.5 244l123.5 8a1044 1044 0 0 1 39 2.1c56.3 5 78.8 9 90.2 16.7 6.5 4.2 5 7.8-6.6 14.7-7.5 4.5-17 7.4-35 10.6-12 2-33.5 3.7-54.6 4l-15.7.2-4.4-4.6a128 128 0 0 0-25.7-18.9 109 109 0 0 0-57.3-9.9c-13 1.4-20.8 3.7-29.5 9a40 40 0 0 1-7.7 3.9 60 60 0 0 1-9.1-9.7l-10-11.8C206 251.3 200 244 200 243c0-.8 1.2-1 3.8-.6l11.7 1.6zM406 357a202 202 0 0 1-14.7 17.5L367 401.8c-5 6-10 10.7-10.7 10.7a854 854 0 0 1-52.9-55.3 97 97 0 0 1 14.7.9c23.4 2.3 70 1.2 87-2 .4 0 .7.4.7 1z"/></svg>
              <div>
                <p>Super Houses</p>
                <small>We rent.</small>
              </div>
            </a>
          </h1>          
          <?php if ($username != NULL) { ?>
            <nav>
              <ul>
                <li id="notifications">
                  <i id="notificationBell" class="far fa-bell"></i>
                  <span id="notificationNum"><?=count($notifications)?></span>
                  <?=drawNotificationList($notifications)?> 
                </li>
                <li>Signed in as <a id="loggeduser" href="profile.php"><?=$username?></a></li>
                <li><a id="logoutbutton" href="../actions/action_logout.php">Logout</a></li>
              </ul>
            </nav>
          <?php } ?>
        </section>
      </header>
      <?php if (isset($_SESSION['messages'])) {?>
        <section id="sessionMessages">
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

<?php function drawNotificationList($notifications) { ?>
  <ul id="notificationList">
    <?php foreach ($notifications as $notif) { ?>
      <li class="notifUnseen">
        <span class="notifId hidden"><?=$notif->getID()?></span>
        <a class="notifClickable" href="../actions/action_viewNotification.php?id=<?=$notif->getID()?>">
          <p class="notifContent"><?=toHTML($notif->getContent())?></p>
          <span class="notifDate"><?=toHTML($notif->getDateString())?></span>
        </a>
        <span class="notifMarkAsSeen clickable"><i class="fas fa-eye"></i></span>
      </li>
    <?php } ?>
  </ul>
<?php } ?>