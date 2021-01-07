<?php
//入力チェック
if(
!isset($_POST["name"]) || $_POST["name"]=="" ||
!isset($_POST["email"]) || $_POST["email"]=="" ||
!isset($_POST["address"]) || $_POST["address"]=="" ||
!isset($_POST["naiyou"]) || $_POST["naiyou"]==""
){
    exit('ParamError');//エラーを防ぐおまじない
}

//1.POSTデータ取得
$name = $_POST["name"];//アンケート画面で記入したものが飛んでくる
$email = $_POST["email"];
$address = $_POST["address"];
$naiyou = $_POST["naiyou"];

//2. DB接続します（エラー処理追加）
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');//新しく作るときはgs＿の変更必要 host＝さくらを使う場合変更 ＞'pass'入れる
} catch (PDOException $e) {
    exit('DbConnectError:'.$e->getMessage());
}//この塊が毎回使える

//3. データ登録SQL作成
$sql = "INSERT INTO gs_an_table(id, name, email, address, naiyou, indate )VALUES(NULL,:a1,:a2,:a3,:a4, 
sysdate() )"; //変数をそのまま入れると危険なので入れ替える
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':a1',$name, PDO::PARAM_STR); //Integer(数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2',$email, PDO::PARAM_STR); //Integer(数値の場合)PDO::PARAM_INT)
$stmt->bindValue(':a3',$address, PDO::PARAM_STR); //Integer(数値の場合)PDO::PARAM_INT)
$stmt->bindValue(':a4',$naiyou, PDO::PARAM_STR); //Integer(数値の場合PDO::PARAM_INT)
$status = $stmt->execute();

//4.データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブ
    $error =$stmt->errorInfo();
    exit("QueryError:".$error[2]); //処理をとめる[2]エラー文
}else{
    //5. index.phpへリダイレクト
    header("Location: post.php"); //header はっっかく
    exit;//おまじない的な意味

}
?>
