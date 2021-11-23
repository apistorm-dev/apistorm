<?php
/**
 * Copyright (c) 2021. YiiMan\apiStorm
 * Authors
 * info@yiiman.ir
 * https://yiiman.ir
 * develop@ariaservice.net
 * https://ariaservice.net
 ******************************************************************************/

/**
 * @date_of_create: 11/23/2021 AD 14:33
 */

namespace YiiMan\ApiStorm\examples;


use YiiMan\ApiStorm\Core\Connection;
use YiiMan\ApiStorm\Core\Res;
use YiiMan\ApiStorm\examples\post\PostCreateProduct;
use YiiMan\ApiStorm\examples\response\CreateProductResponse;
use YiiMan\ApiStorm\Post\BasePostData;

class TestApi
{

    public $protocol = 'https';
    public $baseURl = 'n8.yiiman.ir/webhook';

    /**
     * @param  BasePostData  $dataClass
     * @return Res
     */
    private function call($path, $dataClass, $method = 'post')
    {
        $servedArrayOfDataClass = $dataClass->serve();
        $connection = new Connection();
        $connection->baseURL = $this->baseURl;
        $connection->protocol = 'https';

        return $connection->call($path, [], $servedArrayOfDataClass, [],$method);
    }

    /**
     * @param  PostCreateProduct  $product
     * @return CreateProductResponse|bool
     */
    public function createProduct(PostCreateProduct $product)
    {
        if ($product->validated()) {

            // you will send $product to your server
            $response = $this->call('6c81aa91-63a1-43d9-abb6-6b5398716f81', $product,'get');


            if ($response->isSuccess()) {
                $response = new CreateProductResponse($response);
            }

            return $response;
            // </ Here, you will classify response >
        } else {
            return false;
        }
    }

     /**
     * @param  PostCreateProduct  $product
     * @return CreateProductResponse|bool
     */
    public function createProduct2(PostCreateProduct $product)
    {
        if ($product->validated()) {

            // you will send $product to your server
            $response = $this->call('6c81aa91-63a1-43d9-abb6-6b5398716f81', $product);


            if ($response->isSuccess()) {
                $response = new CreateProductResponse($response);
            }

            return $response;
            // </ Here, you will classify response >
        } else {
            return false;
        }
    }


}