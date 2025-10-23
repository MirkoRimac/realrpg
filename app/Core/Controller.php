<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function render(string $view, array $params = [], string $layout = "main"): void
    {
        extract($params, EXTR_SKIP);

        // KI generiert
        // View in Buffer -> $content 
        // Laut KI - klassisches Layout-System (Templating) wie bei Symfony, Laravel, etc.
        ob_start();
        require __DIR__ . "/../views/" . $view . ".php";
        $content = ob_get_clean();

        // Layout ausgeben
        require __DIR__ . "/../views/layout/" . $layout . ".php";
    }

    public function view(string $view, array $params = []): void
    {
        $this->render($view, $params, "main");
    }

    public function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }
}