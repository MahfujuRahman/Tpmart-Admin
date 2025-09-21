<!-- Journal Report Table Component -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="reportTable">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i> SI</th>
                <th><i class="fas fa-calendar"></i> Transaction Date</th>
                <th><i class="fas fa-file-invoice"></i> Code</th>
                <th><i class="fas fa-arrow-up"></i> Debit Account</th>
                <th><i class="fas fa-arrow-up"></i> Debit Amount</th>
                <th><i class="fas fa-arrow-down"></i> Credit Account</th>
                <th><i class="fas fa-arrow-down"></i> Credit Amount</th>
                <th><i class="fas fa-sticky-note"></i> Note</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($transactions) && count($transactions) > 0)
                @php $si = 1; @endphp
                @foreach($transactions as $detail)
                    @if($detail->accountTransaction)
                        <tr>
                            <td class="si-number text-center">{{ $si++ }}</td>
                            <td class="text-left">{{ $detail->accountTransaction->trans_date ? \Carbon\Carbon::parse($detail->accountTransaction->trans_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-left">
                                <a href="{{ route('voucher.journal.show', $detail->accountTransaction->id) }}" class="text-primary" target="_blank">
                                    {{ $detail->accountTransaction->voucher_no }}
                                </a>
                            </td>
                            <td class="text-left">
                                @if($detail->drSubLedger)
                                    {{ $detail->drSubLedger->name }} ({{ $detail->drSubLedger->ledger_code }})
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="debit-amount text-right">৳{{ number_format($detail->amount, 2) }}</td>
                            <td class="text-left">
                                @if($detail->crSubLedger)
                                    {{ $detail->crSubLedger->name }} ({{ $detail->crSubLedger->ledger_code }})
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="credit-amount text-right">৳{{ number_format($detail->amount, 2) }}</td>
                            <td class="text-left">{{ $detail->accountTransaction->comments ?? 'N/A' }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="no-data">
                            <i class="fas fa-info-circle"></i>
                            <h5>No Data Found</h5>
                            <p>No transactions found for the selected criteria</p>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
        @if(isset($transactions) && count($transactions) > 0)
            <tfoot>
                <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td colspan="4" class="text-right">Total:</td>
                    <td class="debit-amount text-right">৳{{ number_format($totalDebit ?? 0, 2) }}</td>
                    <td></td>
                    <td class="credit-amount text-right">৳{{ number_format($totalCredit ?? 0, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
