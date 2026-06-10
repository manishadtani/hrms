<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Sent to Employee when their leave is rejected
 */
class LeaveRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $lr = $this->leaveRequest;
        $leaveDates = $lr->start_date->format('d M Y') . ' — ' . $lr->end_date->format('d M Y');

        $mail = (new MailMessage)
            ->subject('❌ Leave Rejected — ' . $lr->leaveType->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Unfortunately, your leave request has been **rejected**.')
            ->line('')
            ->line('**📝 Leave Type:** ' . $lr->leaveType->name)
            ->line('**📅 Dates:** ' . $leaveDates)
            ->line('**📊 Total Days:** ' . $lr->total_days);

        if ($lr->admin_remarks) {
            $mail->line('**💬 Reason for rejection:** ' . $lr->admin_remarks);
        }

        $mail->action('View My Leaves', url('/employee/leaves'))
             ->line('If you have questions, please reach out to your manager or HR.');

        return $mail;
    }
}
