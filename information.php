<html>
	<head>
		<style type="text/css">
		body{ background-color:#37393D; }
        
		* {
			text-align:left;
			font-family:"Classic Robot";
			font-size:18px;
            padding:2px;
			color:#FFFFFF;
		}
        
        .header {
            font-size:30px;
        }
        
        .smalltext {
            font-size:12px;
        }
        
        .postlight {
			background-color:#969696;
			text-align:left;
            margin:5px;
            border-radius: 3px;
		}
        
        .postdark {
			background-color:#646464;
			text-align:left;
            margin:5px;
            border-radius: 3px;
		}
		</style>
	</head>
    <?php
        //Database information (assuming database.php is located in parent directory)
        require '../database.php';
        
        try
        {
            //Try to get a connection
            $pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$mysql_database, $mysql_user, $mysql_pass);
            
            $stmt = $pdo->prepare("SELECT time_posted, title, author, content FROM info_posts WHERE info_posts.visible = 1 ORDER BY time_posted DESC");
            $stmt->execute();
            $posts = $stmt->fetchAll();
            
            if(count($posts) > 0)
            {
                $inc = 0;
                
                foreach( $posts as $row => $post)
                {
                    $inc++;
                    if($inc % 2 == 1)
                    {
                        echo '<div class="postlight">';
                        echo '<h1 class="header">'.$post['title'].'</h1>';
                        echo '<small class="smalltext">Posted on '.$post['time_posted'].' by '.$post['author'].'</small>';
                        echo '<p>'.$post['content'].'</p>';
                        echo '</div>';
                    }
                    else
                    {
                        echo '<div class="postdark">';
                        echo '<h1 class="header">'.$post['title'].'</h1>';
                        echo '<small class="smalltext">Posted on '.$post['time_posted'].' by '.$post['author'].'</small>';
                        echo '<p>'.$post['content'].'</p>';
                        echo '</div>';
                    }
                }
            }
            else
            {
                echo "No posts were found";
            }
            
            //Close the database connection and related objects
            $posts = null;
            $stmt = null;
            $pdo = null;
        }
        catch (PDOException $e)
        {
            //If something goes wrong while interacting with the database, we will give an error
            echo "The database is not currently available, please check back later<br/>";
            die();
        }
    ?>
</html>