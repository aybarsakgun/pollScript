<?php
define('AJAX', TRUE);

require_once 'admin/class.user.php';

sessionStart($app);

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

$postedValues = $_POST;

$answers = [];

foreach ($postedValues as $key => $value) {
    $questionNumber = explode('_', $key)[1];

    if (!isset($questionNumber) || !($questionNumber > 0 && $questionNumber < 20)) {
        die(result(400, 'Security1'));
    }

    if ($questions[$questionNumber]['type'] !== 'textarea') {
        if (!is_array($value)) {
            if (!in_array($value, $questions[$questionNumber]['options'][$_GET['language']])) {
                die(result(400, 'Security2'));
            }
        } else {
            foreach ($value as $val) {
                if ($questions[$questionNumber]['type'] !== 'starring') {
                    if (!in_array($val, $questions[$questionNumber]['options'][$_GET['language']])) {
                        die(result(400, 'Security3'));
                    }
                } else {
                    foreach ($questions[$questionNumber]['options'][$_GET['language']] as $key => $option) {
                        if ($val && !in_array($val, $option)) {
                            die(result(400, 'Security4 ' . $val . ' ' . implode(',', $option)));
                        }
                    }
                }

            }
        }
    } else {
        $postedValues[$key] = cleanData($value);
    }
}

foreach(range(1, 19) as $questionNumber) {
    $answers['question_' . $questionNumber] = isset($postedValues['question_' . $questionNumber]) ? (is_array($postedValues['question_' . $questionNumber]) ? implode(',', $postedValues['question_' . $questionNumber]) : $postedValues['question_' . $questionNumber]) : '';
}

try {
    $saveAnswer = $DB_con->prepare('INSERT INTO poll_answers
            (ip_address, user_agent, answers, date, language) VALUES 
            (:ip_address, :user_agent, :answers, :date, :language)');
    $saveAnswer->execute(array(
        ':ip_address' => $_SERVER['REMOTE_ADDR'],
        ':user_agent' => $_SERVER['HTTP_USER_AGENT'],
        ':answers' => implode('|||', $answers),
        ':date' => date("Y-m-d H:i:s"),
        ':language' => $_GET['language']
    ));
}
catch(PDOException $ex) {
    die(result(400, 'Database Error: ' . $ex->getMessage()));
}

// print_r($answers);

die(result(200));