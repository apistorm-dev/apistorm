<?php


namespace YiiMan\ApiStorm\examples\response;


use YiiMan\ApiStorm\Response\BaseResponse;

/**
 * Class SuccessCreated
 * @package YiiMan\ApiStorm\examples\response
 *
 * @property integer $status
 * @property integer $created_id
 * @property string $message
 *
 * @property string $product_name
 * @property string $product_color
 * @property string $product_id_hash
 * @property integer $product_publish_status
 * @property string $product_created_at
 * @property string $product_updated_at
 */
class CreateProductResponse extends BaseResponse
{
    public
        $status = 'int',
        $created_id = 'int',
        $product_name = 'string',
        $product_color = 'string',
        $product_id_hash = 'string',
        $product_publish_status = 'int',
        $product_created_at = 'string',
        $product_updated_at = 'string',
        $errors = 'array',
        $message = 'string';
}