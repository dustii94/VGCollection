<?php
require 'inc/functions.php';

$pageTitle = "Edit Game";
$page = "editgame";

$message = "";

$name = $age = $gender = '';

if(isset($_GET['id'])){
  $game = get_game(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $game_id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
  $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
  $platform = trim(filter_input(INPUT_POST, 'platform', FILTER_SANITIZE_STRING));
  $release = trim(filter_input(INPUT_POST, 'release', FILTER_SANITIZE_STRING));
  $region = trim(filter_input(INPUT_POST, 'region', FILTER_SANITIZE_STRING));
  $genres = trim(filter_input(INPUT_POST, 'genres', FILTER_SANITIZE_STRING));
  $description = trim(filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING));
  $developers = trim(filter_input(INPUT_POST, 'dev', FILTER_SANITIZE_STRING));
  $publishers = trim(filter_input(INPUT_POST, 'pub', FILTER_SANITIZE_STRING));
  $progress = trim(filter_input(INPUT_POST, 'progress', FILTER_SANITIZE_STRING));
  $score = trim(filter_input(INPUT_POST, 'score', FILTER_SANITIZE_NUMBER_INT));

  if(empty($name)){
    $error_message = 'Please fill out the required fields';
  }
  else{
    if(add_game($name, $platform, $release, $region, $genres, $description, $developers, $publishers, $progress, $score, $game_id)){
      $message = "Updated game \"" . $name. "\"";
      header('location: games.php?msg='. $message);
      exit;
    }
    else{
      $error_message = "Could not update";
    }
  }
}

include 'inc/header.php';
?>
<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Edit Item</h1>
            <?php
            if(isset($error_message)){
              echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="editgame.php">
                <table>
                    <tr>
                        <th><label for="name">Name<span class="required">*</span></label></th>
                        <td><input type="text" id="name" name="name" value="<?php echo $game['name'] ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="platform">Platform<span class="required">*</span></label></th>
                        <td><input type="text" id="platform" name="platform" value="<?php echo $game['platform'] ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="release">Release Date</label></th>
                        <td><input type="text" id="release" name="release" value="<?php echo $game['release_date'] ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="region">Region</label></th>
                        <td><input type="text" id="region" name="region" value="<?php echo $game['region'] ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="genres">Genre(s)</label></th>
                        <td><textarea id="genres" name="genres" rows="5" cols="40"><?php echo $game['genres'];?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="desc">Description</label></th>
                        <td><textarea id="desc" name="desc" rows="5" cols="40"><?php echo $game['description'];?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="dev">Developer(s)</label></th>
                        <td><textarea id="dev" name="dev" rows="5" cols="40"><?php echo $game['developers'];?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="pub">Publisher(s)</label></th>
                        <td><textarea id="pub" name="pub" rows="5" cols="40"><?php echo $game['publishers'];?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="progress">Progress</label></th>
                        <td><input type="text" id="progress" name="progress" value="<?php echo $game['labels'] ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="score">User Score</label></th>
                        <td>
                          <select id="score" name="score">
                              <option value="score:0" <?php if($game['user_rating'] == 0) echo ' selected';?>>0</option>
                              <option value="score:1" <?php if($game['user_rating'] == 1) echo ' selected';?>>1</option>
                              <option value="score:2" <?php if($game['user_rating'] == 2) echo ' selected';?>>2</option>
                              <option value="score:3" <?php if($game['user_rating'] == 3) echo ' selected';?>>3</option>
                              <option value="score:4" <?php if($game['user_rating'] == 4) echo ' selected';?>>4</option>
                              <option value="score:5" <?php if($game['user_rating'] == 5) echo ' selected';?>>5</option>
                              <option value="score:6" <?php if($game['user_rating'] == 6) echo ' selected';?>>6</option>
                              <option value="score:7" <?php if($game['user_rating'] == 7) echo ' selected';?>>7</option>
                              <option value="score:8" <?php if($game['user_rating'] == 8) echo ' selected';?>>8</option>
                              <option value="score:9" <?php if($game['user_rating'] == 9) echo ' selected';?>>9</option>
                              <option value="score:10" <?php if($game['user_rating'] == 10) echo ' selected';?>>10</option>
                          </select>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="id" name="id" value="<?php echo $game['id'] ?>" />
                <input type="button" value="Go back" onclick="history.back()" />
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
