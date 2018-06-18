<html>
<head>
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
  <h1>Dustin's Video Game Collection App</h1>
  <div class="nav">
    <a href="/">Home</a>
    <a href="/addgame.php">Add Game</a>
    <a href="/games.php">List Games</a>
    <a href="/about.php">About</a>
  </div>
  <br />
  <div class="search">
    <form method="get" action="games.php">
      <label for="s">Search:</label>
      <input type="text" name="s" id="s" />
      <input type="submit" value="go" />
    </form>
  </div>
