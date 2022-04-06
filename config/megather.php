<?php

return [
    'validation' => [
        'username_regex' => '/^[a-zA-Z0-9\-_.]{3,20}$/',
        'username_regex_error' => 'ユーザー名には半角英数字と一部の記号(-_.)のみ使用でき、3文字～20文字に設定する必要があります。',
    ],
    'options' => [
        'platforms' => [
            [
                'label' => 'パソコン (PC)',
                'value' => 'pc'
            ],
            [
                'label' => 'モバイル (Mobile)',
                'value' => 'mobile'
            ],
            [
                'label' => 'Play Station 4 (PS4)',
                'value' => 'ps4'
            ],
            [
                'label' => 'Play Station 5 (PS5)',
                'value' => 'ps5'
            ],
            [
                'label' => 'Nintendo Switch',
                'value' => 'switch'
            ],
            [
                'label' => 'Play Station 3 (PS3)',
                'value' => 'ps3'
            ]
        ],
        'games' => [
            [
                'label' => '人気ゲーム',
                'options' => [
                    [
                        'label' => 'Rainbow Six Siege (R6S)',
                        'value' => 'siege'
                    ],
                    [
                        'label' => 'Apex Legends',
                        'value' => 'apex'
                    ]
                ]
            ],
            [
                'label' => 'タクティカルシューター',
                'options' => [
                    [
                        'label' => 'Rainbow Six Siege (R6S)',
                        'value' => 'siege'
                    ],
                    [
                        'label' => 'Valorant',
                        'value' => 'valorant'
                    ],
                    [
                        'label' => 'Apex Legends',
                        'value' => 'apex'
                    ]
                ]
            ],
            [
                'label' => 'バトルロワイアル',
                'options' => [
                    [
                        'label' => 'Apex Legends',
                        'value' => 'apex'
                    ],
                    [
                        'label' => 'Fortnite',
                        'value' => 'fortnite'
                    ],
                    [
                        'label' => 'PLAYERUNKNOWN\'S BATTLEGROUNDS (PUBG)',
                        'value' => 'pubg'
                    ],
                    [
                        'label' => 'Fall Guys: Ultimate Knockout',
                        'value' => 'fallguys'
                    ]
                ]
            ],
            [
                'label' => 'サバイバル',
                'options' => [
                    [
                        'label' => 'Minecraft',
                        'value' => 'minecraft'
                    ],
                    [
                        'label' => 'Rust',
                        'value' => 'rust'
                    ],
                    [
                        'label' => 'Escape From Tarkov',
                        'value' => 'escapefromtarkov'
                    ],
                    [
                        'label' => '7 Days to Die',
                        'value' => '7daystodie'
                    ]
                ]
            ],
            [
                'label' => '心理戦ゲーム',
                'options' => [
                    [
                        'label' => 'Deceit',
                        'value' => 'deceit'
                    ],
                    [
                        'label' => 'Among Us',
                        'value' => 'amongus'
                    ],
                    [
                        'label' => 'Dead By Daylight',
                        'value' => 'dbd'
                    ]
                ]
            ],
            [
                'label' => 'その他',
                'options' => [
                    [
                        'label' => '原神',
                        'value' => 'genshin'
                    ],
                    [
                        'label' => 'その他',
                        'value' => 'other'
                    ]
                ]
            ]
        ],
        'types' => [
            [
                'label' => '募集',
                'options' => [
                    [
                        'label' => '即席メンバー募集',
                        'value' => 'imb'
                    ],
                    [
                        'label' => '固定メンバー募集',
                        'value' => 'kmb'
                    ],
                    [
                        'label' => 'クランメンバー募集',
                        'value' => 'cmb'
                    ]
                ]
            ],
            [
                'label' => '志願',
                'options' => [
                    [
                        'label' => '即席メンバー志願',
                        'value' => 'ims'
                    ],
                    [
                        'label' => '固定メンバー志願',
                        'value' => 'kms'
                    ],
                    [
                        'label' => 'クランメンバー志願',
                        'value' => 'cms'
                    ]
                ]
            ],
            [
                'label' => 'その他',
                'options' => [
                    [
                        'label' => 'その他',
                        'value' => 'other'
                    ]
                ]
            ]
        ]
    ]
];
