<?php

namespace IQ2i\PrestashopWebservice\Generator;

class Schema
{
    /** @var array<Field> */
    private array $fields;

    public function __construct(
        private string $resourceName,
        private string $className,
    ) {
    }

    public function getResourceName(): string
    {
        return $this->resourceName;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function addField(Field $field): void
    {
        $this->fields[] = $field;
    }
}
