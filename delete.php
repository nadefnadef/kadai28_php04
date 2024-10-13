<?php
// 1. POSTデータ取得
$id = $_POST['id'];

// 2. DB接続
try {
    $pdo = new PDO('');
} catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
}

// 3. データ削除SQL作成
$stmt = $pdo->prepare("DELETE FROM gs_an_table3 WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 4. データ削除処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL Error: ".$error[2]);
} else {
    header('Location: select.php');
}
?>
