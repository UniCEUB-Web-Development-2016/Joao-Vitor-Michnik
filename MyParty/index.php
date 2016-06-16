<?php

include "util/RequestRouter.php";
	
	session_start();
    echo json_encode((new RequestRouter)->route());