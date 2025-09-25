# Contact System - お問い合わせフォーム

---

## 環境構築

1. リポジトリを取得

   ```bash
   # ホスト側
   git clone git@github.com:mao716/contact-system.git
   ```

2. 環境変数ファイルコピー（ホスト側）
   ```bash
   # ホスト側
   cp .env.example .env
   ```
   > ※ 今回の環境では、UID/GID の指定が .env.example に含まれています。権限エラーが発生する場合は、ホスト環境に合わせて修正してください。未設定の場合は既定で 1000:1000 になります（Linux/WSL 向け）。
   > また、MySQL は OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compose.yml ファイルを編集してください。

3. Docker ビルド＆起動

   ```bash
   # ホスト側
   docker-compose up -d --build
   ```

---

## Laravel 環境構築

1. PHP コンテナに入る

   ```bash
   # ホスト側
   docker compose exec php bash
   ```

2. Composer インストール

   ```bash
   # PHPコンテナ内
   cd /var/www
   composer install
   ```

   > ※ Laravel の初回セットアップは composer install で依存関係を入れる

3. 環境変数ファイルコピー（Laravel 用）
   ```bash
   # PHPコンテナ内(/var/www)
   cp .env.example .env
   ```
   > ※ DB 接続設定を docker-compose.yml に合わせて修正
4. アプリキー作成

   ```bash
   # PHPコンテナ内
   php artisan key:generate
   ```

5. マイグレーション

   ```bash
   # PHPコンテナ内
   php artisan migrate
   ```

6. シーディング
   ```bash
   # PHPコンテナ内
   php artisan db:seed
   ```

---

## 使用技術

- PHP 8.1.33
- Laravel 8.83.29
- MySQL 8.0
- Nginx 1.21.1
- Docker 28.3.0 / docker compose 2.38.1-desktop.1
- Laravel Fortify（認証機能）

---

## ER 図

![ER図](docs/er.png)

---

## 画面／URL一覧

- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/

### お問い合わせ
| 画面／機能       | メソッド | パス        | 名前             | 備考                              |
|------------------|----------|-------------|------------------|-----------------------------------|
| 入力フォーム     | GET      | `/`         | contact.create   | 初期表示                          |
| 確認ページ       | POST     | `/confirm`  | contact.confirm  | 入力後の確認画面                  |
| 保存処理         | POST     | `/store`    | contact.store    | DB 保存、完了ページへリダイレクト |
| サンクスページ   | GET      | `/thanks`   | contact.thanks   | 完了専用ページ                    |
| 入力値リセット   | GET      | `/reset`    | ―                | セッション初期化して `/` に戻る   |

### 管理画面
| 画面／機能       | メソッド | パス                        | 名前                   | 備考                              |
|------------------|----------|-----------------------------|------------------------|-----------------------------------|
| 一覧表示         | GET      | `/admin`                    | admin.index            | 検索・絞り込み・ページネーション |
| 詳細表示 (JSON)  | GET      | `/admin/contacts/{contact}` | admin.contacts.show    | モーダル用                     |
| 削除処理         | DELETE   | `/admin/contacts/{contact}` | admin.contacts.destroy | モーダル内の削除ボタン            |
| CSV エクスポート | GET      | `/admin/export`             | admin.export           | 絞り込み条件があればその状態で出力 |

 • 「検索条件で絞り込んだ状態」で CSV エクスポートを押すと、その絞り込み結果だけが出力されます。
 • 例：性別=「女性」、お問い合わせの種類=「その他」を選んで検索した状態で「エクスポート」を押すと、その条件に一致するレコードのみが CSV になります。
 • 出力形式は UTF-8 / カンマ区切り。

### 認証（Fortify提供）
| 画面／機能       | メソッド | パス        | 名前      | 備考                |
|------------------|----------|-------------|-----------|---------------------|
| ログインフォーム | GET      | `/login`    | login     | ログインページ       |
| ログイン処理     | POST     | `/login`    | ―         |                     |
| ログアウト       | POST     | `/logout`   | logout    | 管理画面ヘッダーから |
| 登録フォーム     | GET      | `/register` | register  | ユーザー登録ページ   |
| 登録処理         | POST     | `/register` | ―         |                     |
