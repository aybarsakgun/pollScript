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
            'en' => 'Boat type that you own'
        ],
        'options' => [
            'tr' => [
                'Yelkenli',
                'Motorlu'
            ],
            'en' => [
                'Sailing',
                'Motor'
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
            'en' => 'Boat length',
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
            'en' => 'How did you find us?'
        ],
        'options' => [
            'tr' => [
                'Dergi Vb.',
                'İnternet',
                'Tavsiye',
                'Fuarlar'
            ],
            'en' => [
                'Magazine, etc.',
                'Internet',
                'Advice',
                'Fair'
            ],
        ]
    ],
    5 => [
        'name' => 'question_5',
        'type' => 'radio',
        'question' => [
            'tr' => 'Kaç yıldır firmamızla beraber çalışıyorsunuz?',
            'en' => 'How long are you working with us?'
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
                'Electric/Plumbing',
                'Turning/Welding',
                'Upholstery/Sails',
                'Mechanics',
                'Painting',
                'Carpentry',
                'Other'
            ],
        ]
    ],
    7 => [
        'name' => 'question_7',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firmamıza, iletişim kanalları yardımı ile kolayca ulaşabilme',
            'en' => 'To be reached easily to our company by using any communication channels'
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
                'Normal',
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
            'en' => 'To be fulfilled of service visits on time as promised'
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
                'Normal',
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
            'en' => 'To be done quick and right determination for notified written/verbal service requests'
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
                'Normal',
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
            'en' => 'To be given information clearly about works which will be executed, before the service'
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
                'Normal',
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
            'en' => 'Degree of resolving problems which were requested'
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
                'Normal',
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
            'en' => 'To be provided you with written/verbal reports clearly, after the service'
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
                'Normal',
                'Good',
                'Very Good'
            ],
        ]
    ],
    13 => [
        'name' => 'question_13',
        'type' => 'starring',
        'question' => [
            'tr' => 'Firma Yetkilisinin/Servis Personelinin size olan yaklaşımı ve iletişimi',
            'en' => 'Approch of our Authorized Person/Service Personnel to you, and communication with you'
        ],
        'options' => [
            'tr' => [
                'Ofis/Ön Büro' => array_values(range(1, 5)),
                'Elektrik/Tesisat' => array_values(range(1, 5)),
                'Torna/Kaynak' => array_values(range(1, 5)),
                'Döşeme/Yelken' => array_values(range(1, 5)),
                'Motor Atölyesi' => array_values(range(1, 5)),
                'Boyahane' => array_values(range(1, 5)),
                'Marangozhane' => array_values(range(1, 5))
            ],
            'en' => [
                'Office' => array_values(range(1, 5)),
                'Electric/Plumbing' => array_values(range(1, 5)),
                'Turning/Welding' => array_values(range(1, 5)),
                'Upholstery/Sails' => array_values(range(1, 5)),
                'Mechanics' => array_values(range(1, 5)),
                'Painting' => array_values(range(1, 5)),
                'Carpentry' => array_values(range(1, 5))
            ],
        ]
    ],
    14 => [
        'name' => 'question_14',
        'type' => 'starring',
        'question' => [
            'tr' => 'Firma Yetkilisinin/Servis Personelinin dış görünüşlerine gösterdikleri özen',
            'en' => 'Our Authorized Person/Service Personnel to pay attention to their appearance'
        ],
        'options' => [
            'tr' => [
                'Ofis/Ön Büro' => array_values(range(1, 5)),
                'Elektrik/Tesisat' => array_values(range(1, 5)),
                'Torna/Kaynak' => array_values(range(1, 5)),
                'Döşeme/Yelken' => array_values(range(1, 5)),
                'Motor Atölyesi' => array_values(range(1, 5)),
                'Boyahane' => array_values(range(1, 5)),
                'Marangozhane' => array_values(range(1, 5))
            ],
            'en' => [
                'Office' => array_values(range(1, 5)),
                'Electric/Plumbing' => array_values(range(1, 5)),
                'Turning/Welding' => array_values(range(1, 5)),
                'Upholstery/Sails' => array_values(range(1, 5)),
                'Mechanics' => array_values(range(1, 5)),
                'Painting' => array_values(range(1, 5)),
                'Carpentry' => array_values(range(1, 5))
            ],
        ]
    ],
    15 => [
        'name' => 'question_15',
        'type' => 'starring',
        'question' => [
            'tr' => 'Teknisyenin servis sırasında çalışma bölgesinde dikkatli ve temiz olması',
            'en' => 'The technicians attention and care in the working area during service'
        ],
        'options' => [
            'tr' => [
//                'Ofis/Ön Büro' => array_values(range(1, 5)),
                'Elektrik/Tesisat' => array_values(range(1, 5)),
                'Torna/Kaynak' => array_values(range(1, 5)),
                'Döşeme/Yelken' => array_values(range(1, 5)),
                'Motor Atölyesi' => array_values(range(1, 5)),
                'Boyahane' => array_values(range(1, 5)),
                'Marangozhane' => array_values(range(1, 5))
            ],
            'en' => [
//                'Office' => array_values(range(1, 5)),
                'Electric/Plumbing' => array_values(range(1, 5)),
                'Turning/Welding' => array_values(range(1, 5)),
                'Upholstery/Sails' => array_values(range(1, 5)),
                'Mechanics' => array_values(range(1, 5)),
                'Painting' => array_values(range(1, 5)),
                'Carpentry' => array_values(range(1, 5))
            ],
        ]
    ],
    16 => [
        'name' => 'question_16',
        'type' => 'starring',
        'question' => [
            'tr' => 'Teknisyenin, servis konularında teknik bilgi yeterliliği',
            'en' => 'Competence for technical knowledge of technician in service matters'
        ],
        'options' => [
            'tr' => [
//                'Ofis/Ön Büro' => array_values(range(1, 5)),
                'Elektrik/Tesisat' => array_values(range(1, 5)),
                'Torna/Kaynak' => array_values(range(1, 5)),
                'Döşeme/Yelken' => array_values(range(1, 5)),
                'Motor Atölyesi' => array_values(range(1, 5)),
                'Boyahane' => array_values(range(1, 5)),
                'Marangozhane' => array_values(range(1, 5))
            ],
            'en' => [
//                'Office' => array_values(range(1, 5)),
                'Electric/Plumbing' => array_values(range(1, 5)),
                'Turning/Welding' => array_values(range(1, 5)),
                'Upholstery/Sails' => array_values(range(1, 5)),
                'Mechanics' => array_values(range(1, 5)),
                'Painting' => array_values(range(1, 5)),
                'Carpentry' => array_values(range(1, 5))
            ],
        ]
    ],
    17 => [
        'name' => 'question_17',
        'type' => 'starring',
        'question' => [
            'tr' => 'Teknisyenin, sorunları belirleme/çözmedeki becerisi',
            'en' => 'Skill of the technician in identifying/solving problems'
        ],
        'options' => [
            'tr' => [
//                'Ofis/Ön Büro' => array_values(range(1, 5)),
                'Elektrik/Tesisat' => array_values(range(1, 5)),
                'Torna/Kaynak' => array_values(range(1, 5)),
                'Döşeme/Yelken' => array_values(range(1, 5)),
                'Motor Atölyesi' => array_values(range(1, 5)),
                'Boyahane' => array_values(range(1, 5)),
                'Marangozhane' => array_values(range(1, 5))
            ],
            'en' => [
//                'Office' => array_values(range(1, 5)),
                'Electric/Plumbing' => array_values(range(1, 5)),
                'Turning/Welding' => array_values(range(1, 5)),
                'Upholstery/Sails' => array_values(range(1, 5)),
                'Mechanics' => array_values(range(1, 5)),
                'Painting' => array_values(range(1, 5)),
                'Carpentry' => array_values(range(1, 5))
            ],
        ]
    ],
    18 => [
        'name' => 'question_18',
        'type' => 'radio',
        'question' => [
            'tr' => 'Firmamızdan aldığınız servisten genel olarak memnuniyetiniz',
            'en' => 'Overall, how satisfied are you with us, after the service?'
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
                'Normal',
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
        'options' => [],
        'notRequired' => true
    ]
];