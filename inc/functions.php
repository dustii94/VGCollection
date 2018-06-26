<?php
/**
 * Returns a full list of games from the database
 * @param  integer  $limit  How many items to show on one page
 * @param  integer $offset The offset for subsquent page
 * @param string $filter Filter criteria
 * @return array List of games
 */
function full_game_list_array($limit = null, $offset = 0, $filter = null){
  // Connect to database
  include "connection.php";

  // Run query
  try{
    $sql = "SELECT id, name, platform, release_date, publishers, labels, user_rating
            FROM games";
    $where = filter($filter);

    if(is_integer($limit)){
      $results = $db->prepare($sql . $where . " LIMIT ? OFFSET ?");
      if(is_array($filter)){
        $results->bindValue(1, $filter[1]);
        if($filter[2]){
          $results->bindValue(2, $filter[2], PDO::PARAM_STR);
          $results->bindParam(3, $limit, PDO::PARAM_INT);
          $results->bindParam(4, $offset, PDO::PARAM_INT);
        }
        else{
          $results->bindParam(2, $limit, PDO::PARAM_INT);
          $results->bindParam(3, $offset, PDO::PARAM_INT);
        }
      }
      else{
        $results->bindParam(1, $limit, PDO::PARAM_INT);
        $results->bindParam(2, $offset, PDO::PARAM_INT);
      }
    }
    else{
      $results = $db->prepare($sql. $where);
    }
    $results->execute();
  } catch(Exception $e){
    echo "Unable to retrieve results... --> " . $e->getMessage();
  }

  // Get results
  $games = $results->fetchAll();

  // Close connection
  $db = null;

  return $games;
}

/**
 * Adds a game to the database
 * @param int $game_id ID of existing game; used for editing
 * @return true if successful
 */
function add_game(
  $name = "",
  $platform = "",
  $release = "",
  $region = "",
  $genres = "",
  $description = "",
  $developers = "",
  $publishers = "",
  $progress = "Unplayed",
  $score = null,
  $game_id = null
){
  try{
    // Connect to database
    include 'connection.php';
    if($game_id){
      $sql = 'UPDATE games SET
      name = ?,
      platform = ?,
      release_date = ?,
      region = ?,
      genres = ?,
      description = ?,
      developers = ?,
      publishers = ?,
      labels = ?,
      user_rating = ?
      WHERE id = ?';
    }
    else{
      $sql = 'INSERT INTO games(name, platform, release_date, region, genres, description, developers, publishers, labels, user_rating)
      VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    }
    $results = $db->prepare($sql);
    $results->bindValue(1, $name, PDO::PARAM_STR);
    $results->bindValue(2, $platform, PDO::PARAM_STR);
    $results->bindValue(3, $release, PDO::PARAM_STR);
    $results->bindValue(4, $region, PDO::PARAM_STR);
    $results->bindValue(5, $genres, PDO::PARAM_STR);
    $results->bindValue(6, $description, PDO::PARAM_STR);
    $results->bindValue(7, $developers, PDO::PARAM_STR);
    $results->bindValue(8, $publishers, PDO::PARAM_STR);
    $results->bindValue(9, $progress, PDO::PARAM_STR);
    $results->bindValue(10, $score, PDO::PARAM_INT);
    if($game_id){
      $results->bindValue(11, $game_id, PDO::PARAM_INT);
    }
    $results->execute();
    return true;
  } catch(Exception $e){
    echo "Whoops... "  . $e->getMessage() . "<br />" ;
    return false;
  }
}

/**
 * Adds a game to the database
 * @return true if successful
 */
function delete_game($game_id){
  try{
    include 'connection.php';
    $sql = 'DELETE FROM games WHERE id = ?';
    $results = $db->prepare($sql);
    $results->bindValue(1, $game_id, PDO::PARAM_INT);
    $results->execute();
  } catch(Exception $e){
    echo "Whoops... "  . $e->getMessage() . "<br />" ;
    return false;
  }
  if($results->rowCount() > 0){
    return true;
  }
  else{
    return false;
  }
}

/**
 * Adds a game to the database
 * @return array List of games if successful
 */
function get_game($game_id){
  try{
    include 'connection.php';
    $sql = 'SELECT * FROM games WHERE id = ?';
    $results = $db->prepare($sql);
    $results->bindValue(1, $game_id, PDO::PARAM_INT);
    $results->execute();
  } catch(Exception $e){
    echo "Whoops... "  . $e->getMessage() . "<br />" ;
    return false;
  }
  if($results->rowCount() > 0){
    return $results->fetch();
  }
  else{
    return false;
  }
}

/**
 * Returns a list of games from the database based on search criteria
 * @param  string  $search Search input from the user
 * @param  integer  $limit  How many items to show on one page
 * @param  integer $offset The offset for subsquent page
 * @return array List of games
 */
