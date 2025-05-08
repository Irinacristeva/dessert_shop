<?php
// views/create_dessert.php
?>

<h1>Добавить новый десерт</h1>

<form action="" method="POST" enctype="multipart/form-data">
    <div>
        <label for="name">Название десерта:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label for="description">Описание десерта:</label>
        <textarea id="description" name="description" required></textarea>
    </div>

    <div>
        <label for="price">Цена десерта:</label>
        <input type="number" id="price" name="price" step="0.01" required>
    </div>

    <div>
        <label for="category_id">Категория:</label>
        <select id="category_id" name="category_id" required>
            <option value="1">Торты</option>
            <option value="2">Пироги</option>
            <option value="3">Печенье</option>
        </select>
    </div>

    <div>
        <label for="image">Изображение десерта:</label>
        <input type="file" id="image" name="image" required>
    </div>

    <div>
        <label for="vegan">Веганский десерт:</label>
        <input type="checkbox" id="vegan" name="vegan">
    </div>

    <button type="submit">Добавить десерт</button>
</form>
