<?php


namespace Utils\Form;


abstract class ValidationRule
{
    abstract public function getMessage(): string;
    abstract public function validate($value): bool;
}