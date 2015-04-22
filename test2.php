<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>הזמנת פונטים</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <style>
        .group_row{
            display: table-row;
        }
        .group_row div{
            display: table-cell;
        }
        body {
            direction: rtl;
        }
    </style>


</head>
<body>

    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <form class="form-inline" id="loginForm">
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" class="form-control" id="username" placeholder="username">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" class="form-control" id="password" placeholder="password">
                </div>
                <input class="btn btn-success" type="button" value="login" id="doLogin">
            </form>

            <div id="credits" style="display: none;">
                <span id="creditsVal">0</span> קרדיטים
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <form id="theForm">
                <input type="hidden" name="token" id="token"/>
                <table>
                    <tr id="register_form">
                        <td valign="top">
                            <table>
                                <tr>
                                    <td>name</td>
                                    <td><input name="name" value="name"/></td>
                                </tr>
                                <tr>
                                    <td>company_name_he</td>
                                    <td><input name="company_name_he" value="company_name_he"/></td>
                                </tr>
                                <tr>
                                    <td>company_name_en</td>
                                    <td><input name="company_name_en" value="company_name_en"/></td>
                                </tr>
                                <tr>
                                    <td>phone</td>
                                    <td><input name="phone" value="phone"/></td>
                                </tr>
                                <tr>
                                    <td>ext</td>
                                    <td><input name="ext" value="ext"/></td>
                                </tr>
                                <tr>
                                    <td>mobile</td>
                                    <td><input name="mobile" value="mobile"/></td>
                                </tr>
                                <tr>
                                    <td>fax</td>
                                    <td><input name="fax" value="fax"/></td>
                                </tr>
                                <tr>
                                    <td>mail</td>
                                    <td><input name="mail" value="mail"/></td>
                                </tr>
                                <tr>
                                    <td>address</td>
                                    <td><input name="address" value="address"/></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <table>
                                <tr>
                                    <td>remarks</td>
                                    <td><textarea name="remarks"></textarea></td>
                                </tr>
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
                            <div id="fonts_count">בחרת <span class="fontsCount">0</span> פונטים </div>
                            <div id="fonts_container"></div>
                            <div id="fonts_count2">בחרת <span class="fontsCount">0</span> פונטים </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div>
                                <button id="send" value="cake">cakes</button>
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
            if (isLoggedIn() && (getSelectedFontsCount() > credits)) {
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
                var j = $.ajax(
                    api_url + '/lead/create',
                    {
                        'data': $("#theForm").serialize(),
                        'method': 'POST',
                        'success': function(reply) {
                            if(!reply.success) {
                                alert(reply.err);
                            } else {
                                alert(reply.data.leadId)
                                document.location = 'afterlead.php';
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
</body>
</html>