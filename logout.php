<?php

require_once './config.php';

session_destroy();                //ينتهي من السيشن
header("location: ./index.php");
