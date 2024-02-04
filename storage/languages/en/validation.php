<?php

declare(strict_types=1);

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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field is required.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value',
        'file' => 'The :attribute must be greater than :value kb',
        'string' => 'The :attribute must be greater than :value characters',
        'array' => 'The :attribute must be greater than :value items',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be great than or equal to :value',
        'file' => 'The :attribute must be great than or equal to :value kb',
        'string' => 'The :attribute must be great than or equal to :value characters',
        'array' => 'The :attribute must be great than or equal to :value items',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value',
        'file' => 'The :attribute must be less than :value kb',
        'string' => 'The :attribute must be less than :value characters',
        'array' => 'The :attribute must be less than :value items',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value',
        'file' => 'The :attribute must be less than or equal to :value kb',
        'string' => 'The :attribute must be less than or equal to :value characters',
        'array' => 'The :attribute must be less than or equal to :value items',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute cannot match a given regular rule.',
    'numeric' => 'The :attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must be start with :values ',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute is invalid UUID.',
    'max_if' => [
        'numeric' => 'The :attribute may not be greater than :max when :other is :value.',
        'file' => 'The :attribute may not be greater than :max kilobytes when :other is :value.',
        'string' => 'The :attribute may not be greater than :max characters when :other is :value.',
        'array' => 'The :attribute may not have more than :max items when :other is :value.',
    ],
    'min_if' => [
        'numeric' => 'The :attribute must be at least :min when :other is :value.',
        'file' => 'The :attribute must be at least :min kilobytes when :other is :value.',
        'string' => 'The :attribute must be at least :min characters when :other is :value.',
        'array' => 'The :attribute must have at least :min items when :other is :value.',
    ],
    'between_if' => [
        'numeric' => 'The :attribute must be between :min and :max when :other is :value.',
        'file' => 'The :attribute must be between :min and :max kilobytes when :other is :value.',
        'string' => 'The :attribute must be between :min and :max characters when :other is :value.',
        'array' => 'The :attribute must have between :min and :max items when :other is :value.',
    ],
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
            'rule-name' => 'custom-message',
        ],
    ],


    'attributes' => [],
    'phone_number' => 'The :attribute must be a valid phone number',
    'telephone_number' => 'The :attribute must be a valid telephone number',

    'chinese_word' => 'The :attribute must contain valid characters(chinese/english character, number, underscore)',
    'sequential_array' => 'The :attribute must be sequential array',
];
