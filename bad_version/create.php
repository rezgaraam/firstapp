<?php

//connecting to data base with port 3306 and root username and 'empty' password
$pdo=new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
/*
------HERE WE DONT NEED TO SELECT THE DATAS FROM DATABASE-----
$statement=$pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
$statement->execute();
$products=$statement->fetchall(PDO::FETCH_ASSOC);
*/
//we need an error array and that should be here always
$errors=[];

//this will show parametre if we refresh page after submit
$title='';
$price='';
$description='';

if ($_SERVER['REQUEST_METHOD']==='POST')
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    if (!$title)
    {
        $errors[]='product title is required';
    }
    if (!$price)
    {
        $errors[]='product price is required';
    }
    if (!is_dir('images'))
    {
        mkdir('images');
    }
    if (empty($errors))
    {
        $image=$_FILES['image'] ?? null;
        $imagepath='';
        if ($image && $image['tmp_name'])
        {
            $imagepath='images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagepath));
            move_uploaded_file($image['tmp_name'],$imagepath);
        }
        $statement=$pdo->prepare("INSERT INTO products(title,image,description,price,create_date)
                VALUES(:title,:image,:description,:price,:date)
        ");
        $statement->bindValue(':title',$title);
        $statement->bindValue(':image',$imagepath);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':date',$date);
        $statement->execute();//in baray baz gasht be safhe index ast ke mahsul ra be aval ezafe mikonad
        header('Location:index.php');
    }
}
function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!--link to find my css file-->
    <link rel="stylesheet" href="app.css">
    <title>PRODUCT</title>
  </head>
  <body>
    <h1>Create Product</h1>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>product image</label>
            <br>
            <input type="file" name="image">
        </div>
        <div class="form-group">
         <label>product title</label>
         <input type="text" name="title" class="form-control" value="<?php echo $title ?>">
        </div>
        <div class="form-group">
            <label>product description</label>
            <textarea class="form-control" name="description"><?php echo $description ?></textarea>
        </div>
        <div class="form-group">
            <label>product price</label>
            <input type="number" step=".01" name="price" class="form-control" value="<?php echo $price ?>">
        </div>

       <button type="submit" class="btn btn-primary">Ceate</button>
    </form> 
  </body>
</html>