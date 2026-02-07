<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Models\AuditLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('user')->latest()->paginate(20);
        return view('admin::audit.index', compact('logs'));
    }

    public function export(Request $request)
    {
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // Header
            fputcsv($handle, ['ID', 'User', 'Action', 'Description', 'IP', 'Date']);

            AuditLog::with('user')->chunk(100, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->user ? $log->user->name : 'System',
                        $log->action,
                        $log->description,
                        $log->ip_address,
                        $log->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="audit_log_' . date('Y-m-d') . '.csv"');

        return $response;
    }
}
