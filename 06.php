<?php




if (!empty($_POST)) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $mail = $_POST['mail'];
}else {
    $name = '';
    $age = '';
    $mail = '';
}

function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            width: 600px;
        }

        th,
        td {
            border: 1px solid #666666;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #dddddd;
        }
    </style>
    <title>フォーム</title>
</head>

<body>
    <?php if (!empty($mail)) : ?>

        <tr>
            <th>名前</th>
            <th>年齢</th>
            <th>メール</th>
        </tr>
        <tr>
            <td><?=$name?></td>
            <td><?=$age?></td>
            <td><?=$mail?></td>
        </tr>


    <?php else : ?>
        <h1> フォーム</h1>

        <form action="" method="post">
            名前：<input type="text" value="<?=h($name)?>" name="name" size="10">
            年齢：<input type="text" value="<?=h($age)?>" name="age" size="3" maxlength="3">
            メール：<input type="email" value="<?=h($mail)?>" name="mail">
            <p><input type="submit" value="送信"></p>
        </form>
    <?php endif; ?>
</body>

</html>