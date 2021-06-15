
# QR コードによる着席登録システム

## 概要
後期の授業開始に際し、対面授業においてはコロナ感染対策のため誰がどこの座席に着席したかを記録することになりました。そこで、大学の講義室の全座席（約15,000席）の端に QR コードを貼り付け、学生のスマートフォンで QR コードをかざすと、学生がそこに着席したことが記録されるシステムを開発します。

## 処理手順
 - 学生のスマートフォンで QR コード（座席情報に関する情報が記載）を読ませる
 - スマートフォンのブラウザが立ち上がる
 - 全学認証システム（ポータルを見に行くときにでるログイン画面）が表示
 - 認証後、座席がデータベースに登録される
 - データベースの登録情報は、時刻、学籍番号、教室名、座席位置（前後方向）、座席位置（左右方向）など
 - 管理者（職員）が、登録された情報を検索できる。例えば「811 教室の前4左5から前後左右5席の範囲で座ってた学生の一覧を表示」など。

## 構築するもの
 - Web アプリケーション：QR コードにアクセスしたらデータベースに着席情報を登録、管理者の検索画面と検索
 - ユーザインターフェース：着席登録の確認画面、検索結果の表示
 - URL 自動生成および QR コード一括作成：教室名、座席位置を指定したら一括で登録用 URL の発行を行い（Excel のマクロ等）、Word の差し込み印刷で席に貼り付けるシールを作成

## 実行環境の作成
以下、work# とある部分はカレントディレクトリ名を参考のために記載しているものです。コマンド入力は # より以降の部分のみ行ってください。

### サーバ環境のセットアップ
1. 作業用フォルダを用意する
1. github からサーバ環境構成をクローンする
    ```
    work# git clone https://github.com/ocu-stproj/service.git
    ```
1. env.example を .env ファイルにコピーし、.env ファイルを書き換える
    1. MYSQL_ROOT_PASSWORD: MySQL のデータベースを操作するのに必要なパスワード
    1. MYSQL_DUMP_PASSWORD: MySQL のデータベースをバックアップするのに必要なパスワード
1. docker-compose でサーバ環境を作成する
    ```
    work# cd service
    service# docker-compose build
    ```
1. サーバ環境を実行する
    ```
    service# docker-compose up -d
    ```

### データベースの作成
```
service# docker-compose exec mysql bash
(docker)# mysql -p
（MYSQL_ROOT_PASSWORD で設定したパスワードを入れる）
(mysql)> create database seatreg;
(mysql)> exit
(docker)# exit
```

### Web アプリケーションのセットアップと動作確認
1. data/www に移動
    ```
    service# cd data/www
    ```
1. github からアプリケーションをクローン
    ```
    service/data/www# git clone https://github.com/ocu-stproj/seatreg.git
    service/data/www# rm -rf html
    service/data/www# mv seatreg html
    ```
1. php 環境に入り、初期設定を行う
    ```
    service/data/www# cd ../..
    service# docker-compose exec php bash
    /var/www/html# cp .env.example .env
    （.env ファイルを編集 DB_PASSWORD に MYSQL_ROOT_PASSWORD で設定したパスワードを入れる）
    /var/www/html# composer update
    /var/www/html# php artisan key:generate
    /var/www/html# php artisan config:cache
    /var/www/html# php artisan migrate
    /var/www/html# php artisan ui stisla

    /var/www/html# npm install && npm run dev
    ```
1. ブラウザを開き http://localhost:20080/ にアクセス
    1. Laravel の画面がでるか確認
    1. REGISTER から自分のユーザを登録（OCUID には学籍番号を入力）
    1. ログイン後の画面が表示されるかを確認
    1. 一度ログアウト→ログインを行い、動作するかを確認

# Visual Studio Code による Github との連携
1. Visual Studio を新規に開く（すでに開いている場合は File → Close Workspace）
1. ワークスペースが空の状態で、File → Add Folder to Workspace で先に data/www/html フォルダを選択
1. 次に Add Folder to Workspace で docker-compose.yml のあるフォルダを選択（順番を間違うと git が2つ登録されない）
1. Source Control （左側のボタンの上から3番目）を押す
1. SOURCE CONTROL の右にある ... を押して、SOURCE CONTROL REPOSITORIES をチェック。seatreg と html の2つのレポジトリが登録されていることを確認
1. あとはブランチを選択して、同期ボタンを押すと自動的に push/pull する
1. チェックのボタンで commit、コメントを入れる
1. 作業を始める前に同期して、作業を終わらせるときに同期すればよい


