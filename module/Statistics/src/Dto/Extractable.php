<?php

namespace Statistics\Dto;

/**
 * Model could be converted to array
 *
 * @package Statistics\Dto
 */
interface Extractable
{

    /**
     * @return array
     */
    public function toArray(): array;
}