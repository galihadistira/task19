<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'tugas19');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua kategori untuk navigasi
$categoriesQuery = "SELECT * FROM categories";
$categoriesResult = $conn->query($categoriesQuery);

if (!$categoriesResult) {
    die("Query Error: " . $conn->error);  // Tambahkan pengecekan kesalahan
}

// Ambil artikel berdasarkan pencarian (jika ada)
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$articlesQuery = "SELECT * FROM artikel WHERE title LIKE '%$searchKeyword%'"; // Menggunakan LIKE untuk pencarian
$articlesResult = $conn->query($articlesQuery);

if (!$articlesResult) {
    die("Query Error: " . $conn->error);  // Tambahkan pengecekan kesalahan
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>List of Articles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Navigasi Kategori -->
        <nav class="navbar">
            <ul>
                <?php while($category = $categoriesResult->fetch_assoc()): ?>
                    <li><a href="index.php?category_id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                <?php endwhile; ?>
            </ul>
        </nav>

        <!-- Formulir Pencarian -->
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="search" placeholder="Cari artikel..." value="<?= htmlspecialchars($searchKeyword) ?>" class="search-input">
            <button type="submit" class="search-button">Cari</button>
        </form>
      <div class="artikel-detail"></div>

        <!-- Daftar Artikel -->
        <div class="artikel-list">
            <?php while($artikel = $articlesResult->fetch_assoc()): ?>
                <div class="artikel-item">
                    <h2><a href="artikel.php?id=<?= $artikel['id'] ?>"><?= $artikel['title'] ?></a></h2>
                    <p><?= substr($artikel['content'], 0, 100) ?>...</p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
