<?php
/**
 * Created by Miki Maine Amdu.
 * For : INNOVATE E-COMMERCE
 * User: MIKI$
 * Date: 6/9/2016
 * Time: 10:29 PM
 */

namespace Innovate\Api\Transformers;


/**
 * Class Transformer
 * @package Innovate\Api\Transformers
 */
abstract class Transformer {

    /**
     * @param $items
     * @return array
     */
    public function transformCollection($items)
    {
        return array_map([$this,'transform'],$items["data"]);
    }

    /**
     * @param $item
     * @return mixed
     */
    public abstract function transform($item);

}