<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'ザ・ :attribute 受け入れる必要があります。',
    'active_url' => 'ザ・ :attribute は有効なURLではありません。',
    'after' => 'ザ・ :attribute 後の日付である必要があります :date',
    'after_or_equal' => 'ザ・ :attribute 日付以降である必要があります :date',
    'alpha' => 'ザ・ :attribute 文字のみを含めることができます。',
    'alpha_dash' => 'ザ・ :attribute 文字、数字、ダッシュ、アンダースコアのみを含めることができます。',
    'alpha_num' => 'ザ・ :attribute 文字と数字のみを含めることができます。',
    'array' => 'ザ・ :attribute 配列である必要があります。',
    'before' => 'ザ・ :attribute 前の日付である必要があります :date',
    'before_or_equal' => 'ザ・ :attribute 日付以前の日付である必要があります :date',
    'between' => [
        'numeric' => 'ザ・ :attribute 間にある必要があります :min そして :max',
        'file' => 'ザ・ :attribute 間にある必要があります :min そして :max キロバイト',
        'string' => 'ザ・ :attribute 間にある必要があります :min そして :max 文字',
        'array' => 'ザ・ :attribute 間にある必要があります :min そして :max アイテム',
    ],
    'boolean' => 'ザ・ :attribute フィールドはtrueまたはfalseである必要があります。',
    'confirmed' => 'ザ・ :attribute 確認が一致しません。',
    'date' => 'ザ・ :attribute は有効な日付ではありません。',
    'date_equals' => 'ザ・ :attribute に等しい日付である必要があります :date',
    'date_format' => 'ザ・ :attributeフォーマットと一致しません :format',
    'different' => 'ザ・ :attribute そして :other 異なっている必要があります。',
    'digits' => 'ザ・ :attribute でなければなりません :digits 数字。',
    'digits_between' => 'ザ・ :attribute 間にある必要があります :min そして :max 数字。',
    'dimensions' => 'ザ・ :attribute 画像のサイズが無効です。',
    'distinct' => 'ザ・ :attribute フィールドの値が重複しています。',
    'email' => 'ザ・ :attribute 有効な電子メールアドレスでなければなりません。',
    'ends_with' => 'ザ・ :attribute のいずれかで終了する必要があります following: :values',
    'exists' => 'ザ・ 選択済み :attribute 無効です。',
    'file' => 'ザ・ :attribute ファイルである必要があります。',
    'filled' => 'ザ・ :attribute フィールドには値が必要です。',
    'gt' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'gte' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value ',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'image' => 'ザ・ :attribute 画像である必要があります。',
    'in' => 'ザ・ 選択済み :attribute 無効です。',
    'in_array' => 'ザ・ :attribute フィールドはに存在しません :other',
    'integer' => 'ザ・ :attribute 整数である必要があります。',
    'ip' => 'ザ・ :attribute 有効なIPアドレスである必要があります。',
    'ipv4' => 'ザ・ :attribute 有効なIPv4アドレスである必要があります。',
    'ipv6' => 'ザ・ :attribute 有効なIPv6アドレスである必要があります。',
    'json' => 'ザ・ :attribute 有効なJSON文字列である必要があります。',
    'lt' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value ',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'lte' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value ',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'max' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value ',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'mimes' => 'ザ・ :attribute のファイルである必要があります type: :values',
    'mimetypes' => 'ザ・ :attribute のファイルである必要があります type: :values',
    'min' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value ',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'multiple_of' => 'ザ・ :attribute の倍数である必要があります :value',
    'not_in' => 'ザ・ 選択済み :attribute 無効です。',
    'not_regex' => 'ザ・ :attribute 形式が無効です。',
    'numeric' => 'ザ・ :attribute 数字でなければなりません。',
    'password' => 'ザ・ password 間違っています。',
    'present' => 'ザ・ :attribute フィールドが存在する必要があります。',
    'regex' => 'ザ・ :attribute 形式が無効です。',
    'required' => 'ザ・ :attribute フィールドは必須項目です。',
    'required_if' => 'ザ・ :attribute でなければなりません :other です :value',
    'required_unless' => 'ザ・ :attribute ただし、フィールドは必須です。 :other にあります :values',
    'required_with' => 'ザ・ :attribute でなければなりません :values が存在します。',
    'required_with_all' => 'ザ・ :attribute でなければなりません :values 存在しています。',
    'required_without' => 'ザ・ :attribute フィールドは次の場合に必要です :values 存在しません。',
    'required_without_all' => 'ザ・ :attribute いずれもない場合はフィールドが必要です :values 存在しています。',
    'same' => 'ザ・ :attribute そして :other 一致している必要があります。',
    'size' => [
        'numeric' => 'ザ・ :attribute より大きい必要があります :value',
        'file' => 'ザ・ :attribute より大きい必要があります :value ',
        'string' => 'ザ・ :attribute より大きい必要があります :value 文字。',
        'array' => 'ザ・ :attribute 以上を持っている必要があります :value アイテム。',
    ],
    'starts_with' => 'ザ・ :attribute のいずれかで開始する必要があります following: :values',
    'string' => 'ザ・ :attribute 文字列である必要があります。',
    'timezone' => 'ザ・ :attribute 有効なゾーンである必要があります。',
    'unique' => 'ザ・ :attribute すでに使用されている。',
    'uploaded' => 'ザ・ :attribute アップロードに失敗しました。',
    'url' => 'ザ・ :attribute 形式が無効です。',
    'uuid' => 'ザ・ :attribute 有効なUUIDである必要があります。',
    'exists_if' => 'ザ・ 選択済み :attribute 無効です。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'processing_company_name_duplicate' => '入力されたサービス名と決済代行会社の組合せは、既に登録済みです'
    ],
];
