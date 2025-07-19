<?php
include 'db.php';

// إضافة بيانات جديدة
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $conn->query("INSERT INTO ai_student (name, age) VALUES ('$name', $age)");
    header("Location: index.php"); exit;
}

// تبديل الحالة
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $row = $conn->query("SELECT status FROM ai_student WHERE id=$id")->fetch_assoc();
    $new_status = $row['status'] == 1 ? 0 : 1;
    $conn->query("UPDATE ai_student SET status=$new_status WHERE id=$id");
    header("Location: index.php"); exit;
}

// جلب البيانات
$result = $conn->query("SELECT * FROM ai_student");
?>

<!DOCTYPE html>
<html>
<head>
    <title>ai_student Form</title>
    <style>
        body {background: #222; color: #fff;}
        table {border-collapse: collapse;}
        th, td {padding: 8px; border: 1px solid #999;}
    </style>
</head>
<body>
    <form method="POST">
        Name: <input type="text" name="name" required>
        Age: <input type="number" name="age" required>
        <button type="submit" name="add">Submit</button>
    </form>
    <br>
    <table>
        <tr><th>ID</th><th>Name</th><th>Age</th><th>Status</th><th>Action</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']?></td>
                <td><?= htmlspecialchars($row['name'])?></td>
                <td><?= $row['age']?></td>
                <td><?= $row['status']?></td>
                <td>
                    <a href="?toggle=<?= $row['id']?>"><button type="button">Toggle</button></a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
