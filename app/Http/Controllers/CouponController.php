<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::whereDepartment(auth()->guard('web')->user()->department)
                            ->where('expiration_at', '>', Carbon::now('America/Denver')->toDateString())
                            ->orderBy('expiration_at', 'ASC')
                            ->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupons = new Collection();
        for($i=0; $i < $request->get('count'); $i++){
            $coupon = new Coupon();
            $coupon->department = auth()->guard('web')->user()->department;
            $coupon->code = (new \App\Models\RandomWord())->generate(10, true, false, false);
            $coupon->value = $request->get('value');
            $coupon->expiration_at = $request->get('expiration_at');
            $coupon->save();
            $coupons->push($coupon);
        }

        $pdf = \PDF::loadView('admin.coupons.print', compact('coupons'))->setOrientation('landscape');
        return $pdf->download('coupons.pdf');

        return view('admin.coupons.print', compact('coupons'));

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
        $this->authorize('update-pricing');

        $printer = Coupon::findorFail($id);
        $printer->delete();

        return redirect()->back();
    }
}
