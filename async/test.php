<?php

$variable = "25/10/2023";

if(preg_match("^\d{2}/\d{2}/\d{4}$/^", $variable))
{
 echo("oui");
} else {
    echo("non");
}

?>