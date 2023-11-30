<?php
/*
 * Mental Space Project - Creative Commons License
 */


foreach ($assets ?? [] as $asset) {
    echo sprintf('<script type="text/javascript" src="%s"></script>', $asset);
}