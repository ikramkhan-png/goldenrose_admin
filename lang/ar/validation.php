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

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other :value.',
    'active_url' => ':attribute ليس رابط صحيح.',
    'after' => 'يجب أن يكون :attribute تاريخ بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخ بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'ascii' => 'يجب أن يحتوي :attribute على أحرف ASCII وأرقام فقط.',
    'before' => 'يجب أن يكون :attribute تاريخ قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخ قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على بين :min و :max عناصر.',
        'file' => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'string' => 'يجب أن يحتوي :attribute على بين :min و :max أحرف.',
    ],
    'boolean' => 'يجب أن يكون :attribute صحيح أو خطأ.',
    'can' => 'يحتوي :attribute على قيمة غير مصرح بها.',
    'confirmed' => 'تأكيد :attribute لا يتطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'ليس :attribute تاريخ صحيح.',
    'date_equals' => 'يجب أن يكون :attribute تاريخ يساوي :date.',
    'date_format' => 'لا يتطابق :attribute مع التنسيق :format.',
    'decimal' => 'يجب أن يحتوي :attribute على :decimal أرقام عشرية.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما يكون :other :value.',
    'different' => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يحتوي :attribute على بين :min و :max أرقام.',
    'dimensions' => 'لديه :attribute أبعاد صورة غير صالحة.',
    'distinct' => 'لدى :attribute قيمة مكررة.',
    'doesnt_end_with' => 'لا يمكن أن ينتهي :attribute بأحد التالي: :values.',
    'doesnt_start_with' => 'لا يمكن أن يبدأ :attribute بأحد التالي: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح.',
    'ends_with' => 'يجب أن ينتهي :attribute بأحد التالي: :values.',
    'enum' => 'قيمة :attribute المحددة غير صالحة.',
    'exists' => 'قيمة :attribute المحددة غير صالحة.',
    'file' => 'يجب أن يكون :attribute ملف.',
    'filled' => 'يجب أن يكون :attribute له قيمة.',
    'gt' => [
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يكون حجم :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
        'string' => 'يجب أن يحتوي :attribute على أكثر من :value أحرف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي :attribute على :value عناصر أو أكثر.',
        'file' => 'يجب أن يكون حجم :attribute على الأقل :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :value أو أكبر.',
        'string' => 'يجب أن يحتوي :attribute على :value أحرف على الأقل.',
    ],
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => 'قيمة :attribute المحددة غير صالحة.',
    'in_array' => 'قيمة :attribute غير موجودة في :other.',
    'integer' => 'يجب أن يكون :attribute عدداً صحيحاً.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيح.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيح.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيح.',
    'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
    'lowercase' => 'يجب أن يكون :attribute أحرف صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي :attribute على أقل من :value عناصر.',
        'file' => 'يجب أن يكون حجم :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute أقل من :value.',
        'string' => 'يجب أن يحتوي :attribute على أقل من :value أحرف.',
    ],
    'lte' => [
        'array' => 'يجب أن يحتوي :attribute على :value عناصر أو أقل.',
        'file' => 'يجب أن يكون حجم :attribute على الأكثر :value كيلوبايت.',
        'numeric' => 'يجب أن يكون :value أو أقل.',
        'string' => 'يجب أن يحتوي :attribute على :value أحرف على الأكثر.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صحيح.',
    'max' => [
        'array' => 'يجب ألا يحتوي :attribute على أكثر من :max عناصر.',
        'file' => 'يجب ألا يتجاوز حجم :attribute :max كيلوبايت.',
        'numeric' => 'يجب ألا يتجاوز :attribute :max.',
        'string' => 'يجب ألا يتجاوز :attribute :max أحرف.',
    ],
    'mimes' => 'يجب أن يكون :attribute ملف من نوع: :values.',
    'mimetypes' => 'يجب أن يكون :attribute ملف من نوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي :attribute على الأقل :min عناصر.',
        'file' => 'يجب أن يكون حجم :attribute على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'string' => 'يجب أن يحتوي :attribute على الأقل :min أحرف.',
    ],
    'missing' => 'حقل :attribute مفقود.',
    'missing_if' => 'حقل :attribute مفقود عندما يكون :other :value.',
    'missing_unless' => 'حقل :attribute مفقود ما لم يكن :other :value.',
    'missing_with' => 'حقل :attribute مفقود عندما يكون :values موجوداً.',
    'missing_with_all' => 'حقل :attribute مفقود عندما يكون :values موجوداً.',
    'multiple_of' => 'يجب أن يكون :attribute مضاعفاً لـ :value.',
    'not_in' => 'قيمة :attribute المحددة غير صالحة.',
    'not_regex' => 'تنسيق :attribute غير صالح.',
    'numeric' => 'يجب أن يكون :attribute رقماً.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب أن يكون :attribute موجوداً.',
    'prohibited' => 'حقل :attribute ممنوع.',
    'prohibited_if' => 'حقل :attribute ممنوع عندما يكون :other :value.',
    'prohibited_unless' => 'حقل :attribute ممنوع ما لم يكن :other في :values.',
    'prohibits' => 'حقل :attribute يمنع وجود :other.',
    'regex' => 'تنسيق :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'حقل :attribute يحتوي على مفاتيح مطلوبة: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other :value.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_with_all' => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_without' => 'حقل :attribute مطلوب عندما لا يكون :values موجوداً.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يكون أي من :values موجوداً.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size عناصر.',
        'file' => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute :size.',
        'string' => 'يجب أن يحتوي :attribute على :size أحرف.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بأحد التالي: :values.',
    'string' => 'يجب أن يكون :attribute سلسلة.',
    'timezone' => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
    'unique' => 'تم استخدام :attribute بالفعل.',
    'uploaded' => 'فشل في تحميل :attribute.',
    'uppercase' => 'يجب أن يكون :attribute أحرف كبيرة.',
    'url' => 'يجب أن يكون :attribute رابط صحيح.',
    'ulid' => 'يجب أن يكون :attribute ULID صالح.',
    'uuid' => 'يجب أن يكون :attribute UUID صالح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
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

    'attributes' => [],
];
