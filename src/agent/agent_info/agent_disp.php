<?php 

require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();
$sql = "SELECT * FROM clients WHERE client_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$agent= $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"
    />
    <link rel="stylesheet" href="../../vendor/tailwind/tailwind.output.css">
    <title>boozer企業詳細</title>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50"
      :class="{ 'overflow-hidden': isSideMenuOpen}"
    >
      <!-- side banner -->
      <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-slate-500 md:block" >
        <div class="py-4 text-gray-500">
          <a
            class="ml-6 text-lg font-bold text-gray-800 "
            href="#"
          >
            SideBanner
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="../../admin/boozer_index.php">
                <span class="ml-4">企業一覧</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
                <span class="ml-4">企業新規登録</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="../../admin/boozer_student.php">
                <span class="ml-4">学生一覧</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
                <span class="ml-4">無効申請一覧</span>
                <!-- 無効申請で絞り込みする -->
              </a>
            </li>
          </ul>
        </div>
      </aside>

      <div class="flex flex-col flex-1 w-full">
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 ">企業詳細</h2>
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                      <th class="px-4 py-3">企業名</th>
                      <th class="px-4 py-3">掲載期間</th>
                      <th class="px-4 py-3">登録状態</th>
                      <th class="px-4 py-3">操作</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y">
                    <tr class="text-gray-700">
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?=$agent["service_name"]?></p>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?=$agent["started_at"]?>  ~  <?=$agent["ended_at"]?>
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full"
                        >
                        <!-- 色の設定はクラスの付加でjqueryで行う 登録無効（拒否）-->
                          登録完了
                        </span>
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <button
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit"
                            data = <?=$agent["client_id"]?>
                          >
                            <a href="http://localhost:8080/agent/agent_info/agent_disp.php?id=<?=$agent["client_id"]?>">詳細</a>
                          </button>
                        </div>
                      </td>
                    </tr> 
                  </tbody>
                </table>
              </div>
              <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t sm:grid-cols-9">
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
  </body>
</html>
