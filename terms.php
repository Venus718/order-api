<?php
/**
 * terms.php
 * User: sami
 * Date: 27-Apr-15
 * Time: 9:50 AM
 */
require __DIR__ . '/header.php';

use Symfony\Component\HttpFoundation\Session\Session;

$session = new Session();
$session->start();

// set and get session attributes
$session->set('visited_terms', 'yes');

?>

<?php
include 'header_html.php';
include 'fontbit_head.php';
?>

<Br /><Br />

<div class="cont">
    <div class="stage">
        <h2>טופס הזמנת פונטים</h2>
        <IFRAME src="http://fontbit.co.il/licence.asp" width="100%" height="320" frameborder="0" scrolling="yes" style="overflow-x: false;" name="licence"></IFRAME>

            <div style="margin:10px auto;text-align:center;">
                <button onclick="location='orderform.php'">אשר</button> &nbsp;&nbsp;
                <button onclick="location='http://fontbit.co.il'">לא מאשר</button>
            </div>
        </div></div>
</body>
</html>