<?php
declare(strict_types=1);

namespace App\Core;

class Response
{

    public function __construct(
        public ?string $view = null,
        public array $data = [],
        public ?string $redirect = null,
        public int $status = 200,
        private ?string $layout = __DIR__ . "/../views/layout.php",
    ) {}

    //??
    public function isRedirect(): bool
    {
        return $this->redirect !== null;
    }

    public function send(): void
    {
        if ($this->redirect) {
            header("Location: {$this->redirect}", true, $this->status);
            exit;
        }

        if ($this->view) {
            extract($this->data);
            ob_start();
            include $this->view;
            $content = ob_get_clean();

            if ($this->layout && file_exists($this->layout)) {
                include $this->layout;
            } else {
                echo $content;
            }
        }
    }
}
