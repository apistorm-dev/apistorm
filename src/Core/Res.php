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
 * @date_of_create: 11/23/2021 AD 16:46
 */

namespace YiiMan\ApiStorm\Core;

/**
 * Class Res
 * @package YiiMan\ApiStorm\Core
 *
 */
class Res
{
    private $success0000;
    private $data0000;
    private $errors0000 ;

    /**
     *
     * @return Err
     */
    public function getError(){
        return $this->errors0000;
    }

    public function setError(int $ErrCode, $message)
    {
        $this->setUnSuccess();
        $this->errors0000 = new Err($ErrCode, $message);
    }


    public function setData($data)
    {
        $this->data0000 = $data;
    }


    public function getData()
    {
        return $this->data0000;
    }

    public function isSuccess()
    {
        return $this->success0000;
    }

    /**
     * set response status success
     */
    public function setSuccess()
    {
        $this->success0000 = true;
    }

    /**
     * set response status to unSuccess
     */
    public function setUnSuccess()
    {
        $this->success0000 = false;
    }

}