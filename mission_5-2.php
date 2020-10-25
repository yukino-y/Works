<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-2</title>
</head>
<body>
    <?php

	// DB接続設定*/
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$hensyuname="";
$hensyutext="";
$hensyunum="";
$pass="pass";


if(!empty($_POST["hensyu"]) && $_POST["pass"]==$pass){
	$id =  $_POST["hensyu"]; // idがこの値のデータだけを抽出したい、とする

    $sql = 'SELECT * FROM tbtest_512 WHERE id=:id ';
    $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
    $stmt->execute();                             // ←SQLを実行する。
    $results = $stmt->fetchAll(); 
    	foreach ($results as $row){
    		//$rowの中にはテーブルのカラム名が入る
    		$row['id'];
    		$hensyuname=$row['name'];
    		$hensyutext=$row['comment'];
    	echo "<hr>";
    	}
    	$hensyunum=$_POST["hensyu"];
}

?>

    <form action="" method="post">
         <div>
             <td>名前:　　　　</td>
         <input type="text" name="name" placeholder="名前" value="<?php echo $hensyuname;?>">
         </div>
         <div>
             <td>コメント:　　</td>
         <input type="text" name="comment" placeholder="コメント" value="<?php echo $hensyutext;?>">
         </div><div>
   <!-- 投稿番号 -->
         <input type="hidden" name="hensyunum" value="<?php echo $hensyunum;?>">
         </div><div>
              <td>パスワード:　</td>
         <input type="password" name="pass">
         </div><div>
        <input type="submit" name="submit">
         </div>
        </form><br>
    <form action="" method="post">
             <td>削除:　　　　</td>
         <input type="number" name="sakujo" placeholder="削除番号指定">
         </div><div>
            <td>パスワード:　</td>
         <input type="password" name="pass">
         </div>
        <input type="submit" name="submit">
        </form><br>
    <form action="" method="post">
             <td>編集フォーム:</td>
         <input type="number" name="hensyu" placeholder="編集番号">
         </div><div>
            <td>パスワード:　</td>
         <input type="password" name="pass">
         </div>
        <input type="submit" name="submit">
    </form><br>

<?php
$date=date('Y-m-d H:i:s');

if(!empty($_POST["comment"]) && !empty($_POST["name"]) && $_POST["pass"]==$pass){
    if(!empty($_POST["hensyunum"])){
        $id = $_POST["hensyunum"]; //変更する投稿番号
	    $name = $_POST["name"];
    	$comment = $_POST["comment"];
    	$sql = 'UPDATE tbtest_512 SET name=:name,comment=:comment,date=:date WHERE id=:id';
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
    	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    	$stmt->execute();
    }
    elseif(isset($_POST["hensyunum"])){
	$sql = $pdo -> prepare("INSERT INTO tbtest_512 (name, comment, date) VALUES (:name, :comment, :date)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
	$date=date('Y-m-d H:i:s');
	$sql -> execute();
    }
}

elseif(!empty($_POST["sakujo"])&& $_POST["pass"]==$pass){
    $id = $_POST["sakujo"];
	$sql = 'delete from tbtest_512 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}  

	$sql = 'SELECT * FROM tbtest_512';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	/*$date=date("Y/m/d　H:i:s");*/
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].',';

	echo "<hr>";

	}


 ?>
</body>
</html>