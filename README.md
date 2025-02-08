# gl-test - Тестове завдання для Глянець

A simple PHP-based blog system with MySQL database, pagination, search, and filtering.

📌 Features
    📰 Display and manage news articles.
    🔍 Search by keywords in titles and descriptions.
    📅 Filter by date range.
    📑 Pagination for easy browsing.
    ⚙️ Admin panel to add, edit, and delete posts.
    🛡️ Security: Prepared statements to prevent SQL injections.

## 📌 Setup Instructions

🔹 1. Database Setup
    🔸 Step 1: Create Database
        Open phpMyAdmin
        Create a new database gl-test.
        Run the following SQL script to create the news table:

            CREATE TABLE news (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            short_description TEXT NOT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

    🔸 Step 2: Insert Sample Data
        Run this SQL query to insert 8 test news posts into the news table:
            INSERT INTO news (title, short_description, content, created_at) VALUES
            ('Tech Innovations in 2025', 'Discover the latest tech trends...', 'Full article about innovations.', '2025-02-01 10:00:00'),
            ('Best Travel Destinations', 'Top 10 places to visit this year...', 'Complete travel guide.', '2025-02-02 12:30:00'),
            ('Healthy Living Tips', '5 habits to improve your life...', 'Article about healthy living.', '2025-02-03 08:15:00'),
            ('AI and the Future', 'How AI is changing the world...', 'Detailed analysis on AI impact.', '2025-02-04 14:45:00'),
            ('Space Exploration', 'NASA’s new Mars mission...', 'Deep dive into space projects.', '2025-02-05 16:20:00'),
            ('Stock Market Trends', 'Investing strategies for 2025...', 'Complete guide for beginners.', '2025-02-06 09:50:00'),
            ('Cybersecurity in 2025', 'Protecting yourself online...', 'Expert tips on digital security.', '2025-02-07 11:05:00'),
            ('Web Development Trends', 'Latest web dev technologies...', 'Overview of modern frameworks.', '2025-02-08 13:00:00');

🔹 2. Configuring the Project
    Ensure OpenServer or another local server is running.
    Create the project gl-test.local
    Verify that Database.php contains correct database credentials:
        <pre>
        class Database {
            private $host = "localhost";
            private $dbname = "gl-test";
            private $username = "root";
            private $password = "";
            public $conn;

            public function __construct() {
                $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
                if ($this->conn->connect_error) {
                    die("Database connection failed: " . $this->conn->connect_error);
                }
                $this->conn->set_charset("utf8mb4");
            }

            public function query($sql, $params = []) {
                $stmt = $this->conn->prepare($sql);
                if ($params) {
                    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
                }
                $stmt->execute();
                return $stmt->get_result();
            }
        }
        </pre>

🔹 3. Running the Project
    🔸 Step 1: Start the Server
        Open OpenServer and start Apache & MySQL.

    🔸Step 2: Access the Website
        🌎 Home Page: http://gl-test.local/index.php
        🔧 Admin Panel: http://gl-test.local/admin.php
        📝 Edit Post: http://gl-test.local/edit.php?id=1

🔹 4. GitHub Repository
    📌 GitHub Repo: https://github.com/kryvoviazov-aleksandr/gl-test

🔹 5. Technologies Used
    PHP 8.1+
    MySQL
    HTML, CSS
    Vanilla JavaScript
    Git & GitHub



