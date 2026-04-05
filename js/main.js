// js/main.js

// Functionality for form submission
function submitForm(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(event.target);
    // Prepare data for AJAX call
    const data = Object.fromEntries(formData);
    // Make AJAX call to the API
    sendDataToAPI(data);
}

// AJAX call to the API
function sendDataToAPI(data) {
    fetch('https://api.example.com/endpoint', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        // Handle success (e.g., show a message or update the UI)
    })
    .catch((error) => {
        console.error('Error:', error);
        // Handle error (e.g., show an error message)
    });
}

// Interactive features (e.g., event listeners)
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form'); // Replace with your form selector
    form.addEventListener('submit', submitForm);
});
