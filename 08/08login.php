<?php

require_once 'util.inc.php';
const UP_PATH = 'uploads/';


$size = 200;
$num  = 5;

session_start();
if (!empty($_SESSION)) {
    if ($_SESSION['authenticated'] == true) {
        header('Location: 08member.php');
        exit;
    }
} else {
    $user = '';
}

if (!empty($_POST)) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    if ($user === 'taro' and $pass === 'abcd') {
        $_SESSION['authenticated'] = true;

        $_SESSION['userid'] = $user;
        header('Location: 08member.php');
    } else {
        $loginError = 'ユーザIDかパスワードが正しくありません。';
    }
} else {
    $user = '';
}












if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $size = $_POST['size'];
    $num  = $_POST['num'];

    if ($_FILES['upfile']['error'] == UPLOAD_ERR_OK) {
        if (!move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            UP_PATH . serialNum(mb_convert_encoding(
                $_FILES['upfile']['name'],
                'cp932',
                'utf8')
            )
        )) {
            $errorMessage = 'アップロードに失敗しました';
        }
    } elseif ($_FILES['upfile']['error'] == UPLOAD_ERR_NO_FILE) {
    } else {
        $errorMessage = 'アップロードに失敗しました';
    }
}

$files = glob('uploads/*.png');






?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error {
            color: #f00;
        }
    </style>
    <title>ログイン</title>
</head>

<body>
<!-- ログイン -->
    <h1>ログイン</h1>

    <p>ユーザーIDとパスワードを入力して「ログイン」を押してください。</p>
    <?php if (isset($loginError)) : ?>
        <p class="error"><?php h($loginError) ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <table>
            <tr>
                <td class="left">ユーザーID</td><td class="right"><input type="text" name="user"></td>
            </tr>
            <tr>
                <td class="left">パスワード</td><td class="right"><input type="password" name="pass"></td>
            </tr>

        </table>
        <p><input type="submit" value="送信"></p>
    </form>



    <!-- 画像表示 -->

        <table>
            <tr>
                <th colspan="<?=h($num)?>">画像一覧</th>
            </tr>
            <tr>
                <?php for ($i = 0; $i < count($files); $i++) : ?>
                    <?php
                    $file = mb_convert_encoding($files[$i], 'utf8', 'cp932');
                    $file_name = str_replace(['uploads/', '.png'], '', $file);
                    ?>
                    <?php if ($i % $num == ($num - 1)) : ?>
                        <td><img src="<?= h($files[$i]) ?>" alt="<?= h($file) ?>" width="<?=h($size)?>"><span><?= h($file_name) ?></span></td>
            </tr>
            <tr>
            <?php else : ?>
                <td><img src="<?= h($files[$i]) ?>" alt="<?= h($file) ?>" width="<?=h($size)?>"><span><?= h($file_name) ?></span></td>
            <?php endif; ?>
        <?php endfor; ?>
            </tr>
        </table>
<?php if (!isset($files)):?>
        <table>
            <tr>
                <th>画像一覧</th>
            </tr>
            <tr>
                <td>アップロードされたファイルはありません</td>
            </tr>
        </table>
<?php endif;?>
</body>

</html>