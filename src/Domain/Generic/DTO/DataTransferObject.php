<?php

namespace App\Domain\Generic\DTO;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class DataTransferObject
 *
 * @package App\Domain\Generic\DTO
 */
class DataTransferObject
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  int  $as_array
     *
     * @return mixed
     */
    protected function requestToData(Request $request, $as_array = 0)
    {
        return json_decode(
            $request->getContent(),
            $as_array
        );
    }
}
