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
            color: rgb(35, 31, 32);
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            top: 30px;
            position: absolute;
            right: 90px;
            white-space: nowrap
        }
        .value{
            bottom: 30px;
            color: rgb(35, 31, 32);
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            position: absolute;
            right: 100px;
            white-space: nowrap
        }
    </style>
</head>
<body>

@foreach($coupons as $coupon)

    @if(($loop->iteration % 4) == 1)
        <div class="page">
    @endif

        <div class="coupon">
            <div class="code" style="color: rgb(35, 31, 32);">
                Code: {{ $coupon->code }}
            </div>
            <img class="background" src="{!! asset('storage/coupon/3D-printing-coupon.png') !!}"/>
            <div class="value" style="color: rgb(35, 31, 32);">
                {{ $coupon->expiration_at->toFormattedDateString() }}&nbsp;&nbsp;&nbsp;&nbsp;${{ $coupon->value / 100 }} maximum
            </div>
        </div>

    @if(($loop->iteration % 4) == 0)
        </div>
    @endif

@endforeach

</body>
</html>