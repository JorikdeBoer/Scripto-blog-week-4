<?php
    // Give permission for used request methods
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");

    $verb = $_SERVER['REQUEST_METHOD'];

    //Global variable
    $blogs_numbers = array();

    // Code to put new blogs in the database with author, title, text and category
    if ($verb == 'POST'){
        // Check if there is a blog to put in the database
        if (isset( $_POST["myblog"] )){
            
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "scripto4"; 
                $posttext = $_POST["myblog"];
                $posttitle = $_POST["title"];
                $postauthor = $_POST["author"];
                $postcategory = $_POST["category"];
                $category_number = "";
                $blog_number = "";
                
                // Translation to make blogs with ' in the text possible
                $text = str_replace("'", "''", "$posttext");
                $title = str_replace("'", "''", "$posttitle");
                $author = str_replace("'", "''", "$postauthor");
                $category = str_replace("'", "''", "$postcategory");
            
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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
                
                 // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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
                $conn->close();        
        }
        
        // Check if there is a comment to put in the database
        elseif (isset( $_POST["mycomment"] )){
            
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "scripto4"; 
                $posttext = $_POST["mycomment"];
                $posttitle = $_POST["titel_blog"];
                
                // Translation to make blogs with ' in the text possible
                $text = str_replace("'", "''", "$posttext");
                $title = str_replace("'", "''", "$posttitle");
            
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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
        // Check if there is a category selection in the request: 
        // get blogs from certain category!
        if (isset( $_GET["category"] )){
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "scripto4"; 
                $category = $_GET["category"];
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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
                $sql = "SELECT blog_id FROM articles_categories WHERE category_id = '$category_number'";
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
        
        // Check if there is a blog titel selection in the request: 
        // get comments for certain blog!
        elseif (isset( $_GET["titel_blog"] )){
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "scripto4"; 
                $titel_blog = $_GET["titel_blog"];
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "scripto4"; 
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "scripto4"; 

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
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