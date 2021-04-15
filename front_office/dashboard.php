<?php
	/**
	 * Include Header
	 */
	try {
	  include("../_config/config.php");
      include("../_config/db_connect.php");
      include("../_includes/functions.php");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	
	if(!is_super_user()){
        print "Only the Super User is allowed back here!";
        exit();
    }

?>




<ul>

<li><a href="login.php">Login</a></li>
<li><a href="logout.php">Logout</a></li>
<li><a href="front_office.php">Front Office</a></li>
<li><a href="leader_board.php">Leader Board</a></li>

</ul>

Super Admin Access
<br />
<br />
<strong>Players</strong>
<ul>
<li><a href="seed_players_table.php">Seed Players Table</a></li>
<li>Update Players</li>
<li>Add New Players</li>
<li>Delete Players</li>
</ul>

<strong>Homeruns</strong>
<ul>
<li><a href="seed_hr_tables.php">Seed Homerun Tables</a></li>
<li><a href="update_daily_homeruns.php">Update Daily Homeruns</a></li>
<li>Add Homerun Record</li>
</ul>

<strong>Users</strong>
<ul>
<li><a href="register.php">Register User</a></li>
<li>Edit User</li>
</ul>

<strong>Leagues</strong>
<ul>
<li><a href="create_league.php">Create League</a></li>
<li>Edit League</li>
</ul>

<strong>Teams</strong>
<ul>
<li><a href="create_team.php">Create Teams</a></li>
<li>Edit Teams</li>
</ul>

<strong>Seasons</strong>
<ul>
<li>Add Season - see http://localhost/sandbox/mysportsfeeds/getCurrentSeason.php</li>
</ul>

<a href="get_apis_params.php">Select API's and their related filter parameters</a><br />
<a href="select_season.php?id=1">Select Season<a/><br />
<a href="select_daily_homeruns.php?id=6">Daily Homeruns<a/><br /><br />
<a href="scrap_paper.php">Scrap Paper<a/><br />


<?php

	/**
	 * Include Footer
	 */
	include('../_includes/footer.php');


?>
