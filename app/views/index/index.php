<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app\views\index\css\style.css">
    <title>Messenger</title>
</head>
<body onload="refresh_contacts()">
    <div class="main-wrapper">

        <div class="profile-popup hidden">
            <div id="profile-container">
                <div id="top-section">
                    <button id="close-btn" type="button">+</button>
                    <span>
                        <span>
                            <img id="contact-photo" src="app\views\index\css\user-icon.webp" alt="">
                            <!-- <span id="name">test</span> -->
                        </span>
                    </span>
                </div>
                <div id="info-section">
                    <p id="name">Profile</p>
                    <div>
                        <ul>
                            <div>
                                <p>
                                    Name
                                    <a id="change-name" href="#">Change</a>
                                </p>
                                <li id="name">test</li>
                            </div>

                            <div>
                                <p>Phone number</p>
                                <li id="phone-number">test</li>
                            </div>

                            <div>
                                <p>Bio</p>
                                <li id="bio">Welcome to my profile!</li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-container">
            <div class="messenger-container">

            </div>

            <div class="contact-wrapper">
                <div class="contact-control">
                    <button title="Add contact" class="add-contact-btn" type="button">+</button>
                    <button title="Edit mode" class="edit-contact-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg></button>

                </div>
                <div class="contacts-container">
                    <div class="contact-card hidden">
                        <img class="contact-photo" src="app\views\index\css\user-icon.webp" alt="">
                        <div class="message-wrapper">
                            <p class="contact-name">test</p>
                            <p class="contact-last-message">test</p>
                        </div>
                    </div>
                </div>
                <div class="contact-actions-modal hidden">
                    <form onsubmit="return false;">
                        <div class="hidden">
                            <div class="icon-grid"><p class="modal-info">Add Contact</p></div>
                            <div class="inputs-container">
                                <div class="add-contact-name">
                                    <input type="text" placeholder="Contact name">
                                    <p class="error-text hidden">*</p>
                                </div>
                                <div class="add-contact-number">
                                    <input type="tel" placeholder="Contact number">
                                    <p class="error-text hidden">*</p>
                                </div>
                                <input type="submit" value="Confirm" class="create-contact-btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/jquery-3.4.1.min.js"></script>

    <script src="app\views\index\index.js"></script>
</body>
</html>