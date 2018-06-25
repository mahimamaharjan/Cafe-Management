<?php include_once 'includes/header.php'; ?>
<section id="showcase">
    <div class="container_registration">
        <h1>sign up for yeom</h1>
        <h2></h2>
        <div class="registrationForm">
                        <form class="registerformInput" name="registration" method="post" action="register.php">
                            <?php
                            if (isset($error_msg) && $error_msg != '') {
                                echo '<div class="error-div">' . $error_msg . '</div>';
                            }
                            ?>
            <div class="register-row">
                <div class="left">
                    <div for="first-name">First Name</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input id="first-name" name="first_name" class="text" type="text"
                           value="<?php if (isset($first_name)) echo $first_name; ?>" placeholder="Your First Name">
                </div>
            </div>
            <div class="register-row">
                <div class="left">
                    <div for="last-name">Last Name</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input id="last-name" name="last_name" class="text" type="text"
                           value="<?php if (isset($last_name)) echo $last_name; ?>" placeholder="Your Last Name">
                </div>
            </div>
            <div class="register-row studentStaffIdRow">
                <div class="left">
                    <div>Student/Staff ID</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input class="studentStaffId" name="student_staff_id" class="text"
                           type="text" value="<?php if (isset($student_staff_id)) echo $student_staff_id; ?>"
                           placeholder="Your Student or Staff Id">
                </div>
                <div class="error studentStaffId-error">

                </div>
            </div>
            <div class="register-row">
                <div class="left">
                    <div for="phone">Phone</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input id="phone" name="phone" class="text" type="text"
                           value="<?php if (isset($phone)) echo $phone; ?>"
                           placeholder="Phone Number">
                </div>
            </div>
            <div class="register-row emailAddressRow">
                <div class="left">
                    <div>Email Address</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input class="emailAddress" name="email_address" class="text"
                           type="text" value="<?php if (isset($email_address)) echo $email_address; ?>"
                           placeholder="you@domain.com">
                </div>
                <div class="error emailAddress-error">
                </div>
            </div>
            <div class="register-row creditCardRow">
                <div class="left">
                    <div for="credit_card">Credit Card Number</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input class="creditCard" name="creditcard_number" class="text"
                           type="number" value="<?php if (isset($creditcard_number)) echo $creditcard_number; ?>"
                           placeholder="**** **** ****">
                </div>
                <div class="error creditCard-error">
                </div>

            </div>
            <div class="register-row passwordRow">
                <div class="left">
                    <div for="password">Password</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input class="password" name="password" class="text"
                           type="password">
                </div>
                <div class="error password-error">
                </div>

            </div>
            <div class="register-row passwordConfirmRow">
                <div class="left">
                    <div for="passwordconfirm">Confirm Password</div>
                    <span class="required">*</span>
                </div>
                <div class="right">
                    <input class="passwordConfirm" name="confirm_password" type="password">
                </div>
                <div class="error passwordConfirm-error">
                </div>
            </div>
            <div class="register-row">
                <div>By Signing Up, I agree to Yeom&#39;s Terms of Use and Privacy
                    Policy.
                </div>
            </div>
            <div class="register-row">
                <input id="submit" name="submit" class="registerBtn" type="submit"  value="Register">
            </div>
            <div class="register-row">
                <label>Already have an account? <a href="login.php"> Sign in </a></label>
            </div>
                        </form>
        </div>
    </div>
