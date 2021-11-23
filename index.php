<?php
/**
 * Copyright (c) 2021. YiiMan\apiStorm
 * Authors
 * info@yiiman.ir
 * https://yiiman.ir
 * develop@ariaservice.net
 * https://ariaservice.net
 ******************************************************************************/

use YiiMan\ApiStorm\examples\post\PostCreateProduct;
use YiiMan\ApiStorm\examples\TestApi;

include __DIR__."/vendor/autoload.php";
$api = new TestApi();
$data = new PostCreateProduct();
$data->name0 = 'Pen';
$data->category0 = 10;
$data->color0 = "#fffff";
$data->status0 = 1;
if ($data->validate()) {
    $response = $api->createProduct($data);
    if ($response && $response->isSuccess()) {
        echo $response->created_id;
    }else{
        var_export($response->getError());
    }
}











echo "\n\n\n\n";
if ($data->validate()) {
    $response = $api->createProduct2($data);
    if ($response && $response->isSuccess()) {
        echo "Created_id is: ". $response->created_id;
    }else{
        var_export($response->getError());
    }
}
echo "\n\n\n\n";

