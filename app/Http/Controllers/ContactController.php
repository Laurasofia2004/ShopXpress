<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Muestra el formulario de contacto.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Procesa el formulario de contacto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Guarda el mensaje en la base de datos
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        // Enviar el mensaje por correo electrónico
        Mail::send('emails.contact', ['contact' => $contact], function ($mail) use ($contact) {
            $mail->to('soporte@tuempresa.com')
                 ->subject('Nuevo mensaje de contacto: ' . $contact->subject);
        });

        // Redireccionar con mensaje de éxito
        return redirect()->route('contact.index')
            ->with('success', '¡Tu mensaje ha sido enviado con éxito! Nos pondremos en contacto contigo pronto.');
    }
}
