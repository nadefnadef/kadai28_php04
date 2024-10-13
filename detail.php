<?php
// 1. GETデータ取得
$id = $_GET['id'];

// 2. DB接続
try {
    $pdo = new PDO('mysql:dbname=nadefnadef_genzaichi01;charset=utf8;host=mysql3101.db.sakura.ne.jp', 'nadefnadef_genzaichi01', 'genzaichi01');
} catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
}

// 3. データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table3 WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 4. データ表示
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL Error: ".$error[2]);
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入力内容編集ページ</title>
</head>
<body>
    <h1>入力内容編集ページ</h1>

    <!-- 編集フォーム -->
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?>">
        <label for="facility_name">施設名:</label>
        <input type="text" name="facility_name" value="<?= htmlspecialchars($row['facility_name'], ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label for="destination_name">目的地名:</label>
        <input type="text" name="destination_name" value="<?= htmlspecialchars($row['destination_name'], ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label for="duration">所要時間:</label>
        <input type="text" name="duration" value="<?= htmlspecialchars($row['duration'], ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <input type="submit" value="更新">
    </form>

    <!-- 削除ボタン -->
    <form action="delete.php" method="POST" style="margin-top:10px;">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="submit" value="削除" style="background-color:red; color:white;">
    </form>

    <button onclick="window.location.href='select.php'">戻る</button>
</body>
</html>