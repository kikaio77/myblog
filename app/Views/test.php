<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       td{padding: 20px;}
       td.active{ background-color: black !important; color: #ffffff;}
    </style>
</head>
<body>
<button id="elem" onclick="alert('클릭!');">자동클릭버튼</button>

<script>
let event = new Event('click');
elem.dispatchEvent(event);
</script>
</body>
</html>