<?php

namespace Modules\ClassRecord\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Services\PdfExportService;
use Modules\ClassRecord\Mail\ReportCardEmail;
use Illuminate\Support\Facades\Mail;

class SendReportCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;

    /**
     * Create a new job instance.
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Execute the job.
     */
    public function handle(PdfExportService $pdfService)
    {
        // 1. Generate PDF
        $pdf = $pdfService->generateReportCard($this->student);
        $pdfContent = $pdf->output();

        // 2. Identify Recipient
        $recipient = $this->student->email ?? $this->student->guardian_email;

        if (!$recipient) {
            // Log warning or throw exception based on requirement
            // \Log::warning("No email found for student {$this->student->id}");
            return;
        }

        // 3. Send Email
        Mail::to($recipient)->send(new ReportCardEmail($this->student, $pdfContent));
    }
}
