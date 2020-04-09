<?php


namespace Utils\Form;


use Utils\Url;

class Validator
{
    const GET_PARAM_FAILED_VALIDATIONS = 'failed_validations';

    /**
     * @var Field[]
     */
    public array $fields;

    public function __construct(array $fields, array $commonValidationRules = [])
    {
        $this->fields = $fields;
    }

    /**
     * @return string[]
     */
    public static function getErrorMessages(): array
    {
        $failedValidations = $_GET[self::GET_PARAM_FAILED_VALIDATIONS] ?? [];

        $messages = [];

        foreach ($failedValidations as $field => $validations) {
            $messages[$field] = $validations ? (self::mapValidationNamesToMessages($validations) ?? []) : [];
        }

        return $messages;
    }

    public function validate(): array
    {
        $failedValidations = [];

        foreach ($this->fields as $field) {
            $value = $_POST[$field->name] ?? '';
            foreach ($field->validationRules as $rule) {
                if (!$rule->validate($value)) {
                    $failedValidations[$field->name] ??= [];
                    $failedValidations[$field->name][] = $rule->getName();
                }
            }
        }

        return $failedValidations;
    }

    public function validateAndRedirect(string $redirectTarget = null, ?\Closure $onSuccess = null)
    {
        $failedValidations = $this->validate();

        $data = [];
        foreach ($this->fields as $field) {
            // XSS защита всех полей.
            $data[$field->name] = htmlspecialchars($_POST[$field->name]);
        }

        if ($failedValidations) {
            $currentUrl = \GlobalContext::getRouteUrl();
            header("Location: ". $currentUrl . '?' . Url::update(array_merge(
                    $data,
                    [
                        self::GET_PARAM_FAILED_VALIDATIONS => $failedValidations
                    ]
                )));
        } else {
            $result = $onSuccess($data);
            // Если был возвращен вложенный валидатор, то мы передаем ему полномочия по редиректу.
            if ($result instanceof Validator) {
                return;
            }
            // Если была возвращена строка, то перенаправляем туда.
            elseif (is_string($result)) {
                header("Location: " . $result);
                return;
            }
            $redirectTarget ??= '/';
            header("Location: " . $redirectTarget);
        }
    }

    private static function getRuleMessageByName(string $name): ?string
    {
        // Contextless rule
        if (method_exists(ValidationRules::class, $name)) {
            return ValidationRules::$name()->getMessage();
        } else {
            // Contextwise
            foreach (ValidationRules::CONTEXTWISE_RULES as $ruleClass) {
                if ($ruleClass::getName() === $name) {
                    return $ruleClass::getMessage();
                }
            }
        }
        return null;
    }

    private static function mapValidationNamesToMessages(array $validationNames): array
    {
        $messages = [];
        foreach ($validationNames as $validationName) {
            if ($message = self::getRuleMessageByName($validationName)) {
                array_push($messages, $message);
            }
        }
        return $messages;
    }
}

