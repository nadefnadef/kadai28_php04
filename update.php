<?php
// 1. POSTデータ取得
$id = $_POST['id'];
$facility_name = $_POST['facility_name'];
$destination_name = $_POST['destination_name'];
$duration = $_POST['duration'];

// 2. DB接続
try {
    $pdo = new PDO('mysql:dbname=nadefnadef_genzaichi01;charset=utf8;host=mysql3101.db.sakura.ne.jp', 'nadefnadef_genzaichi01', 'genzaichi01');
} catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
}

// 3. データ更新SQL作成
$stmt = $pdo->prepare("UPDATE gs_an_table3 SET facility_name = :facility_name, destination_name = :destination_name, duration = :duration WHERE id = :id");
$stmt->bindValue(':facility_name', $facility_name, PDO::PARAM_STR);
$stmt->bindValue(':destination_name', $destination_name, PDO::PARAM_STR);
$stmt->bindValue(':duration', $duration, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 4. データ更新処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL Error: ".$error[2]);
} else {
    header('Location: select.php');
}
?>

