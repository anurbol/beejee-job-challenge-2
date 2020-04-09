<?php

trait View {
    static self $currentInstance;

    /**
     * Этот метод должен вызываться изнутри шаблона,
     * то есть после вызова метода render(), но никак не раньше,
     * в противном случае переменная $currentInstance будет пустой,
     * что вызовет ошибку.
     *
     * @return static
     */
    public static function getInstance(): self {
        return static::$currentInstance;
    }

    /**
     * Этот метод должен подключать (require) шаблон.
     * Явное подключение файла позволяет легкую навигацию -
     * переход в файл подключаемого шаблона по клику на его путь.
     */
    abstract function requireTemplate(): void;

    public function render(): void {
        static::$currentInstance = $this;
        $this->requireTemplate();
    }
}
