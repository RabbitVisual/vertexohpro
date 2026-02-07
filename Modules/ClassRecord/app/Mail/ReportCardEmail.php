<?php

namespace Modules\ClassRecord\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\ClassRecord\Models\Student;

class ReportCardEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $student;
    protected $pdfContent;

    /**
     * Create a new message instance.
     *
     * @param Student $student
     * @param string $pdfContent
     */
    public function __construct(Student $student, $pdfContent)
    {
        $this->student = $student;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Boletim Escolar - ' . $this->student->name)
                    ->html("Olá, segue em anexo o boletim escolar de {$this->student->name}.")
                    ->attachData($this->pdfContent, 'boletim_escolar.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
