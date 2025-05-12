<?php

require_once './../helpers/session_helper.php';
require_once __DIR__.'/../php/dbh.php';
require_once __DIR__.'/../lib/sendMail.php';

$verificationCode = mt_rand(100000,999999);

$stmt = $dbh->prepare('UPDATE auth_settings SET
                                verification_code = ?,
                                verification_req_date = CURRENT_TIMESTAMP
                                WHERE user_id = ?;
                        ');

$stmt->execute(array($verificationCode, $_SESSION['userid']));

sendVerificationMail($_SESSION['email'], $verificationCode);

$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

if (!empty($referer)) {

    echo '
        <p><a id="send" href="' . $referer . '" title="Return to the previous page">« Go back</a></p>
    ';

} else {

    echo '<p><a id="send" href="javascript:history.go(-1)" title="Return to the previous page">« Go back</a></p>';

}
?>
<script>
    function clickTheButton() {
        document.querySelector('#send').click();
    }

    clickTheButton();
</script>
