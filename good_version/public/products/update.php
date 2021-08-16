<?php

/** @var $pdo \PDO */
 require_once "../../database.php";
 require_once "../../functions.php";

$id=$_GET['id'] ?? null;
if(!$id)
{
    header('Location:index.php');
    exit;
}
//hame chiz ra ar rabete ba products jaii ke id dorost ast entekhab kon
$statement=$pdo->prepare('SELECT * FROM products WHERE id= :id');
$statement->bindValue(':id',$id);
$statement->execute();
$product=$statement->fetch(PDO::FETCH_ASSOC);



//we need an error array and that should be here always
$errors=[];

//ba in kar mitawan haman esm mahsoul ke baray taghiir ast ra namayesh dahad
$title=$product['title'];
$price=$product['price'];
$description=$product['description'];

if ($_SERVER['REQUEST_METHOD']==='POST')
{
    require_once "../../validate.php";

    if (empty($errors))
    {

        $statement=$pdo->prepare("UPDATE products SET title=:title,image=:image,
                    description=:description,price=:price WHERE id =:id");
        $statement->bindValue(':title',$title);
        $statement->bindValue(':image',$imagepath);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':id',$id);
        $statement->execute();//in baray baz gasht be safhe index ast ke mahsul ra be aval ezafe mikonad
        header('Location:index.php');
    }
}


?>
<?php include_once "../../views/partial/Header.php"; ?>
<p>
    <a href="index.php" class="btn btn-secondary"> go back to products</a>
</p>
<h1>Update Product <b><?php echo $product['title'] ?></b></h1>

<?php include_once "../../views/product/form.php"; ?>
</body>
</html>