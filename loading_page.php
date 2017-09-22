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
            function GameDetails( servername, serverurl, mapname, maxplayers, steamid, gamemode )
            {
                document.getElementById("Server").innerHTML = servername;
                document.getElementById("Map").innerHTML = mapname;
            }
            function DownloadingFile( fileName )
            {
                document.getElementById("FileLoad").innerHTML = fileName;
            }
            function SetStatusChanged( status )
            {
                document.getElementById("FileStatus").innerHTML = status;
            }
        </script>
	</head>
    
    
    <?php
        //Common elements referenced by java script
        echo '<p id="Server">Connected on web</p>';
        
    
        if(isset($_GET["steamid"]) && isset($_GET["mapname"]))
        {
            //Connected through game
            
            //Game specific elements referenced by java script
            echo '<p id="Map">Error</p>';
            echo '<p id="FileLoad">Error</p>';
            echo '<p id="FileStatus">Error</p>';
            
            //include the information in steam.php. Assuming steam.php is located in parent directory.
            include '../steam.php';
            
            $id = $_GET["steamid"];
            $map = $_GET["mapname"];
             
            $userSummary = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='. $steamApiKey .'&steamids=' . $id . '&format=json');

            $userData = json_decode($userSummary, true);
        }
        else
        {
            //Connected through web
            
        }
    ?>
</html>