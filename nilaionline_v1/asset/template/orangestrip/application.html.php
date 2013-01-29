<?php
Session::init();
Src::css('layout');
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<data>
    <css><![CDATA[<?php echo Src::getCss(); ?>]]></css>
    <content>
        <![CDATA[<div id="online-score">{PAGE_CONTENT}</div>]]>
    </content>
</data>
