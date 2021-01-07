<?php
//1.POSTでid,name,email,address,naiyouを取得
$id      = $_POST["id"];
$name    = $_POST["name"];
$email   = $_POST["email"];
$address = $_POST["address"];
$naiyou  = $_POST["naiyou"];
//2.DB接続
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。'.$e->getMessage());
} 

//3.UPDATE gs_an_table SET....で更新(bindValue)
$sql = ('UPDATE gs_an_table SET name=:name,email=:email,address=:address,naiyou=:naiyou WHERE id=:id');
$stmt= $pdo->prepare($sql);
$stmt->bindValue(':name',   $name,   PDO::PARAM_STR);
$stmt->bindValue(':email',  $email,  PDO::PARAM_STR);
$stmt->bindValue(':address',$address,PDO::PARAM_STR);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$stmt->bindValue(':id',     $id,     PDO::PARAM_INT);  //更新したいIDを渡す
$status = $stmt->execute();

//4.データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);

}else{
    //select.phpへリダイレクト
    header("Location:select.php");//一覧画面に戻す
    exit;

}
?>