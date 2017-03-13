<?php
if ($_GET['randomId'] != "aP8etgu5o4ezpc7tzcnRlNT3VrNNEBdRl9ybj_OVbpBeOrn6oBZvziuyLHxhM1oT") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
