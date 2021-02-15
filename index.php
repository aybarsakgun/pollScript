<?php
define('VAR1', true);

require_once 'admin/class.user.php';

sessionStart($app);

$language = isset($_GET['language']) && in_array($_GET['language'], $languages) ? $_GET['language'] : 'tr';

$translate = [
    'header' => [
        'tr' => 'Müşteri Memnuniyeti Formu',
        'en' => 'Customer Satisfaction Survey'
    ],
    'description' => [
        'tr' => 'Firmamızı ve hizmetlerimizi daha iyi bir noktaya taşıyabilmemiz için sizin düşünceleriniz bizim için çok değerli. Sadece 5 dakikanızı ayırarak aşağıdaki anketimize katılmanız, sizlere çok daha kaliteli hizmet verebilmek için bize ışık tutacaktır.',
        'en' => 'Dear our customer, your opinions are very valuable for us to improve our company and services to a better point. We will be glad if you can take just 5 minutes to provide with you a much higher quality service.'
    ],
    'group1' => [
        'tr' => 'Müşteri Portföyü',
        'en' => 'Customer Portfolio'
    ],
    'group1_footer' => [
        'tr' => 'HADİ BAŞLAYALIM!',
        'en' => 'LETS START!'
    ],
    'group2' => [
        'tr' => 'Servis Süreci',
        'en' => 'Service Process'
    ],
    'group2_footer' => [
        'tr' => 'ÇOK AZ KALDI!',
        'en' => 'HAD VERY LITTLE!'
    ],
    'group3' => [
        'tr' => 'Personel',
        'en' => 'Staff'
    ],
    'group3_footer' => [
        'tr' => 'NEREDEYSE BİTTİ!',
        'en' => 'ALMOST DONE!'
    ],
    'group4' => [
        'tr' => 'Genel',
        'en' => 'General'
    ],
    'group4_footer' => [
        'tr' => 'TEŞEKKÜRLER!',
        'en' => 'THANKS!'
    ],
    'group5' => [
        'tr' => 'Görüş ve Önerileriniz',
        'en' => 'Opinions & Suggestions'
    ],
    'submit_button' => [
        'tr' => 'ANKETİ BİTİR VE KAYDET',
        'en' => 'Finish and Save'
    ],
    'privacy' => [
        'tr' => 'GİZLİLİK BİLDİRİMİ',
        'en' => 'PRIVACY STATEMENT'
    ],
    'privacy_detail' => [
        'tr' => 'Değerli müşterimiz/kullanıcımız, kişisel verilerinizin gizliliği ve güvenliği bizim için herşeyden önce gelmektedir. Bu yüzden anketimizde sizden firmamız hakkında değerlendirme bildirimi isterken hiç bir şekilde kişisel bilgilerinizi girmenizi talep etmedik. Amacımız siz değerli müşterilerimiz/kullanıcılarımızın firmamız hakkında düşüncelerini kendimizi geliştirmek için analiz amaçlı kullanmak olduğunu belirtmek isteriz. Bu anket formu uçtan uca 128 Bit şifreleme yapısı ile korunmaktadır.',
        'en' => 'Dear our customer, Privacy and security of your personal data are very important more than anything for us. In this matter we never request that you enter personal information while filling the survey about our company. Our main purpose is that we will analyze your precious thoughts about how to improve more ourself. This form is protected with end-to-end 128 Bit encryption structure.'
    ],
    'choose' => [
        'tr' => 'Seçiniz',
        'en' => 'Choose'
    ],
    'success' => [
        'tr' => 'Değerli müşterimiz/kullanıcımız, anketimize katıldığınız için teşekkür ederiz. Ankette belirtmiş olduğunuz cevaplar doğrultusunda, kendimizi geliştirip daha iyi bir hizmet kalitesi için yenileyeceğiz.',
        'en' => 'Thank you for taking the time to complete our form. Hope you to stay safe and healthy.'
    ],
    'fail' => [
        'tr' => 'Teknik bir problem yaşandı. Lütfen daha sonra tekrar deneyin.',
        'en' => 'There was a technical problem. Please try again later.'
    ],
];

