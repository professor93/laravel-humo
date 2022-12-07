<?php
/**
 * Date: 10/6/2022
 * Time: 11:32 AM
 */

namespace Uzbek\LaravelHumo\Response\Issuing;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class ResetPinCounter
 *
 * @property-read string response_code
 * @property-read string error_description
 * @property-read string error_action
 * @property-read string EXTERNAL_SESSION_ID
 * @property-read bool isOk
 */
class ResetPinCounter extends BaseResponse
{
    public function __construct(array $params)
    {
        $params = $params['multiRef'] ?? [];
        parent::__construct($params);
    }

    public function getIsOk(): bool
    {
        return $this->response_code === '0';
    }
}
