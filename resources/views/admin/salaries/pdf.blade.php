<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Salaries Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .report-date {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #e8e8e8;
            font-weight: bold;
        }
        .total-row td {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }
    </style>
</head>
<body>
    <h2>Salary Report</h2>
    <div class="report-date">
        <strong>Period:</strong> {{ $monthDisplay }}<br>
        <strong>Generated:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th class="text-right">Working Days</th>
                <th class="text-right">Basic Salary</th>
                <th class="text-right">Daily Rate</th>
                <th class="text-right">Overtime</th>
                <th class="text-right">Advances</th>
                <th class="text-right">Expenses</th>
                <th class="text-right">Final Salary</th>
            </tr>
        </thead>
        <tbody>
            @php $totalFinal = 0; @endphp
            @foreach($salaries as $sal)
            <tr>
                <td>{{ $sal['employee_name'] }}</td>
                <td class="text-right">{{ $sal['working_days'] }}</td>
                <td class="text-right">{{ number_format($sal['basic_salary'], 2) }}</td>
                <td class="text-right">{{ number_format($sal['daily_wage'], 2) }}</td>
                <td class="text-right">{{ number_format($sal['overtime_total'], 2) }}</td>
                <td class="text-right">{{ number_format($sal['advance_total'], 2) }}</td>
                <td class="text-right">{{ number_format($sal['expenses_total'], 2) }}</td>
                <td class="text-right"><strong>{{ number_format($sal['final_salary'], 2) }}</strong></td>
            </tr>
            @php $totalFinal += $sal['final_salary']; @endphp
            @endforeach
            <tr class="total-row">
                <td colspan="7" class="text-right"><strong>TOTAL SALARIES:</strong></td>
                <td class="text-right"><strong>{{ number_format($totalFinal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
