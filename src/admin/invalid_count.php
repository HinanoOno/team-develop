<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$count = $pdo->query("SELECT COUNT(*) FROM (SELECT id, updated_at, name, hurigana, college, faculty, grad_year FROM users INNER JOIN user_register_client AS relation ON users.id = relation.user_id WHERE valid = 1 OR valid = 2 GROUP BY id) AS sub")->fetchAll(PDO::FETCH_ASSOC);

?>
