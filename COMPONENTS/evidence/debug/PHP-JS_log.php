<?php
#funkce která funguje hlavně jako debug output (stejná funkce jak JS console.log)
function console_log($input){
    $output = json_encode($input);
    if (is_array($output)){
        $output = implode(',', $output);
    }
    echo "<script>console.log('".$output."');</script>";
}
?>