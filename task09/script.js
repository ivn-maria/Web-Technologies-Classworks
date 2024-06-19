$(document).ready(function() {
    $('#register-btn').on('click', function() {
        const username = $('#username').val().trim();
        const name = $('#name').val().trim();
        const familyName = $('#family-name').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val().trim();
        const street = $('#street').val().trim();
        const city = $('#city').val().trim();
        const postalCode = $('#postal-code').val().trim();

        let valid = true;
        $('.error').hide();

        if (username.length < 3 || username.length > 10) {
            $('#username-error').text('Username must be between 3 and 10 characters.').show();
            valid = false;
        }

        if (name.length > 50) {
            $('#name-error').text('Name must less than 50 characters.').show();
            valid = false;
        }

        if (familyName.length > 50) {
            $('#family-name-error').text('Family name must less than 50 characters.').show();
            valid = false;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            $('#email-error').text('Email must be valid.').show();
            valid = false;
        }

        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,10}$/;
        if (!passwordPattern.test(password)) {
            $('#password-error').text('Password must be between 6 and 10 characters, include at least one lowercase letter, one uppercase letter, and one number.').show();
            valid = false;
        }

        const postalCodePattern = /^(\d{4}|\d{5}-\d{4})$/;
        if (!postalCodePattern.test(postalCode)) {
            $('#postal-code-error').text('Postal code must be in the format 1111 or 11111-1111.').show();
            valid = false;
        }

        if (valid) {
            $.ajax({
                url: 'https://jsonplaceholder.typicode.com/users',
                method: 'GET',
                success: function(users) {
                    const userExists = users.some(user => user.username === username);

                    if (userExists) {
                        $('#message').text('Username already exists.').css('color', 'red');
                    } else {
                        $('#message').text('');
                        const newUser = {
                            username,
                            name,
                            familyName,
                            email,
                            password,
                            address: {
                                street,
                                city,
                                postalCode
                            }
                        };
                        $('#success').text('Registration successful!');
                    }
                }
            });
        }
    });
});
