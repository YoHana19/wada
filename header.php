<?php
require('dbconnect.php');

// ページ名の取得
$file_name = getFileNameFromUri();

// 友達リクエスト申請者の取得
$sql = 'SELECT * FROM `friends` AS f LEFT JOIN `members` AS m ON f.login_member_id=m.member_id WHERE f.friend_member_id=? AND f.state=0 ORDER BY f.created';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$requests = array();
while ($request = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $requests[] = $request;
}
?>


<nav class="navbar navbar-webmaster" style="width:'auto'; height: 80px">
  <div class="header-bk">
    <div class="navbar-header">
      <a class="navbar-brand" href="timeline.php">和だ</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav navbar-right">
        <!-- 友達リクエスト -->
        <li class="active click">
          <a id="request_button" style="text-align: center;"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a>
          <!-- 友達リクエスト一覧 -->
          <div id="requests" class="requests-display">
            <div class="left-wrap" style="padding: 0; background-color: #bce2e8; width: auto;" >
              <?php foreach ($requests as $request) { ?>
                <div class="media" style="position: relative; margin-top: 3px; border-bottom: solid 1px #ffffff; padding: 5px;">
                  <a class="pull-left">
                    <img class="media-object" src="assets/images/users/<?php echo $request['user_picture_path']; ?>" style="width: 30px; height: 30px; border-radius: 50%; margin: 0 0 4px 4px;">
                  </a>
                  <div class="media-body" style="padding-top: 6px;">
                    <span class="media-heading"><?php echo $request['nick_name'];?></span>
                  </div>
                  <div id="<?php echo $request['login_member_id'] . '_cont' ?>" class="request-button" style="text-align: right; padding-right: 5px;">
                    <button type="button" id="<?php echo $request['login_member_id'] . '_a' ?>" class="request btn request-admit">許可</button>
                    <button type="button" id="<?php echo $request['login_member_id'] . '_r' ?>" class="request btn request-delete">削除</button>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </li>
        <!-- プロフページ -->
        <li class="active click"><a href="profile.php"><i class="fa fa-user fa-2x" aria-hidden="true"></i><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
        <!-- チャットページ -->
        <li class="active click"><a href="chat.php"><i class="fa fa-comments fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
        <!-- 友達一覧ページ -->
        <li class="active click"><a href="friends.php"><i class="fa fa-users fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
        <!-- ランキングページ -->
        <li class="active click"><a href="ranking.php"><i class="fa fa-sort-numeric-asc fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
        <!-- ログアウト -->
        <li id="logout"><a href="logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a></li>

        <form action="timeline.php" method="POST" class="navbar-form navbar-right search-form form-horizontal" role="search">
          <!-- 検索フォーム -->
          <div>
            <div class="input-group">
              <?php if (isset($search_word)): ?>
                <input type="text" name="search_word" class="search-query form-control" placeholder="あなぐる" value="<?php echo $search_word ?>">
              <?php else: ?>
                <input type="text" name="search_word" class="search-query form-control" placeholder="あなぐる">
              <?php endif; ?>
              <span class="input-group-btn">
                <button type="submit" class="btn btn-danger">
                  <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
                </button>
              </span>
            </div>
            <!-- 詠むボタン -->
            <?php if ($file_name != 'chat.php'): ?>
              <input type="button" id="modal-open" class="btn btn-info haiku-input" value="詠む">
            <?php endif; ?>
          </div>
        </form>
      </ul>
    </div>
  </div>
</nav>


<?php if ($file_name != 'chat.php'): ?>
  <!-- LOGIN FORM -->
  <div id="modal-content_1" class="haiku-mw-content">
    <div class="text-center">
      <div class="logo">
        <img src="assets/images/source/yomu.png">
      </div>
      <!-- Main Form -->
      <div class="login-form-1">
        <form action="send/send_haiku.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="login-form-main-message"></div>
          <div class="main-login-form">
            <div class="login-group">
              <!-- 上の句 -->
              <div class="form-group">
                <label for="up_haiku" class="sr-only">Username</label>
                <input type="text" class="form-control" id="up_haiku" name="up_haiku" placeholder="壱行目（四〜六文字）">
                <p id="up_haiku_valid" class="haiku-input-err" style="display: none">四から六文字で入力してください</p>
              </div>
              <!-- 中の句 -->
              <div class="form-group">
                <label for="md_haiku" class="sr-only">Username</label>
                <input type="text" class="form-control" id="md_haiku" name="md_haiku" placeholder="弐行目（六〜八文字）">
                <p id="md_haiku_valid" class="haiku-input-err" style="display: none">六から八文字で入力してください</p>
              </div>
              <!-- 下の句 -->
              <div class="form-group">
                <label for="lw_haiku" class="sr-only">Username</label>
                <input type="text" class="form-control" id="lw_haiku" name="lw_haiku" placeholder="参行目（四〜六文字）">
                <p id="lw_haiku_valid" class="haiku-input-err" style="display: none">四から六文字で入力してください</p>
              </div>

              <!-- 一言説明 -->
              <div class="form-group" style="margin-top: 15px;">
                <label for="short_comment" class="sr-only">Username</label>
                <input type="text" class="form-control" id="short_comment" name="short_comment" placeholder="一言説明（二十文字以下）">
                <p id="short_comment_valid" class="haiku-input-err" style="display: none">二十文字以内で入力してください</p>
              </div>

              <!-- 画像送信 -->
              <div class="form-group" style="margin-top: 15px; position: relative; padding-right: 0;">
                <input type="file" id="photo_file" name="photo_file" style="display:none;" onchange="changePhotoFile();" accept="image/*">
                <img id="photo_img" src="assets/images/source/photo_submit.png" alt="参照" class="img-submit">
                <input id="photo_display" type="text" name="photo_display" value="" size="25" style="margin-left: 10px; width: 200px;">
              </div>
            </div>

            <!-- 詠むボタン -->
            <div id="yomu">
              <button type="button" id="yomu_pre" class="login-button" style="font-size: 16px;">詠</button>
              <input id="yomu_ready" type="button" onclick="submit();" class="login-button" value="詠" style="font-size: 16px; background-color: #f8b862; color: #ffffff; display: none;">
            </div>
          </div>
        </form>
      </div>
      <!-- end:Main Form -->

      <!-- 戻るボタン -->
      <div style="text-align: right;">
        <button type="button" id="modal-close" class="btn btn-info input-back">戻る</button>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- 友達リクエスト -->
<script src="assets/js/friend_requests.js"></script> 

<?php if ($file_name != 'chat.php'): ?>
  <!-- 俳句入力バリデーション -->
  <script src="assets/js/haiku_input.js"></script>

  <!-- jQuery (necessary for Modal Window) -->
  <script src="assets/js/modal_window.js"></script>

  <script>
    // 1番最初のモーダルウィンドウ呼び出し
    modalWindowOnFirst('modal-open', 'modal-content_1');

    // 2番目のモーダルウィンドウ呼び出し
    // modalWindowOn('modal-check', 'modal-content_1', 'modal-content_2');

    // モーダルウィンドウの終了
    modalWindowOff('modal-close', 'modal-content_1');
  </script>
<?php endif; ?>
