<?php
  function debugLog($label, $data)
    {
        $logfile = __DIR__ . '/debug_log.txt';
        $timestamp = date("Y-m-d H:i:s");
        $output = "[$timestamp] [$label] " . print_r($data, true) . "\n";
        file_put_contents($logfile, $output, FILE_APPEND);
    }
?>