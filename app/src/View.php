<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(private string $path, private array $params)
    {
    }

    public static function show(string $path, array $params=[]): static
    {
        return new static($path, $params);
    }

    public function render(): string
    {

        $viewPath= VIEW_PATH . '/' . $this->path . '.php';

        if(! file_exists($viewPath)){
            throw new ViewNotFoundException();
        }

        extract($this->params);

        ob_start();

        include $viewPath;
        
        return (string) ob_get_clean();

        
    }

    public function __toString(): string
    {
        return $this->render();
    }
}