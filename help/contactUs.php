<!DOCTYPE html>
<html>
    <head>
        <title>Contact Us</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .dropDownBtn {
                background-color: purple;
                color: white;
                padding: 16px;
                font-size: 16px;
                border: none;
            }
            
            .dropdown {
                position: relative;
                display: inline-block;
            }
            
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #ffa639;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }
            
            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }
            
            .dropdown-content a:hover {background-color: #9bff74;}
            
            .dropdown:hover .dropdown-content {display: block;}
            
            .dropdown:hover .dropbtn {background-color: yellow;}
      </style>
    </head>
    <body>
        <h1>Live</h1>
        <h2>Customer Service</h2>
        
        <div class="dropdown">
            <button class="dropDownBtn">Choose a topic</button>
            <div class="dropdown-content">
                <a href="../help/contactForm.php">Account Information and Settings</a>
                <a href="../help/contactForm.php">Technical Support</a>
                <a href="../help/contactForm.php">Report a bug</a>
                <a href="../help/howToUseOurSite.php">Learn How To Use Our Site</a>
            </div>
        </div>

    </body>