function search_game_array($search, $limit = null, $offset = 0){
  include "connection.php";
  try{
    $sql = "SELECT DISTINCT id, name, platform, release_date, publishers, labels, user_rating
          FROM games
          WHERE name LIKE ?";
    $results = $db->prepare($sql);
    if(is_integer($limit)){
      $results = $db->prepare($sql . " LIMIT ? OFFSET ?");
      $results->bindValue(1, "%".$search."%", PDO::PARAM_STR);
      $results->bindParam(2, $limit, PDO::PARAM_INT);
      $results->bindParam(3, $offset, PDO::PARAM_INT);
    }
    else{
      $results = $db->prepare($sql);
      $results->bindValue(1, "%".$search."%", PDO::PARAM_STR);
    }
    $results->execute();
  } catch(Exception $e){
    echo "Unable to retrieve results... " . $e->getMessage() . "\n";
  }
  $games = $results->fetchAll();

  // Close connection
  $db = null;

  return $games;
}

/**
 * Queries the count of items in a table and returns that count
 * @param  string  $search Search input from the user
 * @param string $filter Filter criteria
 * @return integer Total num of items
 */
function get_game_count($search = null, $filter = null){
  include("connection.php");

  try{
    $sql = "SELECT COUNT(id) FROM games";
    $where = filter($filter);

    if(!empty($search)){
      $result = $db->prepare($sql
      . " WHERE name LIKE ?");
      $result->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
    }
    else{
      $result = $db->prepare($sql . $where);
      if(is_array($filter)){
        $result->bindValue(1, $filter[1], PDO::PARAM_STR);
        if($filter[2]){
          $result->bindValue(2, $filter[2], PDO::PARAM_STR);
        }
      }
    }
    $result->execute();
  } catch(Exception $e){
    echo "Bad query: " .$e->getMessage();
  }

  $count = $result->fetchColumn(0);
  return $count;
}

/**
 * Filter games based on a given criteria
 * @param  string  $filter Filter criteria
 * @return string WHERE clause for SQL query
 */
function filter($filter){
  $where = '';
  // if(is_array($filter)){
  //   switch($filter[0]){
  //     case 'gender':
  //       $where = ' WHERE gender = ?';
  //       break;
  //     case 'age':
  //       if($filter[1] <= 100){
  //         $where = ' WHERE age >= ? AND age <= ?';
  //       }
  //       else{
  //         $where = ' WHERE age >= ?';
  //       }
  //       break;
  //   }
  // }
  return $where;
}

/**
 * Returns four games randomly
 * @return array Random list of games
 */
function random_game_array(){
  // Connect to database
  include "connection.php";

  // Run query
  try{
    $results = $db->query(
      "SELECT id, name, platform, release_date, publishers, labels, user_rating
      FROM games
      ORDER BY RAND()
      LIMIT 4"
    );
  } catch(Exception $e){
    echo "Unable to retrieve results... " . $e->getMessage() . "\n";
  }

  // Get results
  $games = $results->fetchAll();

  // Close connection
  $db = null;

  return $games;
}

/**
 * Structures information in a HTML format
 * @param  array Result from database
 * @return string Information in HTML
 */
function get_item_html($result) {
    if (count($result) > 0) {
        // Output data of each row
        $output =  "<table class='game-list'>"
        . "<tr class='headers'>
                <th class='name header'>Name</th>
                <th class='platform header'>Platform</th>
                <th class='release header'>Release Date</th>
                <th class='desc header'>Publisher(s)</th>
                <th class='progress header'>Progress</th>
                <th class='score header'>User Score</th>
                <th colspan='2'>More</th>
              </tr>";
        foreach($result as $row) {
          $output .= "
                  <tr class='game'>
                    <td class='name row'>" . $row["name"] . "</td>
                    <td class='platform row'>" . $row["platform"] . "</td>
                    <td class='release row'>" . $row["release_date"] . "</td>
                    <td class='desc row'>" . $row["publishers"] . "</td>
                    <td class='progress row'>" . $row["labels"] . "</td>
                    <td class='score row'>" . $row["user_rating"] . "</td>
                    <td class='details row'><a href='game.php?id=" . $row["id"] . "'>Details</a></td>
                    <td class='delete row'>
                      <form method='post' action='games.php' onsubmit=\"return confirm('Are you sure you want to delete this item?');\">\n
                        <input type='hidden' value='" . $row["id"] . "' name='delete' />
                        <input type='submit' class='button--delete' value='Delete' />\n
                      </form>
                    </td>
                  </tr>";
        }
        $output .= "</table>";
    } else {
        $output = "0 results";
    }

    return $output;
}

?>
