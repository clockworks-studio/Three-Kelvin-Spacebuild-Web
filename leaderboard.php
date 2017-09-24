<html>
	<head>
		<style type="text/css">
		body{ background-color:#37393D; }
		
		* {
			text-align:left;
			font-family:"Classic Robot";
			font-size:18px;
			color:#FFFFFF;
		}
		
		.lightleft {
			background-color:#646464;
			text-align:left;
			padding-left:5px
		}
		.lightright {
			background-color:#646464;
			text-align:right;
			padding-right:5px
		}
		.darkleft {
			background-color:#969696;
			text-align:left;
			padding-left:5px
		}
		.darkright {
			background-color:#969696;
			text-align:right;
			padding-right:5px
		}
		</style>
	</head>
	
	<?php
        //Import database information and helper functions (assuming database.php and functions.php is located in parent directory)
		require '../database.php';
        require '../functions.php';
		
        ///Database connection
        try
        {
            //Try to get a connection
            $pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$mysql_database, $mysql_user, $mysql_pass);
            
            $stmt = $pdo->prepare("SELECT nick_name, team, score, playtime FROM server_player_record, player_stats WHERE server_player_record.steamid = player_stats.steamid ORDER BY score DESC, playtime DESC LIMIT 20");
            //$stmt = $pdo->prepare("SELECT nick_name, team, score, playtime FROM server_player_record ORDER BY score DESC, playtime DESC LIMIT 20");
            $stmt->execute();
            $users = $stmt->fetchAll();
            
            if(count($users) > 0)
            {
                echo "<table width='100%'>";
            
                $inc = 0;
                
                /* Table headlines for testing, the in-game terminal already have this
                echo "<tr><td class='lightleft'>Position</td>";
                echo "<td class='lightleft'>Name</td>";
                echo "<td class='lightright'>Score</td> ";
                echo "<td class='lightright'>Playtime</td></tr>";
                */
                
                foreach( $users as $row => $user)
                {
                    $inc++;
                    if($inc % 2 == 1)
                    {
                        if($inc == 1)
                        {
                            echo "<tr> <td class='darkleft'>".pad($inc)."] </td> <td class='darkleft'>" . colorNamr($user['nick_name'], $user['team']) . "</td>";
                        }
                        else
                        {
                            echo "<tr> <td class='darkleft'>".pad($inc)."] </td> <td class='darkleft'>" . colorNamr($user['nick_name'], $user['team']) . "</td>";
                        }
                        echo "<td class='darkright'>".number_format($user['score'])."</td> <td class='darkright'>" . formatTime($user['playtime']) . "</td> </tr>";
                    }
                    else
                    {
                        echo "<tr> <td class='lightleft'>".pad($inc)."] </td> <td class='lightleft'>" . colorNamr($user['nick_name'], $user['team']) . "</td>";
                        echo "<td class='lightright'>".number_format($user['score'])."</td> <td class='lightright'>" . formatTime($user['playtime']) . "</td> </tr>";
                    }
                }
                
                echo "</table>";
            }
            else
            {
                echo "No user data was found";
            }
            
            //Close the database connection and related objects
            $users = null;
            $stmt = null;
            $pdo = null;
        }
        catch (PDOException $e)
        {
            //If something goes wrong while interacting with the database, we will give an error
            //It might be a good idea to put the details in a seperate log file and just tell
            //the user that an error occured. Otherwise you might leak information you don't want to
            echo "Leaderboard is not currently available, please check back later<br/>";
            die();
        }
	?>
</html>