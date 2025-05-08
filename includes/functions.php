<?php
// Старт сессии, если не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Проверяет, авторизован ли пользователь.
 *
 * @return bool
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Получить имя текущего пользователя.
 *
 * @return string|null
 */
function current_username(): ?string {
    return $_SESSION['username'] ?? null;
}

/**
 * Получить ID текущего пользователя.
 *
 * @return int|null
 */
function current_user_id(): ?int {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Редирект на страницу входа, если пользователь не авторизован.
 */
function require_login(): void {
    if (!is_logged_in()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
        header("Location: auth/login.php");
        exit;
    }
}

/**
 * Экранирует строку для безопасного HTML-вывода.
 *
 * @param string $string
 * @return string
 */
function e(string $string): string {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
