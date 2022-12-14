<?php
session_start();
$_SESSION['validationList'] = null;
$_SESSION['validationFlag'] = null;

require_once('../Models/Contact.php');
require_once('../Views/dbconnect.php');
require_once(ROOT_PATH."database.php");

$GLOBALS['connect'] = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

class ContactController {
    private $request;   // リクエストパラメータ(GET,POST)
    private $Contact;    // Contactモデル

    public function __construct()
    {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        // モデルオブジェクトの生成
        $this->Contact = new Contact();
    }

    public function create()
    {
        if (isset($_POST['submit'])) {
            $validationFlag = true;
            $validationList = [
                "name"=> true,
                "kana"=> true,
                "tel"=> true,
                "email"=> true,
                "body"=> true
            ];
            $_SESSION["name"]= htmlspecialchars($_POST['name']);
            $_SESSION["kana"]= htmlspecialchars($_POST['kana']);
            $_SESSION["tel"]= htmlspecialchars($_POST['tel']);
            $_SESSION["email"]= htmlspecialchars($_POST['email']);
            $_SESSION["body"]= htmlspecialchars($_POST['body']);
            // 氏名バリデーション
            if (!$_SESSION["name"]) {
                $validationList['name'] = '氏名は必須入力です';
                $validationFlag = false;
            }
            if (10 <= mb_strlen($_SESSION["name"], "UTF-8")) {
                $validationList['name'] = '氏名は、10文字以内(半角、全角区別なし)で入力して下さい';
                $validationFlag = false;
            }
            // フリガナバリデーション
            if (!$_SESSION["kana"]) {
                $validationList['kana'] = 'フリガナは必須入力です';
                $validationFlag = false;
            }
            if (10 <= mb_strlen($_SESSION["kana"], "UTF-8")) {
                $validationList['kana'] = 'フリガナは、10文字以内(半角、全角区別なし)で入力して下さい';
                $validationFlag = false;
            }
            // 電話番号バリデーション(入力必須ではない)
            if (!preg_match("/^[0-9]+$/", $_SESSION["tel"]) && empty(!$_SESSION["tel"])) {
                $validationList['tel'] = '電話番号は、数字(0~9)で入力して下さい';
                $validationFlag = false;
            }
            // メールアドレスバリデーション
            if (!$_SESSION["email"]) {
                $validationList['email'] = 'メールアドレスは必須入力です';
                $validationFlag = false;
            }
            if (!preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $_SESSION["email"])) {
                $validationList['email'] = 'メールアドレスは、xxx@xxx形式で入力して下さい';
                $validationFlag = false;
            }
            // お問い合わせ内容バリデーション
            if (!$_SESSION["body"]) {
                $validationList['body'] = 'お問い合わせ内容は必須入力です';
                $validationFlag = false;
            }
            $_SESSION['validationList'] = $validationList ;
            $_SESSION['validationFlag'] = $validationFlag ;
            if (!$validationFlag) {
                return;
                echo 'failed';
            } else {
                header('Location: confirm.php');
            }
        } else {
        }
    }

    public function confirm()
    {
        if (isset($_POST['confirm'])) {
            $dbh = dbConnect();
            $sql = "INSERT INTO contacts(name, kana, tel, email, body)
                    VALUES(:name, :kana, :tel, :email, :body)";
            $dbh->beginTransaction();
            try {
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(":name", $_SESSION["name"], PDO::PARAM_STR);
                $stmt->bindValue(":kana", $_SESSION["kana"], PDO::PARAM_STR);
                $stmt->bindValue(":tel", $_SESSION["tel"], PDO::PARAM_STR_CHAR);
                $stmt->bindValue(":email", $_SESSION["email"], PDO::PARAM_STR);
                $stmt->bindValue(":body", $_SESSION["body"], PDO::PARAM_STR);
                $stmt->execute();
                $dbh->commit();
                // 登録完了後にセッションデータの空文字リセット
                $_SESSION["name"]= "";
                $_SESSION["kana"]= "";
                $_SESSION["tel"]= "";
                $_SESSION["email"]= "";
                $_SESSION["body"]= "";
                header('Location: thanks.php');
            } catch (PDOException $e) {
                echo "登録失敗";
                $dbh->rollBack();
                exit($e);
            }
        }
    }

    public function back()
    {
        if (isset($_POST['back'])) {
            header("location: contact.php");
        }
    }

    public function getContents()
    {
        if (isset($this->request['get'])) {
        }
        $contacts = $this->Contact->findAll();
        $params = [
            'contacts' => $contacts,
        ];
        return $params;
    }

    public function detail()
    {
        if (empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $contact = $this->Contact->findById($this->request['get']['id']);
        $params = [
            'contact' => $contact
        ];
        return $params;
    }

    public function edit()
    {
        if (isset($_POST['update'])) {
            $validationFlag = true;
            $validationList = [
                "name"=> true,
                "kana"=> true,
                "tel"=> true,
                "email"=> true,
                "body"=> true
            ];
            $id = $_GET["id"];
            $name = htmlspecialchars($_POST['name']);
            $kana = htmlspecialchars($_POST['kana']);
            $tel = htmlspecialchars($_POST['tel']);
            $email = htmlspecialchars($_POST['email']);
            $body = htmlspecialchars($_POST['body']);
            // 氏名バリデーション
            if (!$name) {
                $validationList['name'] = '氏名は必須入力です';
                $validationFlag = false;
            }
            if (10 <= mb_strlen($name, "UTF-8")) {
                $validationList['name'] = '氏名は、10文字以内(半角、全角区別なし)で入力して下さい';
                $validationFlag = false;
            }
            // フリガナバリデーション
            if (!$kana) {
                $validationList['kana'] = 'フリガナは必須入力です';
                $validationFlag = false;
            }
            if (10 <= mb_strlen($kana, "UTF-8")) {
                $validationList['kana'] = 'フリガナは、10文字以内(半角、全角区別なし)で入力して下さい';
                $validationFlag = false;
            }
            // 電話番号バリデーション(入力必須ではない)
            if (!preg_match("/^[0-9]+$/", $tel) && empty(!$tel)) {
                $validationList['tel'] = '電話番号は、数字(0~9)で入力して下さい';
                $validationFlag = false;
            }
            // メールアドレスバリデーション
            if (!$email) {
                $validationList['email'] = 'メールアドレスは必須入力です';
                $validationFlag = false;
            }
            if (!preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $email)) {
                $validationList['email'] = 'メールアドレスは、xxx@xxx形式で入力して下さい';
                $validationFlag = false;
            }
            // お問い合わせ内容バリデーション
            if (!$body) {
                $validationList['body'] = 'お問い合わせ内容は必須入力です';
                $validationFlag = false;
            }
            $_SESSION['validationList'] = $validationList ;
            $_SESSION['validationFlag'] = $validationFlag ;
            if (!$validationFlag) {
                return;
                echo 'failed';
            } else {
                $dbh = dbConnect();
                $sql = "UPDATE contacts SET name = :name, kana = :kana, tel = :tel, email = :email, body = :body
                        WHERE id = :id";
                $dbh->beginTransaction();
                try {
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
                    $stmt->bindValue(":kana", $kana, PDO::PARAM_STR);
                    $stmt->bindValue(":tel", $tel, PDO::PARAM_STR_CHAR);
                    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                    $stmt->bindValue(":body", $body, PDO::PARAM_STR);
                    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $dbh->commit();
                    // 更新完了後にお問い合わせ入力画面へ遷移
                    header('location: contact.php');
                } catch (PDOException $e) {
                    echo "登録失敗";
                    $dbh->rollBack();
                    exit($e);
                }
            }
        } else {
        }
    }

    public function editBack()
    {
        if (isset($_POST['back'])) {
            header("location: contact.php");
        }
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $dbh = dbConnect();
            $sql = "DELETE FROM contacts WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":id", $_POST["delete_id"], PDO::PARAM_INT);
            $stmt->execute();
            // 更新完了後にお問い合わせ入力画面へ遷移
            header('location: contact.php');
        }
    }
}
