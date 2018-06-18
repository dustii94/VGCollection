<?php
  include("inc/functions.php");

  $pageTitle = "VG Collection App";

  // Header
  include("inc/header.php");
?>
  <div>
    <h2>Random</h2>
    <?php
      $random = random_game_array();
      echo get_item_html($random);
    ?>
  </div>
<?php
  // Footer
  include("inc/footer.php");
?>
