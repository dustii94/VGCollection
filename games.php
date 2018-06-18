<?php
include("inc/functions.php");

$pageTitle = "Full List";
$search = null;
$items_per_page = 10;

$message = '';

$filter = 'all';

if(!empty($_GET['filter'])){
  $filter = explode(':', filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING));
}

if(isset($_POST['delete'])){
  if(delete_game(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))){
    header('location: games.php?msg=Item+Deleted');
    exit;
  }
  else{
    header('location: games.php?msg=Unable+To+Delete+Item');
    exit;
  }
}

if(isset($_GET['msg'])) {
  $message = filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING);
}

if(isset($_GET["pg"])){
  $current_page = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
}
if(isset($_GET["s"])){
  $search = filter_input(INPUT_GET, "s", FILTER_SANITIZE_STRING);
}
if(empty($current_page)){
  $current_page = 1;
}

$total_items = get_game_count($search, $filter);
$total_pages = 1;
$offset = 0;
if($total_items > 0){
  $total_pages = ceil($total_items / $items_per_page);

  // Limit results in redirect
  $limit_results = "";
  if(!empty($search)){
    $limit_results = "s=" . urlencode(htmlspecialchars($search)) . "&";
  }

  // Redirect too-large page numbers to last page
  if($current_page > $total_pages){
    header("location:games.php?"
    . $limit_results
    . $filter[0] . "&"
    . "pg=" .$total_pages);
  }
  // Redirect too-small page numbers to first page
  if($current_page < 1){
    header("location:games.php?"
    . $limit_results
    . $filter[0] . "&"
    . "pg=1");
  }

  // Determine the offset (number of items to skip for the current page). Example: Pg 3 / 8 --> offest would be 16
  $offset = ($current_page - 1) * $items_per_page;

  // Pagination
  $pagination = "<div class=\"pagination\">";
  $pagination .= "Pages: ";
  // First Page
  if($current_page == 1){
    $pagination .= " <span>1</span>";
  }
  else{
    if(is_array($filter)){
      $pagination .= " <a href='games.php?pg=1&filter=$filter[0]%3A$filter[1]'>1</a>";
    }
    else{
      $pagination .= " <a href='games.php?pg=1'>1</a>";
    }
  }
  // Limit number of pages
  for($i = 2; $i <= $total_pages; $i++) {
    if(($i > $current_page+3 || $i <  $current_page-3) && $i <= $total_pages-2){
      if (substr_count($pagination, '...') < 1 || $i == $total_pages-2) {
        $pagination .= " ... ";
      }
      continue;
    }
    if($i == $current_page){
      $pagination .= " <span>$i</span>";
    }
    else{
      if(is_array($filter)){
        $pagination .= " <a href='games.php?pg=$i'>$i</a>";
      }
      else{
        $pagination .= " <a href='games.php?pg=$i'>$i</a>";
      }
    }
  }
  $pagination .= "</div>";
}

// Get list
if(!empty($search)){
  $games = search_game_array($search, $items_per_page, $offset);
  $pageTitle = "Search results for $search";
}
else{
  $games = full_game_list_array($items_per_page, $offset, $filter);
}

// Header
include("inc/header.php");
?>

<h1><?php
if($search != null){
  echo "Search results for \"". htmlspecialchars($search) ."\"";
}
else{
  echo $pageTitle;
}
?></h1>

<?php
  echo "<p>Total games: " . get_game_count() . "</p>";
  if($search != null){
    echo "<p>" . get_game_count($search) . " results found with search \"". htmlspecialchars($search) ."\"</p>";
  }
?>

<?php if($message) echo $message; ?>

<!-- <form class='form-container form-report' action='games.php' method='get'>
  <label for='filter'>Filter By:</label>
  <select id='filter' name='filter'>
    <option value=''>Select One</option>
    <optgroup label="Gender">
      <option value="gender:Male">Male</option>
      <option value="gender:Female">Female</option>
      <option value="gender:???">???</option>
    </optgroup>
    <optgroup label="Age">
      <option value="age:0:10">0-10</option>
      <option value="age:11:20">11-20</option>
      <option value="age:21:30">21-30</option>
      <option value="age:31:40">31-40</option>
      <option value="age:41:50">41-50</option>
      <option value="age:51:60">51-60</option>
      <option value="age:61:70">61-70</option>
      <option value="age:71:80">71-80</option>
      <option value="age:81:90">81-90</option>
      <option value="age:91:100">91-100</option>
      <option value="age:101">101+</option>
    </optgroup>
  </select>
  <input class="button" type="submit" value="Run" />
</form> -->

<?php
  if($total_items < 1){
    echo "<p> No items were found matching that search term. </p>";
  }
  else{
    echo $pagination;
?>

<ul class="items">
    <?php
      echo get_item_html($games);
    ?>
</ul>

<?php echo $pagination; } ?>
</body>
</html>
