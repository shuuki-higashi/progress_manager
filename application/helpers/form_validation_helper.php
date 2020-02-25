<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  バリデーションルールに引っかかった場合にバリデーションメッセージをセットする。それ以外はtrueを返却する。
 *  $validation_errorsに改行文字とバリデータによって戻されたすべてのエラーメッセージを格納する。
 *  error_messageセッションで変数$validation_errorsをフレッシュデータとしてセットする。
 *
 * @return true|false
 */

function form_validation($uri = '')
{
    $ci =& get_instance();
    if ($ci->form_validation->run($uri) === false) {
        // エラーメッセージの基本形設定
        $ci->form_validation->set_message(error_message());
        // エラーメッセージが無いときはスルーする
        if (empty(validation_errors())) return true;
        $validation_errors = explode(PHP_EOL, validation_errors());
        $ci->session->set_flashdata('error_message', $validation_errors);
        return false;
    }
    return true;
}

/**
 *  コントローラ名を取得して、末尾に文字's'を結合したものを変数$controller_nameに格納している。
 *  CI_Controllerのインスタンスを取得して、$controller_nameに格納された文字列に対応したモデル(phpファイル)を読み込む。
 *  ただし、読み込むモデルはAdminsかUsersのどちらかであり、それに応じて各々モデル内の関数get_already_email_cnt()に、
 *  引数$emailのメールアドレスを入れた配列を渡す。そして返却値を変数$cntに格納する。（返却値はfalseか、すでに登録されていたメールアドレスの数）
 *  もしもint型の0より大きな数が変数$cntに格納されていた場合は、この関数はfalseを返却する。そうでない場合はtrueを返却する。
 *  
 * @param string $email
 * @return true|false
 */

function duplicate_email($email)
{
    $controller_name = controller_name() . 's';
    
    $ci =& get_instance();
    $ci->load->model("{$controller_name}");
    $cnt = $ci->{$controller_name}->get_already_email_cnt(['email' => $email]);
    
    if ($cnt > 0) {
        return false;
    }
    return true;
}

/**
 * 日付データを指定した形式でパースして、変数$dに格納する。
 * 返却時に、$dがfalseでないかと、指定フォーマットでの日付と、引数として受け取った日付が一致しているかを確認している。
 * 正しければtrueを返却し、そうでなければfalseを返却する。
 * 
 * @param string $date
 * @return true|false
 */

function valid_date($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * 日付時刻データを指定した形式でパースして、変数$dに格納する。
 * 返却時に、$dがfalseでないかと、指定フォーマットでの日付時刻と、引数として受け取った日付時刻が一致しているかを確認している。
 * 正しければtrueを返却し、そうでなければfalseを返却する。
 * 
 * @param string $time
 * @return true|false
 */

function valid_datetime($time)
{
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $time);
    return $d && $d->format('Y-m-d H:i:s') === $time;
}

/**
 * 受け取った変数$urlに格納されているURLの形式をバリデーションする関数。
 * 具体的には以下の形式を保証するバリデーションである。
 * ・http://
 * ・https://
 * ・mailto:
 * ・その他のスキーム://
 * 
 * ただし、その他のスキーム: などは保証されない。
 * URLの形式が正しければtrueを返却し、そうでなければfalseを返却する。
 * 
 * @param string $url
 * @return true|false
 */

function valid_url_filter_var($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return true;
    }
    return false;
}

/**
 * 返却値の左オペランド電話番号データが、数字あるいは数字を表す文字列かどうかを判断している。
 * 右オペランドは、文字列形式の場合に（XXX-XXXX-XXXXのような）電話番号が正規表現として正しいかどうかを判断している。
 * 
 * 
 * @param string $number
 * @return true|false
 */

function valid_tel($number)
{
    return is_numeric($number) || (is_string($number) && preg_match('/\A\d{2,4}+-\d{2,4}+-\d{4}\z/', $number));
}

/**
 * POSTされた値が配列かを調べる
 * @method valid_array
 * @param  array $array
 * @return boolean
 */
function valid_array($array)
{
    if (is_array($array)) {
        return true;
    }
    return false;
}

/**
 * パスワードが半角英数字記号をそれぞれ1種類以上含む8文字以上32文字以下か調べる
 * @method valid_password
 * @param string $password
 * @return boolean
 */
function valid_password($password)
{
    if (preg_match('#\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-/:-@[-`{-~])[!-~]{8,32}+\z#i', $password)) {
        return true;
    }
    return false;
}