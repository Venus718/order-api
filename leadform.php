<?php
/**
 * leadform.php
 * User: sami
 * Date: 24-Mar-15
 * Time: 3:42 PM
 */
?>
<!doctype html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <title>leadform</title>
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
    <form id="theForm">
        <table>
            <tr>
                <td valign="top">
                    <table>
                        <tr>
                            <td>username</td>
                            <td><input name="username"/> </td>
                        </tr>
                        <tr>
                            <td>password</td>
                            <td><input name="password" type="password"/> </td>
                        </tr>
                    </table>
                </td>
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
                    <div id="fonts_container"></div>
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

    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script>
        var api_url = 'http://81.218.173.203/order/api.php';
        var api_url = 'api.php';

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
                    console.log(catalog);
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
            })

            $("#send").click(function() {
                doSubmit();
                return false;
            })
        })
    </script>
</body>
</html>