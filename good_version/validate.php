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
if (!is_dir(__DIR__.'/public/images'))
{
    mkdir(__DIR__.'/public/images');
}
if (empty($errors))
{
    $image=$_FILES['image'] ?? null;
    $imagepath=$product['image'];

    if ($image && $image['tmp_name'])
    {
        if ($product['image'])
        {
            unlink(__DIR__.'/public/'.$product['image']);//ba in aks ghabli ra hazf mikonim
        }
        $imagepath='images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname(__DIR__.'/public/'.$imagepath));
        move_uploaded_file($image['tmp_name'],__DIR__.'/public/'.$imagepath);
    }
}