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
            <form action="register/insert_data" method="post">
                <h1>Register</h1>
                <div>
                    <label>
                        Username
                        <br>
                        <input type="text" Name="username" placeholder="Max 16 characters." maxlength="16" required>
                    </label>
                </div>
                <!-- <div>
                    <label>
                        Last Name
                        <br>
                        <input type="text" Name="l_name" placeholder="Doe" maxlength="16" required>
                    </label>
                </div> -->
                <div>
                    <label>
                        Password
                        <br>
                        <input type="password" Name="password" required maxlength="18" placeholder="Max 18 characters.">
                    </label>
                </div>
                <div>
                    <label>
                        Confirm Password
                        <br>
                        <input type="password" Name="confirm_password" required maxlength="18" placeholder="Rewrite your password.">
                    </label>
                </div>
                <div>
                    <input class="colored_button" type="submit" value="Confirm">
                </div>
                <div>
                    <a href="login">Trying to log in instead?</a>
                </div>
            </form>
        </div>
    </body>
</html>