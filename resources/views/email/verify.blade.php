<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Verifikujte vašu email adresu!</h2>

<div>
    Hvala što ste se registrovali na našu aplikaciju.
    Da bi ste potvrdili registraciju kliknite na sledeći link.
    {{ URL::to('register/verify/' . $confirmation_code) }}.<br/>

</div>

</body>
</html>