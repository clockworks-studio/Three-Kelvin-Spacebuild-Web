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
        if(isset($_GET["steamid"]) && isset($_GET["mapname"]))
        {
            //Connected through game
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
        
        echo '<p id="Server">Test server name</p>';
        echo '<p id="Map">Test map name</p>';
        echo '<p id="FileLoad">Test file load</p>';
        echo '<p id="FileStatus">Test file status</p>';
    ?>
</html>