if (empty($_SESSION[$app['name'].'Token'])) {
    $_SESSION[$app['name'].'Token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION[$app['name'].'Token'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="<?=$csrfToken?>">
		<title><?=$app['siteName']?></title>
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			body {
				font-family: 'Roboto', sans-serif;
				color: #808080;
			}
            textarea {
                color: #808080!important;
            }
            .background-gray {
                background-color: #cccccc!important;
                color: #666666!important;
            }
			.text-red {
				color: #ff4a52;
			}
			.background-red {
				background-color: #ff4a52;
			}
			.background-red, .background-green > * {
				color: #fff!important;
			}
			.text-green {
				color: #3579BD;
			}
			.background-green {
				background-color: #3579BD;
			}
			.logo {
				margin-bottom: 50px;
			}
			.questions-group {
				background-color: #ececec;
				border-radius: 10px;
			}
			.flex-center {
			    display: flex;
				justify-content: center;
				align-items: center;
			}
			.label-vertical {
				position: relative;
				display: inline-block;
				vertical-align: middle;
				text-align: center;
				font-weight: 600;
				color: #ff4a52;
				top: -7px;
				margin-right: 15px;
			}
            .background-red .label-vertical {
                color: #fff;
            }
			.background-green .label-vertical {
				color: #fff;
			}
			.label-vertical input {
				position: absolute;
				top: 28px;
				left: 50%;
				margin-left: -6px;
				display: block;
				cursor: pointer;
				margin-bottom: 10px;
			}
			.questions-footer {
				padding-top: 50px;
				position: relative;
			}
			.questions-footer .footer-label {
				position: absolute;
				top: 13px;
				right: 0;
				border-bottom-right-radius: 10px;
				border-top-left-radius: 15px;
				padding: 10px;
				font-weight: 600;
				text-transform: uppercase;
				font-size: 11px;
                background-color: #ff4a52;
                color: #fff;
			}
			.question-row select {
				width: 25%;
			}
			@media (max-width: 767px) {
				.flex-center {
					display: block;
					text-align: center;
				}
				.flex-center > div {
					margin-bottom: 15px;
					flex: 0 0 100%;
					max-width: 100%;
				}
				.label-vertical {
					margin-right: 14px;
					font-size: 12px;
				}
                .checkbox-group {
                    font-size: 12px;
                }
                .starring {
                    font-size: 12px;
                }
			}
			.checkbox-group ul {
				column-count: 2;
				column-gap: 2rem;
				list-style: none;
				padding-inline-start: 0px;
                margin-block-end: 0px;
			}
			.checkbox-group ul li {
				color: #ff4a52;
				font-weight: 600;
			}
            .background-green .checkbox-group ul li, .background-red .checkbox-group ul li {
                color: #fff;
            }
			.checkbox-group ul li input {
				margin-right: 10px;
			}
            .btn-submit {
                background-color: #ff4a52;
                font-weight: 600;
                text-transform: uppercase;
                text-align: center;
                color: #fff;
                padding: 15px;
            }
            .btn-submit:hover {
                color: #fff;
            }
            .starring {
                margin: auto;
                min-width: 100px;
                flex-wrap: wrap;
                flex-direction: column;
                padding: 1rem;
                direction: rtl;
            }
            .starring span.fa {
                font-size: 20px;
                cursor: pointer;
            }
            .starring label {
                font-weight: 600;
                color: #ff4a52;
            }
            .starring span:hover:before,
            .starring span:hover~span:before,
            .starring span.selected:before,
            .starring span.selected~span:before {
                color: orange;
            }
            .background-red .starring label,
            .background-green .starring label {
                color: #fff!important;
            }
		</style>
	</head>
	<body>
		<div class="container-lg">
			<div class="logo pt-3">
				<img src="img/logo.png" class="img-fluid">
			</div>
			<h1 class="text-red font-weight-bold"><?=$translate['header'][$language]?></h1>
			<p class="mt-3"><?=$translate['description'][$language]?></p>
			<form id="form">
                <div class="questions-group">
                    <h2 class="text-green font-weight-bold m-3 pt-3"><?=$translate['group1'][$language]?></h2>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[1]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <select class="form-control d-inline-block" name="<?=$questions[1]['name']?>" id="<?=$questions[1]['name']?>">
                                    <option value=""><?=$translate['choose'][$language]?></option>
                                    <?php foreach(range(18, 100) as $age) { ?>
                                        <option value="<?=$age?>"><?=$age?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[2]['question']['tr']?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[2]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[2]['name']?>" id="<?=$questions[2]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[3]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <select class="form-control d-inline-block" name="<?=$questions[3]['name']?>" id="<?=$questions[3]['name']?>">
                                    <option value=""><?=$translate['choose'][$language]?></option>
                                    <?php foreach(range(1, 100) as $age) { ?>
                                        <option value="<?=$age?>"><?=$age?></option>
                                    <?php } ?>
                                </select>
                                <span><?=$questions[3]['span'][$language]?></span>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[4]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[4]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[4]['name']?>" id="<?=$questions[4]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="questions-footer">
                        <div class="footer-label">
                            <?=$translate['group1_footer'][$language]?>
                        </div>
                    </div>
                </div>
                <div class="questions-group">
                    <h2 class="text-green font-weight-bold m-3 pt-3"><?=$translate['group2'][$language]?></h2>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[5]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[5]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[5]['name']?>" id="<?=$questions[5]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[6]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6 checkbox-group">
                                <ul>
                                    <?php foreach ($questions[6]['options'][$language] as $index => $option) { ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="<?=$questions[6]['name']?>[]" id="<?=$questions[6]['name']?>" value="<?=$option?>"/>
                                            <span><?=$option?></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[7]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[7]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[7]['name']?>" id="<?=$questions[7]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[8]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[8]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[8]['name']?>" id="<?=$questions[8]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[9]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[9]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[9]['name']?>" id="<?=$questions[9]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[10]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[10]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[10]['name']?>" id="<?=$questions[10]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[11]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[11]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[11]['name']?>" id="<?=$questions[11]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[12]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[12]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[12]['name']?>" id="<?=$questions[12]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="questions-footer">
                        <div class="footer-label">
                            <?=$translate['group2_footer'][$language]?>
                        </div>
                    </div>
                </div>
                <div class="questions-group">
                    <h2 class="text-green font-weight-bold m-3 pt-3"><?=$translate['group3'][$language]?></h2>
                    <div class="question-row">
                        <div class="px-1 py-3">
                            <div class="col-12">
                                <span><?=$questions[13]['question'][$language]?></span>
                            </div>
                            <div class="col-12">
                                <div class="row mt-3">
                                    <?php
                                    foreach ($questions[13]['options'][$language] as $index => $option) {
                                        echo '<div class="starring flex-center">';
                                        if (is_array($option)) {
                                            echo '<label>' . $index . '</label><div>';
                                            foreach (array_reverse($option) as $subOption) {
                                                echo '<span class="fa fa-star" data-rate="'.$subOption.'"></span>';
                                            }
                                            echo '<input type="hidden" name="'.$questions[13]['name'].'[]" id="'.$questions[13]['name'].'"></div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="px-1 py-3">
                            <div class="col-12">
                                <span><?=$questions[14]['question'][$language]?></span>
                            </div>
                            <div class="col-12">
                                <div class="row mt-3">
                                    <?php
                                    foreach ($questions[14]['options'][$language] as $index => $option) {
                                        echo '<div class="starring flex-center">';
                                        if (is_array($option)) {
                                            echo '<label>' . $index . '</label><div>';
                                            foreach (array_reverse($option) as $subOption) {
                                                echo '<span class="fa fa-star" data-rate="'.$subOption.'"></span>';
                                            }
                                            echo '<input type="hidden" name="'.$questions[14]['name'].'[]" id="'.$questions[14]['name'].'"></div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="px-1 py-3">
                            <div class="col-12">
                                <span><?=$questions[15]['question'][$language]?></span>
                            </div>
                            <div class="col-12">
                                <div class="row mt-3">
                                    <?php
                                    foreach ($questions[15]['options'][$language] as $index => $option) {
                                        echo '<div class="starring flex-center">';
                                        if (is_array($option)) {
                                            echo '<label>' . $index . '</label><div>';
                                            foreach (array_reverse($option) as $subOption) {
                                                echo '<span class="fa fa-star" data-rate="'.$subOption.'"></span>';
                                            }
                                            echo '<input type="hidden" name="'.$questions[15]['name'].'[]" id="'.$questions[15]['name'].'"></div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="px-1 py-3">
                            <div class="col-12">
                                <span><?=$questions[16]['question'][$language]?></span>
                            </div>
                            <div class="col-12">
                                <div class="row mt-3">
                                    <?php
                                    foreach ($questions[16]['options'][$language] as $index => $option) {
                                        echo '<div class="starring flex-center">';
                                        if (is_array($option)) {
                                            echo '<label>' . $index . '</label><div>';
                                            foreach (array_reverse($option) as $subOption) {
                                                echo '<span class="fa fa-star" data-rate="'.$subOption.'"></span>';
                                            }
                                            echo '<input type="hidden" name="'.$questions[16]['name'].'[]" id="'.$questions[16]['name'].'"></div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question-row">
                        <div class="px-1 py-3">
                            <div class="col-12">
                                <span><?=$questions[17]['question'][$language]?></span>
                            </div>
                            <div class="col-12">
                                <div class="row mt-3">
                                    <?php
                                    foreach ($questions[17]['options'][$language] as $index => $option) {
                                        echo '<div class="starring flex-center">';
                                        if (is_array($option)) {
                                            echo '<label>' . $index . '</label><div>';
                                            foreach (array_reverse($option) as $subOption) {
                                                echo '<span class="fa fa-star" data-rate="'.$subOption.'"></span>';
                                            }
                                            echo '<input type="hidden" name="'.$questions[17]['name'].'[]" id="'.$questions[17]['name'].'"></div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="questions-footer">
                        <div class="footer-label">
                            <?=$translate['group3_footer'][$language]?>
                        </div>
                    </div>
                </div>
                <div class="questions-group">
                    <h2 class="text-green font-weight-bold m-3 pt-3"><?=$translate['group4'][$language]?></h2>
                    <div class="question-row">
                        <div class="flex-center px-1 py-3">
                            <div class="col-xs-12 col-sm-6">
                                <span><?=$questions[18]['question'][$language]?></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?php foreach ($questions[18]['options'][$language] as $index => $option) { ?>
                                    <label class="label-vertical">
                                        <input type="radio" name="<?=$questions[18]['name']?>" id="<?=$questions[18]['name']?>" value="<?=$option?>"><?=$option?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="questions-footer">
                        <div class="footer-label background-gray">
                            <?=$translate['group4_footer'][$language]?>
                        </div>
                    </div>
                </div>
                <div class="questions-group">
                    <h2 class="text-green font-weight-bold m-3 pt-3"><?=$translate['group5'][$language]?></h2>
                    <div class="question-row col-12 pb-4">
                        <textarea class="form-control" name="<?=$questions[19]['name']?>" id="<?=$questions[19]['name']?>" rows="4" placeholder="<?=$questions[19]['question'][$language]?>"></textarea>
                    </div>
                </div>
                <div class="submit-button-area col-12 flex-center my-4">
                    <button type="submit" class="btn btn-submit"><?=$translate['submit_button'][$language]?></button>
                </div>
                <hr>
                <p class="form-fail-result text-danger" style="display:none"><?=$translate['fail'][$language]?></p>
                <p class="form-success-result text-green" style="display:none"><?=$translate['success'][$language]?></p>
                <div class="privacy">
                    <h3 class="text-red font-weight-bold pb-2"><?=$translate['privacy'][$language]?></h3>
                    <p class="text-red"><?=$translate['privacy_detail'][$language]?></p>
                </div>
            </form>
		</div>
	</body>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script>
        var questions = JSON.parse('<?=json_encode($questions)?>');
        // $('input, select, textarea').change(function() {
        //     if (!$(this).hasClass('filled')) {
        //         $(this).parents('.question-row').removeClass('background-green background-red').addClass('filled');
        //         var notFilledQuestions = $('.question-row:not(.filled)');
        //         if (notFilledQuestions.length) {
        //             $(notFilledQuestions[0]).addClass('background-green');
        //         }
        //     }
        // });
        // $('.fa').click(function() {
        //     var rate = $(this).data('rate');
        //     var rateInput = $(this).siblings('input[type="hidden"]');
        //     $(this).siblings('span.fa').removeClass().addClass('fa fa-star');
        //     $(this).addClass('selected');
        //     rateInput.val(rate);
        //     var formValues = $('#form').serializeArray();
        //     if (formValues.findIndex(function(item) {
        //         return item.name === rateInput.attr('name') && !item.value
        //     }) === -1) {
        //         if (!$(this).hasClass('filled')) {
        //             $(this).parents('.question-row').removeClass('background-green background-red').addClass('filled');
        //             var notFilledQuestions = $('.question-row:not(.filled)');
        //             if (notFilledQuestions.length) {
        //                 $(notFilledQuestions[0]).addClass('background-green');
        //             }
        //         }
        //     }
        // });
        $('input, select, textarea').change(function() {
            $(this).parents('.question-row').removeClass('background-green background-red');
        });
        $('.fa').click(function() {
            var rate = $(this).data('rate');
            var rateInput = $(this).siblings('input[type="hidden"]');
            $(this).siblings('span.fa').removeClass().addClass('fa fa-star');
            $(this).addClass('selected');
            rateInput.val(rate);
            $(this).parents('.question-row').removeClass('background-green background-red');
        });
        $('#form').on('submit',(function(e) {
            e.preventDefault();
            var formValues = $(this).serializeArray();
            for (var i = 0; i < 19; i++) {
                var questionRowOfQuestion = $('#question_' + (i + 1)).parents('.question-row');
                if (formValues.findIndex(function(item) {
                    return (item.name === 'question_' + (i + 1) || item.name === 'question_' + (i + 1) + '[]') && item.value
                }) === -1 && !questions[i + 1].notRequired) {
                    $('.question-row').each(function() {
                        $(this).removeClass('background-green background-red');
                    });
                    if (questionRowOfQuestion.length) {
                        $(questionRowOfQuestion[0]).addClass('background-red');
                        $('html,body').animate({
                            scrollTop: $(questionRowOfQuestion[0]).offset().top
                        }, 'slow');
                    }
                    return;
                }
            }
            $.ajax({
                url: "save-poll-<?=$language?>",
                type: "POST",
                data:  new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                headers : {
                    'csrftoken': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data)
                {
                    if(data.success) {
                        $('.questions-group').hide();
                        $('.submit-button-area').hide();
                        $('.form-fail-result').hide();
                        $('.form-success-result').show();
                    } else {
                        $('.form-fail-result').show();
                    }
                }
            });
        }));
    </script>
</html>
