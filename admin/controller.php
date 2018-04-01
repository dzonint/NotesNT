<?php
    require "database.php";

    // Check if username is already taken - AJAX call from function checkUsername. (row 104 - index.php)
    if($_POST["task"] == "check-username")
    {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        
        $query = "SELECT authorid FROM authors WHERE username = '$username'";
        mysqli_query($conn, $query); 
        
        if(mysqli_affected_rows($conn) != 0)
        {
            $response=array('status_code' => 1, 'status_message' => 'Username is taken.');
        }
        else
            $response=array('status_code' => 0, 'status_message' => 'OK.');
        echo json_encode($response);
    }

    // Check if email is already in use - AJAX call from function checkEmail. (row 124 - index.php)
    if($_POST["task"] == "check-email")
    {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        
        $query = "SELECT authorid FROM authors WHERE email = '$email'";
        mysqli_query($conn, $query); 
        
        if(mysqli_affected_rows($conn) != 0)
        {
            $response=array('status_code' => 2, 'status_message' => 'Email is already in use.');
        }
        else
            $response=array('status_code' => 0, 'status_message' => 'OK.');
        echo json_encode($response);
    }
    
    // Add an author to database - AJAX call from function registerAccount. (row 176 - index.php)
    if($_POST["task"] == "create-author")
    {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        
        $query = "INSERT INTO authors(username, password, email) VALUES ('$username', '$password', '$email')";
        mysqli_query($conn, $query);
        
        if(mysqli_affected_rows($conn) != 0)
        {
            $response=array('status_code' => 0, 'status_message' => 'OK.');
        }
        else
            $response=array('status_code' => 3, 'status_message' => 'An error during account creation occurred.');
        echo json_encode($response);
    }

    // Login author - AJAX call from function Login. (row 199 - index.php)
    if($_POST["task"] == "login-author")
    {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
        
        $query = "SELECT authorid FROM authors WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query); 
        $row = mysqli_fetch_assoc($result);
        
        if(mysqli_affected_rows($conn) != 0)
        {
            $response=array('status_code' => 0, 'status_message' => 'OK.');
            $_SESSION["logged_in"] = 1;
            $_SESSION["authorid"] = $row["authorid"];
            $_SESSION["username"] = $username;
        }
        else
            $response=array('status_code' => 4, 'status_message' => 'Login failed.');
        echo json_encode($response);
    }

    // Create a note - AJAX call from function createNote. (row 47 - notes.php)
    if($_POST["task"] == "create-note")
    {
        $text = mysqli_real_escape_string($conn, $_POST["text"]);
        $authorid = $_SESSION["authorid"];
        
        $query = "INSERT INTO notes(authorid, note) VALUES ($authorid, '$text')";
        mysqli_query($conn, $query); 
        
        if(mysqli_affected_rows($conn) != 0)
        {
            $response=array('status_code' => 0, 'status_message' => 'OK.');
        }
        else
            $response=array('status_code' => 5, 'status_message' => 'An error during note creation occurred.');
        echo json_encode($response);
    }

    // List all notes from database - AJAX call from function getNotes. (row 65 - notes.php)
    if($_POST["task"] == "list-notes")
    {
        $query = "SELECT authors.username, notes.postdate, notes.note 
                  FROM notes INNER JOIN authors ON authors.authorid = notes.authorid
                  ORDER BY notes.postdate DESC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $json[] = $row;
        }
        echo json_encode($json);
    }

    // Search notes by username - AJAX call from function getNotes when function gets called by search button press and radio 'Search by author name' is selected. (row 65 - notes.php)
    if($_POST["task"] == "search-by-name")
    {
        $content = mysqli_real_escape_string($conn, $_POST["content"]);
        
        $query = "SELECT authors.username, notes.postdate, notes.note 
                  FROM notes INNER JOIN authors ON authors.authorid = notes.authorid 
                  WHERE authors.username = '$content'
                  ORDER BY notes.postdate DESC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $json[] = $row;
        }
        echo json_encode($json);
    }
    
    // Search notes by content - AJAX call from function getNotes when function gets called by search button press and radio 'Search by post content' is selected. (row 65 - notes.php)
    if($_POST["task"] == "search-by-content")
    {
        $content = mysqli_real_escape_string($conn, $_POST["content"]);
        
        $query = "SELECT authors.username, notes.postdate, notes.note 
                  FROM notes INNER JOIN authors ON authors.authorid = notes.authorid 
                  WHERE notes.note LIKE '%$content%'
                  ORDER BY notes.postdate DESC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $json[] = $row;
        }
        echo json_encode($json);
    }

    // Log out - navbar button when logged in.
    if($_POST["task"] == "logout")
    {
        if(session_destroy())
        {
            $response=array('status_code' => 0, 'status_message' => 'OK.');
        }
        else
            $response=array('status_code' => 6, 'status_message' => 'An error while attempting to log out occurred.');
        echo json_encode($response);
    }
?>