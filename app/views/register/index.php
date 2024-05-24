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
            <form onsubmit="return false;" autocomplete="on">
                <h1>Register</h1>
                <div id="pnumber_box">
                    <label>
                        Phone Number
                        <br>
                        <input type="tel" Name="number" placeholder="Enter your phone number." required>
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
                <div id="password_box">
                    <label>
                        Password
                        <br>
                        <input type="password" Name="password" required maxlength="20" placeholder="Max 20 characters.">
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div id="cpassword_box">
                    <label>
                        Confirm Password
                        <br>
                        <input type="password" Name="confirm_password" required maxlength="20" placeholder="Max 20 characters.">
                        <div class="error_text hidden_text">*</div>
                    </label>
                </div>
                <div>
                    <input class="colored_button" type="submit" value="Confirm">
                </div>
                <div>
                    <a href="<?= URL ?>/login">Trying to log in instead?</a>
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
                let num_check = false
                let pass_check = false
                let num = $("input[name='number']").val().trim()
                let pass = $("input[name='password']").val()
                let cpass = $("input[name='confirm_password']").val()
                // if(num){
                //     let err_msg = $("#pnumber_box .error_text")
                //     if(num.match(/^[a-zA-Z0-9_]+$/)){
                //         if(num.match(/^[a-zA-Z]+/)){
                //             user_check = true
                //         }else{
                //             // $("#pnumber_box .error_text").text("*Must not contain: " + name.replace(/[a-zA-Z0-9_]+$/, "").split('').join(',').replace(/\s+/, "whitespace").replace(/\s+/g, "") + ".")
                //             err_msg.text("*Must include a letter.")
                //             err_msg.removeClass("hidden_text")
                //         }

                //     }else{
                //         // $("#pnumber_box .error_text").text("*Must not contain: " + name.replace(/[a-zA-Z0-9_]+$/, "").split('').join(',').replace(/\s+/, "whitespace").replace(/\s+/g, "") + ".")
                //         $("#pnumber_box .error_text").text("*Special Characters/Whitespace not allowed.")
                //         $("#pnumber_box .error_text").removeClass("hidden_text")
                //     }
                // }
                if(num){
                    let err_msg = $("#pnumber_box .error_text")
                    if(num[0] == "0"){
                        num = num.slice(1, num.length)
                        $("input[name='number']").val(num)
                    }
                    if(num.match(/^[6789][0-9]{9}$/)){
                        num_check = true
                    }else{
                        $("#pnumber_box .error_text").text("*Please enter a valid phone number.")
                        $("#pnumber_box .error_text").removeClass("hidden_text")
                    }
                }
                if(pass){
                    let err_msg = $("#password_box .error_text")
                    if(pass.match(/^(?=.*\d)/)){
                        if(pass.match(/[a-z]/)){
                            if(pass.match(/.[A-Z]/)){
                                if(pass.match(/.{6,20}/)){
                                    pass_check = true
                                }else{
                                    err_msg.text("*Must have a minimum of 6 letters.")
                                    err_msg.removeClass("hidden_text")
                                }
                            }else{
                                err_msg.text("*Must have an uppercase letter.")
                                err_msg.removeClass("hidden_text")
                            }
                        }else{
                            err_msg.text("*Must contain a lowercase letter.")
                            err_msg.removeClass("hidden_text")
                        }
                    }else{
                        err_msg.text("*Must contain a digit.")
                        err_msg.removeClass("hidden_text")
                    }
                }
                if(pass == cpass){
                    if(num_check && pass_check){
                        $.ajax({
                            url: "register/insert_data",
                            type: "POST",
                            data: {
                                "pnumber": num,
                                "password": pass,
                            },
                            success: function (response){
                                response = JSON.parse(response);
                                for(let res in response){
                                // Object.values(response).forEach(v => {
                                    if(res == "code"){
                                        switch(response[res]){
                                            case 0:
                                                window.location.assign("<?= URL ?>/login");
                                                break
                                            case 1:
                                                $("#pnumber_box .error_text").text = "*Special Characters/Whitespace not allowed."
                                                $("#pnumber_box .error_text").removeClass("hidden_text")
                                                break
                                            case 2:
                                                $("#pnumber_box .error_text").text = "*Phone number already used."
                                                $("#pnumber_box .error_text").removeClass("hidden_text")
                                                break
                                        }
                                    }
                                };
                            },
                            error: function (response) {
                                alert("Server-side error.");
                            }
                        });
                    }
                }else{
                    $("#cpassword_box .error_text").text("*Must be the same as your password.")
                    $("#cpassword_box .error_text").removeClass("hidden_text")
                }
            })
        </script>
    </body>
</html>