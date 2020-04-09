<?php


namespace Utils\Form;

abstract class ContexwiseValidationRule extends ValidationRule
{
    abstract public static function getName(): string;
}