<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotes\QuotesStoreRequest;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $quotes = Quote::where([
            ['name', '!=', null],
            [function ($query) use ($request) {
                if ( ($search = $request->search) ) {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')->get();
                    $query->orWhere('description', 'LIKE', '%' . $search . '%')->get();
                }
            }]
        ])
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('quotes.index')
            ->with([
                'quotes' => $quotes
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('quotes.edit')->with([
            'quote' => new Quote()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\Users $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotesStoreRequest $request)
    {

        $quote = new Quote();

        $quote->name = $request->input('name');
        $quote->description = $request->input('description');
        $quote->content = $request->input('quote-builder');

        if ( $quote->save() ) {

            return redirect()->route('quotes.edit', ['quote' => $quote])
                ->with('message', __('quote.added'));

        }

        return redirect()->route('quotes.create')
        ->withErrors([__('quote.failed_to_add')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('quotes.edit', ['quote' => Quote::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $quote = Quote::where('id', $id)->first();

        return view('quotes.edit')->with([
            'quote' => $quote
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotesStoreRequest $request, $id)
    {

        $quote = Quote::findOrFail($id);

        $quote->name = $request->input('name');
        $quote->description = $request->input('description');
        $quote->content = $request->input('quote-builder');

        if ( $quote->update() ) {

            return redirect()->route('quotes.edit', ['quote' => $quote])
                ->with('message', __('quote.updated'));

        }

        return redirect()->route('quotes.edit', ['quote' => $quote])
            ->withErrors([__('quote.failed_to_update')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $quote = Quote::find($id);

        if ( $quote->delete() ) {
            return redirect()->route('quotes.index')
                ->with('message', __('quote.deleted'));
        }

        return redirect()->route('quotes.index')
            ->withErrors([__('quote.failed_to_delete')]);

    }
}
