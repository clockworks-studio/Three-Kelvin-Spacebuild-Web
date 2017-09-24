<?php
    function colorNamr($name, $faction)
    {
        switch ($faction)
        {
        case 1:
            return '<span style="color:#F4EEF4;">' . $name . '</span>';
            break;
        case 2:
            return '<span style="color:#FAAF32;">' . $name . '</span>';
            break;
        case 3:
            return '<span style="color:#4B4BEB;">' . $name . '</span>';
            break;
        case 4:
            return '<span style="color:#afeb4b;">' . $name . '</span>';
            break;
        case 5:
            return '<span style="color:#c84b4b;">' . $name . '</span>';
            break;
        default:
            return '<span style="color:#FFFFFF;">' . $name . '</span>';
        }
    }
        
    function parseTeam($team)
    {
        switch ($team)
        {
        case 1://User
            break;
        case 2://VIP
            return '<span style="color:#004BFF;">[VIP]</span>';
            break;
        case 3://DJ
            return '<span style="color:#000000;">[DJ]</span>';
            break;
        case 4://Moderator
            return '<span style="color:#00C800;">[M]</span>';
            break;
        case 5://Admin
            return '<span style="color:#FFD700;">[A]</span>';
            break;
        case 6://Super Admin
            return '<span style="color:#C80000;">[SA]</span>';
            break;
        case 7://Owner
            return '<span style="color:#7D00FF;">[O]</span>';
            break;
        default:
            break;
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
            return "0 minutes";
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
        
        return $string . '<br/>';
    }
    
    //Converts a 64-bit steam id (also known as community id) into a regular steam id
    //Made with information from https://developer.valvesoftware.com/wiki/SteamID
    function steamid64ToSteamid($steamid64)
    {
        $universe = ($steamid64 >> 56) & 0xFF;
        if ($universe == 1)
            $universe = 0;

        $accountIdLowBit = $steamid64 & 1;
        $accountIdHighBits = ($steamid64 >> 1) & 0x7FFFFFF;
        
        return "STEAM_" . $universe . ":" . $accountIdLowBit . ":" . $accountIdHighBits;
    }
?>