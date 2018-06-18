<?php
require 'inc/functions.php';

$pageTitle = "Details";
$page = "game";

$name = $age = $gender = '';

if(isset($_GET['id'])){
  $game = get_game(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
}

include 'inc/header.php';
?>
<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Game Details</h1>
            <?php
            if(isset($error_message)){
              echo "<p class='message'>$error_message</p>";
            }
            echo "<p>Name: ". $game['name'] ."</p>";
            echo "<p>Platform: ". $game['platform'] ."</p>";
            echo "<p>Release Date: ". $game['release_date'] ."</p>";
            echo "<p>Region: ". $game['region'] ."</p>";
            echo "<p>Genre(s): ". $game['genres'] ."</p>";
            echo "<p>Description: ". $game['description'] ."</p>";
            echo "<p>Developer(s): ". $game['developers'] ."</p>";
            echo "<p>Publisher(s): ". $game['publishers'] ."</p>";
            echo "<p>Progress: ". $game['labels'] ."</p>";
            echo "<p>User Score: ". $game['user_rating'] ."</p>";
            echo "<a href='editgame.php?id=" . $game['id'] . "'>Edit</a>"
            ?>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
