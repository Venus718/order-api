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
                <form name="qsearch" id="qsearch" method="get" action="http://www.fontbit.co.il/search.asp">
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
        <IFRAME src="http://fontbit.co.il/licence.asp" width="100%" height="320" frameborder="0" scrolling="yes" style="overflow-x: false;" name="licence"></IFRAME>

            <div style="margin:10px auto;text-align:center;">
                <button onclick="location='orderform.php'">אשר</button> &nbsp;&nbsp;
                <button onclick="location='http://fontbit.co.il'">לא מאשר</button>
            </div>
        </div></div>
</body>
</html>