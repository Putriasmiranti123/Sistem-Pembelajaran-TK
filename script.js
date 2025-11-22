// script.js
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const role = document.getElementById('role').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const error = document.getElementById('error');
    
    if (!role || username === '' || password === '') {
        e.preventDefault();
        error.textContent = 'Role, username, dan password harus diisi!';
        return;
    }
});