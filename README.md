# Flea Market App

フリマアプリ

---

## 環境構築

### Dockerビルド

```bash
git clone git@github.com:rararamonkey/flea_market_app.git
cd flea_market_app
docker compose up -d --build
```

### Laravel環境構築

```bash
docker compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan config:clear
```

---

## 使用技術

- PHP 8.1
- Laravel 8
- MySQL 8.0
- Nginx
- Docker
- Laravel Fortify
- Stripe
- MailHog

---

## URL

- 開発環境：http://localhost
- phpMyAdmin：http://localhost:8080
- MailHog：http://localhost:8025

---

## テストアカウント

### 出品者ユーザー

- メールアドレス：seller@test.com
- パスワード：password

### 購入者ユーザー

- メールアドレス：buyer@test.com
- パスワード：password

---

## メール認証

MailHogを使用しています。

```env
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="test@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Stripe

Stripe決済を使用しています。  
`.env` に以下を設定してください。

```env
STRIPE_KEY=pk_test_xxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxx
```

---

## 機能一覧

- 会員登録
- ログイン
- ログアウト
- メール認証
- 商品一覧表示
- 商品詳細表示
- 商品検索
- マイリスト表示
- いいね登録・解除
- コメント投稿
- 商品購入
- 支払い方法選択
- 配送先変更
- プロフィール編集
- 商品出品

---

## ER図

※ER図を追加
