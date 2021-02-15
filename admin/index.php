<?php
define('VAR1', true);

require_once 'class.user.php';

sessionStart($app);

if (empty($_SESSION[$app['name'].'Token'])) {
    $_SESSION[$app['name'].'Token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION[$app['name'].'Token'];

if(loginCheck($DB_con) == false)
{
    header("Location: login");
    exit();
}

$getUser = $DB_con->prepare("SELECT id, username, name FROM users WHERE id = :id");
$getUser->execute(array(":id" => loginCheck($DB_con)));
$user = $getUser->fetch(PDO::FETCH_ASSOC);

$pageRequest = filter_input(INPUT_GET, 'pr', FILTER_SANITIZE_STRING);

if (!in_array($pageRequest, $existPages)) {
    $pageRequest = null;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="<?=$csrfToken?>">
        <title>Yönetici Paneli - <?=$app['siteName']?></title>
        <link rel="icon" href="img/favicon.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="plugins/node-waves/waves.min.css" rel="stylesheet" />
        <link href="plugins/animate-css/animate.min.css" rel="stylesheet" />
        <link href="plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet">
        <link href="css/all-themes.min.css" rel="stylesheet" />
    </head>
    <?php if (!isset($pageRequest)) {?>
    <body class="four-zero-four">
        <div class="four-zero-four-container">
            <div class="error-code">404</div>
            <div class="error-message">Sayfa bulunamadı</div>
            <div class="button-place">
                <a href="home" class="btn btn-default btn-lg waves-effect">Anasayfaya dön</a>
            </div>
        </div>
    <?php } else { ?>
    <body class="theme-<?=$app['themeColor']?>">
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-<?=$app['themeColor']?>">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Yükleniyor...</p>
            </div>
        </div>
        <div class="overlay"></div>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="home">Yönetici<strong>Paneli</strong></a>
                </div>
            </div>
        </nav>
        <section>
            <aside id="leftsidebar" class="sidebar">
                <div class="user-info">
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$user['name']?></div>
                        <div class="email"><?php echo $user['username']; ?></div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons logoutButton">exit_to_app</i>
                        </div>
                    </div>
                </div>
                <div class="menu">
                    <ul class="list">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#profileSettingsModal">
                                <i class="material-icons">settings</i>
                                <span>Profil Ayarları</span>
                            </a>
                        </li>
                        <li class="<?php if ($pageRequest == 'home') { ?>active<?php } ?>">
                            <a href="home">
                                <i class="material-icons">home</i>
                                <span>Kontrol Paneli</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-toggle waves-effect waves-block">
                                <i class="material-icons">import_export</i>
                                <span>EXCEL'e Aktar</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="export-xls-tr" target="_blank" class="waves-effect waves-block">Türkçe Cevaplar</a>
                                </li>
                                <li>
                                    <a href="export-xls-en" target="_blank" class="waves-effect waves-block">İngilizce Cevaplar</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="menu-toggle waves-effect waves-block">
                                <i class="material-icons">import_export</i>
                                <span>CSV'e Aktar</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="export-csv-tr" target="_blank" class="waves-effect waves-block">Türkçe Cevaplar</a>
                                </li>
                                <li>
                                    <a href="export-csv-en" target="_blank" class="waves-effect waves-block">İngilizce Cevaplar</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#pollLinksModal">
                                <i class="material-icons">link</i>
                                <span>Anket Bağlantıları</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="legal">
                    <div class="copyright">
                        &copy; 2020 <?=$app['siteName']?>
                    </div>
                </div>
            </aside>
        </section>
        <?php if ($pageRequest == 'home') { ?>
        <section class="content">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default panel-post">
                            <div class="panel-heading">
                                <h4><strong>Yönetici Giriş Kayıtları</strong></h4>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <select class="form-control" id="sort">
                                        <option value="0">Tarihe göre (Önce en yeni giriş)</option>
                                        <option value="1">Tarihe göre (Önce en eski giriş)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 accessLogs">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default panel-post">
                            <div class="panel-heading">
                                <h4><strong>Gelen Anket Cevapları</strong></h4>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <select class="form-control" id="sortPoll">
                                        <option value="0">Tarihe göre (Önce en yeni cevap)</option>
                                        <option value="1">Tarihe göre (Önce en eski cevap)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="startDate" readonly placeholder="Başlangıç tarihi">
                                    </div>
                                    <span class="input-group-addon"><i class="material-icons">date_range</i></span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="endDate" readonly placeholder="Bitiş tarihi">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pollAnswers">

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="answersModal" tabindex="-1" role="dialog" style="display: none;">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Cevaplar</h4>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pollLinksModal" tabindex="-1" role="dialog" style="display: none;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Anket Bağlantıları</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 m-b-20">
                                            <div class="input-group" style="margin-bottom:0px!important">
                                                <label for="pollLinkTr">Türkçe Form Linki</label>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="pollLinkTr" value="<?=$app['url']?>anket" readonly>
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" class="btn bg-<?=$app['themeColor']?> col-white waves-effect" onclick="copyToClipboard('pollLinkTr')">Kopyala</button>
                                                </span>
                                            </div>
                                            <p class="text-success" id="pollLinkTrCopied" style="display:none;"><strong>Kopyalandı</strong></p>
                                        </div>
                                        <div class="col-md-12 m-b-20">
                                            <div class="input-group" style="margin-bottom:0px!important">
                                                <label for="pollLinkEn">İngilizce Form Linki</label>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="pollLinkEn" value="<?=$app['url']?>poll" readonly>
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" class="btn bg-<?=$app['themeColor']?> col-white waves-effect" onclick="copyToClipboard('pollLinkEn')">Kopyala</button>
                                                </span>
                                            </div>
                                            <p class="text-success" id="pollLinkEnCopied" style="display:none;"><strong>Kopyalandı</strong></p>
                                        </div>
                                        <div class="col-md-12 m-b-20">
                                            <div class="input-group" style="margin-bottom:0px!important">
                                                <label for="pollLinkTr">Türkçe Form Gönder</label>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="pollLinkTrEmail">
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" class="btn bg-<?=$app['themeColor']?> col-white waves-effect" onclick="sendMail('pollLinkTrEmail', 'tr', this)">Gönder</button>
                                                </span>
                                            </div>
                                            <p id="pollLinkTrSentResult" style="display:none;"></p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group" style="margin-bottom:0px!important">
                                                <label for="pollLinkTr">İngilizce Form Gönder</label>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="pollLinkEnEmail">
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" class="btn bg-<?=$app['themeColor']?> col-white waves-effect" onclick="sendMail('pollLinkEnEmail', 'en', this)">Gönder</button>
                                                </span>
                                            </div>
                                            <p id="pollLinkEnSentResult" style="display:none;"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="profileSettingsModal" tabindex="-1" role="dialog" style="display: none;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Profil Ayarları</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <form id="profileSettingsForm">
                                            <div class="col-xs-12">
                                                <input type="hidden" name="id" value="<?=$user['id']?>">
                                                <label for="username">Kullanıcı Adı</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="username" name="username" class="form-control" value="<?=$user['username']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <label for="name">Ad</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="name" name="name" class="form-control" value="<?=$user['name']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <label for="password">Şifre <small>(Şifrenizi değiştirmek istemiyorsanız boş bırakınız.)</small></label>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="password" id="password" name="password" class="form-control">
                                                    </div>
                                                    <span class="input-group-addon">
                                                        <i class="material-icons" style="cursor:pointer;" id="passwordVisibilityChanger">visibility</i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <label for="passwordVerify">Şifre Tekrar</label>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="password" id="passwordVerify" name="passwordVerify" class="form-control">
                                                    </div>
                                                    <span class="input-group-addon">
                                                        <i class="material-icons" style="cursor:pointer;" id="passwordVerifyVisibilityChanger">visibility</i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div id="result"></div>
                                                <button type="submit" class="btn bg-<?=$app['themeColor']?> m-t-15 waves-effect" id="editProfileButton">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php }
    }
    ?>
        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="plugins/node-waves/waves.min.js"></script>
        <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
        <script src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="plugins/bootstrap-datepicker/locales/bootstrap-datepicker.tr.min.js"></script>
        <script src="js/main.js"></script>
        <?php include_once 'pageJS.php'; ?>
    </body>
</html>
