<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Muestra la página de inicio.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('pages.home');
    }

    /**
     * Muestra la página de "Acerca de Nosotros".
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Muestra la página de "Servicios".
     *
     * @return \Illuminate\View\View
     */
    public function services()
    {
        return view('pages.services');
    }

    /**
     * Muestra la página de "Contacto".
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Maneja el envío del formulario de contacto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleContactForm(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Aquí puedes manejar el almacenamiento de datos, enviar un correo, etc.
        // Por ejemplo, enviar un correo con los detalles de contacto
        // Mail::to(config('mail.admin_email'))->send(new ContactFormMail($request->all()));

        return redirect()->route('contact')
                         ->with('success', '¡Gracias por contactarnos! Nos pondremos en contacto contigo pronto.');
    }
}
