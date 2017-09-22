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
	</head>
    
    <form action="" method="post">
        <input class="button" type="submit" value="Publish Post"><br/>
        <p class="whitetext">Title:</p>
        <input type="text" name="title" required><br/>
        <p class="whitetext">Content:</p>
        <textarea rows="20" cols="100" name="content" required></textarea><br/>
    </form>
    
    <?php
        if(isset($_POST['content']) && isset($_POST['title']))
        {
            //Database information (assuming database.php is located in parent directory)
            require '../database.php';
            
            try
            {
                //Try to get a connection
                $pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$mysql_database, $mysql_user, $mysql_pass);
                
                $stmt = $pdo->prepare("INSERT INTO info_posts(title, author, content) VALUES (:title, :author, :content)");
                $stmt->execute(array("title" => $_POST['title'], "author" => "Admin", "content" => $_POST['content']));
                
                //Close the database connection and related objects
                $stmt = null;
                $pdo = null;
                
                echo "Post published!";
            }
            catch (PDOException $e)
            {
                //If something goes wrong while interacting with the database, we will give an error
                echo "The database is not currently available, please check back later<br/>";
                die();
            }
        }
    ?>
</html>