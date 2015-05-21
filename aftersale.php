<?php
/**
 * aftersale.php
 * User: sami
 * Date: 27-Apr-15
 * Time: 10:19 AM
 */
require __DIR__ . '/header.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
// set and get session attributes
$visited = $session->get('visited_terms', 'no');

if('yes' !== $visited) {
    $response = new RedirectResponse('terms.php');
    $response->send();
}

/** @var \controller\SaleController $saleController */
$saleController = $container->get('controller.sale');
$theSale = $saleController->getSaleAction($saleController->getLastSaleId());

//echo($theSale['fonts'][0]['name']);
//echo('<br/>');

//dump($theSale);

?>
<?php
include 'header_html.php';
include 'fontbit_head.php';
?>
<Br /><Br />

<div class="cont">
    <div class="stage">
        <h2>טופס הזמנת פונטים</h2>

        תודה על הזמנתך, חבילת המשקלים תשלח לכתובת המייל שציינת<BR />
        פרטי ההזמנה:<BR />
        <table>
            <tr>
                <th width="150">מספר הזמנה:</th>
                <td><?php echo $theSale['id'];?></td>
            </tr>
            <tr>
                <th>המשקלים שהוזמנו:</th>
                <td>
                    <?php
                    foreach ($theSale['fonts'] as $font) {
                           echo $font['name'].'<BR />';
                    }
                    ?>
                </td>
            </tr>
        </table>
</div></div>
</body>
</html>