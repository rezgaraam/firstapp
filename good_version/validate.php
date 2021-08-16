<?php
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');
$imagepath='';

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
    $imagepath=$product['image'];

    if ($image && $image['tmp_name'])
    {
        if ($product['image'])
        {
            unlink($product['image']);//ba in aks ghabli ra hazf mikonim
        }
        $imagepath='images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagepath));
        move_uploaded_file($image['tmp_name'],$imagepath);
    }
}