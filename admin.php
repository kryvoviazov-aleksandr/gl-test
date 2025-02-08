<?php
require 'header.php';

$message = ""; // Змінна для відображення повідомлень

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
    $title = trim($_POST['title']);
    $short_description = trim($_POST['short_description']);
    $content = trim($_POST['content']);

    // Перевірка обов'язкових полів
    if (empty($title) || empty($short_description) || empty($content)) {
        $message = "All fields are required!";
    } elseif (mb_strlen($title) > 255) { // Перевірка довжини заголовка
        $message = "Title cannot exceed 255 characters!";
    } else {
        $db->query("INSERT INTO news (title, short_description, content) VALUES (?, ?, ?)", [$title, $short_description, $content]);
        header("Location: admin.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $db->query("DELETE FROM news WHERE id = ?", [(int)$_GET['delete']]);
    header("Location: admin.php");
    exit;
}

$newsList = $db->query("SELECT id, title, created_at FROM news ORDER BY created_at DESC");
?>

<div class="container">
    <h2>Manage Blog Posts</h2>

    <?php if (!empty($message)): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="admin-panel">
        <h3>Add a New Post</h3>
        <form method="POST" class="form">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" maxlength="255" placeholder="Title" required>

            <label for="short_description">Short Description</label>
            <textarea name="short_description" id="short_description" placeholder="Short description" required></textarea>

            <label for="content">Content</label>
            <textarea name="content" id="content" placeholder="Full text" required></textarea>

            <button type="submit" name="add_news">Add Post</button>
        </form>
    </div>

    <h3>Existing Posts</h3>
    <div class="news-grid">
        <?php while ($news = $newsList->fetch_assoc()): ?>
            <div class="news-item">
                <h3><?= htmlspecialchars($news['title']) ?></h3>
                <small class="news-date"><?= date('d.m.Y H:i', strtotime($news['created_at'])) ?></small>
                <div class="admin-actions">
                    <a href="edit.php?id=<?= $news['id'] ?>" class="edit-btn">Edit</a>
                    <a href="admin.php?delete=<?= $news['id'] ?>" onclick="return confirm('Delete this post?')" class="delete-btn">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require 'footer.php'; ?>
