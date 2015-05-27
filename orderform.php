<?php
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

?>
<!DOCTYPE html>


<?php
include 'header_html.php';
include 'fontbit_head.php';
?>
<Br /><Br />

<div class="cont">
    <div class="stage">
        <h2>טופס הזמנת פונטים</h2>
<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-12">
        <p>
            תהליך ההזמנה:<BR />
            א. במידה וקיבלת שם משתמש וסיסמה מפונטביט, אנא השתמש בהם לביצוע ההזמנה,
        אחרת מלא את פרטיך<BR />
            ב. סמן את המשקלים שברצונך להזמין.
            לבחירת כל המשקלים של הפונט, לחץ על תיבת הסימון בתחילת השורה
            <BR />
        </p>
        <form class="form-inline" id="loginForm">

            <table>

        <tr>
                <Td width="152">        <label for="username">שם משתמש</label></Td>
                <Td>    <input type="text" class="form-control" id="username" placeholder="שם משתמש"></Td>
        </tr>
        <tr>
                <td><label for="password">סיסמה</label></td>
                <Td><input type="password" class="form-control" id="password" placeholder="סיסמה"></td>
        </tr>
        <Tr>
            <td colspan="2" align="left">
                <input class="btn btn-success" type="button" value="כניסה" id="doLogin">
            </td></tr>
        </table>

        </form>

        <div id="credits" style="display: none;">
           ברשותך <span id="creditsVal">0</span> קרדיטים
            <span id="refreshCredits" class="glyphicon glyphicon-refresh" aria-hidden="true"><img src="images/reload.png" /></span>
        </div>
    </div>


</div>

        <hr />
<div class="row">
    <div class="col-md-12">
        <form id="theForm" name="formi">
            <input type="hidden" name="token" id="token"/>
            <table>
                <tr id="register_form">
                    <td valign="top">
                        <table>
                            <tr>
                                <td width="152">שם מלא *</td>
                                <td><input type="text" name="name" value=""/></td>
                            </tr>
                            <tr>
                                <td>שם חברה/עסק</td>
                                <td><input type="text" name="company_name_he" value=""/></td>
                            </tr>
                            <tr>
                                <td>שם חברה/עסק באנגלית</td>
                                <td><input type="text" name="company_name_en" value=""/></td>
                            </tr>
                            <tr>
                                <td>טלפון *</td>
                                <td><input type="text" name="phone" value=""/></td>
                            </tr>
                            <tr>
                                <td>שלוחה</td>
                                <td><input type="text" name="ext" value=""/></td>
                            </tr>
                            <tr>
                                <td>טלפון נייד</td>
                                <td><input type="text" name="mobile" value=""/></td>
                            </tr>
                            <tr>
                                <td>פקס</td>
                                <td><input type="text" name="fax" value=""/></td>
                            </tr>
                            <tr>
                                <td>כתובת מייל</td>
                                <td><input type="text" name="mail" value=""/></td>
                            </tr>
                            <tr>
                                <td>כתובת מלאה *</td>
                                <td><input type="text" name="address" value=""/></td>
                            </tr>
                            <tr>
                                <td>הערות</td>
                                <td><textarea name="remarks"></textarea></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <table>

                            <tr id="mailtoRow" style="display: none;">
                                <td width="152">אנא שלחו החבילה למייל: </td>
                                <td><input type="email" name="mailTo" /></td>
                            </tr>

                        </table>
                        <div style="display:none">
                        <table>

                                <tr>
                                    <td>otf</td>
                                    <td><input name="otf" value="1" type="checkbox"/></td>
                                </tr>
                                <tr>
                                    <td>pc</td>
                                    <td><input name="pc" value="1" type="checkbox"/></td>
                                </tr>
                                <tr>
                                    <td>mac</td>
                                    <td><input name="mac" value="1" type="checkbox"/></td>
                                </tr>

                        </table>
                        </div>
                        <hr />
                        <div id="fonts_count">בחרת <span class="fontsCount">0</span> פונטים </div>
                        <div id="fonts_container"></div>
                        <div id="fonts_count2">בחרת <span class="fontsCount">0</span> פונטים </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div>
                            <button id="send" value="cake">שליחת הזמנה</button>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/observer.js"></script>
