# NotesNT

## About
NotesNT is a simple online note storage created for REST project assignment - it works by sending AJAX requests from pages while behaving according to the incoming responses.

It contains 2 pages :
1. index.php - This is a register / login page.
2. notes.php - This is a page where you can submit the notes and search through already existing ones.

To use it, simply save this repository in htdocs folder of your choice (assuming you are using XAMPP) and import the database (make sure it's called 'notesnt'. You can change the connection parameters if you wish by modifying admin/database.php file).

Status codes : 
+ 0 - OK.
+ 1 - Username is taken.
+ 2 - Email is already in use.
+ 3 - An error during account creation occured.
+ 4 - Login failed.
+ 5 - Unauthorized.
+ 6 - An error during note creation occured.
+ 7 - No results found.
+ 8 - User is not logged in.
+ 9 - An error while attempting to log out occured.

## Images
<img src="https://dzonint.github.io/img/portfolio/notesnt_1.png" width="250"></img>
<img src="https://dzonint.github.io/img/portfolio/notesnt_2.png" width="250"></img>
<img src="https://dzonint.github.io/img/portfolio/notesnt_3.png" width="250"></img>
