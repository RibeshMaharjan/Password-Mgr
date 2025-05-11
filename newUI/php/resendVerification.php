<?php


require_once './../helpers/session_helper.php';
require_once __DIR__.'/../php/dbh.php';
require_once __DIR__.'/../lib/sendMail.php';

$verificationCode = mt_rand(100000,999999);

$stmt = $dbh->prepare('UPDATE users SET
                                verification_code = ?,
                                verification_req_date = CURRENT_TIMESTAMP
                                WHERE user_id = ?;
                        ');

$stmt->execute(array($verificationCode, $_SESSION['userid']));

sendVerificationMail($_SESSION['email'], $verificationCode);
