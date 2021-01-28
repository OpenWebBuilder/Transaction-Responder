function logResponse($mailResult){
    $log = get_home_path() . 'log/hook_log.txt';
    $message = $mailResult;

    if (file_exists( $log)) {
        $file = fopen( $log, 'a');
        fwrite($file, $message ."\n");
    } else {
        $file = fopen( $log, 'w');
        fwrite( $file, $message ."\n");
    }
    fclose($file);
}
