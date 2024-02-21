<h1 class="font-extrabold mb-0">Contact Form</h1>
<h2 class="font-bold txt-blue mb-3">PB TRAVEL</h2>
<!-- /// FORM START \\\ -->
{!! Form::open([ 'action' => 'App\Http\Controllers\MailController@create', 'method' => 'get', 'enctype' => 'multipart/form-data' ]) !!}
<div class="">
    <div class="flex justify-between">
        <div class="mb-2">
            {{Form::text('first_name', '', ['class' => 'form-control mr-5', 'placeholder' => 'Voornaam..', 'name' => 'first_name', 'id' => 'field-first_name'])}}
        </div>
        <div class="mb-2">
            {{Form::text('last_name', '', ['class' => 'form-control mr-5', 'placeholder' => 'Achternaam..',  'name' => 'last_name', 'id' => 'field-last_name'])}}
        </div>
    </div>
    <div class="mb-2">
        {{Form::text('company_name', '', ['class' => 'form-control', 'placeholder' => 'Bedrijfsnaam..',  'name' => 'company_name', 'id' => 'field-company_name'])}}
    </div>
    <div class="mb-2">
        {{Form::tel('tel', '', ['class' => 'form-control', 'placeholder' => 'Telefoonnummer..', 'name' => 'tel', 'id' => 'field-telephone'])}}
    </div>
    <div class="mb-2">
        {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'E-mailadres..',  'name' => 'email', 'id' => 'field-email_adress'])}}
    </div>
    <div class="">
        {{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'Typ hier een bericht..', 'name' => 'message', 'id' => 'field-message', 'rows' => '5'])}}
    </div>
    <div class="">
        <div class="checkbox">
            <input name="agreement" value="true" id="checkbox-form" type="checkbox">
            <label class="txt-grey ml-2 pt-2">Ik ga akkoord met de <a href="" data-toggle="modal" data-target="#general">voorwaarden</a>.</label>
        </div>
    </div>
    <div class="flex justify-end">
        {{Form::submit('Versturen', ['class'=>'submit'])}}
    </div>
</div>
{!! Form::close() !!}
<!-- /// FORM END \\\ -->
