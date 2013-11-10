<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Response;

use Symfony\Component\HttpFoundation\JsonResponse as BaseResponse;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Json response
 */
class JsonResponse extends BaseResponse
{

    const DATA_ELEMENT_NAME = 'data';
    const SUCCESS_ELEMENT_NAME = 'success';
    const MESSAGE_ELEMENT_NAME = 'message';

    /**
     * @param array $data
     * @param bool $success
     * @param string $message
     */
    public function __construct(array $data = array(), $success = true, $message = null)
    {
        parent::__construct($this->createResponseArray($data, $success, $message));
    }

    /**
     * @param array $data
     * @param bool $success
     * @param string $message
     * @return array
     */
    private function createResponseArray(array $data, $success, $message)
    {
        return array(
            self::DATA_ELEMENT_NAME => $data,
            self::SUCCESS_ELEMENT_NAME => $success,
            self::MESSAGE_ELEMENT_NAME => $message
        );
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public static function createSuccessResponse($message = null)
    {
        return new self(array(), true, $message);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public static function createErrorResponse($message = null)
    {
        return new self(array(), false, $message);
    }

    /**
     * @param string $name
     * @param mixed $value
     * TODO: Refactor processing additional data fields.
     */
    public function addData($name, $value)
    {
        $data = json_decode($this->data, true);
        $data[$name] = $value;
        $this->setData($data);
    }

}