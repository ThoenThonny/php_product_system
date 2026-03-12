<?php
class Controller {
    protected function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    protected function view($view, $data = []) {
        extract($data);
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/' . $view . '.php';
        require_once '../app/views/layouts/footer.php';
    }

    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
}