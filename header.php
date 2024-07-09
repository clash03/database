<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK RENTAL</title>
    <link rel="stylesheet" href="css/header.css">

</head>
<body>

<header>

    <?php
    if (isset($_SESSION["student_id"])) 
	
	{
        echo "<div class='overlay-text'>BOOK RENTAL</div>";
		echo "<a href='/logout.php'>Logout</a>";
    }
	
    ?>
	
</header>

<nav>
    <?php
    if (isset($_SESSION["student_id"])) 
	
	{
        echo "<a href='/index.php'>Home</a>";
        echo "<a href='/edit.php'>Create</a>";
        echo "<a href='/delete.php'>Read</a>";
        echo "<a href='/create.php'>Update</a>";

    } 
	
else 
	
	{
        echo "<a href='/logout.php'>Logout</a>";
        echo "<a href='/register.php'>Register</a>";
    }
    ?>
</nav>

<main>
