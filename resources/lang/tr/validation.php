<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, doğrulayıcı sınıf tarafından kullanılan varsayılan hata mesajlarını içerir. Bu kurallardan bazıları,
    | boyut kuralları gibi, birden fazla versiyona sahiptir. Bu mesajları burada serbestçe ayarlayabilirsiniz.
    |
    */

    'accepted' => ':attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL değil.',
    'after' => ':attribute, :date tarihinden sonraki bir tarih olmalıdır.',
    'after_or_equal' => ':attribute, :date tarihinden sonra veya tarihe eşit bir tarih olmalıdır.',
    'alpha' => ':attribute yalnızca harflerden oluşmalıdır.',
    'alpha_dash' => ':attribute yalnızca harfler, rakamlar, çizgiler ve alt çizgiler içerebilir.',
    'alpha_num' => ':attribute yalnızca harfler ve rakamlar içerebilir.',
    'array' => ':attribute bir dizi olmalıdır.',
    'before' => ':attribute, :date tarihinden önceki bir tarih olmalıdır.',
    'before_or_equal' => ':attribute, :date tarihinden önce veya tarihe eşit bir tarih olmalıdır.',
    'between' => [
        'numeric' => ':attribute, :min ile :max arasında olmalıdır.',
        'file' => ':attribute, :min ile :max kilobayt arasında olmalıdır.',
        'string' => ':attribute, :min ile :max karakter arasında olmalıdır.',
        'array' => ':attribute, :min ile :max öğe arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'date' => ':attribute geçerli bir tarih değil.',
    'date_equals' => ':attribute, :date tarihine eşit bir tarih olmalıdır.',
    'date_format' => ':attribute, :format biçimi ile eşleşmiyor.',
    'different' => ':attribute ve :other farklı olmalıdır.',
    'digits' => ':attribute, :digits rakam olmalıdır.',
    'digits_between' => ':attribute, :min ile :max rakam arasında olmalıdır.',
    'dimensions' => ':attribute geçersiz resim boyutlarına sahip.',
    'distinct' => ':attribute alanında yinelenen bir değer var.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'email_verification' => ':attribute e-posta adresli üyelik doğrulanmamıştır.',
    'ends_with' => ':attribute şunlardan biriyle bitmelidir: :values.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'file' => ':attribute bir dosya olmalıdır.',
    'filled' => ':attribute alanının bir değeri olmalıdır.',
    'gt' => [
        'numeric' => ':attribute, :value değerinden büyük olmalıdır.',
        'file' => ':attribute, :value kilobayttan büyük olmalıdır.',
        'string' => ':attribute, :value karakterden büyük olmalıdır.',
        'array' => ':attribute, :value öğeden fazla olmalıdır.',
    ],
    'gte' => [
        'numeric' => ':attribute, :value değerinden büyük veya eşit olmalıdır.',
        'file' => ':attribute, :value kilobayttan büyük veya eşit olmalıdır.',
        'string' => ':attribute, :value karakterden büyük veya eşit olmalıdır.',
        'array' => ':attribute, :value veya daha fazla öğe içermelidir.',
    ],
    'image' => ':attribute bir resim olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute alanı, :other içinde mevcut değil.',
    'integer' => ':attribute bir tamsayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON dizgisi olmalıdır.',
    'lt' => [
        'numeric' => ':attribute, :value değerinden küçük olmalıdır.',
        'file' => ':attribute, :value kilobayttan küçük olmalıdır.',
        'string' => ':attribute, :value karakterden küçük olmalıdır.',
        'array' => ':attribute, :value öğeden az olmalıdır.',
    ],
    'lte' => [
        'numeric' => ':attribute, :value değerinden küçük veya eşit olmalıdır.',
        'file' => ':attribute, :value kilobayttan küçük veya eşit olmalıdır.',
        'string' => ':attribute, :value karakterden küçük veya eşit olmalıdır.',
        'array' => ':attribute, :value öğeden fazla olmamalıdır.',
    ],
    'max' => [
        'numeric' => ':attribute, :max değerinden büyük olmamalıdır.',
        'file' => ':attribute, :max kilobayttan büyük olmamalıdır.',
        'string' => ':attribute, :max karakterden büyük olmamalıdır.',
        'array' => ':attribute, :max öğeden fazla olmamalıdır.',
    ],
    'mimes' => ':attribute, :values türünde bir dosya olmalıdır.',
    'mimetypes' => ':attribute, :values türünde bir dosya olmalıdır.',
    'min' => [
        'numeric' => ':attribute en az :min olmalıdır.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'string' => ':attribute en az :min karakter olmalıdır.',
        'array' => ':attribute en az :min öğe içermelidir.',
    ],
    'multiple_of' => ':attribute, :value\'nın katları olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute biçimi geçersiz.',
    'numeric' => ':attribute bir sayı olmalıdır.',
    'password' => 'Şifre yanlış.',
    'present' => ':attribute alanı mevcut olmalıdır.',
    'regex' => ':attribute biçimi geçersiz.',
    'required' => ':attribute alanı gereklidir.',
    'required_if' => ':other :value olduğunda :attribute alanı gereklidir.',
    'required_unless' => ':other :values içinde olmadıkça :attribute alanı gereklidir.',
    'required_with' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_with_all' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_without' => ':values mevcut olmadığında :attribute alanı gereklidir.',
    'required_without_all' => ':values\'ın hiçbiri mevcut olmadığında :attribute alanı gereklidir.',
    'same' => ':attribute ve :other eşleşmelidir.',
    'size' => [
        'numeric' => ':attribute, :size olmalıdır.',
        'file' => ':attribute, :size kilobayt olmalıdır.',
        'string' => ':attribute, :size karakter olmalıdır.',
        'array' => ':attribute, :size öğe içermelidir.',
    ],
    'starts_with' => ':attribute şunlardan biriyle başlamalıdır: :values.',
    'string' => ':attribute bir dizge olmalıdır.',
    'timezone' => ':attribute geçerli bir bölge olmalıdır.',
    'unique' => ':attribute zaten alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'url' => ':attribute biçimi geçersiz.',
    'uuid' => ':attribute geçerli bir UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Burada, "attribute.rule" kuralını kullanarak öznitelikler için özel doğrulama mesajları belirleyebilirsiniz.
    | Bu, belirli bir öznitelik kuralı için hızlı bir şekilde özel bir dil satırı belirtmeyi kolaylaştırır.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'özel-mesaj',
        ],
        'tours_fields_check' => [
            'required' => 'Her turda bir tur ID, tur tarihi (YYYY-MM-DD), kişi sayısı, zaman ve ürünler bulunmalıdır.',
            'tour_id' => 'Her turda geçerli bir tur ID bulunmalıdır.',
            'tour_date' => 'Her turda geçerli bir tarih bulunmalıdır.',
            'tour_time' => 'Her turda geçerli bir zaman bulunmalıdır.',
            'person' => 'Her turda geçerli bir kişi sayısı bulunmalıdır.',
            'products' => 'Her turda geçerli ürünler bulunmalıdır.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Öznitelikleri
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, öznitelik yer tutucumuzu "E-Posta Adresi" gibi daha okuyucu dostu bir şeyle değiştirmek için kullanılır.
    | "email" yerine. Bu, mesajımızı daha ifade gücü yüksek hale getirmemize yardımcı olur.
    |
    */

    'attributes' => [],

];
