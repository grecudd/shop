<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function profile()
    {
        $user = User::findOrFail(Auth::user()->id);
        $buyHistory = Item::where('bought_user_id', $user->id)->get();
        return view('profile', compact('user', 'buyHistory'));
    }

    public function addToCart($id)
    {
        $item = Item::findOrFail($id);
        $cart = session()->get('cart');
        if (!$cart) {
            $cart = [
                $id => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => 1
                ]
            ];
        } elseif (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => 1,
                'price' => $item->price
            ];
        }
        if ($item->quantity - $cart[$id]['quantity'] >= 0) {
            session()->put('cart', $cart);
        }
        return redirect()->route('shop.showCart');
    }

    public function showCart()
    {
        $cart = session()->get('cart');
        $totalPrice = $this->priceCount();
        return view('show_cart', compact('cart', 'totalPrice'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if ($cart[$id]['quantity']) {
            $cart[$id]['quantity']--;
        }


        if (!$cart[$id]['quantity']) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);
        session()->flash('removed_from_cart', 'Item removed from cart successfully');
        return redirect()->route('shop.showCart');
    }

    public function buy()
    {
        $user = User::findOrFail(Auth::user()->id);
        $totalPrice = $this->priceCount();
        if ($user->balance - $totalPrice >= 0) {
            $user->balance -= $totalPrice;

            foreach (session()->get('cart') as $id => $cartItem) {
                $item = Item::findOrFail($cartItem['id']);
                $item->quantity -= $cartItem['quantity'];
                $item->bought_user_id = $user->id;
                $item->bought_quantity = $cartItem['quantity'];
                $item->save();
            }

            $this->clearShoppingCart();
            $user->save();
            session()->flash('transaction_success', 'Transaction completed successfully');
        } else {
            session()->flash('transaction_failed', 'Transaction failed');
        }
        return redirect()->route('items.index');
    }

    public function removeAll()
    {
        $this->clearShoppingCart();
        session()->flash('removed_all_from_cart', 'Items removed from cart successfully');
        return redirect()->route('items.index');
    }

    private function clearShoppingCart()
    {
        session()->put('cart', null);
    }

    public function logOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function priceCount()
    {
        $totalPrice = 0;

        if (session()->get('cart')) {
            foreach (session()->get('cart') as $id => $item) {
                $totalPrice += $item['quantity'] * $item['price'];
            }
        }

        return $totalPrice;
    }

    public function search(Request $request)
    {
        $builder = Item::query();

        if ($request->search) {
            $builder->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $builder->where('quantity', '>', '0')->get();
        $sort = 'asc';
        $search = $request->input('search');

        return view('index', compact('items', 'sort', 'search'));
    }

    public function sortPrice(Request $request)
    {

        $sort = 'asc';
        if ($request->input('sort') == 'asc') {
            $items = Item::where('name', 'like', '%' . $request->input('search') . '%')
                ->where('quantity', '>', '0')
                ->get()
                ->sortBy('price');

            $sort = 'desc';
        } else {
            $items = Item::where('name', 'like', '%' . $request->input('search') . '%')
                ->where('quantity', '>', '0')
                ->get()
                ->sortByDesc('price');
        }

        $search = $request->input('search');

        return view('index', compact('items', 'sort', 'search'));
    }
}
