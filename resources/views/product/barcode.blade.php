<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>

    <style>
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            @foreach ($dataproduct as $key => $product)
                <td class="text-center" style="border: 1px solid">
                    <p>{{ $product->product_name }} - {{ number_format($product->sell_price, 0, '.', ',') }}</p>

                    {{-- Gambar barcode nya --}}
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->product_code, 'C39') }}" alt="{{ $product->product_code }}" width="180" height="60">

                    <br>

                    {{ $product->product_code }}
                </td>
                
                {{-- jika sudah 3 baris, tutup baris, buat baris baru --}}
                @if ($no++ % 3 == 0)
                </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>