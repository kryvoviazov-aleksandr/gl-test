<?php
require 'header.php';

// Параметри пагінації
$limit = 6; // Кількість новин на сторінці
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Фільтрація за датою
$filter_start = isset($_GET['start_date']) ? $_GET['start_date'] : "";
$filter_end = isset($_GET['end_date']) ? $_GET['end_date'] : "";

// Пошук за ключовими словами
$search_query = isset($_GET['search']) ? trim($_GET['search']) : "";

// Формуємо SQL-запит
$sql = "SELECT id, title, short_description, created_at FROM news WHERE 1=1";
$params = [];

if (!empty($search_query)) {
    $sql .= " AND (title LIKE ? OR short_description LIKE ?)";
    $params[] = "%$search_query%";
    $params[] = "%$search_query%";
}

if (!empty($filter_start) && !empty($filter_end)) {
    $sql .= " AND created_at BETWEEN ? AND ?";
    $params[] = $filter_start;
    $params[] = $filter_end;
}

$sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;

$newsList = $db->query($sql, $params);

// Підрахунок загальної кількості новин
$totalNews = $db->query("SELECT COUNT(*) as total FROM news WHERE 1=1")->fetch_assoc()['total'];
$totalPages = ceil($totalNews / $limit);
?>

<div class="container">
    <h2>Recent blog posts</h2>

    <!-- Форма пошуку та фільтрації -->
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search news..." value="<?= htmlspecialchars($search_query) ?>">
        <input type="date" name="start_date" value="<?= htmlspecialchars($filter_start) ?>">
        <input type="date" name="end_date" value="<?= htmlspecialchars($filter_end) ?>">
        <button type="submit">Apply</button>
    </form>

    <!-- Виведення новин -->
    <?php if ($newsList->num_rows > 0): ?>
        <div class="news-grid">
            <?php while ($news = $newsList->fetch_assoc()): ?>
                <div class="news-item">
                    <div class="news-content">
                        <small class="news-date"><?= date('d.m.Y H:i', strtotime($news['created_at'])) ?></small>
                        <h3><?= htmlspecialchars($news['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($news['short_description'])) ?></p>
                        <a href="news.php?id=<?= $news['id'] ?>">Read more →</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="no-results">No news found for the selected criteria.</p>
    <?php endif; ?>

    <!-- Пагінація -->
    <?php if ($totalNews > $limit): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
