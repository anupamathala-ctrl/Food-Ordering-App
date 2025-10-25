document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const registerBtn = document.getElementById('registerBtn');
    
    // Get all required input fields within the form
    const requiredInputs = form.querySelectorAll('input[required]');

    // Function to check if all required fields are filled
    function checkFormValidity() {
        let allFilled = true;
        
        requiredInputs.forEach(input => {
            // Trim to account for only spaces
            if (input.value.trim() === '') { 
                allFilled = false;
            }
        });

        // Check password match separately for better user feedback
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // This simple check ensures all fields are filled AND passwords match
        const passwordsMatch = (password === confirmPassword && password.length > 0);


        if (allFilled && passwordsMatch) {
            // 1. Enable the button
            registerBtn.removeAttribute('disabled');
            // 2. Change the color (add the active CSS class)
            registerBtn.classList.add('active');
        } else {
            // 1. Disable the button
            registerBtn.setAttribute('disabled', 'disabled');
            // 2. Reset the color (remove the active CSS class)
            registerBtn.classList.remove('active');
        }
    }

    // Attach the checkFormValidity function to every input event
    requiredInputs.forEach(input => {
        input.addEventListener('input', checkFormValidity);
    });

    // Run the check once on load in case the browser pre-fills fields
    checkFormValidity();
});

document.addEventListener('DOMContentLoaded', function() {

    // --- GENERIC FUNCTION TO HANDLE BUTTON ACTIVATION ---
    function setupFormValidation(formId, buttonId) {
        const form = document.getElementById(formId);
        const submitBtn = document.getElementById(buttonId);

        if (!form || !submitBtn) return; // Exit if elements don't exist

        // Get all required input fields within the specific form
        const requiredInputs = form.querySelectorAll('input[required]');

        // Function to check if all required fields are filled
        function checkFormValidity() {
            let allFilled = true;
            
            requiredInputs.forEach(input => {
                if (input.value.trim() === '') { 
                    allFilled = false;
                }
            });

            // Special check for password confirmation only on the registration form
            if (formId === 'registrationForm') {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                if (password !== confirmPassword || password.length === 0) {
                    allFilled = false;
                }
            }

            if (allFilled) {
                // Activate the button
                submitBtn.removeAttribute('disabled');
                submitBtn.classList.add('active'); // Apply the dark red color
            } else {
                // Deactivate the button
                submitBtn.setAttribute('disabled', 'disabled');
                submitBtn.classList.remove('active'); // Remove the dark red color
            }
        }

        // Attach the validity check to input events for all required fields
        requiredInputs.forEach(input => {
            input.addEventListener('input', checkFormValidity);
        });

        // Run the check once on load
        checkFormValidity();
    }


    // --- SETUP FORMS ---
    
    // 1. Setup the Registration Form (If it's on this page, or a separate page)
    setupFormValidation('registrationForm', 'registerBtn');

    // 2. Setup the Login Form 
    // This is the one that will run on login.php
    setupFormValidation('loginForm', 'loginBtn');

});