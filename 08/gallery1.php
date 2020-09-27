<?php
require_once 'util.inc.php';
const UP_PATH = 'uploads/';

$size = 200;
$num  = 5;

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
    <title>画像ギャラリー</title>
    <style>
        h1,
        form,
        table {
            width: <?= $size * $num * .8 ?>px;
            margin: auto;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        img {
            display: block;
            padding: 3px;
            border: 1px solid #aaa;
            box-shadow: 0 0 8px #ccc;
        }

        span {
            font-size: 12px;
            font-weight: bold;
        }

        span::after {
            content: " ]";
        }

        span::before {
            content: "[ ";
        }

        .error {
            color: #990000;
        }
    </style>
</head>

<body>
    <h1>画像ギャラリー</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>画像幅：
            <select name="size">
                <option <?= $size == 100 ? 'selected' : '' ?>>100</option>
                <option <?= $size == 150 ? 'selected' : '' ?>>150</option>
                <option <?= $size == 200 ? 'selected' : '' ?>>200</option>
            </select>
        </p>
        <p>横並びの数：
            <input type="radio" name="num" value="3" <?=$num == 3 ? 'checked' : '' ?>>3
            <input type="radio" name="num" value="4" <?=$num == 4 ? 'checked' : '' ?>>4
            <input type="radio" name="num" value="5" <?=$num == 5 ? 'checked' : '' ?>>5
            <input type="radio" name="num" value="6" <?=$num == 6 ? 'checked' : '' ?>>6
        </p>
        <p>
            <input type="file" name="upfile">
            <input type="submit" value="送信">
        </p>
    </form> <?php if (isset($messageError)) : ?>
        <p class="error"><?= h($messageError) ?></p>
    <?php endif; ?>
    <?php if (0 < count($files)) : ?>
        <table>
            <tr>
                <th colspan="<?=h($num)?>"">画像一覧</th>
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
    <?php else : ?>
        <table>
            <tr>
                <th>画像一覧</th>
            </tr>
            <tr>
                <td>アップロードされたファイルはありません</td>
            </tr>
        </table>
    <?php endif; ?>
</body>

</html>