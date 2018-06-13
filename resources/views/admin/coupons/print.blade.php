<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coupons</title>
    <style type="text/css">
        .page {
            overflow: hidden;
            page-break-after: always;
        }
        .coupon{
            position: relative;
            display: inline-block;
        }
        .background{
            height: 430px;
            width: 600px;
        }
        .code{
            top: 30px;
            position: absolute;
            right: 60px;
        }
        .value{
            bottom: 30px;
            font-size: 20px;
            position: absolute;
            right: 130px;
        }
    </style>
</head>
<body>

@foreach($coupons as $coupon)

    @if(($loop->iteration % 4) == 1)
        <div class="page">
    @endif

        <div class="coupon">
            <div class="code">
                Code: {{ $coupon->code }}
            </div>
            <img class="background" src="{{ Storage::disk('public')->url('app/coupons/3D-printing-coupon.png') }}"/>
            <div class="value">
                {{ $coupon->expiration_at->toFormattedDateString() }} ${{ $coupon->value / 100 }} maximum
            </div>
        </div>

    @if(($loop->iteration % 4) == 0)
        </div>
    @endif

@endforeach

</body>
</html>