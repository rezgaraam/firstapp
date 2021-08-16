<?php

//connecting to data base with port 3306 and root username and 'empty' password
$pdo=new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 //ba in methode dar site search khahim dasht
$search=$_GET['search'] ?? '';
if ($search)
{
    $statement=$pdo->prepare('SELECT * FROM products where title LIKE :title ORDER BY create_date DESC');
    $statement->bindValue(':title',"%$search%");
}
else
{
    $statement=$pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$statement->execute();
$products=$statement->fetchall(PDO::FETCH_ASSOC);


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"> 
    <!--link to find my css file-->
    <link rel="stylesheet" href="app.css">
    <title>PRODUCT</title>
  </head>
  <body>
    <h1>Product Crud</h1>
    <p>
      <a href="create.php" class="btn btn-success">create product</a>
    </p>
    <form>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search for product" name="search"
            value="<?php echo $search ?>">
            <button class="btn btn-outline-secondary" type="button" id="submit"><b>Search</b></button>
        </div>
    </form>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">image</th>
      <th scope="col">title</th>
      <th scope="col">price</th>
      <th scope="col">create date</th>
      <th scope="col">action</th>
      <th scope="col">description</th>
      
    </tr>
  </thead>
  <tbody>
    <!-- here we try to print the datas that we have in the database -->
    <?php foreach ($products as $i => $product):?>
      <tr>
        <th scope="row"><?php echo $i+1 ?></th>
        <td>
            <img src="<?php echo $product['image'] ?>" class="thumb-image">
        </td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
          <!--ba in methode mitavan hazf kard-->
        <td>
          <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-primary">edit</a>
          <form style="display: inline-block" method="post" action="delete.php">
              <input type="hidden" name="id" value="<?php echo $product['id']?>">
              <button type="submit" class="btn btn-danger">delete</button>
          </form>
        </td>
      </tr> 
    <?php endforeach; ?>
  </tbody>
</table>

    
  </body>
</html>