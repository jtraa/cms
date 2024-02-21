<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormRequest as Request;
use App\Mail\SendMail;
use App\Models\Mail as ContactForm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->store($request);

        $mailData = $request->only([
            'firstname',
            'lastname',
            'companyname',
            'email',
            'phone',
            'streetname',
            'housenumber',
            'postalcode',
            'city',
            'country',
            'text',
        ]);

        Mail::to('info@gevelsendaken.nl')->send(new SendMail($mailData));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mail = new ContactForm;
        $mail->firstname = $request['firstname'];
        $mail->lastname = $request['lastname'];
        $mail->companyname = $request['companyname'];
        $mail->email = $request['email'];
        $mail->phone = $request['phone'];
        $mail->streetname = $request['streetname'];
        $mail->housenumber = $request['housenumber'];
        $mail->postalcode = $request['postalcode'];
        $mail->city = $request['city'];
        $mail->country = $request['country'];
        $mail->text = $request['text'];
        $mail->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
