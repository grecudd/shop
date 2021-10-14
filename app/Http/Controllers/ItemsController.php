<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::where('quantity', '>', '0')->get();
        $sort = 'asc';
        $search = '';
        return view('index', compact('items', 'sort', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_item');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'required|mimes:jpg,png,jped'
        ]);
        $newImageName = time() . '-' . $request->input('name') . '.' . $request->file('image')->extension();

        Storage::disk('public')->put($newImageName, $request->file('image')->getContent());

        $item = Item::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'image_path' => $newImageName
        ]);
        session()->flash('item_added', 'Item has been added successfully');

        return redirect()->route('items.show', compact('item'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('show_item', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('edit_item', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        $item->quantity = $request->input('quantity');

        if ($request->image) {
            if ($path = $item->image_path) {
                Storage::disk('public')->delete($path);
            }

            $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();

            Storage::disk('public')->put($newImageName, $request->file('image')->getContent());

            $item->image_path = $newImageName;
        }

        $item->save();

        return view('show_item', compact('item'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        Storage::disk('public')->delete($item->image_path);

        $item->delete();
        session()->flash('item_deleted', 'Item has been deleted successfully');
        return redirect()->route('items.index');
    }
}
