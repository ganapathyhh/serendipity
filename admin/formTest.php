<html>
<head>

</head>
<body>
    <?php 
        if(isset($_POST['submit']))
            echo $_POST['parent'];
    ?>
<form action = "" method = "post">
    <select name = "parent">
        <option>None</option>
        <option>One</option>
    </select>
    <input type = "submit" name = "submit" value = "submit">
</form>
</body>
</html>