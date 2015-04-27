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
<html lang="he">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>הזמנת פונטים</title>

    <!-- Bootstrap -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="http://www.fontbit.co.il/css/new.css" type="text/css" media="screen" />

    <style>

        @font-face {
            font-family: 'SpacerRegular';
            src: url('fonts/fbspacersp-regular-webfont.eot');
            src: url('fonts/fbspacersp-regular-webfont.eot?#iefix') format('embedded-opentype'),
            url('fonts/fbspacersp-regular-webfont.woff') format('woff'),
            url('fonts/fbspacersp-regular-webfont.ttf') format('truetype'),
            url('fonts/fbspacersp-regular-webfont.svg#SpacerRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'TypoRegular';
            src: url('fonts/fbtipografsp-regular-webfont.eot');
            src: url('fonts/fbtipografsp-regular-webfont.eot?#iefix') format('embedded-opentype'),
            url('fonts/fbtipografsp-regular-webfont.woff') format('woff'),
            url('fonts/fbtipografsp-regular-webfont.ttf') format('truetype'),
            url('fonts/fbtipografsp-regular-webfont.svg#SpacerRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'EzmelLight';
            src: url('fonts/ezmellightwebfont.eot');
            src: url('fonts/ezmellightwebfont.eot?#iefix') format('embedded-opentype'),
            url('fonts/ezmellightwebfont.woff') format('woff'),
            url('fonts/ezmellightwebfont.ttf') format('truetype'),
            url('fonts/ezmellightwebfont.svg#EzmelLight') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        label {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .form-inline .form-control {
            display: inline-block;
            width: auto;
            vertical-align: middle;
        }
        .form-control, #theForm input[type=text],  #theForm textarea, #theForm input[type=email] {
            display: block;
            width: 100%;
            height: 20px;
            padding: 6px 12px;
            font-size: 14px;

            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }

        body{
            font-family:'TypoRegular', Arial;
            font-size:16px;
            line-height: 1.42857143;
        }
        .group_row{
            display: table-row;
        }
        .group_row div{
            display: table-cell;

        }
        body {
            direction: rtl;
        }
        .cont{
            margin: 0 auto;
            text-align:center;
            max-width:1000px;
        }
        .stage input{
            margin:0 5px!important;
        }
        .row{
            direction:rtl;
            tect-align:right;
        }
        .stage {
            text-align:right;

        }
        td{
            padding:5px;
        }
        .stage  textarea,.stage input[type=text].stage input[type=password]{
            width:100%;
            margin:0 5px!important;
        }
        label{

            font-weight:normal;
        }
        .grp_div label{
            font-weight:700;
        }

        #header{

            font-family:'EzmelLight', Arial;
        }
        #theForm{
            width:100%;
        }
        table{
            width:100%;
        }

</style>

</head>
<body>

<!--fontbit header-->
<div id="header">
    <div class="logo">
        <a href="http://www.fontbit.co.il/"><img src="http://www.fontbit.co.il/images/logoN.png" height="32" alt="Fontbit" /></a></div>
    <div class="cont">
        <ul style="z-index:200;position:relative;">
            <li class="search" style="position:relative;top:-1px;">
                <form name="qsearch" id="qsearch" method="get" action="search.asp">
                    <input type="text" name="query" id="tags" />
                    <input type="image" name="submit" src="http://www.fontbit.co.il/images/search.png" />
                </form>
            </li>
            <li  id="ourFonts" ><a href="javascript:ourFonts()">הפונטים שלנו</a></li>

            <li><a href="http://www.fontbit.co.il/default.asp#about">על פונטביט</a></li>

            <li ><a href="http://www.fontbit.co.il/page.asp?id=9911">מחירון</a></li>
            <li ><a href="http://www.fontbit.co.il/page.asp?id=9910">מבצעים</a></li>

            <li ><a href="http://www.fontbit.co.il/page.asp?id=7">הורדות</a></li>



            <li ><a href="http://www.fontbit.co.il/forum.asp">פורום</a></li>
            <li><a href="http://fbimages.co.il/" target="_blank">פונטביט אימגז'</a></li>
            <li ><a href="http://www.fontbit.co.il/page.asp?id=8">יצירת קשר</a></li>


        </ul>


        <div style="clear:Both;"></div>

    </div>
</div>

<!--fontbit header-->


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
        <form id="theForm">
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
                observer.event("login_failed").publish();
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

    function updateTokenEl() {
        $("#token").val(token.val);
    }

    function onLogin() {
        updateTokenEl();
        getCredits();
        hideLoginForm();
        showCredits();
        hideRegisterFormFields();
    }

    function onLoginFail() {
        alert("שם משתמש או סיסמה שגויים");
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
        observer.event("login_failed").subscribe(function() {
            onLoginFail();
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

        $("#doLogin").click(function() {
            login();
        });

        $("#refreshCredits").click(function() {
            getCredits();
        });
    })
</script>

<script>
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
            doSubmit();
            return false;
        });


    });


</script>
</div></div>
</body>
</html>