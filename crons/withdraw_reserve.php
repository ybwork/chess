<?php
    $url = 'http://chess/apartment/auto-withdraw-reserve';

    $command = 'curl '. $url;
    
    $result = exec($command);