<script>
    var api_url = "api.php";
    var token = {"val": null, "expiry": null};
    var credits = null;
    var observer = new Observer();

    function isLoggedIn() {
        return ((null !== credits) && (null !== token.val));
    }

    function isEmpty(s) {
        s = String(s);
        return !/[^\s]/.test(s);
    }

    function blink($el) {
        for(i=0;i<3;i++) {
            $el.fadeTo('slow', 0.5).fadeTo('slow', 1.0);
        }
    }

    function getOwnedFonts() {
        console.log('in getOwnedFonts');
        $.ajax(api_url + "/contact/fonts", {data: {
            "token": token.val
        }}).then(function(reply) {
            if(reply.success) {
                observer.event("getOwnedFonts_success").publish(reply.data.fonts);
            } else {
                observer.event("getOwnedFonts_failed").publish();
            }
        });
    }

    function doLogin(username, password) {
        $.ajax(api_url + "/token/get", {data: {
            "username": username,
            "password": password
        }}).then(function(reply) {
            if(reply.success) {
                token.val = reply.data.token;
                token.expiry = reply.data.expiry;
                credits = 0;
                observer.event("login_success").publish();
            } else {
                observer.event("login_failed").publish(reply.data.errCode);
            }
        });
    }

    function updateCreditsEl(credits) {
        $("#creditsVal").text(credits);
        blink($("#creditsVal"));
    }

    function getCredits() {
        $.ajax(api_url + "/token/get-credits", {data: {
            "token": token.val
        }}).then(function(reply) {
            if(reply.success) {
                credits = reply.data.credits;
                observer.event("getCredits_success").publish(credits);
            } else {
                observer.event("getCredits_failed").publish();
            }
        })
    }

    function login() {
        var username = $.trim($("#username").val());
        var password = $.trim($("#password").val());

        if(isEmpty(username)) {
            alert("שם משתמש ריק");
            return;
        }
        if(isEmpty(password)) {
            alert("סיסמה ריקה");
            return;
        }
        doLogin(username, password);
    }

    function hideLoginForm() {
        $("#loginForm").hide();
    }

    function showCredits() {
        $("#credits").fadeIn();
    }

    function hideRegisterFormFields() {
        $("#register_form").hide();
        $("#mailtoRow").show();
    }

    function markOwnedFonts(fonts) {
        console.log('in markOwnedFonts', fonts);
        for(var i = 0; i < fonts.length; i++) {
            var el = $("#fnt_chk_" + fonts[i].id).closest("div.fnt_div");
            el.addClass('owned');
        }
    }

    function updateTokenEl() {
        $("#token").val(token.val);
    }

    function onLogin() {
        updateTokenEl();
        getCredits();
        hideLoginForm();
        showCredits();
        hideRegisterFormFields();
        getOwnedFonts();
    }

    function onLoginFail(errCode) {
        errCode = parseInt(errCode, 10);
        var msg = "שם משתמש או סיסמה שגויים";
        switch (errCode) {
            case -1:
                msg = "שם משתמש או סיסמה שגויים";
                break;
            case -2:
                msg = "שם משתמש או סיסמה שגויים";
                break;
            case -3:
                msg = "ארעה תקלה, אנא פנה לשירות לקוחות";
                break;
            case -4:
                msg = "חשבונך עדיין לא הופעל";
                break;
            case -5:
                msg = "חשבונך מוקפא";
                break;
            default:
                break;
        }
        alert(msg);

    }

    function onGetCreditsFailed() {
        credits = 0;
        onCreditsUpdated();
    }

    function warnAboutNotEnoughCredits() {
        if (isLoggedIn() && (getSelectedFontsCount() > Math.max(0, credits))) {
            alert("חרגת מכמות הקרדיטים");
        }
    }
    function onCreditsUpdated() {
        updateCreditsEl(credits);
        warnAboutNotEnoughCredits();
    }

    $(function() {
        observer.event("login_failed").subscribe(function(errCode) {
            onLoginFail(errCode);
        });

        observer.event("login_success").subscribe(function() {
            onLogin();
        });

        observer.event("getCredits_success").subscribe(function() {
            onCreditsUpdated();
        });

        observer.event("getCredits_failed").subscribe(function() {
            onGetCreditsFailed();
        });

        observer.event("selectedCountChanged").subscribe(function(selectedCount) {
            warnAboutNotEnoughCredits();
        });

        observer.event("getOwnedFonts_success").subscribe(function(fonts) {
            markOwnedFonts(fonts);
        });

        $("#doLogin").click(function() {
            login();
        });

        $("#refreshCredits").click(function() {
            getCredits();
        });
    })
