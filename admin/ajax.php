<?php
define('AJAX', TRUE);

require_once 'class.user.php';

$pageRequest = filter_input(INPUT_GET, 'pr', FILTER_SANITIZE_STRING);

$allowedNoAjaxRoutes = [
    'export-xls',
    'export-csv'
];

sessionStart($app);

if (!in_array($pageRequest, $allowedNoAjaxRoutes)) {
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
        die(result(400, 'Security'));
    }

    if (empty($_SESSION[$app['name'].'Token'])) {
        $_SESSION[$app['name'].'Token'] = bin2hex(random_bytes(32));
    }

    $csrfToken = $_SESSION[$app['name'].'Token'];

    $headers = apache_request_headers();

    if (isset($headers['csrftoken']))
    {
        if (!hash_equals($csrfToken, $headers['csrftoken'])) {
            die(result(400, 'Security'));
        }
    } else {
        die(result(400, 'Security'));
    }
}

if(loginCheck($DB_con) == false)
{
	header('Location: login');
    die(result(400, 'Security'));
}

if(isset($pageRequest))
{
    if($pageRequest == "logout") {
        echo $_user->logout();
    } else if ($pageRequest == 'access-logs') {
        $checkUser = $DB_con->prepare("SELECT id FROM users WHERE id = :userId");
        $checkUser->execute(array(":userId"=>1));
        if($checkUser->rowCount() == 1)
        {
            $loginAttempts = $DB_con->prepare("SELECT COUNT(userId) AS counter FROM login_attempts WHERE userId = :userId");
            $loginAttempts->execute(array(":userId"=>1));
            $fetchLoginAttempts = $loginAttempts->fetch(PDO::FETCH_ASSOC);
            if($loginAttempts->rowCount() > 0)
            {
                $filterString = "";
                $filterPrefix = "";

                $sortStatus = isset($_GET['sort']) ? (int) $_GET['sort'] : 0;
                
                if($sortStatus == 0)
                {
                    $sortString = "ORDER BY date DESC";
                }
                else if($sortStatus == 1)
                {
                    $sortString = "ORDER BY date ASC";
                }
                else
                {
                    $sortString = "";
                }

                if(isset($_GET["filter"]))
                {
                    $filter = preg_replace('/[^a-z0-9]/', '', filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING));
                    if($filter != "")
                    {
                        if($filter == "filter2")
                        {
                            $filterString .= $filterPrefix . "status = 1 ";
                            $filterPrefix = 'AND ';
                        }
                        else if($filter == "filter3")
                        {
                            $filterString .= $filterPrefix . "status = 0 ";
                            $filterPrefix = 'AND ';
                        }
                    }
                }

                if($filterString != "")
                {
                    $queryString = "SELECT COUNT(userId) AS counter FROM login_attempts WHERE $filterString AND userId = :userId";
                }
                else if($filterString == "")
                {
                    $queryString = "SELECT COUNT(userId) AS counter FROM login_attempts WHERE userId = :userId";
                }

                $query = $DB_con->prepare($queryString);
                $query->execute(array(":userId"=>1));
                $fetchQuery = $query->fetch(PDO::FETCH_ASSOC);

                $perPage = 20;
                $totalRow = $fetchQuery["counter"];
                $totalPage = ceil($totalRow / $perPage);
                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                if($page < 1) $page = 1;
                if($page > $totalPage) $page = $totalPage;
                $limit = ($page - 1) * $perPage;

                if($filterString != "")
                {
                    $queryString = "SELECT * FROM login_attempts WHERE $filterString AND userId = :userId $sortString LIMIT :limit , :perPage";
                }
                else if($filterString == "")
                {
                    $queryString = "SELECT * FROM login_attempts WHERE userId = :userId $sortString LIMIT :limit , :perPage";
                }

                $query = $DB_con->prepare($queryString);
                $query->execute(array(":userId"=>1,":limit"=>$limit,":perPage"=>$perPage));
                ?>
                <strong>Filtrele: </strong>
                <input type="radio" class="with-gap radio-col-light-blue filterButton" name="filter" id="filter1" <?php if( ( !isset($_GET["filter"]) ) || ( isset($_GET["filter"]) && $filter == "filter1" ) ) { ?>checked<?php } ?>>
                <label for="filter1">Tümü</label>
                <input type="radio" class="with-gap radio-col-light-blue filterButton" name="filter" id="filter2" <?php if(isset($_GET["filter"]) && $filter == "filter2") { ?>checked<?php } ?>>
                <label for="filter2">Başarılı</label>
                <input type="radio" class="with-gap radio-col-light-blue filterButton" name="filter" id="filter3" <?php if(isset($_GET["filter"]) && $filter == "filter3") { ?>checked<?php } ?>>
                <label for="filter3">Başarısız</label>
                <br>
                <?php
                if($fetchQuery["counter"] > 0)
                {
                    if($filterString == "")
                    {
                        ?>
                        <small>Toplam <?=$fetchQuery["counter"]?> tane bulunan sonuçtan <?=$query->rowCount()?> tanesini görüntülüyorsunuz.</small>
                        <?php
                    }
                    else
                    {
                        ?>
                        <small>Toplam <?=$fetchLoginAttempts["counter"]?> tane bulunan sonuçtan, filtrelemenize uygun <?=$fetchQuery["counter"]?> tanesinin <?=$query->rowCount()?> tanesini görüntülüyorsunuz.</small>
                        <?php
                    }
                }
                ?>
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>IP Adresi</th>
                        <th>Sistem Bilgileri</th>
                        <th class="visible-sm visible-md visible-lg">Tarih</th>
                        <th class="visible-sm visible-md visible-lg">Durum</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($fetchQuery["counter"] > 0)
                    {
                        while($fetch = $query->fetch(PDO::FETCH_ASSOC))
                        {
                            $systemInfo = systemInfo($fetch['browser']);
                            ?>
                            <tr>
                                <td><?=$fetch["ip_address"]?></td>
                                <td>
                                    <span><?=$systemInfo['os'] . ' / ' . $systemInfo['browser']?></span>
                                    <div class="visible-xs">
                                        <strong>Tarih:</strong> <?=date('d.m.Y H:i:s', strtotime($fetch["date"]))?><br>
                                        <strong>Durum:</strong><br>
                                        <?php if($fetch["status"] == "0") { ?><span class="label label-danger">Başarısız</span><?php } else if($fetch["status"] == "1") { ?><span class="label label-success">Başarılı</span><?php } ?>
                                    </div>
                                </td>
                                <td class="visible-sm visible-md visible-lg"><?=date('d.m.Y H:i:s', strtotime($fetch["date"]))?></td>
                                <td class="visible-sm visible-md visible-lg"><?php if($fetch["status"] == "0") { ?><span class="label label-danger">Başarısız</span><?php } else if($fetch["status"] == "1") { ?><span class="label label-success">Başarılı</span><?php } ?></td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td colspan="5">Filtrelemenize uygun sonuç bulunamadı.</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <?php
                if($fetchQuery["counter"] > 0)
                {
                    ?>
                    <ul class="pagination">
                        <?php
                        $showPage = 5;

                        $lowestCenter = ceil($showPage/2);
                        $highestCenter = ($totalPage+1) - $lowestCenter;

                        $pageCenter = $page;
                        if($pageCenter < $lowestCenter) $pageCenter = $lowestCenter;
                        if($pageCenter > $highestCenter) $pageCenter = $highestCenter;

                        $leftPages = round($pageCenter - (($showPage-1) / 2));
                        $rightPages = round((($showPage-1) / 2) + $pageCenter);

                        if($leftPages < 1) $leftPages = 1;
                        if($rightPages > $totalPage) $rightPages = $totalPage;

                        if($page != 1) echo '<li><a class="waves-effect paginateButton" href="javascript:void(0);" id="1"><i class="material-icons">first_page</i></a></li>';
                        else if($page == 1) echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">first_page</i></a></li>';
                        if($page != 1) echo '<li><a class="waves-effect paginateButton" href="javascript:void(0);" id="'.($page-1).'"><i class="material-icons">chevron_left</i></a></li>';
                        else if($page == 1) echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">chevron_left</i></a></li>';

                        for($s = $leftPages; $s <= $rightPages; $s++) {
                            if($page == $s) {
                                echo '<li class="active"><a href="javascript:void(0);" class="bg-'.$app['themeColor'].'">'.$s.'</a></li>';
                            } else {
                                echo '<li><a class="waves-effect paginateButton" href="javascript:void(0);" id="'.$s.'">'.$s.'</a></li>';
                            }
                        }

                        if($page != $totalPage) echo '<li><a class="waves-effect paginateButton" href="javascript:void(0);" id="'.($page+1).'"><i class="material-icons">chevron_right</i></a></li>';
                        else if($page == $totalPage) echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">chevron_right</i></a></li>';
                        if($page != $totalPage) echo '<li><a class="waves-effect paginateButton" href="javascript:void(0);" id="'.$totalPage.'"><i class="material-icons">last_page</i></a></li>';
                        else if($page == $totalPage)  echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">last_page</i></a></li>';
                        ?>
                    </ul>
                    <?php
                }
            }
            else
            {
                ?>
                <div class='alert alert-danger'><strong>Bilgi: </strong>Henüz yöneticinin sisteme giriş kayıtı bulunamadı.</div>
                <?php
            }
        }
        else
        {
            ?>
            <div class='alert alert-danger'><strong>Hata: </strong>Teknik bir hata yaşandı. Tekrar deneyin.</div>
            <?php
        }
    } else if ($pageRequest == 'poll-answers') {
        $answers = $DB_con->prepare("SELECT COUNT(id) AS counter FROM poll_answers");
        $answers->execute();
        $fetchAnswers = $answers->fetch(PDO::FETCH_ASSOC);
        if((int)$fetchAnswers['counter'] > 0)
        {
            $dateRangeQuery = "";

            $sortStatus = isset($_GET['sort']) ? (int) $_GET['sort'] : 0;

            if($sortStatus == 0)
            {
                $sortString = "ORDER BY date DESC";
            }
            else if($sortStatus == 1)
            {
                $sortString = "ORDER BY date ASC";
            }
            else
            {
                $sortString = "";
            }

            if(isset($_GET['startDate']) && isset($_GET['endDate']))
            {
                $startDate = preg_replace('/[^0-9.]/', '', filter_input(INPUT_GET, 'startDate', FILTER_SANITIZE_STRING));
                $endDate = preg_replace('/[^0-9.]/', '', filter_input(INPUT_GET, 'endDate', FILTER_SANITIZE_STRING));

                if (!empty($startDate) && !empty($endDate)) {
                    $dateRangeQuery = 'date BETWEEN "' . date('Y-m-d', strtotime($startDate)) . ' 00:00:00" AND "' . date('Y-m-d', strtotime($endDate)) . ' 23:59:00"';
                }
            }

            if($dateRangeQuery != "")
            {
                $queryString = "SELECT COUNT(id) AS counter FROM poll_answers WHERE $dateRangeQuery";
            }
            else if($dateRangeQuery == "")
            {
                $queryString = "SELECT COUNT(id) AS counter FROM poll_answers";
            }

            $query = $DB_con->prepare($queryString);
            $query->execute();
            $fetchQuery = $query->fetch(PDO::FETCH_ASSOC);

            $perPage = 20;
            $totalRow = $fetchQuery["counter"];
            $totalPage = ceil($totalRow / $perPage);
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            if($page < 1) $page = 1;
            if($page > $totalPage) $page = $totalPage;
            $limit = ($page - 1) * $perPage;

            if($dateRangeQuery != "")
            {
                $queryString = "SELECT * FROM poll_answers WHERE $dateRangeQuery $sortString LIMIT :limit , :perPage";
            }
            else if($dateRangeQuery == "")
            {
                $queryString = "SELECT * FROM poll_answers $sortString LIMIT :limit , :perPage";
            }

            $query = $DB_con->prepare($queryString);
            $query->execute(array(":limit"=>$limit,":perPage"=>$perPage));
            if($fetchQuery["counter"] > 0)
            {
                if($dateRangeQuery == "")
                {
                    ?>
                    <small>Toplam <?=$fetchQuery["counter"]?> tane bulunan sonuçtan <?=$query->rowCount()?> tanesini görüntülüyorsunuz.</small>
                    <?php
                }
                else
                {
                    ?>
                    <small>Toplam <?=$fetchAnswers["counter"]?> tane bulunan sonuçtan, filtrelemenize uygun <?=$fetchQuery["counter"]?> tanesinin <?=$query->rowCount()?> tanesini görüntülüyorsunuz. <strong><a href="#" id="clearFilter">Filtreyi Kaldır</a></strong></small>
                    <?php
                }
            }
            ?>
            <table class="table table-condensed table-striped">
                <thead>
                <tr>
                    <th>IP Adresi</th>
                    <th>Sistem Bilgileri</th>
                    <th class="visible-sm visible-md visible-lg">Tarih</th>
                    <th class="visible-sm visible-md visible-lg"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($fetchQuery["counter"] > 0)
                {
                    while($fetch = $query->fetch(PDO::FETCH_ASSOC))
                    {
                        $systemInfo = systemInfo($fetch['user_agent']);
                        ?>
                        <tr>
                            <td><?=$fetch["ip_address"]?></td>
                            <td>
                                <span><?=$systemInfo['os'] . ' / ' . $systemInfo['browser']?></span>
                                <div class="visible-xs">
                                    <strong>Tarih:</strong> <?=date('d.m.Y H:i:s', strtotime($fetch["date"]))?><br>
                                    <a href="#" class="label label-success showAnswersButton" data-toggle="modal" data-target="#answersModal" data-language="<?=$fetch['language']?>" data-answers="<?=$fetch['answers']?>" <?php if ($fetch['language'] == 'en') { ?> style="background-color: #3579BD" <?php } ?>><?=$fetch['language'] == 'en' ? 'Answers' : 'Cevaplar'?></a>
                                </div>
                            </td>
                            <td class="visible-sm visible-md visible-lg"><?=date('d.m.Y H:i:s', strtotime($fetch["date"]))?></td>
                            <td class="visible-sm visible-md visible-lg"><a href="#" class="label label-success showAnswersButton" data-toggle="modal" data-target="#answersModal" data-language="<?=$fetch['language']?>" data-answers="<?=$fetch['answers']?>" <?php if ($fetch['language'] == 'en') { ?> style="background-color: #3579BD" <?php } ?>><?=$fetch['language'] == 'en' ? 'Answers' : 'Cevaplar'?></a></td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <tr>
                        <td colspan="5">Filtrelemenize uygun sonuç bulunamadı. <strong><a href="#" id="clearFilter">Filtreyi Kaldır</a></strong></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

            <?php
            if($fetchQuery["counter"] > 0)
            {
                ?>
                <ul class="pagination">
                    <?php
                    $showPage = 5;

                    $lowestCenter = ceil($showPage/2);
                    $highestCenter = ($totalPage+1) - $lowestCenter;

                    $pageCenter = $page;
                    if($pageCenter < $lowestCenter) $pageCenter = $lowestCenter;
                    if($pageCenter > $highestCenter) $pageCenter = $highestCenter;

                    $leftPages = round($pageCenter - (($showPage-1) / 2));
                    $rightPages = round((($showPage-1) / 2) + $pageCenter);

                    if($leftPages < 1) $leftPages = 1;
                    if($rightPages > $totalPage) $rightPages = $totalPage;

                    if($page != 1) echo '<li><a class="waves-effect paginateButtonPoll" href="javascript:void(0);" id="1"><i class="material-icons">first_page</i></a></li>';
                    else if($page == 1) echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">first_page</i></a></li>';
                    if($page != 1) echo '<li><a class="waves-effect paginateButtonPoll" href="javascript:void(0);" id="'.($page-1).'"><i class="material-icons">chevron_left</i></a></li>';
                    else if($page == 1) echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">chevron_left</i></a></li>';

                    for($s = $leftPages; $s <= $rightPages; $s++) {
                        if($page == $s) {
                            echo '<li class="active"><a href="javascript:void(0);" class="bg-'.$app['themeColor'].'">'.$s.'</a></li>';
                        } else {
                            echo '<li><a class="waves-effect paginateButtonPoll" href="javascript:void(0);" id="'.$s.'">'.$s.'</a></li>';
                        }
                    }

                    if($page != $totalPage) echo '<li><a class="waves-effect paginateButtonPoll" href="javascript:void(0);" id="'.($page+1).'"><i class="material-icons">chevron_right</i></a></li>';
                    else if($page == $totalPage) echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">chevron_right</i></a></li>';
                    if($page != $totalPage) echo '<li><a class="waves-effect paginateButtonPoll" href="javascript:void(0);" id="'.$totalPage.'"><i class="material-icons">last_page</i></a></li>';
                    else if($page == $totalPage)  echo '<li class="disabled"><a href="javascript:void(0);"><i class="material-icons">last_page</i></a></li>';
                    ?>
                </ul>
                <?php
            }
        }
        else
        {
            ?>
            <div class='alert alert-danger'><strong>Bilgi: </strong>Henüz sisteme kayıtlı cevaplanmış anket bulunamadı.</div>
            <?php
        }
    } else if ($pageRequest == 'send-mail') {
        $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if (!in_array($language, $languages)) {
            die(result(400, 'Teknik bir hata oluştu. Lütfen daha sonra tekrar deneyin.'));
        }
        if(isset($email) && !empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            die(result(400, 'Lütfen geçerli bir e-posta adresi giriniz.'));
        }
        if ($language == 'tr') {
            $message = '<h1>Müşteri Memnuniyeti Formu</h1><p>Firmamızı ve hizmetlerimizi daha iyi bir noktaya taşıyabilmemiz için sizin düşünceleriniz bizim için çok değerli. Sadece 5 dakikanızı ayırarak aşağıdaki anketimize katılmanız, sizlere çok daha kaliteli hizmet verebilmek için bize ışık tutacaktır.<br><br>Anket: '.$app['url'] . 'anket</p>';
            $subject = 'Müşteri Memnuniyeti Formu';
        } else {
            $message = '<h1>Customer Satisfaction Survey</h1><p>Dear our customer, your opinions are very valuable for us to improve our company and services to a better point. We will be glad if you can take just 5 minutes to provide with you a much higher quality service.<br><br>Survey: '.$app['url'] . 'poll</p>';
            $subject = 'Customer Satisfaction Survey';
        }
        if (sendMail($email, $message, $subject, $app)) {
            die(result(200));
        } else {
            die(result(500, 'Teknik bir hata oluştu. Lütfen daha sonra tekrar deneyin.'));
        }
    } else if ($pageRequest == 'export-xls') {
        $language = isset($_GET['language']) && in_array($_GET['language'], $languages) ? $_GET['language'] : 'tr';

        $today = date('dmy');

        $fileName = ($language == 'tr' ? 'anket_cevaplari_' : 'poll_answers_') . $today . '.xls';

        header('Content-Encoding: UTF-8');
        header("Content-Type: application/xls; charset=UTF-8");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "\xEF\xBB\xBF";

        $answers = $DB_con->prepare('SELECT id, date, ip_address, answers FROM poll_answers WHERE language = :language');

        $answers->execute(array(
            'language' => $language
        ));

        $fetchAnswers = $answers->fetchAll(PDO::FETCH_ASSOC);

        $_questions = [];

        foreach ($questions as $question) {
            $_questions[] = $question['question'][$language];
        }

        array_unshift($_questions, 'ID', $language == 'tr' ? 'Tarih' : 'Date', $language == 'tr' ? 'IP Adresi' : 'IP Address');

        if(!empty($fetchAnswers)){
            echo '<table border="1"><tr>';
            foreach ($_questions as $header) {
                echo '<th>'. $header .'</th>';
            }
            echo '</tr>';
            foreach($fetchAnswers as $answer) {
                echo '<tr>';
                foreach($answer as $k => $v) {
                    if ($k === 'answers') {
                        foreach (explode('|||', $answer[$k]) as $key => $parsedAnswer) {
                            if ($questions[$key + 1]['type'] == 'starring') {
                                echo '<td>';
                                foreach (explode(',', $parsedAnswer) as $index => $subOption) {
                                    echo array_keys($questions[$key + 1]['options'][$language])[$index] . ': ' . ($subOption != '' ? ($subOption . ($language == 'tr' ? ' Yıldız' : ' Star')) : '-') . '<br>';
                                }
                                echo '</td>';
                            } else {
                                echo '<td>' . $parsedAnswer . '</td>';
                            }
                        }
                    } else {
                        echo '<td>' . $v . '</td>';
                    }
                }
                echo '</tr>';
            }
            echo '</table>';
        }
    } else if ($pageRequest == 'export-csv') {
        $language = isset($_GET['language']) && in_array($_GET['language'], $languages) ? $_GET['language'] : 'tr';

        $today = date('dmy');

        $fileName = ($language == 'tr' ? 'anket_cevaplari_' : 'poll_answers_') . $today . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='. $fileName);

        echo "\xEF\xBB\xBF";

        $answers = $DB_con->prepare('SELECT id, date, ip_address, answers FROM poll_answers WHERE language = :language');

        $answers->execute(array(
            'language' => $language
        ));

        $fetchAnswers = $answers->fetchAll(PDO::FETCH_ASSOC);

        $_questions = [];

        foreach ($questions as $question) {
            $_questions[] = $question['question'][$language];
        }

        array_unshift($_questions, 'ID', $language == 'tr' ? 'Tarih' : 'Date', $language == 'tr' ? 'IP Adresi' : 'IP Address');

        $output = fopen("php://output", "w");

        fputcsv($output, $_questions);

        foreach($fetchAnswers as $answer) {
            $row = [];
            foreach($answer as $k => $v) {
                if ($k === 'answers') {
                    foreach (explode('|||', $v) as $key => $parsedAnswer) {
                        if ($questions[$key + 1]['type'] == 'starring') {
                            $subOptions = [];
                            foreach (explode(',', $parsedAnswer) as $index => $subOption) {
                                $subOptions[] = array_keys($questions[$key + 1]['options'][$language])[$index] . ': ' . ($subOption != '' ? ($subOption . ($language == 'tr' ? ' Yıldız' : ' Star')) : '-');
                            }
                            $row[] = implode(' , ', $subOptions);
                        } else {
                            $row[] = $parsedAnswer;
                        }
                    }
                } else {
                    $row[] = $v;
                }
            }
            fputcsv($output, $row);
        }

        fclose($output);
    } else if ($pageRequest == 'edit-profile') {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $additionalSQL = '';
        if(!empty($_POST["password"]) && !empty($_POST["passwordVerify"]))
        {
            $newPassword = $_POST['passwordVerify'];
            $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $additionalSQL = ', password = :password';
        }
        $updateUser = $DB_con->prepare('UPDATE users SET name = :name, username = :username ' . $additionalSQL . ' WHERE id = :id');
        if ($updateUser->execute(empty($additionalSQL) ? array(':name' => $name, ':username' => $username, ':id' => loginCheck($DB_con)) : array(':name' => $name, ':username' => $username, ':password' => $newHashedPassword, ':id' => loginCheck($DB_con)))) {
            die(json_encode([
                'success' => true,
                'message' => 'Success',
                'code' => 200,
                'isPasswordChanged' => !empty($additionalSQL)
            ]));
        } else {
            die(result(500, 'Teknik bir hata oluştu. Lütfen daha sonra tekrar deneyin.'));
        }
    }
} else {
    die(result(404, 'Security'));
}
