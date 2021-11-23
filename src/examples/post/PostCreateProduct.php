<?php

namespace YiiMan\ApiStorm\examples\post;

use YiiMan\ApiStorm\Post\BasePostData;

/**
 * Class PostCreateProduct
 *
 * @property string $name0 name of product
 * @property string $color0 hex color of product
 * @property integer $status0 status of product for publish|private in site
 * @property integer $category0 category of product
 *
 * @property float $price price of product
 * @property integer $available_count how many of this product is available in shop?
 */
class PostCreateProduct extends BasePostData
{
    public
        $name0,
        $color0,
        $price = 0,
        $status0 = 1,
        $available_count = 0,
        $category0;


    public function rules(): array
    {
        return
            [
                'name'            => 'string',
                'color'           => 'string',
                'price'           => 'float',
                'status'          => 'int',
                'available_count' => 'int',
                'category'        => 'int',
            ];
    }
}