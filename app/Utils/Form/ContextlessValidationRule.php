<?php


namespace Utils\Form;

/**
 * Эти правила не зависят от контекста, и проверяют только само поле;
 * они хранятся как синглтон-объекты в классе ValidationRules
 *
 * @see ValidationRules
 * @package Utils\Form
 */
abstract class ContextlessValidationRule extends ValidationRule
{
    /**
     * @var string Строковый идентификатор, который удобен для передачи через GET параметры
     * (вместо длинных, кириллических сообщений об ошибках).
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }
}