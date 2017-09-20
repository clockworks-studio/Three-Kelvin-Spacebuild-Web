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
        ///Database connection
    
        //Database information (assuming database.php is located in parent directory)
		require '../database.php';
		
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
                            echo "<tr> <td class='darkleft'>".pad($inc)."] </td> <td class='darkleft'>";
                        }
                        else
                        {
                            echo "<tr> <td class='darkleft'>".pad($inc)."] </td> <td class='darkleft'>";
                        }
                        colorNamr($user['nick_name'], $user['team']);
                        echo "</td> <td class='darkright'>".number_format($user['score'])."</td> <td class='darkright'>";
                        formatTime($user['playtime']);
                        echo "</td> </tr>";
                    }
                    else
                    {
                        echo "<tr> <td class='lightleft'>".pad($inc)."] </td> <td class='lightleft'>";
                        colorNamr($user['nick_name'], $user['team']);
                        echo "</td> <td class='lightright'>".number_format($user['score'])."</td> <td class='lightright'>";
                        formatTime($user['playtime']);
                        echo "</td> </tr>";
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
		
        ///Functions
        
		function colorNamr($name, $faction)
        {
            switch ($faction)
            {
            case 1:
                echo '<span style="color:#F4EEF4;">'.$name;
                break;
            case 2:
                echo '<span style="color:#FAAF32;">'.$name;
                break;
            case 3:
                echo '<span style="color:#4B4BEB;">'.$name;
                break;
            case 4:
                echo '<span style="color:#afeb4b;">'.$name;
                break;
            case 5:
                echo '<span style="color:#c84b4b;">'.$name;
                break;
            default:
                echo '<span style="color:#FFFFFF;">'.$name;
            }
		}
		
		function pad($num)
        {
			if($num < 10)
            {
				return "0".$num;
			}
			else
            {
				return (string)$num;
			}
		}
		
		function formatTime($time)
        {
            if($time == 0)
            {
                echo "0 minutes";
                return;
            }
            
			$days = floor($time / 1440);
			$hours = floor(($time - ($days * 1440)) / 60);
			$mins = floor(($time - ($days * 1440) - ($hours * 60)));
			
            $string = "";
            
			if($days > 0)
            {
                $string .= $days." ";
                $string .= $days == 1 ? "day" : "days";
			}
			if($hours > 0)
            {
                $string .= " ".$hours." ";
                $string .= $hours == 1 ? "hour" : "hours";
			}
			if($mins > 0)
            {
                $string .= " ".$mins." ";
                $string .= $mins == 1 ? "minute" : "minutes";
			}
            
            echo $string.'<br/>';
		}
	?>
</html>