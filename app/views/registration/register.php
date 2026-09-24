<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

<link rel="stylesheet" href="/css/register.css">

</head>

<body>

<div class="container">

<h1>Register</h1>

<form method="POST" action="/register">

    <div class="field">
        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
        >

        <div class="error" id="email-error"></div>
    </div>

    <div class="field">
        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
        >

        <div class="error" id="password-error"></div>
    </div>

    <div class="field">
        <label for="password2">Repeat password</label>

        <input
            type="password"
            id="password2"
            name="password2"
        >

        <div class="error" id="password2-error"></div>
    </div>

    <button type="submit">
        Register
    </button>

</form>

</div>

<div id="error-popup" class="error-popup">
    <span id="error-popup-message"></span>
    <button type="button" id="error-popup-close">&times;</button>
</div>

<script src="/js/register.js"></script>

</body>
</html>
