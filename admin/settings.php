<?php
if(!defined('AJAX') && !defined('VAR2')) {
    die('Security');
}

define('VAR3', TRUE);

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$app = [
    'name' => 'pollScript',
    'siteName' => 'Antalya Gemi',
    'timeZone' => 'Europe/Istanbul',
    'themeColor' => 'orange',
    'url' => 'https://www.aybarsakgun.com/pollscript/'
];

$databaseSettings = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'databaseName' => 'pollscript'
];

$existPages = [
    'home'
];

$languages = ['tr', 'en'];

$questions = [
    1 => [
        'name' => 'question_1',
        'type' => 'text',
        'question' => [
            'tr' => 'Yaşınız?',
            'en' => 'Your age?',
        ],
        'options' => [
            'tr' => array_values(range(18, 100)),
            'en' => array_values(range(18, 100)),
        ]
    ],
    2 => [
        'name' => 'question_2',
        'type' => 'radio',
        'question' => [
            'tr' => 'Sahip olduğunuz tekne türü',
            'en' => 'Own boat type?'
        ],
        'options' => [
            'tr' => [
                'Yelkenli',
                'Motorlu'
            ],
            'en' => [
                'Sailboat',
                'Motorboat'
            ],
        ]
    ],
    3 => [
        'name' => 'question_3',
        'type' => 'text',
        'span' => [
            'tr' => 'mt.',
            'en' => 'm'
        ],
        'question' => [
            'tr' => 'Sahip olduğunuz teknenin boyu',
            'en' => 'The size of the boat you own?',
        ],
        'options' => [
            'tr' => array_values(range(1, 100)),
            'en' => array_values(range(1, 100)),
        ]
    ],
    4 => [
        'name' => 'question_4',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firmamızı hangi kanaldan duydunuz veya öğrendiniz?',
            'en' => 'From which channel did you hear or learn about our company?'
        ],
        'options' => [
            'tr' => [
                'Dergi Vb.',
                'İnternet',
                'Tavsiye',
                'Fuarlar'
            ],
            'en' => [
                'Journal etc.',
                'Internet',
                'Advice',
                'Fairs'
            ],
        ]
    ],
    5 => [
        'name' => 'question_5',
        'type' => 'radio',
        'question' => [
            'tr' => 'Kaç yıldır firmamızla beraber çalışıyorsunuz?',
            'en' => 'How many years have you been working with our company?'
        ],
        'options' => [
            'tr' => [
                '0-1 Yıl',
                '1-2 Yıl',
                '2-3 Yıl',
                '3+ Yıl'
            ],
            'en' => [
                '0-1 Year',
                '1-2 Years',
                '2-3 Years',
                '3+ Years'
            ],
        ]
    ],
    6 => [
        'name' => 'question_6',
        'type' => 'checkbox',
        'question' => [
            'tr' => 'Hangi atölye(ler) den servis talebiniz oldu?',
            'en' => 'From which workshop(s) did you have a service request?'
        ],
        'options' => [
            'tr' => [
                'Elektrik/Tesisat',
                'Torna/Kaynak',
                'Döşeme/Yelken',
                'Motor',
                'Boyahane',
                'Marangozhane',
                'Diğer'
            ],
            'en' => [
                'Elektrik/Tesisat',
                'Torna/Kaynak',
                'Döşeme/Yelken',
                'Motor',
                'Boyahane',
                'Marangozhane',
                'Diğer'
            ],
        ]
    ],
    7 => [
        'name' => 'question_7',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firmamıza, iletişim kanalları yardımı ile kolayca ulaşabilme',
            'en' => 'Easy access to our company with the help of communication channels'
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    8 => [
        'name' => 'question_8',
        'type' => 'radio',
        'question' => [
            'tr' => 'Servis ziyaretlerinin taahhüt edildiği şekilde zamanında yerine getirilmesi',
            'en' => 'Timely execution of service visits as promised'
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    9 => [
        'name' => 'question_9',
        'type' => 'radio',
        'question' => [
            'tr' => 'Bildirilen yazılı/sözlü servis taleplerinde, hızlı ve doğru tespitlerin yapılması',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    10 => [
        'name' => 'question_10',
        'type' => 'radio',
        'question' => [
            'tr' => 'Servis öncesinde, yapılacak işlemler hakkında bilginin tarafınıza net olarak verilmesi',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    11 => [
        'name' => 'question_11',
        'type' => 'radio',
        'question' => [
            'tr' => 'Talep edilen sorunların, çözüme kavuşturma derecesi',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    12 => [
        'name' => 'question_12',
        'type' => 'radio',
        'question' => [
            'tr' => 'Servis sonrasında, yazılı/sözlü raporların tarafınıza net olarak sunulması',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    13 => [
        'name' => 'question_13',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firma Yetkilisinin/Servis Personelinin size olan yaklaşımı ve iletişimi',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    14 => [
        'name' => 'question_14',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firma Yetkilisinin/Servis Personelinin dış görünüşlerine gösterdikleri özen',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    15 => [
        'name' => 'question_15',
        'type' => 'radio',
        'question' => [
            'tr' => 'Teknisyenin servis sırasında çalışma bölgesinde dikkatli ve temiz olması',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    16 => [
        'name' => 'question_16',
        'type' => 'radio',
        'question' => [
            'tr' => 'Teknisyenin, servis konularında teknik bilgi yeterliliği',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    17 => [
        'name' => 'question_17',
        'type' => 'radio',
        'question' => [
            'tr' => 'Teknisyenin, sorunları belirleme/çözmedeki becerisi',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    18 => [
        'name' => 'question_18',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firmamızdan aldığınız servisten genel olarak memnuniyetiniz',
            'en' => ''
        ],
        'options' => [
            'tr' => [
                'İyi Değil',
                'Orta',
                'İyi',
                'Çok İyi'
            ],
            'en' => [
                'Not Good',
                'Not Bad',
                'Good',
                'Very Good'
            ],
        ]
    ],
    19 => [
        'name' => 'question_19',
        'type' => 'textarea',
        'question' => [
            'tr' => 'Düşüncelerinizi bizimle paylaşın',
            'en' => 'Share your thoughts with us',
        ],
        'options' => []
    ]
];