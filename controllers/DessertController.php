<?php
// controllers/DessertController.php

require_once 'models/Dessert.php';

class DessertController {
    private $dessertModel;

    // Конструктор для получения подключения к базе данных
    public function __construct($pdo) {
        $this->dessertModel = new Dessert($pdo);
    }

    // Метод для отображения всех десертов на главной странице
    public function showDesserts() {
        $desserts = $this->dessertModel->getAllDesserts();
        require 'views/home.php'; // Подключаем представление для отображения
    }

    // Метод для создания нового десерта
    public function createDessert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из формы
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image = $_FILES['image']['name']; // Имя файла изображения
            $imageTmpName = $_FILES['image']['tmp_name']; // Временный путь изображения
            $vegan = isset($_POST['vegan']) ? 1 : 0;

            // Делаем проверку на тип изображения (например, только .jpg или .png)
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = pathinfo($image, PATHINFO_EXTENSION);
            if (!in_array($imageExtension, $allowedExtensions)) {
                echo "Только изображения .jpg, .jpeg и .png разрешены!";
                return;
            }

            // Перемещаем загруженное изображение в папку с изображениями
            $targetDir = 'uploads/images/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFilePath = $targetDir . basename($image);
            move_uploaded_file($imageTmpName, $targetFilePath);

            // Добавляем десерт в базу данных
            $this->dessertModel->createDessert($name, $description, $price, $category_id, $image, $vegan);
            header('Location: /'); // Перенаправление на главную страницу
        }

        // Загружаем форму для создания десерта
        require 'views/create_dessert.php';
    }
}