</section>
<?php include_once 'includes/footer.php'; ?>
<script type="text/javascript">

    let isValidStudentStaffId = false;
    let isValidEmailAddress = false;
    let isValidPassword = false;
    let isValidCreditCard = false;
    let isValidPasswordConfirm = false;


    // Staffid
    const isValidChar = (inputValue) => {
        const checkStudentChar = inputValue[0].toUpperCase() === 'U' && inputValue[1].toUpperCase() === 'E';
        const checkIfEmployee = inputValue[0].toUpperCase() === 'U' && inputValue[1].toUpperCase() === 'S';
        return checkStudentChar || checkIfEmployee
    }
    const isValidLength = (inputValue) => inputValue.length === 6;
    const messages = [
        {type: 'employeeChar', message: 'The starting Character must be US or UE', complies: isValidChar},
        {type: 'length', message: 'The id length must be 6', complies: isValidLength}
    ]

    let renderStudentMessage = messages.map(function (msg) {
        return {
            ...msg,
            valid: false
        }
    })

    $('.studentStaffId').bind('input', function ({target}) {
        const inputValueArray = target.value.split('');

        showConditionMessage('studentStaffId')

        renderStudentMessage = messages.map(function (msg) {
            return {
                ...msg,
                valid: msg.complies(inputValueArray)
            }
        })

        isValidStudentStaffId = renderStudentMessage.every(d => d.valid)
        appendErrorMessage('studentStaffId', renderStudentMessage)
        addConditionValidBorder('studentStaffId', isValidStudentStaffId)
        isValidAll();

    });
    $('.studentStaffId').blur(function (e) {

        hideConditionMessage('studentStaffId')
    })


    // Email
    const isValidEmail = emailFromInput => (emailFromInput && emailFromInput.length > 0 &&
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailFromInput))

    const emailValidMessage = [
        {type: 'password', message: 'Password is Valid', complies: isValidEmail},
    ]
    let renderEmailMessage = emailValidMessage.map(function (msg) {
        return {
            ...msg,
            valid: false
        }
    })
    $('.emailAddress').bind('input', function ({target}) {

        const emailFromInput = target.value;
        showConditionMessage('emailAddress')
        renderEmailMessage = emailValidMessage.map(function (msg) {
            return {
                ...msg,
                valid: msg.complies(emailFromInput)
            }
        })
        isValidEmailAddress = renderEmailMessage.every(d => d.valid)
        appendErrorMessage('emailAddress', renderEmailMessage)
        addConditionValidBorder('emailAddress', isValidEmailAddress)
        isValidAll();

    })

    $('.emailAddress').blur(function (e) {

        hideConditionMessage('emailAddress')
    })


    // Credit card
    const isValidCard = cardFromInput => (cardFromInput.length > 0 && cardFromInput.length === 12)

    const creditCardMessage = [
        {type: 'password', message: 'Credit is Valid', complies: isValidCard},
    ]
    let renderCreditCardMessage = creditCardMessage.map(function (msg) {
        return {
            ...msg,
            valid: false
        }
    })

    $('.creditCard').bind('input', function ({target}) {
        showConditionMessage('creditCard')

        renderCreditCardMessage = creditCardMessage.map(function (msg) {
            return {
                ...msg,
                valid: msg.complies(target.value)
            }
        })

        isValidCreditCard = renderCreditCardMessage.every(d => d.valid)
        appendErrorMessage('creditCard', renderCreditCardMessage)
        addConditionValidBorder('creditCard', isValidCreditCard)
        isValidAll();

    })
    $('.creditCard').blur(function (e) {

        hideConditionMessage('creditCard')
    })

    // passworkd
    let currentPassword = null;
    let passwordConfirm = null;

    const isValidPasswordLength = password =>
        password.length > 0 && password.length > 5 && password.length < 13;

    const containLowerAndUpper = textFromInput => findLowerOrUpper(textFromInput);
    const containSpecial = textFromInput =>
        textFromInput.split('')
            .map(function (char) {
                return specialChars.indexOf(char) !== -1;
            })
            .indexOf(true) !== -1;

    const containNumber = textFromInput =>
        textFromInput.split('')
            .map(function (char) {
                return isNaN(char);
            })
            .indexOf(false) !== -1;

    const isMatched = (input) => passwordConfirm === currentPassword;
    // const passwordConfirmMessage = [
    //     {type: 'passwordConfirm', message: 'Password Match is Valid', complies: isMatched},
    // ]
    // let renderPasswordConfirm = passwordConfirmMessage.map(function (msg) {
    //     return {
    //         ...msg,
    //         valid: false
    //     }
    // })


    const passwordMessage = [
        {type: 'length', message: 'Password length is Valid', complies: isValidPasswordLength},
        {type: 'containLowerAndUpper', message: 'containLowerAndUpper is Valid', complies: containLowerAndUpper},
        {type: 'containSpecial', message: 'containSpecial is Valid', complies: containSpecial},
        {type: 'containNumber', message: 'containNumber is Valid', complies: containNumber},
        {type: 'passwordConfirm', message: 'Password Match is Valid', complies: isMatched},

    ]
    let renderPasswordMessage = passwordMessage.map(function (msg) {
        return {
            ...msg,
            valid: false
        }
    })

    const specialChars = ['~', '!', '#', '$'];
    $('.password').bind('input', function ({target}) {
        currentPassword = target.value;
        showConditionMessage('password')

        renderPasswordMessage = passwordMessage.map(function (msg) {
            return {
                ...msg,
                valid: msg.complies(target.value)
            }
        })

        isValidPassword = renderPasswordMessage.filter(d=>d.type!=='passwordConfirm').every(d => d.valid)
        appendErrorMessage('password', renderPasswordMessage)
        console.error(isValidPassword,'ddd')
        addConditionValidBorder('password', isValidPassword)
        isValidAll();

    })

    $('.password').blur(function (e) {

        // hideConditionMessage('password')
    })

    function validatePassword(password) {
        const isValidLength =
            password.length > 0 && password.length > 5 && password.length < 13;
        const passArray = password.split('');
        const containLowerAndUpper = findLowerOrUpper(passArray);
        const containSpecial =
            passArray
                .map(function (char) {
                    return specialChars.indexOf(char) !== -1;
                })
                .indexOf(true) !== -1;

        const containNumber =
            passArray
                .map(function (char) {
                    return isNaN(char);
                })
                .indexOf(false) !== -1;
        return (
            isValidLength &&
            containLowerAndUpper &&
            containNumber &&
            containSpecial
        );
    }


    function findLowerOrUpper(passwordFromInput) {
        const password = passwordFromInput.split('');
        const validLower =
            password
                .map(function (character) {
                    return (
                        isNaN(character) &&
                        specialChars.indexOf(character) < 0 &&
                        character === character.toLowerCase()
                    );
                })
                .indexOf(true) !== -1;

        const validUpper =
            password
                .map(function (character, index) {
                    return (
                        isNaN(character) &&
                        specialChars.indexOf(character) < 0 &&
                        character === character.toUpperCase()
                    );
                })
                .indexOf(true) !== -1;
        return validLower && validUpper;
    }

    $('.passwordConfirm').bind('input', function ({target}) {

        passwordConfirm = target.value;
        console.error(renderPasswordMessage, 'check')
        renderPasswordMessage = renderPasswordMessage.map(function (msg) {

            if (msg.type === 'passwordConfirm') {
                return {
                    ...msg,
                    valid: msg.complies(target.value)
                }
            }
            return {
                ...msg,

            }

        })
        appendErrorMessage('password', renderPasswordMessage)
        addConditionValidBorder('passwordConfirm',isMatched() )
        isValidAll();
    })

    function appendErrorMessage(selector, message) {
        const errorElement = `<div class="error ${selector}Row-error"> </div>`
        const elment = $(`.${selector}-error`)

        $(`.${selector}-error .message`).remove()

        message.map(msgItem => {

            msg = $(`<div class="message ${msgItem.valid ? 'validMessage' : 'errrorMessage'}"></div>`);
            //                    <div class="message"><i class=" faIcon fas fa-check"></i><div>The id length must be 6</div>  </div>
            const icon = msgItem.valid ? '<i class=" faIcon fas fa-check"></i>' : `<i class=" faIcon fas fa-times"></i>`;

            const label = `<div>${msgItem.message}</div>`;
            msg.append(icon);
            msg.append(label);
            elment.append(msg)
        })


    }

    $('.passwordConfirm').blur(function (e) {

        hideConditionMessage('password')
    })

    function hideConditionMessage(selector) {
        $(`.${selector}-error`).hide()
    }

    function showConditionMessage(selector) {
        $(`.${selector}-error`).show()
    }

    function addConditionValidBorder(selector, isTrue) {

        if (!isTrue) {
            $(`.${selector}`).addClass('valid-error')
        }
        if (isTrue) {
            $(`.${selector}`).addClass('valid-success')
        }

    }


    $('.registerBtn').click(function (e) {

       /*
        if (!isValidStudentStaffId) {
            showConditionMessage('studentStaffId')
            appendErrorMessage('studentStaffId', renderStudentMessage)
            addConditionValidBorder('studentStaffId', isValidStudentStaffId)
        }
        if (!isValidEmailAddress) {
            showConditionMessage('emailAddress')
            appendErrorMessage('emailAddress', renderEmailMessage)
            addConditionValidBorder('emailAddress', isValidEmailAddress)
        }
        if (!isValidCreditCard) {

            showConditionMessage('creditCard')
            appendErrorMessage('creditCard', renderCreditCardMessage)
            addConditionValidBorder('creditCard', isValidCreditCard)
        }

        if (!isValidPassword) {
            showConditionMessage('password')
            appendErrorMessage('password', renderPasswordMessage)
            addConditionValidBorder('password', isValidPassword)
            addConditionValidBorder('passwordConfirm', isValidPassword?isMatched():false)

        }
        // if (!isValidPasswordConfirm) {
        //     showConditionMessage('passwordConfirm')
        //     appendErrorMessage('passwordConfirm', renderPasswordConfirm)
        //     addConditionValidBorder('passwordConfirm', isValidPasswordConfirm)
        //
        // }

*/
    })

    function isValidAll() {
        return isValidStudentStaffId && isValidCreditCard && isValidEmailAddress && isValidPassword && isValidPasswordConfirm;


    }


</script>
