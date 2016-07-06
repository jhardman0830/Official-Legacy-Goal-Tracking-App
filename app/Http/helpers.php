<?php

function display( $variable )
{
    echo '<pre>';
    print_r($variable);
    echo '</pre>';
}

function show( $variable ) {
    display( $variable );
    exit;
}