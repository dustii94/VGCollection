<?php
require 'inc/functions.php';

$pageTitle = "Add Game";
$page = "addgame";

$name = $platform = $release = $progress = $score = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
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

  if(empty($name) || empty($platform)){
    $error_message = 'Please fill out the required fields';
  }
  else{
    if(add_game($name, $platform, $release, $region, $genres, $description, $developers, $publishers, $progress, $score)){
      header('location: games.php?msg="Item added"');
      exit;
    }
    else{
      $error_message = "Could not add game";
    }
  }
}

include 'inc/header.php';
?>
<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            <h1 class="actions-header">Add Game</h1>
            <?php
            if(isset($error_message)){
              echo "<p class='message'>$error_message</p>";
            }
            ?>
            <form class="form-container form-add" method="post" action="addgame.php">
                <table>
                    <tr>
                        <th><label for="name">Name<span class="required">*</span></label></th>
                        <td><input type="text" id="name" name="name" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="platform">Platform<span class="required">*</span></label></th>
                        <td><input type="text" id="platform" name="platform" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="release">Release Date</label></th>
                        <td><input type="text" id="release" name="release" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="region">Region</label></th>
                        <td><input type="text" id="region" name="region" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="genres">Genre(s)</label></th>
                        <td><textarea id="genres" name="genres" rows="5" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="desc">Description</label></th>
                        <td><textarea id="desc" name="desc" rows="5" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="dev">Developer(s)</label></th>
                        <td><textarea id="dev" name="dev" rows="5" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="pub">Publisher(s)</label></th>
                        <td><textarea id="pub" name="pub" rows="5" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="progress">Progress</label></th>
                        <td><input type="text" id="progress" name="progress" value="" /></td>
                    </tr>
                    <tr>
                        <th><label for="score">User Score</label></th>
                        <td>
                          <select id="score" name="score">
                              <option value="score:0">0</option>
                              <option value="score:1">1</option>
                              <option value="score:2">2</option>
                              <option value="score:3">3</option>
                              <option value="score:4">4</option>
                              <option value="score:5">5</option>
                              <option value="score:6">6</option>
                              <option value="score:7">7</option>
                              <option value="score:8">8</option>
                              <option value="score:9">9</option>
                              <option value="score:10">10</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
