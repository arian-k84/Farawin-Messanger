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
                <div id="pnumber_box">
                    <label>
                        Phone Number
                        <br>
                        <input type="tel" Name="number" placeholder="Enter your phone number." required>
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div id="password_box">
                    <label>
                        Password
                        <br>
                        <input type="password" Name="password" required maxlength="20" placeholder="Max 20 characters.">
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div>
                    <input class="colored_button" type="submit" value="Confirm">
                </div>
                <div>
                    <a href="<?= URL ?>/register">Trying to register instead?</a>
                </div>
            </form>
        </div>
        <script src="public/js/jquery-3.4.1.min.js"></script>
        <script>
            $("input[type='submit']").on('click',function (){
                $(".error_text").each(function() {
                    if(!$(this).hasClass("hidden_text")){
                        $(this).addClass("hidden_text")
                    }
                })
                let num = $("input[name='number']").val()
                let pass = $("input[name='password']").val()
                $.ajax({
                    url: "login/check_data",
                    type: "POST",
                    data: {
                        "number": num,
                        "password": pass,
                    },
                    success: function (response){
                        response = JSON.parse(response);
                        console.log(response)
                        switch(response.code){
                            case 0:
                                $("#password_box .error_text").text("*Wrong number or password.")
                                $("#password_box .error_text").removeClass("hidden_text")
                                break
                            case 1:
                                window.location.assign("<?= URL ?>");
                                break
                        };
                    },
                    error: function (response) {
                        alert("Server-side error.");
                    }
                });
            })
        </script>
    </body>
</html>