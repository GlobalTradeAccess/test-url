<?php
 
// -----------------------------------------
// IPINFO TEST ONLY
// No redirect
// No bot filtering
// -----------------------------------------
 
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
 
// 1. Visitor IP
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
 
 
// 2. IPinfo token
// IMPORTANT: use a NEW token because the old one was shared publicly.
$token = '15637b87b1b62a';
 
 
// 3. Default values
$country_code = 'XX';
$error = '';
 
 
// 4. Validate IP
if (empty($ip)) {
 
    $error = 'Visitor IP could not be detected.';
 
} else {
 
    // 5. Build IPinfo request
    $api_url =
        'https://ipinfo.io/' .
        rawurlencode($ip) .
        '/country?token=' .
        rawurlencode($token);
 
 
    // 6. Call IPinfo
    $context = stream_context_create([
        'http' => [
            'timeout' => 8,
            'ignore_errors' => true
        ]
    ]);
 
    $response = @file_get_contents(
        $api_url,
        false,
        $context
    );
 
 
    // 7. Read response
    if ($response === false) {
 
        $error = 'IPinfo API request failed.';
 
    } else {
 
        $country_code = strtoupper(trim($response));
 
        // Basic validation
        if (!preg_match('/^[A-Z]{2}$/', $country_code)) {
 
            $error = 'IPinfo did not return a valid country code.';
 
            $country_code = 'XX';
        }
    }
}
 
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
 
<meta charset="UTF-8">
 
<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>
 
<title>IPinfo Test</title>
 
<style>
 
body {
    margin: 0;
    padding: 40px 20px;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
    color: #222;
}
 
.box {
    max-width: 600px;
    margin: auto;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 30px;
}
 
h1 {
    margin-top: 0;
    font-size: 25px;
}
 
.row {
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}
 
.label {
    display: block;
    margin-bottom: 6px;
    color: #777;
    font-size: 12px;
}
 
.value {
    font-size: 18px;
    font-weight: 700;
}
 
.success {
    color: #137333;
}
 
.error {
    margin-top: 20px;
    padding: 12px;
    background: #fff3f3;
    border: 1px solid #e5baba;
    color: #a12828;
}
 
</style>
 
</head>
 
<body>
 
<div class="box">
 
<h1>IPinfo Country Test</h1>
 
<div class="row">
 
<span class="label">
VISITOR IP
</span>
 
<span class="value">
<?= htmlspecialchars($ip) ?>
</span>
 
</div>
 
 
<div class="row">
 
<span class="label">
COUNTRY CODE
</span>
 
<span class="value success">
<?= htmlspecialchars($country_code) ?>
</span>
 
</div>
 
 
<?php if ($error !== ''): ?>
 
<div class="error">
 
<?= htmlspecialchars($error) ?>
 
</div>
 
<?php endif; ?>
 
 
</div>
 
</body>
 
</html>
IPinfo | The Trusted IP Data Provider
Access trusted IP data for your applications — from fraud prevention to geolocation. See why developers rely on IPinfo.
 