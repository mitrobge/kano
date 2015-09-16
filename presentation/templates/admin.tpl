{load_presentation_object filename="admin" assign="obj"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>KANO MODEL Administration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="assets/template1/css/theme3.css" />
    <link rel="stylesheet" type="text/css" href="assets/template1/css/style.css" />
    
    <script src="scripts/ckeditor/ckeditor.js" type="text/javascript"></script> 
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    
    <script type="text/javascript" src="assets/js/jquery.tablednd_0_5.js"></script>
    <script src="assets/js/core.js" type="text/javascript"></script>    

    {*
    <script>
       var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
       document.writeln('<link rel="stylesheet" type="text/css" href="styles/admin_template/css/' + StyleFile + '">');
    </script>
    *}
  </head>
  <body>
    <div id="container">
    <div id="header">
        <h2>Kano Model: Σελίδες Διαχείρισης </h2>
        {include file=$obj->mMenuCell}
    </div>
    {*
    <div class="top_right">
      {if count($obj->mLanguages) > 1}
        <div class="lang_text">Languages:</div>
        <form action="" method="post">
            {section name=i loop=$obj->mLanguages}
                <input type="image" src="{$obj->mSiteImages}{$obj->mLanguages[i].language_flag}" 
                    name="languageId" value="{$obj->mLanguages[i].language_id}" width="28" height="17">&nbsp;
            {/section}
        </form>
      {/if} 
    </div>
    *}
    <div id="wrapper">
        <div id="content">
            {include file=$obj->mContentsCell}
        </div>
    </div>
</body>
</html>
