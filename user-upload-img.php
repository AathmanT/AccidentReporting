<!DOCTYPE html>
<html>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <br>
    <input type="submit" name="submit" value="Submit">
</form>
</body>
</html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
        echo 'failed';
    } else {
        $name = addslashes($_FILES['image']['name']);
        $image = base64_encode(file_get_contents(addslashes($_FILES['image']['tmp_name'])));
        save_image($name, $image);
    }
}
display();

function save_image($name, $image)
{
    $mysqli = new mysqli('localhost', 'root', '', 'accidentreporter');
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    if (!$mysqli -> query("insert into img(name,img) values('$name','$image')")) {
        echo("Error description: " . $mysqli -> error);
    }
    $mysqli -> close();
}

function display(){
    $mysqli = new mysqli('localhost', 'root', '', 'accidentreporter');
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    if ($results = $mysqli -> query("select * from img")) {
        $num = mysqli_num_rows($results);
//        for($i =0 ; $i<$num;$i++){
//            $res = mysqli_fetch_array($results);
//            $img = $res['image'];
//            echo '<img src="data:image;base64,'.$img.'">';
//        }
        if($results->num_rows){
		while($row=$results->fetch_object()){
            echo '<img src="data:image;base64,'.$row->img.'">';
		}
		$results->free();
	}

    }else{
        echo("Error description: " . $mysqli -> error);
    }
    $mysqli -> close();
}


