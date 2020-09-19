<?php
session_start();
require('/Applications/MAMP/htdocs/mini_bbs/dbconnect.php');
ini_set("log_errors", "on");
// ini_set('display_errors', 1);
ini_set("error_log", "/Applications/MAMP/htdocs/mini_bbs/watch.log");

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}

var_dump($_POST);

if (!empty($_POST)) {
  $email = $_POST['email'];

  if (($_POST['email'] !=='' && $_POST['password'] !=='')) {
    $login = $db->prepare('SELECT * FROM membersm WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])  
    ));
    $member = $login->fetch();
    var_dump($member);
    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if ($_POST['save'] === 'on') {
        setcookie('email', $_POST['email'], time()+60*60*24*14);
      }
      header('Location: index.php');
      exit();
    } else {
      $error['login'] ='faild';
    }
  } else {
    $error['login'] ='blank';
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" >
<title>ログインする</title>
</head>

<body>
<div id="wrap">
  <div id="head">
    <h1>ログインする</h1>
  </div>
  <div id="content">
    <div id="lead">
      <p>メールアドレスとパスワードを記入してログインしてください。</p>
      <p>入会手続きがまだの方はこちらからどうぞ。</p>
      <p>&raquo;<a href="join/">入会手続きをする</a></p>
    </div>
    <form action="" method="post">
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" />
          <?php if ($error['login'] === 'blank') : ?>
            <p class='error'>入力してください</p>
          <?php endif ?>
          <?php if ($error['login'] === 'faild') : ?>
            <p class='error'>間違ってます</p>
          <?php endif ?>
        </dd>
        <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
          <?php
          var_dump($_POST);

?>
        </dd>
        <dt>ログイン情報の記録</dt>
        <dd>
          <input id="save" type="checkbox" name="save" value="on">
          <label for="save">次回からは自動的にログインする</label>
        </dd>
      </dl>
      <div>
        <input type="submit" value="ログインする" />
      </div>
    </form>
  </div>
  <div id="foot">
    <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
  </div>
</div>
</body>
</html>