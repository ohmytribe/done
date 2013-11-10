<?php
/**
 * @author Stanislav Ivanov <resha.ru@gmail.com>
 */

namespace Omt\TodoBundle\Model\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Form request validator
 */
class FormRequestValidator
{

    const ERROR_NOT_SUBMITTED = 'invalid_data';
    const ERROR_INVALID_DATA = 'invalid_data';

    /**
     * @var string
     */
    private $error;

    /**
     * @param Form $form
     * @param Request $request
     * @return bool
     */
    public function validate(Form $form, Request $request)
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            $valid = false;
            $this->error = self::ERROR_NOT_SUBMITTED;
        } elseif (!$form->isValid()) {
            $valid = false;
            $this->error = self::ERROR_INVALID_DATA;
        } else {
            $valid = true;
        }

        return $valid;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

}