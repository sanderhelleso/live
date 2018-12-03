<?php 
function check(){
    if (isset($_POST['submitBtnForIssues']) && (!empty($_POST['nameForContact'])) && (!empty($_POST['emailForContact']))){
        echo "Thank you for your response. We will try and address this issue as soon as possible..";
    }else {
        echo "A response field was left empty.";
    }
}
?>

<!DOCTYPE html>
<html>
    <head><title>Contact Form</title></head>
    
    <body>
        <h1>Please tell us what issues you are experiencing below.</h1>
        <form method="post">
            Name:
                <input type="text" name="nameForContact" placeholder="Type first and last name.."><br>
            Email:
                <input type="text" name="emailForContact" placeholder="Type email.." size="35"><br>
            Explain your issue:<br>
                <textarea name="issues" cols="50" rows="10" placeholder="Type the issue you are experiencing.."></textarea><br>
                <!--<button type="submit" name=submitBtnForIssues>Submit Request</button>-->
                <input type="submit" name=submitBtnForIssues value="Submit Request">
        </form>
        <?php check() ?>
    </body>
</html>