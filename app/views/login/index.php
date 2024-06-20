<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="app\views\login\css\style.css">
    </head>
    <body>
        <div id="login_box">
            <div id="information_box">
                <div>
                    <h2>Lorem Ipsum</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A accusamus mollitia, vero minima quam ratione obcaecati ipsam pariatur et placeat unde qui, veritatis corporis vitae sapiente. Eius facilis id delectus, odio aperiam ducimus ab cupiditate vero voluptate quam officiis nisi harum expedita. Amet consequatur laboriosam veritatis voluptas. Id porro quidem ipsum quo magnam odio voluptatum molestias dolore, nisi inventore saepe.</p>
                </div>
            </div>
            <!-- <form action="login/insert_data" method="post"> -->
            <form onsubmit="return false;" autocomplete="on">
                <h1>Login</h1>
                <div id="pnumber-box">
                    <label>
                        Phone Number
                        <br>
                        <input type="tel" Name="number" placeholder="Your phone number" required>
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div id="password-box">
                    <label>
                        Password
                        <br>
                        <input type="password" Name="password" required maxlength="20" placeholder="Password">
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div>
                    <input class="colored_button" type="submit" value="Confirm">
                </div>
                <div>
                    <a id="redirect-link" href="<?= URL ?>/register">Trying to register instead?</a>
                </div>
            </form>
        </div>
        <script src="public/js/jquery-3.4.1.min.js"></script>
        <script src="app/views/login/index.js"></script>
    </body>
</html>