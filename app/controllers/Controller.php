<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../views/$view.php";
        if (!file_exists($viewFile)) {
            die("View not found: " . $viewFile);
        }
        include __DIR__ . "/../views/layout.php";
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}
