<?php
try {
    $db = new PDO('sqlite:obituary_platform.db');

    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $total_results = $db->query("SELECT COUNT(*) FROM obituaries")->fetchColumn();
    $total_pages = ceil($total_results / $limit);

    $stmt = $db->prepare("SELECT * FROM obituaries LIMIT :start, :limit");
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $obituaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$meta_description = "View obituaries and remember your loved ones. Browse through the latest obituaries and share memories.";
$meta_keywords = "obituaries, remembrance, loved ones, obituary listings";
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Obituaries</title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta property="og:title" content="View Obituaries">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://yourwebsite.com/view_obituaries.php">
    <meta property="og:image" content="http://yourwebsite.com/path/to/og_image.jpg">
    <link rel="canonical" href="http://yourwebsite.com/view_obituaries.php?page=<?php echo $page; ?>">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #5cb85c;
            color: white;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #4cae4c;
        }
        .share-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .share-buttons a {
            margin: 0 5px;
            text-decoration: none;
            background-color: #3b5998;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            display: inline-block;
        }
        .share-buttons a.twitter {
            background-color: #55acee;
        }
    </style>
</head>
<body>
    <h1>Obituaries</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Date of Death</th>
            <th>Content</th>
            <th>Author</th>
        </tr>
        <?php if (!empty($obituaries)): ?>
            <?php foreach ($obituaries as $obituary): ?>
                <tr>
                    <td><?php echo htmlspecialchars($obituary['name']); ?></td>
                    <td><?php echo htmlspecialchars($obituary['date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($obituary['date_of_death']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($obituary['content'])); ?></td>
                    <td><?php echo htmlspecialchars($obituary['author']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">No obituaries found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
    <div class="share-buttons">
        <a href="https://www.facebook.com/sharer/sharer.php?u=http://yourwebsite.com/view_obituaries.php" target="_blank">Share on Facebook</a>
        <a class="twitter" href="https://twitter.com/share?url=http://yourwebsite.com/view_obituaries.php&text=Check%20out%20these%20obituaries" target="_blank">Share on Twitter</a>
    </div>
</body>
</html>
