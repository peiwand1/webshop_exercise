<?php

function getExtendedFieldsByPage(string $page): array
{
    switch ($page) {
        case 'login':
            return [
                'email' => [
                    'type' => 'email',
                    'label' => 'Your E-mail'
                ],
                'password' => [
                    'type' => 'password',
                    'label' => 'Your password'
                ],
            ];
        case 'register':
            return [
                'name' => [
                    'type' => 'text',
                    'label' => 'Your name'
                ],
                'email' => [
                    'type' => 'email',
                    'label' => 'Your E-mail'
                ],
                'pass1' => [
                    'type' => 'password',
                    'label' => 'Your password'
                ],
                'pass2' => [
                    'type' => 'password',
                    'label' => 'Repeat password'
                ],
            ];
        case 'contact':
            return [
                'name' => [
                    'type' => 'text',
                    'label' => 'Your name'
                ],
                'email' => [
                    'type' => 'email',
                    'label' => 'Your E-mail'
                ],
                'message' => [
                    'type' => 'textarea',
                    'label' => 'Message'
                ],
            ];
        case 'add_to_cart':
            return [
                'product_id' => [
                    'type' => 'hidden'
                ],
                'amount' => [
                    'type' => 'number',
                    'value' => 1,
                    'attributes' => [
                        'class' => 'order-amount',
                        'min' => 1,
                        'max' => 100
                    ]
                ]
            ];
        case 'update_cart_amount':
            return [
                'product_id' => [
                    'type' => 'hidden'
                ],
                'amount' => [
                    'type' => 'number',
                    'attributes' => [
                        'class' => 'order-amount',
                        'min' => 0,
                        'max' => 100
                    ]
                ]
            ];
    }
    return [];
}
