<html>
	<head>
		<style type="text/css">
		body{ background-color:#37393D; }
        
		* {
			text-align:left;
			font-family:"Classic Robot";
            font-size: 20px;
		}
        
        .whitetext {
            font-size: 25px;
            color:#FFFFFF;
        }
		</style>
        
        <script type="text/javascript">
            var totalFiles = 0;
            function GameDetails( servername, serverurl, mapname, maxplayers, steamid, gamemode )
            {
                document.getElementById("ServerName").innerHTML = servername;
                document.getElementById("MapName").innerHTML = mapname;
                document.getElementById("MaxPlayers").innerHTML = maxplayers;
                document.getElementById("Gamemode").innerHTML = gamemode;
            }
            function SetFilesTotal( total )
            {
                totalFiles = total;
                document.getElementById("TotalFiles").innerHTML = total;
            }
            function SetFilesNeeded( needed )
            {
                if(needed > 0)
                {
                    document.getElementById("FileProgressBar").innerHTML = '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="' + (100 + ((needed - totalFiles) / totalFiles) * 100) + '" aria-valuemin="0" aria-valuemax="100" style="width:' + (100 + ((needed - totalFiles) / totalFiles) * 100) + '%"> ' + (100 + ((needed - totalFiles) / totalFiles) * 100) + '% </div>';
                    document.getElementById("NeededFiles").innerHTML = needed;
                }
                else
                {
                    document.getElementById("FileProgressBar").innerHTML = "";
                    document.getElementById("NeededFiles").innerHTML = "None";
                }
                
                
            }
            function DownloadingFile( fileName )
            {
                document.getElementById("FileLoad").innerHTML = fileName;
            }
            function SetStatusChanged( status )
            {
                document.getElementById("LoadingStatus").innerHTML = status;
            }
        </script>
	</head>
    
    
    <?php
        //Include the information in steam.php, database.php and functions.php. Assuming steam.php is located in parent directory.
        require '../steam.php';
        require '../database.php';
        require '../functions.php';
        
        //Common elements referenced by java script
        echo '<p id="ServerName">Connected on web</p>';
        
        echo '<p id="MapName"></p>';
        echo '<p id="FileLoad"></p>';
        echo '<p id="LoadingStatus"></p>';
            
        echo '<p id="TotalFiles"></p>';
        echo '<p id="NeededFiles"></p>';
        echo '<p id="Gamemode"></p>';
        
        echo '<p id="FileProgressBar"></p>';
    
        if(isset($_GET["steamid"]) && isset($_GET["mapname"]))
        {
            //Connected through game
            
            //Game specific elements referenced by java script
            //echo '<p id="MapName"></p>';
            //echo '<p id="FileLoad"></p>';
            //echo '<p id="LoadingStatus"></p>';
            
            //echo '<p id="TotalFiles"></p>';
            //echo '<p id="NeededFiles"></p>';
            //echo '<p id="Gamemode"></p>';
            
            $id = $_GET["steamid"];
            $map = $_GET["mapname"];
             
            $userSummary = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='. $steamApiKey .'&steamids=' . $id . '&format=json');

            $userData = json_decode($userSummary, true);
            
            echo '<br />' . $userData['response']['players'][0]['personaname'];
            
            //echo '<div class="progress"><p id="FileProgressBar"></p></div>';
        }
        else
        {
            //Connected through web
            $userSummary = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='. $steamApiKey .'&steamids=76561198018055912&format=json');

            $userData = json_decode($userSummary, true);
            
            echo '<br />' . $userData['response']['players'][0]['personaname'];
            
            echo '<div class="progress">
                <p id="FileProgressBar"></p>
            </div>';
            
            echo '<script type="text/javascript"> SetFilesTotal(100); SetFilesNeeded(77); </script>';
        }
        
        try
        {
            //Try to get a connection
            $pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$mysql_database, $mysql_user, $mysql_pass);
            
            $stmt = $pdo->prepare('SELECT nick_name, team, rank FROM server_player_record WHERE steamid = "' . steamid64ToSteamid($userData['response']['players'][0]['steamid']) . '" LIMIT 1');
            $stmt->execute();
            $user = $stmt->fetch();
            
            if(count($user) > 0)
            {
                echo "Welcome back " . parseTeam($user['rank']) . " " . colorNamr($user['nick_name'], $user['team']) . "!";
            }
            else
            {
                echo "Welcome to 3K Spacebuild!";
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
            echo "A connection to the database could not be established<br/>";
            die();
        }
    ?>
</html>