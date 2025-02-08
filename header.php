<?php
require 'Database.php'; // Підключаємо базу даних
$db = new Database(); // Створюємо об'єкт бази
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE BLOG</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
        <div class="header-container">
            <div class="logo"><a href="https://www.facebook.com/AlexandrKryvoviazov">A.Kryvoviazov test project</a></div>
            <nav>
                <a href="/admin.php">Admin</a>

                
            </nav>
        </div>
        <h1><a href="/">THE BLOG</a></h1>
    </header>
