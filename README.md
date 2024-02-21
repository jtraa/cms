## Over dit project

Gevels en daken website bestaat uit een main website en daarachter een CMS. Hier kunnen editors en users de website aanpassen nadat ze ingelogd zijn en gevalideerd zijn
door het systeem. Deze gebruikers kunnen dan services, artikelen, medewerkers en pagina's aanpassen naar hun wens door middel van templates en invoervelden.

## Project opstarten

Hier een gebruiksaanwijzing voor het ophalen van deze repository:

* ENV toevoegen -> voeg toe de secret ID van MS Graph, de database- en mailgegevens van jouw omgeving.
* Zorg ervoor dat je website draait op https://www.gevelsendaken.test/ zodat de inlog van Microsoft goed verloopt.
* Haal de databasebestanden uit het mapje database/gevelsendaken-databases en zet die in je database.
* composer install
* npm install
* php artisan shield:super-admin (maak jezelf superadmin zodat je bij alle bestanden kan)
* php artisan serve / valet link
* Het beste kun je inloggen met je microsoft account die eindigt met @esg.works.nl, @esg.works.nl, @gevelsendaken.nl of @kettlitz.nl

## Aanpassingen

Als je iets wil aanpassen in de Vue JS bestanden kun je het beste deze command line gebruiken: vite

Zodat je aanpassingen verwerkt worden door Vite.

## Database

De database bestanden zitten in het mapje database/gevelsendaken-databases in dit project. 
Als op de een of andere manier deze bestanden niet correct zijn of als je ze niet kunt importeren kun je de volgende command lines uitvoeren
om een groot deel van de database binnen te importeren:

* php artisan migrate 
* php artisan db:seed 
* php artisan shield:generate --all
