<!DOCTYPE html>
<html>
<head>
    <title>TestMail</title>
</head>
<body style="background-color: #f3f4f6; display:flex; justify-content: center;">
	
	<div style="background-color: #fff; border-radius: .25rem; box-shadow: 3px 3px 5px 6px #ccc; padding:25px; width:50%; ">
		
	    <h2>Bericht van {{ $mail['first_name'] }} {{ $mail['last_name'] }}</h2>
	    <h3 style="color: #3c73ff;">Bedrijf: {{ $mail['company_name'] }}</h3>
	    <p>
		    	<strong>Overige informatie:</strong> <br />
			   <a href="tel:{{ $mail['tel'] }}">{{ $mail['tel'] }}</a> <br />
			   <a href="mailto:{{ $mail['email'] }}">{{ $mail['email'] }}</a> 
		</p>	   
	    <p><strong>Bericht: </strong><br />
		    {{ $mail['message'] }} 
	    </p>
	    
	</div>
	
</body>
</html>