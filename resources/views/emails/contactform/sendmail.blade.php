<!DOCTYPE html>
<html>
<head>
    <title>Ingevuld Contactformulier</title>
</head>
<body style="background-color: #f3f4f6; display:flex; justify-content: center; padding: 10px;">

<div style="background-color: #fff; border-radius: .25rem; box-shadow: 3px 3px 5px 6px #ccc; padding:25px; width:50%; ">

    <h2>Ingevuld contactformulier:</h2>
    <p>
        Naam/Bedrijfsnaam: {{ $mailData['firstname'] }} {{ $mailData['lastname'] }}, {{ $mailData['companyname'] }} <br />
        Adres: {{ $mailData['streetname'] }} {{ $mailData['housenumber'] }}, {{ $mailData['postalcode'] }}, {{ $mailData['city'] }}, {{ $mailData['country'] }} <br />
        Telefoonnummer: {{ $mailData['phone'] }} <br />
        Emailadres: {{ $mailData['email'] }} <br /> <br />
        <strong>Bericht</strong><br />
        {{$mailData['text']}}
    </p>

</div>

</body>
</html>
