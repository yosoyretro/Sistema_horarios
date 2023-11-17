<?php

namespace App\Http\Controllers;

use App\Services\RolServicio;
use App\Services\Validaciones;
use Illuminate\Http\Request;

class RollController extends Controller
{
    
    private $obj_service_rol, $validacion_clase;
    public function index()
    {
        $this->validacion_clase = new Validaciones();
        $this->obj_service_rol = new RolServicio();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
