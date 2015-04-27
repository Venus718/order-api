<?php
/**
 * afterlead.php
 * User: sami
 * Date: 26-Mar-15
 * Time: 9:28 PM
 */
require __DIR__ . '/header.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
$visited = $session->get('visited_terms', 'no');

if('yes' !== $visited) {
    $response = new RedirectResponse('terms.php');
    $response->send();
}

/** @var \controller\LeadController $leadController */
$leadController = $container->get('controller.lead');
$theLead = $leadController->getLeadAction($leadController->getLastLeadId());
//dump($theLead);
?>
<?php
include 'header_html.php';
include 'fontbit_head.php';
?>
<Br /><Br />

<div class="cont">
    <div class="stage">
        <h2>טופס הזמנת פונטים</h2>

        תודה על הזמנתך<BR />
        פרטי ההזמנה:<BR />
        <table>
            <tr>
                <th width="150">מספר הזמנה:</th>
                <td><?php echo $theSale['leadCode'];?></td>
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