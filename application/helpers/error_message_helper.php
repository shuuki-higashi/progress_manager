<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * form_validation_helper.phpで呼び出される関数
 * 各種キーと、それに対応するエラーメッセージを格納した配列を返却する。
 *
 * @return array
 */

function error_message()
{
    return [
        'required' => '%sが入力されていません。',
        'xss_clean' => '%sには使用できない文字が入力されています。',
        'valid_email' => '%sはメールアドレスのフォーマットではありません。',
        'alpha' => '%sは英字を入力してください。',
        'min_length' => '%sが文字数オーバーです。',
        'max_length' => '%sが文字数オーバーです。',
        'is_natural' => '%sは数値を入力してください。',
        'is_natural' => '%sは数値を入力してください。',
        'isBanWord' => '%sには使用できない文字が入力されています。',
        'duplicate_email' => '%sは既に使用されています。',
    ];
}
