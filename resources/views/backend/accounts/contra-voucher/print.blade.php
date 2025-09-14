<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contra Voucher - {{ $contraVoucher->voucher_no ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .voucher-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .voucher-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .voucher-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .info-value {
            border-bottom: 1px solid #000;
            padding: 5px 0;
            min-width: 150px;
        }
        .entries-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .entries-table th,
        .entries-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .entries-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .entries-table .amount {
            text-align: right;
        }
        .total-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #000;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 40px;
            margin-bottom: 10px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .voucher-container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="voucher-container">
        <div class="header">
            <div class="company-name">Your Company Name</div>
            <div class="voucher-title">CONTRA VOUCHER</div>
        </div>

        <div class="voucher-info">
            <div class="info-item">
                <div class="info-label">Voucher No:</div>
                <div class="info-value">{{ $contraVoucher->voucher_no ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date:</div>
                <div class="info-value">{{ $contraVoucher->trans_date ? (is_string($contraVoucher->trans_date) ? \Carbon\Carbon::parse($contraVoucher->trans_date)->format('d/m/Y') : $contraVoucher->trans_date->format('d/m/Y')) : 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Amount:</div>
                <div class="info-value">{{ number_format($contraVoucher->amount ?? 0, 2) }}</div>
            </div>
        </div>

        <table class="entries-table">
            <thead>
                <tr>
                    <th style="text-align: center;">Code</th>
                    <th style="text-align: center;">Particulars</th>
                    <th style="text-align: center;">Debit</th>
                    <th style="text-align: center;">Credit</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($debitEntries) && count($debitEntries) > 0)
                    {{-- Debit Entries First --}}
                    @foreach($debitEntries as $entry)
                        <tr>
                            <td>{{ $entry['code'] ?? 'N/A' }}</td>
                            <td>{{ $entry['particulars'] ?? 'N/A' }}</td>
                            <td class="amount">{{ number_format($entry['amount'], 2) }}</td>
                            <td class="amount">0.00</td>
                        </tr>
                    @endforeach
                    
                    {{-- Credit Entries Second --}}
                    @if(isset($creditEntries) && count($creditEntries) > 0)
                        @foreach($creditEntries as $entry)
                            <tr>
                                <td>{{ $entry['code'] ?? 'N/A' }}</td>
                                <td>{{ $entry['particulars'] ?? 'N/A' }}</td>
                                <td class="amount">0.00</td>
                                <td class="amount">{{ number_format($entry['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    
                    {{-- Total Row --}}
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                        <td class="amount"><strong>{{ number_format($totalDebit ?? 0, 2) }}</strong></td>
                        <td class="amount"><strong>{{ number_format($totalCredit ?? 0, 2) }}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" style="text-align: center;">No entries found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="total-section">
            <div>
                <strong>Total Amount: {{ number_format($contraVoucher->amount ?? 0, 2) }}</strong>
            </div>
        </div>

        @if($contraVoucher->comments)
            <div style="margin-top: 20px;">
                <strong>Remarks:</strong> {{ $contraVoucher->comments }}
            </div>
        @endif

        {{-- In Word Section --}}
        @if(isset($amountInWords))
            <div style="margin-top: 20px;">
                <strong>In Word: {{ $amountInWords }}</strong>
            </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div>Prepared By</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div>Approved By</div>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
