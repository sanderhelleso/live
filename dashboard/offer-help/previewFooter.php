<?php

    // get url
    $url = $_SERVER["PHP_SELF"];
    if ($url === '/dashboard/overview/index.php') {
        buildFooter('remove', 'danger', 'Remove Offer');
    }

    else if ($url === '/dashboard/offer-help/index.php') {
        buildFooter('confirm', 'primary', 'Confirm');
    }

    else {
        buildFooter('book', 'primary', 'Get In Touch');
    }


    // build preveiw footer
    function buildFooter($id, $status, $message) {
        echo '<footer class="modal-card-foot">';
        echo '<button class="button hide-modal">Cancel</button>';
        echo '<button id="' . $id . '-offer"'  . 'class="button is-' . $status . ' confirm">' . $message . '</button>';
        echo '</footer>';
    }

?>