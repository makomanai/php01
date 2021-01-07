<?php
//1.GETでidを取得
$id =$_GET["id"];

//2.DB接続
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。'.$e->getMessage());
} 

//3.UPDATE gs_an_table SET....で更新(bindValue)
$sql = 'DELETE FROM gs_an_table  WHERE id=:id';
$stmt= $pdo->prepare($sql);
$stmt->bindValue(':id',   $id,   PDO::PARAM_INT);
$status = $stmt->execute();

//4.データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブ
    $error =$stmt->errorInfo();
    exit("QueryError:".$error[2]); //処理をとめる[2]エラー文
}else{
    //5. index.phpへリダイレクト
    header("Location: select.php"); //header はっっかく
    exit;//おまじない的な意味

}
?>
