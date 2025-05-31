<?php
namespace App\Application\Command;

class CreateProductCommand
{
    public string $name;
    public string $code;
    // otros campos...

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->code = $data['code'];
        // asignar otros campos...
    }
}