</script>

<script>

    function checkedMandatory(){
        if($('#register_form').css('display')!='none') {
        //alert($('#register_form').css('display')=='none');
            if (document.formi.name.value != "" && document.formi.phone.value != "" && document.formi.address.value != "") {
                return true;
            }
            else {
                document.formi.name.focus();
                return false;
            }
        }
        return true;
    }

    function getSelectedFontsCount() {
        return $(".fnt_chk:checked").length;
    }

    function onFontSelection() {
        var selectedCount = getSelectedFontsCount();
        $(".fontsCount").text(selectedCount);
        observer.event("selectedCountChanged").publish(selectedCount);
    }

    function makeRowClick(grpId) {
        return function() {
            var checked = $("#grp_chk_" + grpId).is(":checked");
            $("input", $("#group_" + grpId)).each(function() {
                $(this).prop('checked', checked);
            });
        };
    }

    function buildCatalog() {
        $.ajax(
            api_url + '/catalog-fonts'
        ).then(function(catalog) {
                var container = $("#fonts_container");
                for(group in catalog) {
                    var row = $("<div id='group_"+group+"' class='group_row'></div>");
                    var grp_div = $("<div class='grp_div'></div>");
                    var grp_chk = $("<input type='checkbox' id='grp_chk_"+group+"' class='grp_chk'/>");
                    grp_chk.click(makeRowClick(group));
                    grp_div.append(grp_chk);
                    grp_div.append($("<label for='grp_chk_"+group+"'>"+catalog[group]["name"]+"</label>"));
                    row.append(grp_div);

                    for(var i = 0; i < catalog[group]["fonts"].length; i++) {
                        var f = catalog[group]["fonts"][i];
                        var fnt_div = $("<div class='fnt_div'></div>");
                        fnt_div.append($("<input type='checkbox' id='fnt_chk_"+ f.id+"' class='fnt_chk' name='fonts[]' value='"+ f.id+"'/>"));
                        fnt_div.append($("<label for='fnt_chk_"+ f.id+"'>"+ f.weight+"</label>"));
                        row.append(fnt_div);


                    }
                    container.append(row);
                }
            }).then(function() {
                $("input[type='checkbox']","#fonts_container").each(function() {
                    var $this = $(this);
                    $this.click(function() {
                        onFontSelection();
                    })
                });
            });
    }


    $(function() {

        buildCatalog();

        function doSubmit() {

            var action = "/lead/create";
            var redirectTo = "afterlead.php";
            if(isLoggedIn()) {
                action = "/sale/create";
                redirectTo = "aftersale.php";
            }
            var j = $.ajax(
                api_url + action,
                {
                    'data': $("#theForm").serialize(),
                    'method': 'POST',
                    'success': function(reply) {
                        if(!reply.success) {
                            alert(reply.err);
                            getCredits();
                        } else {
                            document.location = redirectTo;
                        }

                    }
                }
            );
            return j.promise();
        }

        $("#theForm").submit(function(e) {
            doSubmit();
            e.preventDefault();
            return false;
        });

        $("#send").click(function() {
            if (checkedMandatory()) {
                doSubmit();
                return false;
            }
            else{
                alert('אנא מלאו את שדות החובה');
                return false;
            }
        });


    });


</script>
</div></div>
</body>
</html>