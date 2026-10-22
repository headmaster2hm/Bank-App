<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $type = $request->string('type')->toString();
        $year = $request->string('year')->toString();
        $accountId = $request->string('account')->toString();

        $documents = $user->documents()
            ->when($type !== '', fn ($q) => $q->where('document_type', $type))
            ->when($accountId !== '', fn ($q) => $q->where('account_id', $accountId))
            ->when($year !== '', fn ($q) => $q->whereYear('document_date', $year))
            ->orderByDesc('document_date')
            ->get();

        return view('documents.index', [
            'documents' => $documents,
            'accounts' => Account::where('user_id', $user->id)->get(),
            'types' => $documents->pluck('document_type')->unique()->sort()->values(),
            'years' => $user->documents()->orderByDesc('document_date')->get()
                ->pluck('document_date')->map(fn ($d) => $d->year)->unique()->sortDesc()->values(),
            'filters' => ['type' => $type, 'year' => $year, 'account' => $accountId],
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function download(Document $document)
    {
        abort_unless($document->user_id === Auth::id(), 403);

        $body = implode("\n", [
            'SECUREBANK — DEMONSTRATION DOCUMENT',
            str_repeat('=', 46),
            '',
            'Title:   '.$document->title,
            'Period:  '.($document->period_label ?? '—'),
            'Issued:  '.$document->document_date->toFormattedDateString(),
            'Type:    '.Document::typeLabel($document->document_type),
            '',
            'This is sample document content generated for the SecureBank prototype.',
            'It contains no real customer data and no real statement figures.',
            '',
            'Please contact SecureBank support if you need a real statement.',
        ]);

        $filename = Str($document->title)
            ->slug()
            ->append($document->period_label ? '-'.Str($document->period_label)->slug() : '')
            ->append('.txt')
            ->toString();

        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'X-Demo-Content' => 'true',
        ]);
    }
}
