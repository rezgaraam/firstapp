<?php
//ertebat ba paigah dadeh
/** @var $pdo \PDO */
require_once "../../database.php";
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
<?php include_once "../../views/partial/Header.php"; ?>
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