<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Sent to Employee when their leave is approved
 */
class LeaveApproved extends Notification implements ShouldQueue
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
            ->subject('✅ Leave Approved — ' . $lr->leaveType->name)
            ->greeting('Good news, ' . $notifiable->name . '! 🎉')
            ->line('Your leave request has been **approved**.')
            ->line('')
            ->line('**📝 Leave Type:** ' . $lr->leaveType->name)
            ->line('**📅 Dates:** ' . $leaveDates)
            ->line('**📊 Total Days:** ' . $lr->total_days);

        if ($lr->admin_remarks) {
            $mail->line('**💬 Remarks:** ' . $lr->admin_remarks);
        }

        $mail->action('View My Leaves', url('/employee/leaves'))
             ->line('Enjoy your time off! 🌴');

        return $mail;
    }
}
