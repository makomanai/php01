<?php
//1. DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

//2. データ登録SQL作成
$stmt =$pdo->prepare("SELECT * FROM  gs_an_table");
$status =$stmt->execute();

//3. データ表示
$view="";
if($status==false){
    //execute(SQL実行時にエラーがある場合)
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);

}else{
    //selectデータの数だけ自動でループしてくれる
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        //$view .= "<p>".re.$result["id"]."-".$result["name"]."</p>"; //ドットは追加を意味する
        $view .="<p>";
        $view .='<a href="u_view.php?id='.$result["id"].'">';
        $view .=$result["indate"]." : ".$result["name"];
        $view .='</a>';
        $view .='　';
        $view .='<a href="delete.php?id='.$result["id"].'">';
        $view .='[削除]';
        $view .'</a>';
        $view .="</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリーアンケート表示</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->

<header>
    <nav class="navbar navbar-default">
     <div class="container-fluid">
      <div class="navbar-header">
      <a. class="navbar-brand" href="select.php">データ登録</a>
      </div>
    </div>
   </nav>
</header>
<!--Head[End]-->

<!--Main[Start]-->

<div>
   <div class="container jumbotron"><?=$view?></div>
</div>
<!--Main[End]-->
</body>
</html>