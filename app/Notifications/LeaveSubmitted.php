<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Sent to Manager/Admin when an employee submits a leave request
 */
class LeaveSubmitted extends Notification implements ShouldQueue
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
        $employee = $lr->employee;
        $leaveDates = $lr->start_date->format('d M Y') . ' — ' . $lr->end_date->format('d M Y');

        return (new MailMessage)
            ->subject('📋 New Leave Request from ' . $employee->full_name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new leave request requires your attention.')
            ->line('')
            ->line('**👤 Employee:** ' . $employee->full_name . ' (' . $employee->employee_code . ')')
            ->line('**📝 Leave Type:** ' . $lr->leaveType->name)
            ->line('**📅 Dates:** ' . $leaveDates)
            ->line('**📊 Total Days:** ' . $lr->total_days)
            ->line('**💬 Reason:** ' . ($lr->reason ?: 'Not specified'))
            ->action('Review & Approve', url('/manager/leaves'))
            ->line('Please review and take action on this request at your earliest convenience.');
    }
}
