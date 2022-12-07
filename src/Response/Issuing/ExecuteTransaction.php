<?php
/**
 * Date: 9/30/2022
 * Time: 6:12 PM
 */

namespace Uzbek\LaravelHumo\Response\Issuing;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class ExecuteTransaction
 *
 * @property-read string INTERNAL_NO
 */
class ExecuteTransaction extends BaseResponse
{
    public function __construct(array $attributes)
    {
        $data = ['INTERNAL_NO' => $attributes['multiRef'][1]['INTERNAL_NO'] ?? null];
        parent::__construct($data);
    }
}
