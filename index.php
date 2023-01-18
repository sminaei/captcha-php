<?php
session_start();
require_once 'captcha.php';
$captcha = new Captcha();
$captcha->generateCaptcha(6,'both');
