let contacts;
let currently_selected;
let current_contacts = []
let current_messages = []
let last_date;
{ // loading functions/refreshing contacts
    // refreshing contacts
    let card;
    function refresh_contacts(num = false){
        $.ajax({
            url: "index/get_contacts",
            type: "POST",

            success: async function (response){
                response = JSON.parse(response);
                contacts = response
                counter = 0
                total = 0
                for(let [val, i] of response.entries()){
                    if(current_contacts.includes(i["contact_pnumber"])){
                        counter++
                    }
                    total++
                }
                if(counter == total){
                    for(let [val, i] of response.entries()){
                        $(".contacts-container .contact-card").each(function (){
                            if($(this).data("contact-id") == i["contact_id"] && i["status"] == 1){
                                $(this).css('filter', 'brightnesss(1)')
                                return
                            }
                        })
                    }
                }else{
                    card = $(".contacts-container>.contact-card:first").clone(true)
                    card.removeClass("hidden")
                    card.removeAttr("style")
                    card.children(".message-wrapper").children().removeAttr("style")
                    $(".main-container>.contact-wrapper>.contacts-container").empty()
                    current_contacts = []
                    for(let [val, i] of response.entries()){
                        current_contacts.push(i["contact_pnumber"])
                        let new_card = card.clone(true)
                        new_card.appendTo(".contacts-container")
                        new_card.data('name', i["name"])
                        new_card.data('contact-id', i["contact_id"])
                        new_card.data('contact-number', i["contact_pnumber"])
                        if(i["contact_pnumber"] == num){
                            new_card.data('selected', true)
                            new_card.css("background-color", "rgb(255, 202, 56)")
                            new_card.children(".message-wrapper").children().css("color", "white")
                            currently_selected = new_card
                        }else{
                            new_card.data('selected', false)
                        }
                        if(i["status"] == 0){
                            new_card.children("img").css({
                                filter: "brightness(0.7)"
                            })
                        }
                        let info = new_card.children(".message-wrapper")
                        let last_message;
                        await load_messages(new_card, true).then(message => {
                            last_message = message
                        })
                        info.children(".contact-name").text(i["name"])

                        if(last_message.length > 0){
                            info.children(".contact-last-message").text(last_message[last_message.length - 1]["message"])
                        }else{
                            info.children(".contact-last-message").text("...").css("font-size", "1.3rem")
                        }
                    };
                }
            },
            error: function (response) {
                alert("Server-side error.");
            }
        });
    }
    function load_messages(contact, receive = false){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "index/load_messages",
                type: "POST",
                data: {
                    "contact-id" : contact.data("contact-id"), 
                },
                success: function (response){
                    response = JSON.parse(response);
                    let message_data = []

                    for(let [i, val] of response.entries()){
                        message_data.push(val)
                    }
                    
                    message_data.sort((a, b) => a.id - b.id);
                    
                    if(!receive){
                        if((current_messages.length == 0 || message_data.length == 0) || message_data.length < current_messages.length){
                            current_messages = []
                            $("#messenger-container #messages-container").children().empty()
                            currently_selected.children(".message-wrapper").children(".contact-last-message").text("...").css("font-size", "1.3rem")
                        }

                        message_data.forEach(function(data){
                            if (current_messages.lastIndexOf(data["message"]) < message_data.indexOf(data)){
                                current_messages.push(data["message"])
                                let date = data["date_sent"].split(' ')[0]
                                let time = data["date_sent"].split(' ')[1].split(":")
                                currently_selected.children(".message-wrapper").children(".contact-last-message").text(data["message"])
                                currently_selected.children(".message-wrapper").children(".contact-last-message").css("font-size", "");
                                if(last_date !== date){
                                    last_date = date
                                    $("<p class='date'></p>").text(date).appendTo($("#messenger-container #messages-container > div"))
                                }
                                if(data["sender_id"] == contact.data("contact-id")){
                                    let p = $("<p class='contact-message'></p>").text(data["message"]).appendTo($("#messenger-container #messages-container > div"));
                                    p.append($('<p>').css({
                                        opacity: 0.9,
                                        fontSize: '0.9rem',
                                        margin: 0,
                                    }).text(time[0] + ":" + time[1]));
                                } else {
                                    let p = $("<p class='user-message'></p>").text(data["message"]).appendTo($("#messenger-container #messages-container > div"));
                                    p.append($('<p>').css({
                                        opacity: 0.9,
                                        fontSize: '0.9rem',
                                        margin: 0,
                                    }).text(time[0] + ":" + time[1]));
                                }
                            }
                        })
                    }else{
                        resolve(message_data)
                    }
                },
                error: function (response) {
                    alert("Server-side error.");
                }
            });
        })
    }
}
{ // contact functions
    { // modals
        // opening the add contact modal
        let main_open = false
        $(".add-contact-btn").on('click',function (){
            let modal = $(".contact-actions-modal")
            $(".error-text").each(function() {
                if(!$(this).hasClass("hidden")){
                    $(this).css('color', 'rgb(230, 15, 15)')
                    $(this).addClass("hidden")
                }
            })
            if(main_open){
                $(".contact-actions-modal>form>div").toggleClass("hidden")
                $( ".add-contact-btn" ).css('transform', 'initial')
                main_open = false
                setTimeout(function() {
                    modal.css("transform", "initial")
                }, 500)
                setTimeout(function() {
                    modal.toggleClass("hidden")
                }, 900);
                
            }else{
                $(".contact-actions-modal>form").get(0).reset()
                modal.toggleClass("hidden")
                main_open = true
                $( ".add-contact-btn" ).css({
                    transform: "rotate(45deg)"
                });
                modal.css({'transform': 'translateY(' + (-parseFloat(modal.css('top'))) + 'px)'})
                setTimeout(function() {
                    $(".contact-actions-modal>form>div").toggleClass("hidden")
                }, 600);
            }
        })
        // log out button
        $(".logout-btn").on('click' ,function (){
            $.ajax({
                url: 'index/logout',
                type: 'get',
                datatype: 'json',
                success: function(response){
                    location.reload()   
                },
                error: function(response){

                }
            })
        })
        // edit mode button
        $("#messenger-container>#messenger-wrapper>#top-bar>#options-btn").on('click',function (){
            let profile = $(".main-wrapper>.profile-popup>#profile-container")
            profile.find("#info-section>div #name").text(currently_selected.data("name"))
            profile.find("#info-section>div #phone-number").text(currently_selected.data("contact-number"))
            $(".main-wrapper>.profile-popup").toggleClass("hidden")
        })
    }
    // actually adding new contacts
    $(".create-contact-btn").on('click',function (){
        let name_inp = $(".add-contact-name input")
        let name = name_inp.val()
        let num_inp = $(".add-contact-number input")
        let num = num_inp.val()
        let name_check = false
        let num_check = false

        $(".error-text").each(function() {
            if(!$(this).hasClass("hidden")){
                $(this).css('color', 'rgb(230, 15, 15)')
                $(this).addClass("hidden")
            }
        })

        if(name){
            let err_msg = $(".add-contact-name .error-text")
            if(name.match(/^.{2,16}$/)){
                name_check = true
                if(!err_msg.hasClass("hidden")){
                    err_msg.addClass("hidden")
                }
            }else{
                err_msg.text("*Name must be between 2 to 16 characters.")
                err_msg.removeClass("hidden")
            }
        }else{
            $(".add-contact-name .error-text").text("*Please provide a name for the contact.")
            $(".add-contact-name .error-text").removeClass("hidden")
        }

        if(num){
            let err_msg = $(".add-contact-number .error-text")
            if(num[0] == "0"){
                num = num.slice(1, num.length)
                num_inp.val(num)
            }
            if(num.match(/^[6789][0-9]{9}$/)){
                num_check = true
                if(!err_msg.hasClass("hidden")){
                    err_msg.addClass("hidden")
                }
            }else{
                err_msg.text("*Please enter a valid phone number.")
                err_msg.removeClass("hidden")
            }
        }else{
            $(".add-contact-number .error-text").text("*Please provide the contact number.")
            $(".add-contact-number .error-text").removeClass("hidden")
        }

        if(name_check && num_check){
            $.ajax({
                url: "index/add_contact",
                type: "POST",
                data: {
                    "name" : name,
                    "number" : num
                },
                success: function (response){
                    response = JSON.parse(response);
                    for(let res in response){
                    // Object.values(response).forEach(v => {
                        if(res == "code"){
                            let err_msg = $(".add-contact-number .error-text")
                            switch(response[res]){
                                case 0:
                                    err_msg.text("*Successfully added.")
                                    err_msg.css('color', 'green')
                                    err_msg.removeClass("hidden")
                                    refresh_contacts()
                                    break
                                case 1:
                                    err_msg.text("*You cannot add yourself as a contact.")
                                    err_msg.removeClass("hidden")
                                    break
                                case 2:
                                    err_msg.text("*No user with the given number found.")
                                    err_msg.removeClass("hidden")
                                    break
                            }
                        }
                    };
                },
                error: function (response) {
                    console.log(response);
                }
            });
        // }else{
        //     $(".add-contact-number .error-text").val("*Please provide both a name and a number.")
        }
    })
    // profile close button
    $(".profile-popup>#profile-container>#top-section>#close-btn").on('click', function(){
        $(".main-wrapper>.profile-popup").addClass("hidden")
    })
    // profile name change
    let name_change = false
    let previous_name;
    $(".profile-popup>#profile-container>#info-section>div #change-name").on('click', function(){
        if(!name_change){
            $(this).text("Confirm?")
            let name = $(".profile-popup>#profile-container>#info-section>div #name")
            name.attr("contentEditable", true);
            name.css({
                "color": "white",
                "background-color": "rgb(46, 46, 46)",
                "border": "0",
                "border-radius": "3px",
            })
            name_change = true
            previous_name = name.text()
        }else{
            $(this).text("Change")
            let name = $(".profile-popup>#profile-container>#info-section>div #name")
            let pnumber = $(".profile-popup>#profile-container>#info-section>div #phone-number").text()
            name.attr("contentEditable", false);
            name.removeAttr('style');
            
            // console.log($('.contacts-container').find(`.contact-card[data-contact-number='9378764087']`).data('contact-id'))
            if(name.text() != previous_name){
                $.ajax({
                    url: "index/edit_contact",
                    type: "POST",
                    data: {
                        "name" : name.text(),
                        "contact-number" : pnumber,
                    },
                    success: function (response){
                        let response2 = JSON.parse(response)
                        refresh_contacts(pnumber)
                        $(".main-wrapper>.profile-popup").addClass("hidden")
                        // response = JSON.parse(response);
                        // for(let res in response){
                        // };
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
            name_change = false
        }
    })
    // mobile back button
    $("#messenger-wrapper > #top-bar #mobile-back-btn").on('click', function(){
        $("#messenger-container").css({
            "display" : "none",
            "visibility" : "hidden"
        })
        $(".main-wrapper>.main-container>.contact-wrapper").css({
            "display" : "initial",
            "visibility" : "initial"
        })
        $(".contacts-container .contact-card").each(function(){
            $(this).data("selected", false)
            $(this).css("background-color", "")
            $(this).children(".message-wrapper").children().css("color", "")
        })
    })

    $(".contacts-container .contact-card").each(function(){
        $(this).on("click", function(){
            if($(this).data("selected") == false){
                $(".contacts-container .contact-card").each(function(){
                    $(this).data("selected", false)
                    $(this).css("background-color", "")
                    $(this).children(".message-wrapper").children().css("color", "")
                })
                let data;
                let wrapper = $("#messenger-container>#messenger-wrapper")
                $(this).data("selected", true)
                $(this).css("background-color", "rgb(255, 202, 56)")
                $(this).children(".message-wrapper").children().css("color", "white")
                wrapper.css("display", "initial")
                $("#messenger-container>#cover").addClass("hidden")
                load_messages($(this))
                
                setTimeout(function() {
                    wrapper.removeClass("hidden")
                }, 300)
                currently_selected = $(this)
                current_messages = []
                wrapper.children("#top-bar").children("#contact-info").children("p").text($(this).data('name'))
                if (window.matchMedia("(orientation: portrait)")['matches']) {
                    $("#messenger-container").css({
                        "display" : "initial",
                        "visibility" : "initial"
                    })
                    $(".main-wrapper>.main-container>.contact-wrapper").css({
                        "display" : "none",
                        "visibility" : "hidden"
                    })
                    $("#messenger-wrapper > #top-bar #mobile-back-btn").removeClass("hidden")
                }

            }
        })
    })
}
{ // messaging functions
    $("#messenger-container #bottom-bar #message-buttons>#send-button").on("click", function(){
        let message = $("#messenger-container #bottom-bar #message-input>input").val()
        if(message.length > 0){
            $.ajax({
                url: "index/send_message",
                type: "POST",
                data: {
                    "recipient_id" : currently_selected.data("contact-id"),
                    "message" : message
                },
                success: function (response){
                    response = JSON.parse(response);
                    load_messages(currently_selected)
                    $("#messenger-container #bottom-bar #message-input>input").val('')
                },
                error: function (response) {
                    alert("Server-side error.")
                }
            });
        }
    })
}
{ // refreshing messages every 5 seconds
    setInterval(async () => {
        if(currently_selected){
            refresh_contacts(currently_selected.data("contact-number"))
            load_messages(currently_selected)
        }
    }, 5000)
}
{ // set online status
    let stop = false
    let sec = 120;
    async function timer(){
        var timer = setInterval(async => {
            sec--;
            if (stop){
                clearInterval(timer);
                $.ajax({
                    url: "index/change_status",
                    type: "POST",
                    data: {
                        "state" : 1, 
                    },
                    // success: function (response){
                    //     response = JSON.parse(response);
                    // },
                    // error: function (response) {
                    //     alert("Server-side error.")
                    // }
                });
            }
            if (sec < 0) {
                clearInterval(timer);
                console.log("done")
                $.ajax({
                    url: "index/change_status",
                    type: "POST",
                    data: {
                        "state" : 0, 
                    },
                    // success: function (response){
                    //     response = JSON.parse(response);
                    // },
                    // error: function (response) {
                    //     alert("Server-side error.")
                    // }
                });
            }
        }, 1000);
    }
    $(document).on("visibilitychange", function(){
        if(document.hidden){
            stop = false
            sec = 120
            timer()
        }else{
            stop = true
            sec = 120
        }
    })
}
$("<div>",{text:"Made by Arian", css:{position:"absolute", bottom:"8px", left:"8px", fontSize:"0.8rem", color:"white"}}).appendTo("body");