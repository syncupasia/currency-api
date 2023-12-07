<!DOCTYPE html>
<html>
<head>
    <title>Currency Data PDF</title>
    <style>
        #currency {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #currency td, #currency th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #currency tr:nth-child(even){background-color: #f2f2f2;}

        #currency tr:hover {background-color: #ddd;}

        #currency th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>

<h1>CurrencyWatch</h1>

<table id="currency">
    <thead>
        <tr>
            <th>ISO</th>
            <th>Currency</th>
            <th>Previous Rate</th>
            <th>Current Rate</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($currencies as $currency)
            <tr>
                <td>{{ $currency->iso_code }}</td>
                <td>{{ $currency->name }}</td>
                <td>{{ $currency->previous_rate }}</td>
                <td>{{ $currency->current_rate }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
