<?php

namespace Sample\Laptops\Services;

use Bitrix\Main\Error;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;

class ErrorsService implements Errorable
{
    private ErrorCollection $errors;

    public function __construct()
    {
        $this->errors = new ErrorCollection();
    }

    public function addError(Error $error): void
    {
        $this->errors->setError($error);
    }

    /**
     * @param Error[] $errors
     * @return void
     */
    public function addErrors(array $errors): void
    {
        $this->errors->add($errors);
    }

    public function getErrors(): array
    {
        return $this->errors->getValues();
    }

    public function getErrorByCode($code): ?Error
    {
        return $this->errors->getErrorByCode($code);
    }

    public function hasErrors(): bool
    {
        return !$this->errors->isEmpty();
    }
}
