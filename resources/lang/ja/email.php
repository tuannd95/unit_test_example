<?php

return [
    'add_point_review' => [
        'email_content' => "
        %nick_name%様

        鑑定師の感想を誠にありがとうございます。
        %nick_name%様のお声を糧に、今後もサービスの向上と鑑定クオリティの研鑽に努めてまいります。

        僅かばかりではありますが、%po_add%ポイントを追加させて頂きました。

        今後ともクロトを、よろしくお願い申し上げます。

        ▼クロトへログイン
        %top_page_url%

        ▼現在待機中の鑑定師
        %point_page_url%

        ･･･････････････････････････
        鑑定師選びやご利用方法、清算方法など、サービスに関してお困りの際は、お気軽にクロト事務局までお問い合わせ頂けますと幸いです。

        今後とも電話占いクロトをよろしくお願いいたします。

        事務局営業時間：12:00～20:00

        ■クロト事務局
        ┣k-info@klotho.jp
        ┣050-5490-7399
        ┗https://klotho.jp
    ",
        'email_subject' => '感想をありがとうございます',
        'email_sender'  => 'k-service@'. env('DOMAIN_MAIL', 'fortune.dev.nals.vn')
    ],
];
