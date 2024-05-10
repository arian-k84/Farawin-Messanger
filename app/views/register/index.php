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
            <form action="register.php" method="post">
                <h1>Register</h1>
                <div>
                    <label>
                        First Name
                        <br>
                        <input type="text" Name="f_name" placeholder="John" required>
                    </label>
                </div>
                <div>
                    <label>
                        Last Name
                        <br>
                        <input type="text" Name="l_name" placeholder="Doe" required>
                    </label>
                </div>
                <div>
                    <label>
                        Password
                        <br>
                        <input type="password" Name="user_pass" required maxlength="18" placeholder="Max 18 characters.">
                    </label>
                </div>
                <div>
                    <label>
                        Confirm Password
                        <br>
                        <input type="password" Name="confirm_pass" required maxlength="18" placeholder="Rewrite your password.">
                    </label>
                </div>
                <div>
                    <input class="colored_button" type="submit" placeholder="Register">
                </div>
            </form>
        </div>
    </body>
</html>