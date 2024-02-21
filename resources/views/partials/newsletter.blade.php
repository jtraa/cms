<div class="mt-5" id="newsletter">
    <h2 class="font-extrabold mb-3">Meld je aan voor onze nieuwsbrief</h2>
    {!! Form::open([ 'action' => 'App\Http\Controllers\NewsletterController@create', 'method' => 'get', 'enctype' => 'multipart/form-data' ]) !!}<div class="flex justify-between">
        <div class="mb-2">
            {{Form::text('first_name', '', ['class' => 'form-control mr-5', 'placeholder' => 'Voornaam..', 'name' => 'first_name', 'id' => 'field-first_name'])}}
        </div>
        <div class="mb-2">
            {{Form::text('last_name', '', ['class' => 'form-control mr-5', 'placeholder' => 'Achternaam..',  'name' => 'last_name', 'id' => 'field-last_name'])}}
        </div>
    </div>
    <div class="mb-2">
        {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'E-mailadres..',  'name' => 'email', 'id' => 'field-email_adress'])}}
    </div>
    <div class="">
        <div class="checkbox">
            <input name="agreement1" value="true" id="checkbox-form" type="checkbox">
            <label class="txt-grey ml-2 mb-0">Maandelijkse nieuwsbrief.</label>
        </div>
    </div>
    <div class="">
        <div class="checkbox">
            <input name="agreement2" value="true" id="checkbox-form" type="checkbox">
            <label class="txt-grey ml-2 mb-0">Acties, reclame van derden etc.</label>
        </div>
    </div>
    <div class="">
        <div class="checkbox">
            <input name="agreement3" value="true" id="checkbox-form" type="checkbox">
            <label class="txt-grey ml-2">Ik ga akkoord met de <a href="" data-toggle="modal" data-target="#general">voorwaarden</a>.</label>
        </div>
    </div>
    <div class="flex justify-end">
        {{Form::submit('Aanmelden', ['class'=>'submit'])}}
    </div>
    {!! Form::close() !!}
    <!-- /// FORM END \\\ -->
</div>
