<?php
session_start();
require('../dbconnect.php');

ini_set("log_errors", "on");
ini_set("error_log", "/Applications/MAMP/htdocs/mini_bbs/watch.log");


if (!isset($_SESSION['join'])) {
	header('Location: index.php');
	exit();
}

if (!empty($_POST)) {
	$statement = $db->prepare(
		'INSERT INTO membersm SET 
			name=?, email=?, 
			password=?, 
			picture=?, 
			created=NOW()');

    echo $statement->execute(array(
		$_SESSION['join']['name'],
		$_SESSION['join']['email'],
		sha1($_SESSION['join']['password']),
		$_SESSION['image']));

	unset($_SESSION['join']);
	unset($_SESSION['image']);

	header('Location: thanks.php');
	exit();

	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<div id="content">
<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
<form action="" method="post">
	<input type="hidden" name="action" value="submit" />
	<dl>
		<dt>ニックネーム</dt>
		<dd>
		<?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES));
		?>
        </dd>
		<dt>メールアドレス</dt>
		<?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES));
		?>
		<dd>
        </dd>
		<dt>パスワード</dt>
		<dd> 
		【表示されません】
		</dd>
		<dt>写真など</dt>
		<dd>
		<?php if ($_SESSION['image'] !== '') : ?>
			<img src="../member_picrure/<?php print($_SESSION['image']); ?>" width="100" height="100" alt="">
		<?php endif; ?>
		</dd>
	</dl>
	<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
</form>
</div>
</div>
</body>
</html>
<pre>
<?php
echo "<br>============debug=================<br>";
echo "<br>---------------【SESSION】--------------------<br>";
print_r($_SESSION);

// session_destroy();
// $_SESSION = array();
?>
</pre>