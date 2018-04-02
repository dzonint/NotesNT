<?php  
      require 'admin/database.php';
      empty($_SESSION['logged_in']) ? header("Location: index.php") : $a = 1;
?>
<!doctype html>

<html>
	<head>
		<title>NotesNT - Notes</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="icon" href="img/icon.png">  
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="css/upload-form.css">
        <link rel="stylesheet" href="css/comment.css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	</head>

	<body>
        <?php include("modules/navbar.php"); ?>
        <div class="container">
            <div class="row col-md-offset-3">
                <h3>Share a note</h3>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="status-upload">
                        <form id="text-form">
                            <textarea placeholder="Enter your text here." id="text" ></textarea>
                            <button class="btn btn-success green" id="send">Share</button>
                        </form>
                    </div>
                </div>
            </div>
        <hr>
            <div class="row col-md-offset-6">
                    <h2>Notes</h2>
            </div>
            <div class="row col-md-offset-3 col-md-6">
                <form id="search-form">
                 <label>Note search</label> 
                  <div class="input-group">
                    <input type="text" class="form-control" id="form-search-term" placeholder="Enter your search term here...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="search" onclick="getNotes('search')">Go!</button>
                    </span>
                  </div>    
                  <div class="form-check">
                    <label class="form-check-label radio-inline">
                        <input class="form-check-input" type="radio" name="search-by" id="search-by-name" value="search-by-name" checked>
                        Search by author name
                    </label>
                    <label class="form-check-label radio-inline">
                        <input class="form-check-input" type="radio" name="search-by" id="search-by-content" value="search-by-content">
                        Search by post content
                    </label>
                    <label class="form-check-label radio-inline">
                        <button class="btn btn-xs" type="button" id="clear-search" onclick="getNotes()">Clear search</button>
                    </label>  
                  </div>    
                </form>
            </div>
            <div class="row col-md-6 col-md-offset-4" id="notes"></div>
        </div>    
    </body>
    
    <script>
      $(function() { 
          getNotes();
          event.preventDefault();
          $("#send").click(createNote);
        });
        
        function createNote(){
            var text = $("#text").val();

            if(text.length<2){
                return false; 
           }

            $.ajax({
                url: 'admin/engine.php',
                method : "POST",
                data: { create_note : 1,
                        text : text },
                success: function(response) {
                        var object = JSON.parse(response);
                        if(object.status_code != 0)
                            alert(object.status_message);
                        else {
                            alert("Note successfully added.");
                            location.reload();
                        }
                    }
            });
          }
          
        function getNotes(task){ 
            var data;
            var url;
            
            // undefined - someone loaded the page, or clear search button was pressed. search - search button was pressed.
            switch(task){
                case undefined :
                    url = 'admin/engine.php?list-notes';
                    break;
                case 'search' :
                    url = 'admin/engine.php?'+$('input[name=search-by]:checked', '#search-form').val()+'='+$('#form-search-term').val();
                    if($('#form-search-term').val().length<2) return false;
                    break;
            }
            $.ajax({
                url: url,
                method: "GET",
                data: data,
                success: function(response){ 
                    $("#notes").fadeOut;
                    $("#notes").html("");
                    var object = JSON.parse(response);
                    if(object.hasOwnProperty("status_code")){
                        alert(object.status_message);
                        return;
                    }
                    // Each object contains username, postdate and a note.
                    $.each(object, function(key, value){
                        $("#notes").append(
                            '<div class="media comment-box">'
                            +'<div class="media-left">'
                            +'<a href="#">'
                            +'<img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">'
                            +'</a>'
                            +'</div>'
                            +'<div class="media-body">'
                            +'<h4 class="media-heading">'+value.username+' &mdash; '+ value.postdate +'</h4>'
                            +'<p>'+value.note+'</p>'
                            +'</div>'
                            +'</div>'
                            +'</div>'
                        );
                    })
                }
            }); 
        }
        
        function Logout(){
            $.ajax({
                url: "admin/engine.php?logout",
                method: "GET",
                success: function(response) {
                    var object = JSON.parse(response);
                    if(object.status_code != 0)
                        alert(object.status_message);
                        window.location.href = "index.php";
                }
                });
        }
</script>
</html>