<?php
require 'header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid request.');
}

$news_id = (int) $_GET['id'];
$result = $db->query("SELECT title, content, created_at FROM news WHERE id = ?", [$news_id]);

if ($result->num_rows === 0) {
    die('Post not found.');
}

$news = $result->fetch_assoc();
?>

<div class="container">
    <h1 class="news-title"><?= htmlspecialchars($news['title']) ?></h1>
    <small class="news-date"><?= date('d.m.Y H:i', strtotime($news['created_at'])) ?></small>
    <div class="news-content">
        <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
    </div>
    <a href="index.php" class="back-btn">← Back to News</a>
</div>

<?php require 'footer.php'; ?>
