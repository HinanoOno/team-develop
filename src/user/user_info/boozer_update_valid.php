<?php
session_start();

require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = $_POST['data'];
$clientId = $_POST['clientId'];

$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", $data);
$stmt->bindValue(":uid", $_SESSION["uid"]);
$stmt->bindValue(":client_id", $clientId);
$stmt->execute();

// 理由取得
$sql1 = "SELECT reason FROM invalid_reason WHERE user_id = :uid AND client_id = :client_id;";
$stmt1 = $pdo->prepare($sql1);
$stmt1->bindValue(":uid", $_SESSION["uid"]);
$stmt1->bindValue(":client_id", $clientId);
$stmt1->execute();
$fetchedData = $stmt1->fetch(PDO::FETCH_ASSOC);
$stmt1->errorInfo();


// userへのメールアドレス取得
$sql2 = "SELECT mail FROM users WHERE id = :uid";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(":uid", $_SESSION["uid"]);
$stmt2->execute();
$user = $stmt2->fetch(PDO::FETCH_ASSOC);

// 企業へのメールアドレスを取得
$sql3 = "SELECT mail FROM managers WHERE client_id = :client_id";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindValue(":client_id", $clientId);
$stmt3->execute();
$manager = $stmt3->fetch(PDO::FETCH_ASSOC);

// 会社名取得
$sql4 = "SELECT service_name FROM clients WHERE client_id = :client_id";
$stmt4 = $pdo->prepare($sql4);
$stmt4->bindValue(":client_id", $clientId);
$stmt4->execute();
$client = $stmt4->fetch(PDO::FETCH_ASSOC);

$headers = 'From: admin@mail' . "\r\n" .
    'Reply-To: admin@mail' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// user宛のメール
$to_user= $user["mail"];
$subject_user = "【株式会社boozer】企業への申請拒否のお知らせ";
$message_user = "※このメールはシステムからの自動返信です\n\n";
$message_user .= $fetchedData["reason"] . "のため、" . $client["service_name"] . "への申請を拒否させていただきました。\n";
$message_user .= "ご不明点があればご連絡ください\n\n";

// 企業宛のメール
$to_manager = $manager["mail"];
$subject_manager = "【株式会社boozer】申請承認のお知らせ";
$message_manager = "※このメールはシステムからの自動返信です\n\n";
$message_manager .= "株式会社boozerでの新規登録ありがとうございました。\n\n";
$message_manager .= "無効申請を承認させていただきました。\n";
$message_manager .= "詳しくはCRAFTのページをご覧ください\n\n";
$message_manager .= "ご不明点あれば連絡ください\n\n";

// 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
function send_email($to, $subject, $message, $headers) {
    if (mail($to, $subject, $message, $headers)) {
    } else {
        echo "メールの送信に失敗しました。\n";
        echo "エラー情報: " . error_get_last()['message'];
    }
}

send_email($to_user, $subject_user, $message_user, $headers);
send_email($to_manager, $subject_manager, $message_manager, $headers);

?>
