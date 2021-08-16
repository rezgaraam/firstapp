<?php

/** @var $pdo \PDO */
require_once "../../database.php";
require_once "../../functions.php";
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
$product=[ 'image'=>''];

if ($_SERVER['REQUEST_METHOD']==='POST')
{
    require_once "../../validate.php";
    if (empty($errors))
    {

        $statement=$pdo->prepare("INSERT INTO products(title,image,description,price,create_date)
                VALUES(:title,:image,:description,:price,:date)
        ");
        $statement->bindValue(':title',$title);
        $statement->bindValue(':image',$imagepath);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':date',date('Y-m-d H:i:s'));
        $statement->execute();//in baray baz gasht be safhe index ast ke mahsul ra be aval ezafe mikonad
        header('Location:index.php');
    }
}

?>
<?php include_once "../../views/partial/Header.php"; ?>
<p>
    <a href="index.php" class="btn btn-secondary"> go back to products</a>
</p>
<h1>Create new product</h1>
<?php include_once "../../views/product/form.php"; ?>


  </body>
</html>