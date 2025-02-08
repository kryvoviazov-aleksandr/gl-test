<?php
require 'header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid request.');
}

$news_id = (int) $_GET['id'];
$news = $db->query("SELECT title, short_description, content FROM news WHERE id = ?", [$news_id])->fetch_assoc();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $short_description = trim($_POST['short_description']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($short_description) || empty($content)) {
        $message = "All fields are required!";
    } elseif (mb_strlen($title) > 255) {
        $message = "Title cannot exceed 255 characters!";
    } else {
        $db->query("UPDATE news SET title = ?, short_description = ?, content = ? WHERE id = ?", [
            $title, $short_description, $content, $news_id
        ]);
        header("Location: admin.php");
        exit;
    }
}
?>

<div class="container">
    <h2>Edit Post</h2>

    <?php if (!empty($message)): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="admin-panel">
        <form method="POST" class="form">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($news['title']) ?>" maxlength="255" required>

            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" required><?= htmlspecialchars($news['short_description']) ?></textarea>

            <label for="content">Content</label>
            <textarea id="content" name="content" required><?= htmlspecialchars($news['content']) ?></textarea>

            <button type="submit">Update Post</button>
        </form>
    </div>

    <a href="admin.php" class="back-btn">← Back to Admin Panel</a>
</div>

<?php require 'footer.php'; ?>
