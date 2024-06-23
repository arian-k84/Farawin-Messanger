<html>
    <head>
        <title>Register</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="app\views\register\css\style.css">
    </head>
    <body>
        <div id="register_box">
            <div id="information_box">
                <div>
                    <h2>Lorem Ipsum</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A accusamus mollitia, vero minima quam ratione obcaecati ipsam pariatur et placeat unde qui, veritatis corporis vitae sapiente. Eius facilis id delectus, odio aperiam ducimus ab cupiditate vero voluptate quam officiis nisi harum expedita. Amet consequatur laboriosam veritatis voluptas. Id porro quidem ipsum quo magnam odio voluptatum molestias dolore, nisi inventore saepe.</p>
                </div>
            </div>
            <!-- <form action="register/insert_data" method="post"> -->
            <form onsubmit="return false;" autocomplete="off">
                <h1>Register</h1>
                <div id="pnumber-box">
                    <label>
                        Phone Number
                        <br>
                        <input type="tel" Name="number" placeholder="Your phone number" required>
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <!-- <div>
                    <label>
                        Last Name
                        <br>
                        <input type="text" Name="l_name" placeholder="Doe" maxlength="16" required>
                    </label>
                </div> -->
                <div id="password-box">
                    <label>
                        Password
                        <br>
                        <div>
                            <input type="password" Name="password" required maxlength="20" placeholder="Password">
                            <div id="conditions-box" class="hidden">
                                <!-- <div class="error_text hidden_text">*</div> -->
                                <p>*Must contain a digit.</p>
                                <p>*Must contain a lower-case letter.</p>
                                <p>*Must contain an upper-case letter.</p>
                                <p>*Must be at least 6 and at most 20 characters.</p>
                            </div>
                        </div>
                    </label>
                </div>
                <div id="cpassword-box">
                    <label>
                        Confirm Password
                        <br>
                        <input type="password" Name="confirm_password" required maxlength="20" placeholder="Repeat your Password">
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div>
                    <input class="colored_button" type="submit" value="Confirm">
                </div>
                <div>
                    <a id="redirect-link" href="<?= URL ?>/login">Trying to log in instead?</a>
                </div>
            </form>
        </div>
        <script src="public/js/jquery-3.4.1.min.js"></script>
        <script src="app/views/register/index.js"></script>
    </body>
</html>