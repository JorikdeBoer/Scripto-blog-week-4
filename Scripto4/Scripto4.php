<?php
    // Give permission for used request methods
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");

    $verb = $_SERVER['REQUEST_METHOD'];

    //Global variable
    $blogs_numbers = array();
    $GLOBALS['servername'] = "localhost";
    $GLOBALS['password'] = "";
    $GLOBALS['dbname'] = "scripto4";
    $GLOBALS['username'] = "root";
    
    // Code to delete comments
    if ($verb == 'POST'){
        
        // Check if there is a category to add to the list
        if (isset( $_POST["mycategory"] )){
               
                $newcategory = $_POST["mycategory"];
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
            
                // Add category to category database
                $sql = "INSERT INTO categories (category)".
                    "VALUES ('$newcategory')";
                    // Check of a new entry in database has been created
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";} 
                    else {
                        echo "Error: " . $sql . "<br>" . $conn->error;} 
                $conn->close();           
        }
        
        // Check if there is a comment_id to remove comment
        elseif (isset( $_POST["comment_id"] )){
            
                $comment_id = $_POST["comment_id"];
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
            
                // Delete comment from comment database
                $sql = "DELETE FROM comments WHERE comment_id = '$comment_id'";
           
                // Check if comment has been deleted
                if ($conn->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                } 
            $conn->close();   
        }

        // Check if there is a blog to put in the database
        elseif (isset( $_POST["myblog"] )){
            
                $posttext = $_POST["myblog"];
                $posttitle = $_POST["title"];
                $postauthor = $_POST["author"];
                $postcategory = $_POST["category"];
                $postextracategory = $_POST["extracategory"];
                $category_number = "";
                $blog_number = "";
                
                // Translation to make blogs with ' in the text possible
                $text = str_replace("'", "''", "$posttext");
                $title = str_replace("'", "''", "$posttitle");
                $author = str_replace("'", "''", "$postauthor");
                $category = str_replace("'", "''", "$postcategory");
                $extracategory = str_replace("'", "''", "$postextracategory");
            
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                    
                // Insert blog into blog database
                $sql = "INSERT INTO blogs (titel_blog, auteur, tekst)".
                "VALUES ('$title', '$author', '$text')";
                // Check of a new entry in database has been created
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";} 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;}
                    
                // Insert category if category is absent in category database
                $sql = "SELECT category FROM categories WHERE category = '$category'";
                $result = $conn->query($sql);
                if ($result->num_rows == 0) {    
                    $sql = "INSERT INTO categories (category)".
                    "VALUES ('$category')";
                    // Check of a new entry in database has been created
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";} 
                    else {
                        echo "Error: " . $sql . "<br>" . $conn->error;} 
                }
                $conn->close();      
                
                 // Create new connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                    
                // Link blog database to category database in special table
                // Get category_id
                $sql = "SELECT category_id FROM categories WHERE category = '$category'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {    
                    $category_number = $row['category_id'];}
                }
            
                // Get category_id extra category
                $sql = "SELECT category_id FROM categories WHERE category = '$extracategory'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {    
                    $extracategory_number = $row['category_id'];}
                }
            
                // Get blog_id
                $sql = "SELECT blog_id FROM blogs WHERE tekst = '$text'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {    
                    $blog_number = $row['blog_id'];}
                }
            
                // Link both
                $sql = "INSERT INTO articles_categories (blog_id, category_id)".
                "VALUES ('$blog_number','$category_number')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";} 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;}       
            
                // Link second/extra category and blog
                while($category_number != $extracategory_number){
                $sql = "INSERT INTO articles_categories (blog_id, category_id)".
                "VALUES ('$blog_number','$extracategory_number')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";} 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;}}
                $conn->close(); 
        }
        
        // Check if there is a comment to put in the database
        elseif (isset( $_POST["mycomment"] )){
            
                $posttext = $_POST["mycomment"];
                $posttitle = $_POST["titel_blog"];
                
                // Translation to make blogs with ' in the text possible
                $text = str_replace("'", "''", "$posttext");
                $title = str_replace("'", "''", "$posttitle");
            
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                    
                // Insert blog into blog database
                $sql = "INSERT INTO comments (comment, titel_blog)".
                "VALUES ('$text', '$title')";
                // Check of a new entry in database has been created
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";} 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;}
                    
                $conn->close(); 
        }
        else {
                die("Error: the required parameters are missing.");    
        }
    }
    
    // Code to put blogs from the database to the webpage
    if ($verb == 'GET'){
        
        // Get blogs from certain category!
        if (isset( $_GET["category"] )){

                $category = $_GET["category"];
            
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
            
                // Get category_id
                $sql = "SELECT category_id FROM categories WHERE category = '$category'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {    
                    $category_number = $row['category_id'];
                    //echo "Category_number: " . $row["category_id"]. "\r\n";
                    }
                }
                // Get blog_id's
                $sql = "SELECT blog_id FROM articles_categories WHERE category_id = '$category_number' ORDER BY blog_id DESC";
                $result = $conn->query($sql);
                //print_r($result);
                if ($result->num_rows > 0) { 
                    //print_r($result);
                    while($row = $result->fetch_assoc()) {
                    //echo "Blog_id: " . $row["blog_id"]. "\r\n" ;    
                    //echo "Blog_number: " . $row["blog_id"]. "\r\n";  
                    $blog_number = $row['blog_id'];  
                    //$blogs_numbers = array();
                    array_push($blogs_numbers, "$blog_number");
                    }
                }    

                // Get blogs with the blog_id's based on the category_id  
                $length = count($blogs_numbers);
                //print_r($blogs_numbers);
                for ($i = 0; $i < $length; $i++) {        
                    $sql = "SELECT blog_id, tekst, auteur, titel_blog FROM blogs WHERE blog_id= '$blogs_numbers[$i]' ORDER BY blog_id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                            //Output data of each row
                            while($row = $result->fetch_assoc()) {
                               echo "\r\n Auteur: " . $row["auteur"]. "\r\n";
                               echo "Titel: " . $row["titel_blog"]. "\r\n"; 
                               echo "Categorie: " .$category. "\r\n" ;
                               echo "Blog: " . $row["tekst"]. "\r\n" ;
                            }
                     }
                }    
                $conn->close(); 
        }
        
        // Get all available category names!
        elseif (isset( $_GET["categories"] )){

                 // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                // Get categories
                $sql = "SELECT category FROM categories";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {      
                    echo "" . $row["category"]. "  " ;
                    }   
                }
                else {
                    echo "0 results";
                }  
                $conn->close(); 
        }
        
        // Check if there is a blog titel selection in the request: 
        // get comments for certain blog!
        elseif (isset( $_GET["titel_blog"] )){
 
                $titel_blog = $_GET["titel_blog"];
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                // Get category_id
                $sql = "SELECT comment, comment_id FROM comments WHERE titel_blog = '$titel_blog'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {    
                    echo "Comment_ID: " . $row["comment_id"]. "\r\n"; 
                    echo "Comment: " . $row["comment"]. "\r\n" ;
                    }
                }
                else {
                    echo "0 results";
                }
                $conn->close();
        }
        
        // Check if there is the all_blogs keyword in the request: 
        // get comments for certain blog!
        elseif (isset( $_GET["all_blogs"] )){
                
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                // Get category_id
                $sql = "SELECT titel_blog FROM blogs";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) {    
                    echo "Titel blog: " . $row["titel_blog"]. " , "; 
                    }
                }
                else {
                    echo "0 results";
                }
                $conn->close();
        }
        
        // No category selection in the request: get all blogs!
        else {    
                // Create connection
                $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}
                $sql = "SELECT blog_id, tekst, auteur, titel_blog FROM blogs ORDER BY blog_id DESC";
                $result = $conn->query($sql);
                //print_r($result);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {  
                        echo "\r\n Auteur: " . $row["auteur"]. "\r\n";
                        echo "Titel: " . $row["titel_blog"]. "\r\n"; 
                        echo "Blog: " . $row["tekst"]. "\r\n" ;
                    }
                } 
                else {
                    echo "0 results";
                }
                $conn->close();
        }
    }
    
?>