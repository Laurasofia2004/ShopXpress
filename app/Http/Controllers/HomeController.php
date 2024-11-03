<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Método para mostrar la página de inicio
    public function index()
    {
        return view('home'); // Retorna la vista home
    }

    // Método para mostrar una sección sobre nosotros
    public function about()
    {
        return view('about'); // Retorna la vista about
    }

    // Método para mostrar la página de contacto
    public function contact()
    {
        return view('contact'); // Retorna la vista contact
    }

    // Método para manejar el envío de formularios de contacto
    public function sendContact(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Aquí podrías enviar el mensaje o guardarlo en la base de datos
        // Por ejemplo, usando un servicio de correo electrónico

        // Redirigir a la página de contacto con un mensaje de éxito
        return redirect()->route('contact')->with('success', 'Mensaje enviado exitosamente.');
    }

    // Puedes agregar otros métodos según las funcionalidades que necesites
}