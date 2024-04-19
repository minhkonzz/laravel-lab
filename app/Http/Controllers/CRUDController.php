<?php 

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;

class CRUDController extends Controller
{
    protected $service;
    protected $viewName;

    function __construct($service, $viewName)
    {
        $this->service = $service;
        $this->viewName = $viewName;
    }

    public function index(): View
    {
        $items = $this->service->getAll();
        return view($this->viewName.'.'.'index', compact('items'));
    }

    public function show($item): View
    {
        return view($this->viewName.'.'.'show', compact('item'));
    }

    public function create(): View 
    {
        return view($this->viewName.'.'.'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->service->create($request->all());
        return redirect()->route($this->viewName.'.'.'index');
    }

    public function edit($item): View
    {
        return view($this->viewName.'.'.'update', compact('item'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->service->update($request->all(), $id);
        return redirect()->route($this->viewName.'.'.'index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);
        return redirect()->route($this->viewName.'.'.'index');
    }
}