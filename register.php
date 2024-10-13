<?php
// 1. POSTデータ取得
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $name_katakana = $_POST['name_katakana'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. バリデーションチェック
    if (empty($name) || empty($name_katakana) || empty($email) || empty($password)) {
        echo '全てのフィールドを入力してください。';
    } elseif (!preg_match('/^[a-zA-Z0-9]{6,20}$/', $password)) {
        echo 'パスワードは6〜20文字の半角英数字で入力してください。';
    } else {
        // 3. パスワードのハッシュ化
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 4. DB接続
        try {
            $pdo = new PDO('mysql:dbname=nadefnadef_genzaichi01;charset=utf8;host=mysql3101.db.sakura.ne.jp', 'nadefnadef_genzaichi01', 'genzaichi01');
        } catch (PDOException $e) {
            exit('DB Connection Error:'.$e->getMessage());
        }

        // 5. データ登録SQL作成
        $stmt = $pdo->prepare("INSERT INTO users (name, name_katakana, email, password) VALUES (:name, :name_katakana, :email, :password)");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':name_katakana', $name_katakana, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);

        $status = $stmt->execute();

        // 6. 処理後
        if ($status == false) {
            $error = $stmt->errorInfo();
            exit("SQL Error: ".$error[2]);
        } else {
            // ユーザーが正常に登録された場合、ログインページにリダイレクト
            header('Location: login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザー登録</title>
</head>
<body>
    <h1>新規ユーザー登録</h1>
    <form action="register.php" method="POST">
        <label for="name">名前（漢字）:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="name_katakana">なまえ（カタカナ）:</label>
        <input type="text" id="name_katakana" name="name_katakana" required><br><br>

        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]{6,20}" title="6〜20文字の半角英数字で入力してください" required><br><br>

        <input type="submit" value="新規ユーザー登録する">
    </form>
</body>
</html>
