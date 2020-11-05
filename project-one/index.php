<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project One</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <form action="" method="post">
        <fieldset>
            <legend>Control Panel</legend>
            <label for="name">Name: &emsp;</label>
            <input type="text" id="name" name="name" placeholder="Your name"><br><br>
            <label for="mail">Mail:&emsp;&emsp;</label>
            <input type="text" id="mail" name="mail" placeholder="example@mail.com"><br><br>
            <button type="submit" name="createUser">Create</button>
            <br><br><hr><br>
            <label for="id">ID:&emsp;</label>
            <input type="text" id="id" name="id" placeholder="ID">
            <button type="submit" name="deleteUser">Delete this user</button>
            <br><br><hr><br>
            <button type="submit" name="showUsers">Show users as table</button>
            <button type="submit" name="showUsersJSON">Show users as JSON format</button>
        </fieldset>
    </form>

   <?php
        include 'databaseOperations.php';
        include 'pageOperations.php';
   ?>   
</body>
</html>